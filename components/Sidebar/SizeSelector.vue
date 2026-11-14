<script setup lang="ts">
import { ChevronDown } from 'lucide-vue-next'
import { BANDROL_SIZE_PRESETS } from '~/utils/constants'
import { useBandrolStore } from '~/stores/bandrolStore'

const store = useBandrolStore()

function onChange(e: Event) {
  const value = (e.target as HTMLSelectElement).value
  store.updateActivePage({ sizeId: value })
}
</script>

<template>
  <div class="space-y-1">
    <label class="block text-[11px] font-medium text-gray-700">
      *Ukuran &amp; Model
    </label>
    <div class="relative">
      <select
        :value="store.activePage.sizeId"
        class="w-full appearance-none rounded-md bg-gray-400/70 hover:bg-gray-400/80 text-gray-900 text-[11px] font-medium px-2.5 py-2 pr-7 focus:outline-none focus:ring-2 focus:ring-green-600/40 cursor-pointer transition"
        @change="onChange"
      >
        <option
          v-for="preset in BANDROL_SIZE_PRESETS"
          :key="preset.id"
          :value="preset.id"
          class="bg-white text-gray-900"
        >
          {{ preset.label }}
        </option>
      </select>
      <ChevronDown
        class="w-3.5 h-3.5 text-gray-800 pointer-events-none absolute right-2 top-1/2 -translate-y-1/2"
      />
    </div>
  </div>
</template>

