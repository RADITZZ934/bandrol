<script setup lang="ts">
import { computed } from 'vue'
import type { BandrolPageData } from '~/types'
import { getF4LayoutInfo, getPresetById } from '~/utils/constants'
import { useBandrolStore } from '~/stores/bandrolStore'
import BandrolTemplate from '~/components/Canvas/BandrolTemplate.vue'
import BandrolClassicTemplate from '~/components/Canvas/BandrolClassicTemplate.vue'
import BandrolLatestTemplate from '~/components/Canvas/BandrolLatestTemplate.vue'
import BandrolMemberTemplate from '~/components/Canvas/BandrolMemberTemplate.vue'

interface Props {
  page: BandrolPageData
  index: number
  disablePrintPage?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  disablePrintPage: false,
})
const store = useBandrolStore()

const preset = computed(() => getPresetById(props.page.sizeId))
const layoutInfo = computed(() => getF4LayoutInfo(preset.value))
const isActive = computed(() => store.activePageIndex === props.index)

// 1mm = 3.7795275591px at 96dpi
const MM_TO_PX = 3.7795275591
const MAX_PREVIEW_WIDTH_PX = 760
const MAX_PREVIEW_HEIGHT_PX = 500

const baseScale = computed(() => {
  const rawW = preset.value.widthMm * MM_TO_PX
  const rawH = preset.value.heightMm * MM_TO_PX
  const scaleW = MAX_PREVIEW_WIDTH_PX / rawW
  const scaleH = MAX_PREVIEW_HEIGHT_PX / rawH
  return Math.min(1, scaleW, scaleH)
})

const previewScale = computed(() => baseScale.value * store.zoom)

const scaledBoxStyle = computed(() => ({
  width: `${Math.round(preset.value.widthMm * MM_TO_PX * previewScale.value)}px`,
  height: `${Math.round(preset.value.heightMm * MM_TO_PX * previewScale.value)}px`,
}))

const printPageStyle = computed(() => ({
  width: `${preset.value.widthMm}mm`,
  height: `${preset.value.heightMm}mm`,
}))

const tiles = computed(() => {
  const list: Array<{ key: string; col: number; row: number }> = []
  for (let row = 0; row < layoutInfo.value.tileRows; row++) {
    for (let col = 0; col < layoutInfo.value.tileCols; col++) {
      list.push({ key: `${row}-${col}`, col, row })
    }
  }
  return list
})
</script>

<template>
  <div class="flex flex-col items-start">
    <!-- Standard Single-Page Bandrol -->
    <template v-if="!layoutInfo.isTiledPoster">
      <div
        class="print-reset-box cursor-pointer shadow-lg transition-all duration-150"
        :style="scaledBoxStyle"
        @click="store.setActivePageIndex(index)"
      >
        <div
          class="print-reset-scale origin-top-left"
          :style="{ transform: `scale(${previewScale})` }"
        >
          <div
            class="bg-white overflow-hidden"
            :class="{ 'bandrol-print-page': !disablePrintPage }"
            :style="printPageStyle"
            :data-width-mm="preset.widthMm"
            :data-height-mm="preset.heightMm"
          >
            <BandrolMemberTemplate
              v-if="preset.isMemberPromo"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolLatestTemplate
              v-else-if="store.templateStyle === 'latest'"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolTemplate
              v-else-if="store.templateStyle === 'modern'"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolClassicTemplate
              v-else
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
          </div>
        </div>
      </div>
    </template>

    <!-- Tiled Multi-Sheet Promo Poster (2x2 = 4 F4, or 2x1 = 2 F4) -->
    <template v-else>
      <!-- Screen Preview: Full Combined Poster with Dashed Cut-Guides -->
      <div
        class="no-print cursor-pointer shadow-lg transition-all duration-150 relative"
        :style="scaledBoxStyle"
        @click="store.setActivePageIndex(index)"
      >
        <div
          class="origin-top-left"
          :style="{ transform: `scale(${previewScale})` }"
        >
          <div
            class="bg-white overflow-hidden relative"
            :style="printPageStyle"
          >
            <BandrolMemberTemplate
              v-if="preset.isMemberPromo"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolLatestTemplate
              v-else-if="store.templateStyle === 'latest'"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolTemplate
              v-else-if="store.templateStyle === 'modern'"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolClassicTemplate
              v-else
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />

            <!-- Dashed Cut-Guide Overlay -->
            <div
              class="absolute inset-0 pointer-events-none grid"
              :style="{
                gridTemplateColumns: `repeat(${layoutInfo.tileCols}, 1fr)`,
                gridTemplateRows: `repeat(${layoutInfo.tileRows}, 1fr)`,
              }"
            >
              <div
                v-for="tile in tiles"
                :key="tile.key"
                class="border border-dashed border-neutral-600/80"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Print & PDF Export Tiles: Each Quadrant as its own F4 Sheet -->
      <div class="fixed -left-[99999px] top-0 pointer-events-none print:static print:left-auto">
        <div
          v-for="tile in tiles"
          :key="`print-${tile.key}`"
          class="bandrol-print-page bg-white overflow-hidden relative"
          :style="{
            width: `${layoutInfo.sheetWidthMm}mm`,
            height: `${layoutInfo.sheetHeightMm}mm`,
          }"
          :data-width-mm="layoutInfo.sheetWidthMm"
          :data-height-mm="layoutInfo.sheetHeightMm"
        >
          <div
            class="absolute"
            :style="{
              width: `${preset.widthMm}mm`,
              height: `${preset.heightMm}mm`,
              left: `-${tile.col * layoutInfo.sheetWidthMm}mm`,
              top: `-${tile.row * layoutInfo.sheetHeightMm}mm`,
            }"
          >
            <BandrolMemberTemplate
              v-if="preset.isMemberPromo"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolLatestTemplate
              v-else-if="store.templateStyle === 'latest'"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolTemplate
              v-else-if="store.templateStyle === 'modern'"
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolClassicTemplate
              v-else
              :page="page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
          </div>
        </div>
      </div>
    </template>

    <!-- Page Indicator (Screen Only) -->
    <div
      v-if="isActive"
      class="no-print mt-2 text-xs font-medium text-gray-800 select-none"
    >
      Halaman {{ index + 1 }}/{{ store.pages.length }}
      <span v-if="layoutInfo.isTiledPoster" class="text-gray-500 ml-1">
        ({{ layoutInfo.sheetsPerPage }} lembar F4)
      </span>
    </div>
  </div>
</template>
