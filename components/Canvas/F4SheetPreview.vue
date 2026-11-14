<script setup lang="ts">
import { computed } from 'vue'
import { FileSpreadsheet } from 'lucide-vue-next'
import { useBandrolStore } from '~/stores/bandrolStore'
import { getF4LayoutInfo, getPresetById } from '~/utils/constants'
import BandrolLatestTemplate from '~/components/Canvas/BandrolLatestTemplate.vue'
import BandrolTemplate from '~/components/Canvas/BandrolTemplate.vue'
import BandrolClassicTemplate from '~/components/Canvas/BandrolClassicTemplate.vue'
import BandrolMemberTemplate from '~/components/Canvas/BandrolMemberTemplate.vue'

const store = useBandrolStore()

const MM_TO_PX = 3.7795275591
const MAX_WIDTH_PX = 236
const MAX_HEIGHT_PX = 300

const preset = computed(() => store.activePreset)
const f4Info = computed(() => getF4LayoutInfo(preset.value))

const sheetScale = computed(() => {
  const rawW = f4Info.value.sheetWidthMm * MM_TO_PX
  const rawH = f4Info.value.sheetHeightMm * MM_TO_PX
  return Math.min(MAX_WIDTH_PX / rawW, MAX_HEIGHT_PX / rawH)
})

const sheetBoxStyle = computed(() => ({
  width: `${Math.round(f4Info.value.sheetWidthMm * MM_TO_PX * sheetScale.value)}px`,
  height: `${Math.round(f4Info.value.sheetHeightMm * MM_TO_PX * sheetScale.value)}px`,
}))

const slotScaledStyle = computed(() => ({
  width: `${Math.round(preset.value.widthMm * MM_TO_PX * sheetScale.value)}px`,
  height: `${Math.round(preset.value.heightMm * MM_TO_PX * sheetScale.value)}px`,
}))

// For tiled posters (13. F4 Promo Landscape = 2x2 = 4 sheets, 9. F4 2 Promo Portrait = 2x1 = 2 sheets)
const posterTiles = computed(() => {
  const list: Array<{ sheetNumber: number; label: string; col: number; row: number }> = []
  let num = 1
  for (let row = 0; row < f4Info.value.tileRows; row++) {
    for (let col = 0; col < f4Info.value.tileCols; col++) {
      const vLabel = f4Info.value.tileRows > 1 ? (row === 0 ? 'Atas' : 'Bawah') : ''
      const hLabel = col === 0 ? 'Kiri' : 'Kanan'
      list.push({
        sheetNumber: num++,
        label: [vLabel, hLabel].filter(Boolean).join('-'),
        col,
        row,
      })
    }
  }
  return list
})

// For standard multi-slot F4 sheets
const f4Sheets = computed(() => {
  const perSheet = f4Info.value.totalSlots
  const totalSheets = Math.max(1, Math.ceil(store.pages.length / perSheet))
  return Array.from({ length: totalSheets }, (_, sheetIdx) => {
    const start = sheetIdx * perSheet
    return {
      sheetNumber: sheetIdx + 1,
      slots: Array.from({ length: perSheet }, (__, slotIdx) => {
        const pageIndex = start + slotIdx
        return {
          pageIndex,
          page: store.pages[pageIndex] ?? null,
        }
      }),
    }
  })
})
</script>

