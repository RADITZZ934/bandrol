<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import JsBarcode from 'jsbarcode'

interface Props {
  value: string
  scaleFactor?: number
}

const props = withDefaults(defineProps<Props>(), {
  scaleFactor: 0.166,
})

const svgRef = ref<SVGSVGElement | null>(null)

function renderBarcode() {
  if (!svgRef.value) return
  const val = props.value.trim()
  if (!val) return

  try {
    JsBarcode(svgRef.value, val, {
      format: 'CODE128',
      displayValue: false,
      margin: 0,
      width: 1.4,
      height: 36,
      background: '#ffffff',
      lineColor: '#000000',
    })
  } catch {
    // Ignore invalid barcode characters temporarily while typing
  }
}

onMounted(renderBarcode)
watch(() => props.value, renderBarcode)
</script>

<template>
  <div
    v-if="value && value.trim().length > 0"
    class="flex items-center justify-center shrink-0 select-none"
    :style="{ gap: `${Math.max(0.4, 2 * scaleFactor).toFixed(2)}mm` }"
  >
    <!-- Rotated Vertical 1D Barcode -->
    <div
      class="relative flex items-center justify-center overflow-hidden"
      :style="{
        width: `${Math.max(5.5, 42 * scaleFactor).toFixed(2)}mm`,
        height: `${Math.max(12, 92 * scaleFactor).toFixed(2)}mm`,
      }"
    >
      <svg
        ref="svgRef"
        class="shrink-0"
        :style="{
          width: `${Math.max(12, 92 * scaleFactor).toFixed(2)}mm`,
          height: `${Math.max(5.5, 42 * scaleFactor).toFixed(2)}mm`,
          transform: 'rotate(-90deg)',
        }"
      />
    </div>

    <!-- Vertical Barcode Text -->
    <span
      class="font-sans font-semibold text-black leading-none"
      :style="{
        fontSize: `${Math.max(1.8, 10 * scaleFactor).toFixed(2)}mm`,
        writingMode: 'vertical-rl',
        transform: 'rotate(180deg)',
      }"
    >
      {{ value.trim() }}
    </span>
  </div>
</template>

