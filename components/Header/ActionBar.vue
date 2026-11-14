<script setup lang="ts">
import {
  Undo2,
  Redo2,
  ZoomOut,
  ZoomIn,
  Pencil,
  Bookmark,
  Printer,
  Loader2,
} from 'lucide-vue-next'
import { useBandrolStore } from '~/stores/bandrolStore'
import { useBandrolHistory } from '~/composables/useBandrolHistory'
import { usePdfExport } from '~/composables/usePdfExport'
import { triggerBandrolPrint } from '~/utils/printHelper'

const store = useBandrolStore()
const { undo, redo, canUndo, canRedo } = useBandrolHistory()
const { isExporting, exportToPdf } = usePdfExport()

function handlePrint() {
  triggerBandrolPrint(store.activePreset)
}
</script>

<template>
  <header
    class="no-print h-14 bg-white border-b border-gray-200 px-5 flex items-center justify-between shrink-0 z-20"
  >
    <!-- Left: Undo / Redo + Zoom Controls -->
    <div class="flex items-center gap-4">
      <div class="flex items-center gap-1">
        <button
          type="button"
          title="Undo"
          :disabled="!canUndo"
          class="p-2 rounded-md text-gray-700 hover:bg-gray-100 disabled:opacity-35 disabled:cursor-not-allowed transition"
          @click="undo"
        >
          <Undo2 class="w-4 h-4" />
        </button>
        <button
          type="button"
          title="Redo"
          :disabled="!canRedo"
          class="p-2 rounded-md text-gray-700 hover:bg-gray-100 disabled:opacity-35 disabled:cursor-not-allowed transition"
          @click="redo"
        >
          <Redo2 class="w-4 h-4" />
        </button>
      </div>

      <!-- Zoom In / Out Slider -->
      <div class="hidden sm:flex items-center gap-2">
        <button
          type="button"
          title="Zoom Out"
          :disabled="store.zoom <= 0.5"
          class="p-1.5 rounded-md text-gray-700 hover:bg-gray-100 disabled:opacity-35 disabled:cursor-not-allowed transition"
          @click="store.zoomOut()"
        >
          <ZoomOut class="w-4 h-4" />
        </button>
        <input
          :value="store.zoom"
          type="range"
          min="0.5"
          max="1.5"
          step="0.05"
          aria-label="Zoom"
          class="w-24 h-1 bg-gray-300 rounded-lg appearance-none cursor-pointer accent-neutral-800"
          @input="store.setZoom(Number(($event.target as HTMLInputElement).value))"
        />
        <button
          type="button"
          title="Zoom In"
          :disabled="store.zoom >= 1.5"
          class="p-1.5 rounded-md text-gray-700 hover:bg-gray-100 disabled:opacity-35 disabled:cursor-not-allowed transition"
          @click="store.zoomIn()"
        >
          <ZoomIn class="w-4 h-4" />
        </button>
      </div>
    </div>

    <!-- Center: File Name Input -->
    <div class="flex items-center gap-2 border-b border-gray-400 pb-0.5 px-1 w-64 sm:w-72">
      <Pencil class="w-3.5 h-3.5 text-gray-700 shrink-0" />
      <input
        :value="store.fileName"
        type="text"
        placeholder="Namabandrol_tanggal.pdf"
        class="w-full text-xs text-center text-gray-600 bg-transparent focus:outline-none focus:text-gray-900"
        @input="store.setFileName(($event.target as HTMLInputElement).value)"
      />
    </div>

    <!-- Right: Save as & Print -->
    <div class="flex items-center gap-2.5">
      <button
        type="button"
        :disabled="isExporting"
        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-md bg-[#48a842] hover:bg-[#3d9438] text-white text-xs font-semibold shadow-sm disabled:opacity-60 transition"
        @click="exportToPdf"
      >
        <Loader2 v-if="isExporting" class="w-3.5 h-3.5 animate-spin" />
        <Bookmark v-else class="w-3.5 h-3.5 fill-current" />
        <span>{{ isExporting ? 'Saving...' : 'Save as' }}</span>
      </button>

      <button
        type="button"
        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-md bg-neutral-900 hover:bg-black text-white text-xs font-semibold shadow-sm transition"
        @click="handlePrint"
      >
        <Printer class="w-3.5 h-3.5" />
        <span>Print</span>
      </button>
    </div>
  </header>
</template>

