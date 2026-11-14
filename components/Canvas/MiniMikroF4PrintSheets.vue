<script setup lang="ts">
import { computed } from 'vue'
import { useBandrolStore } from '~/stores/bandrolStore'
import { getF4LayoutInfo, getPresetById } from '~/utils/constants'
import BandrolLatestTemplate from '~/components/Canvas/BandrolLatestTemplate.vue'
import BandrolTemplate from '~/components/Canvas/BandrolTemplate.vue'
import BandrolClassicTemplate from '~/components/Canvas/BandrolClassicTemplate.vue'

const store = useBandrolStore()
const preset = computed(() => getPresetById('mini-mikro'))
const f4Info = computed(() => getF4LayoutInfo(preset.value))

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
  <div class="fixed -left-[99999px] top-0 pointer-events-none print:static print:left-auto">
    <div
      v-for="sheet in f4Sheets"
      :key="`mini-f4-${sheet.sheetNumber}`"
      class="bandrol-print-page bg-white flex items-center justify-center overflow-hidden"
      :style="{
        width: `${f4Info.sheetWidthMm}mm`,
        height: `${f4Info.sheetHeightMm}mm`,
      }"
      :data-width-mm="f4Info.sheetWidthMm"
      :data-height-mm="f4Info.sheetHeightMm"
    >
      <div
        class="grid content-start justify-start"
        :style="{
          gridTemplateColumns: `repeat(${f4Info.cols}, ${preset.widthMm}mm)`,
          gridTemplateRows: `repeat(${f4Info.rows}, ${preset.heightMm}mm)`,
          gap: `${f4Info.gapMm}mm`,
        }"
      >
        <div
          v-for="slot in sheet.slots"
          :key="`slot-${slot.pageIndex}`"
          class="relative overflow-hidden border border-dashed border-gray-400 box-border"
          :style="{
            width: `${preset.widthMm}mm`,
            height: `${preset.heightMm}mm`,
          }"
        >
          <template v-if="slot.page">
            <BandrolLatestTemplate
              v-if="store.templateStyle === 'latest'"
              :page="slot.page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolTemplate
              v-else-if="store.templateStyle === 'modern'"
              :page="slot.page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
            <BandrolClassicTemplate
              v-else
              :page="slot.page"
              :preset="preset"
              :brand="store.brand"
              :color-mode="store.colorMode"
            />
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