<template>
  <aside
    class="no-print hidden lg:flex w-72 shrink-0 bg-white border-l border-gray-200 flex-col justify-between p-3.5 overflow-y-auto z-10"
  >
    <div class="space-y-3">
      <!-- Header -->
      <div class="flex items-center justify-between border-b border-gray-100 pb-2">
        <div class="flex items-center gap-1.5">
          <FileSpreadsheet class="w-4 h-4 text-green-600" />
          <h2 class="text-xs font-bold text-gray-800">Preview Kertas F4</h2>
        </div>
        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-gray-100 text-gray-600">
          {{ preset.orientation === 'portrait' ? 'Portrait' : 'Landscape' }}
        </span>
      </div>

      <!-- Mode A: Tiled Promo Poster (each quadrant on its own F4 sheet) -->
      <div
        v-if="f4Info.isTiledPoster"
        class="rounded-lg bg-gray-200/80 p-3 flex flex-col items-center gap-3.5"
      >
        <div
          v-for="tile in posterTiles"
          :key="tile.sheetNumber"
          class="flex flex-col items-center"
        >
          <div
            class="bg-white shadow-md border border-gray-300 relative overflow-hidden"
            :style="sheetBoxStyle"
          >
            <div
              class="origin-top-left pointer-events-none"
              :style="{ transform: `scale(${sheetScale})` }"
            >
              <div
                class="relative overflow-hidden"
                :style="{
                  width: `${f4Info.sheetWidthMm}mm`,
                  height: `${f4Info.sheetHeightMm}mm`,
                }"
              >
                <div
                  class="absolute"
                  :style="{
                    width: `${preset.widthMm}mm`,
                    height: `${preset.heightMm}mm`,
                    left: `-${tile.col * f4Info.sheetWidthMm}mm`,
                    top: `-${tile.row * f4Info.sheetHeightMm}mm`,
                  }"
                >
                  <BandrolLatestTemplate
                    v-if="store.templateStyle === 'latest'"
                    :page="store.activePage"
                    :preset="preset"
                    :brand="store.brand"
                    :color-mode="store.colorMode"
                  />
                  <BandrolTemplate
                    v-else-if="store.templateStyle === 'modern'"
                    :page="store.activePage"
                    :preset="preset"
                    :brand="store.brand"
                    :color-mode="store.colorMode"
                  />
                  <BandrolClassicTemplate
                    v-else
                    :page="store.activePage"
                    :preset="preset"
                    :brand="store.brand"
                    :color-mode="store.colorMode"
                  />
                </div>
              </div>
            </div>
          </div>

          <span class="mt-1 text-[10px] font-medium text-gray-600">
            Lembar F4 #{{ tile.sheetNumber }} ({{ tile.label }})
          </span>
        </div>
      </div>

      <!-- Mode B: Standard F4 Paper Sheets -->
      <div
        v-else
        class="rounded-lg bg-gray-200/80 p-3 flex flex-col items-center gap-4"
      >
        <div
          v-for="sheet in f4Sheets"
          :key="sheet.sheetNumber"
          class="flex flex-col items-center"
        >
          <div
            class="bg-white shadow-md border border-gray-300 relative overflow-hidden flex items-center justify-center"
            :style="sheetBoxStyle"
          >
            <div
              class="grid content-start justify-start"
              :style="{
                gridTemplateColumns: `repeat(${f4Info.cols}, auto)`,
                gap: `${(f4Info.gapMm * MM_TO_PX * sheetScale).toFixed(2)}px`,
              }"
            >
              <div
                v-for="slot in sheet.slots"
                :key="slot.pageIndex"
                class="relative overflow-hidden border border-dashed box-border transition"
                :class="
                  slot.page && slot.pageIndex === store.activePageIndex
                    ? 'border-green-600 ring-1 ring-inset ring-green-600'
                    : 'border-gray-300/90'
                "
                :style="slotScaledStyle"
              >
                <button
                  v-if="slot.page"
                  type="button"
                  class="w-full h-full block text-left cursor-pointer"
                  :title="`Halaman ${slot.pageIndex + 1}`"
                  @click="store.setActivePageIndex(slot.pageIndex)"
                >
                  <div
                    class="origin-top-left pointer-events-none"
                    :style="{ transform: `scale(${sheetScale})` }"
                  >
                    <div
                      :style="{
                        width: `${getPresetById(slot.page.sizeId).widthMm}mm`,
                        height: `${getPresetById(slot.page.sizeId).heightMm}mm`,
                      }"
                    >
                      <BandrolMemberTemplate
                        v-if="getPresetById(slot.page.sizeId).isMemberPromo"
                        :page="slot.page"
                        :preset="getPresetById(slot.page.sizeId)"
                        :brand="store.brand"
                        :color-mode="store.colorMode"
                      />
                      <BandrolLatestTemplate
                        v-else-if="store.templateStyle === 'latest'"
                        :page="slot.page"
                        :preset="getPresetById(slot.page.sizeId)"
                        :brand="store.brand"
                        :color-mode="store.colorMode"
                      />
                      <BandrolTemplate
                        v-else-if="store.templateStyle === 'modern'"
                        :page="slot.page"
                        :preset="getPresetById(slot.page.sizeId)"
                        :brand="store.brand"
                        :color-mode="store.colorMode"
                      />
                      <BandrolClassicTemplate
                        v-else
                        :page="slot.page"
                        :preset="getPresetById(slot.page.sizeId)"
                        :brand="store.brand"
                        :color-mode="store.colorMode"
                      />
                    </div>
                  </div>
                </button>
              </div>
            </div>
          </div>

          <span class="mt-1.5 text-[10px] font-medium text-gray-500">
            Lembar F4 #{{ sheet.sheetNumber }} ({{ f4Info.sheetWidthMm }} × {{ f4Info.sheetHeightMm }} mm)
          </span>
        </div>
      </div>
    </div>

    <!-- Dimension & Capacity Specs -->
    <div class="mt-3 pt-2.5 border-t border-gray-100 space-y-1.5 text-[11px] text-gray-600">
      <div class="flex justify-between">
        <span>Total Halaman</span>
        <span class="font-semibold text-gray-900">{{ store.pages.length }} hal</span>
      </div>
      <div class="flex justify-between">
        <span>Ukuran {{ f4Info.isTiledPoster ? 'Gabungan' : 'Bandrol' }}</span>
        <span class="font-semibold text-gray-900">
          {{ preset.widthMm }} × {{ preset.heightMm }} mm
        </span>
      </div>
      <div v-if="f4Info.isTiledPoster" class="flex justify-between">
        <span>Kebutuhan Kertas</span>
        <span class="font-bold text-green-700">
          {{ f4Info.sheetsPerPage }} lembar F4 ({{ f4Info.tileCols }}×{{ f4Info.tileRows }})
        </span>
      </div>
      <div v-else class="flex justify-between">
        <span>Kapasitas / Lembar F4</span>
        <span class="font-bold text-green-700">
          {{ f4Info.totalSlots }} pcs ({{ f4Info.cols }}×{{ f4Info.rows }})
        </span>
      </div>
    </div>
  </aside>
</template>
