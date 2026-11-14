<script setup lang="ts">
import { computed } from 'vue'
import type { BandrolPageData } from '~/types'
import { getPresetById } from '~/utils/constants'
import { useBandrolStore } from '~/stores/bandrolStore'
import BandrolTemplate from '~/components/Canvas/BandrolTemplate.vue'
import BandrolClassicTemplate from '~/components/Canvas/BandrolClassicTemplate.vue'
import BandrolLatestTemplate from '~/components/Canvas/BandrolLatestTemplate.vue'

interface Props {
  page: BandrolPageData
  index: number
}

const props = defineProps<Props>()
const store = useBandrolStore()

const preset = computed(() => getPresetById(props.page.sizeId))
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
</script>

<template>
  <div class="flex flex-col items-start">
    <!-- Scaled Preview Wrapper (Screen) / Exact mm (Print) -->
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
          class="bandrol-print-page bg-white overflow-hidden"
          :style="printPageStyle"
        >
          <BandrolLatestTemplate
            v-if="store.templateStyle === 'latest'"
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

    <!-- Page Indicator (Screen Only) -->
    <div
      v-if="isActive"
      class="no-print mt-2 text-xs font-medium text-gray-800 select-none"
    >
      Halaman {{ index + 1 }}/{{ store.pages.length }}
    </div>
  </div>
</template>
