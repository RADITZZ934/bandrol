<script setup lang="ts">
import { computed, ref } from 'vue'
import { onClickOutside } from '@vueuse/core'
import type { ProductItem } from '~/types'
import { searchProducts } from '~/utils/productCatalog'
import { useBandrolStore } from '~/stores/bandrolStore'

const store = useBandrolStore()
const containerRef = ref<HTMLElement | null>(null)
const isOpen = ref(false)

const suggestions = computed(() =>
  searchProducts(store.activePage.itemName, 15)
)

onClickOutside(containerRef, () => {
  isOpen.value = false
})

function onInput(event: Event) {
  const val = (event.target as HTMLInputElement).value
  isOpen.value = val.trim().length > 0
  store.updateActivePage({
    itemName: val,
    isBarcodeLocked: false,
  })
}

function selectItem(item: ProductItem) {
  store.updateActivePage({
    itemName: item.name,
    barcode: item.code,
    isBarcodeLocked: true,
  })
  isOpen.value = false
}
</script>

<template>
  <div ref="containerRef" class="relative space-y-1">
    <label class="block text-[11px] font-medium text-gray-700">
      *Nama Item
    </label>
    <input
      :value="store.activePage.itemName"
      type="text"
      placeholder="contoh: ALPUKAT MENTEGA"
      autocomplete="off"
      class="w-full rounded-md bg-gray-200/90 px-2.5 py-1.5 text-xs text-gray-900 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-600/40 border border-transparent focus:border-green-600/40 transition"
      @focus="isOpen = store.activePage.itemName.trim().length > 0 && !store.activePage.isBarcodeLocked"
      @input="onInput"
      @keydown.escape="isOpen = false"
    />

    <!-- Suggestion Bar -->
    <div
      v-if="isOpen && suggestions.length > 0"
      class="absolute left-0 right-0 top-full mt-1 max-h-48 overflow-y-auto rounded-md border border-gray-200 bg-white shadow-lg z-30 divide-y divide-gray-100"
    >
      <button
        v-for="item in suggestions"
        :key="`${item.code}-${item.name}`"
        type="button"
        class="w-full px-2.5 py-1.5 text-left hover:bg-green-50 transition flex flex-col gap-0.5"
        @click="selectItem(item)"
      >
        <span class="text-[11px] font-semibold text-gray-900 leading-tight">
          {{ item.name }}
        </span>
        <span class="text-[10px] text-gray-500 font-mono">
          {{ item.code }}
        </span>
      </button>
    </div>
  </div>
</template>

