<script setup lang="ts">
import { computed } from 'vue'
import QrcodeVue from 'qrcode.vue'
import type { BandrolPageData, BandrolSizePreset, BrandType, ColorMode } from '~/types'
import { formatPriceId } from '~/utils/constants'

interface Props {
  page: BandrolPageData
  preset: BandrolSizePreset
  brand: BrandType
  colorMode: ColorMode
}

const props = defineProps<Props>()

const formattedPrice = computed(() => formatPriceId(props.page.price || '0'))

// Scale proportionally relative to the 330x210mm F4 base
const scaleFactor = computed(() =>
  Math.min(props.preset.widthMm / 330, props.preset.heightMm / 210)
)

const titleFontSize = computed(() => {
  const len = (props.page.itemName || '').length
  let baseMm = 21 * scaleFactor.value
  if (len > 30) baseMm *= 0.75
  else if (len > 22) baseMm *= 0.86
  return `${Math.max(7, baseMm).toFixed(2)}mm`
})

const priceFontSize = computed(() => {
  const len = formattedPrice.value.length
  let baseMm = 86 * scaleFactor.value
  if (len >= 7) baseMm *= 0.65
  else if (len >= 6) baseMm *= 0.78
  else if (len >= 5) baseMm *= 0.92
  return `${Math.max(18, baseMm).toFixed(2)}mm`
})

const slashFontSize = computed(() => `${Math.max(16, 72 * scaleFactor.value).toFixed(2)}mm`)
const uomFontSize = computed(() => `${Math.max(7, 24 * scaleFactor.value).toFixed(2)}mm`)
const rpFontSize = computed(() => `${Math.max(6, 17 * scaleFactor.value).toFixed(2)}mm`)

const qrSizePx = computed(() => Math.round(Math.max(38, 86 * scaleFactor.value)))
</script>

<template>
  <div
    class="w-full h-full bg-white p-[1.5mm] box-border select-none"
    :class="{ grayscale: colorMode === 'grayscale' }"
  >
    <!-- Crisp Outer Black Frame -->
    <div
      class="w-full h-full border-[1.1mm] border-black bg-white flex flex-col justify-between box-border relative overflow-hidden"
      :style="{ padding: `${(2.8 * scaleFactor).toFixed(2)}mm ${(3.2 * scaleFactor).toFixed(2)}mm` }"
    >
      <!-- Optional Promo Badge -->
      <div
        v-if="preset.isPromo"
        class="absolute top-0 right-0 bg-yellow-400 text-black font-display font-black text-xs px-3 py-0.5 tracking-widest uppercase z-10"
      >
        PROMO
      </div>

      <!-- Top Banner: Solid Green Header with Bold White Text -->
      <div
        class="w-full flex items-center justify-center text-center shrink-0"
        :style="{
          backgroundColor: brand === 'laskar' ? '#1f9d45' : '#009846',
          height: `${(36 * scaleFactor).toFixed(2)}mm`,
          padding: `0 ${(4 * scaleFactor).toFixed(2)}mm`,
        }"
      >
        <h1
          class="font-sans font-bold uppercase text-white tracking-wide leading-none truncate w-full"
          :style="{ fontSize: titleFontSize }"
        >
          {{ page.itemName?.trim() || 'NAMA ITEM' }}
        </h1>
      </div>

      <!-- Middle Section: Italic RP. + Massive Red Price + Huge /UOM -->
      <div
        class="flex-1 flex items-center justify-between min-h-0"
        :style="{
          padding: `${(2 * scaleFactor).toFixed(2)}mm ${(3 * scaleFactor).toFixed(2)}mm`,
          gap: `${(3 * scaleFactor).toFixed(2)}mm`,
        }"
      >
        <!-- Left: Italic Bold RP. -->
        <div
          class="shrink-0 flex items-end"
          :style="{ paddingBottom: `${(8 * scaleFactor).toFixed(2)}mm` }"
        >
          <span
            class="font-sans font-extrabold italic text-black leading-none"
            :style="{ fontSize: rpFontSize }"
          >
            RP.
          </span>
        </div>

        <!-- Center: Massive Bright Red Price -->
        <div class="flex-1 flex items-center justify-center min-w-0">
          <span
            class="font-display font-black leading-[0.88] whitespace-nowrap"
            :style="{
              fontSize: priceFontSize,
              color: brand === 'laskar' ? '#ff0000' : '#ef2b2d',
              letterSpacing: '0.01em',
            }"
          >
            {{ formattedPrice }}
          </span>
        </div>

        <!-- Right: Huge "/" + Bold UOM -->
        <div class="shrink-0 flex items-center leading-none">
          <span
            class="font-sans font-extrabold text-black leading-none"
            :style="{
              fontSize: slashFontSize,
              transform: 'skewX(-10deg)',
            }"
          >
            /
          </span>
          <span
            class="font-sans font-extrabold text-black uppercase leading-none self-end"
            :style="{
              fontSize: uomFontSize,
              paddingBottom: `${(8 * scaleFactor).toFixed(2)}mm`,
              marginLeft: `${(1 * scaleFactor).toFixed(2)}mm`,
            }"
          >
            {{ page.uom }}
          </span>
        </div>
      </div>

      <!-- Bottom Footer: Symmetric 3-Color Ribbons + Branch + Bottom-Right QR Code -->
      <div
        class="flex items-end justify-between shrink-0"
        :style="{
          gap: `${(4 * scaleFactor).toFixed(2)}mm`,
          paddingTop: `${(1 * scaleFactor).toFixed(2)}mm`,
        }"
      >
        <!-- Left & Right Ribbons flanking Branch Name -->
        <div
          class="flex-1 flex items-center"
          :style="{
            gap: `${(3 * scaleFactor).toFixed(2)}mm`,
            paddingBottom: `${(1.5 * scaleFactor).toFixed(2)}mm`,
          }"
        >
          <!-- Left Ribbon -->
          <div class="flex-1 flex flex-col">
            <template v-if="brand === 'laskar'">
              <div :style="{ height: `${Math.max(0.7, 1.3 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#fde000' }" />
              <div :style="{ height: `${Math.max(0.7, 1.3 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#22a047' }" />
              <div :style="{ height: `${Math.max(0.7, 1.3 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#ef3b3b' }" />
            </template>
            <template v-else>
              <div :style="{ height: `${Math.max(1, 2 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#ef2b2d' }" />
              <div :style="{ height: `${Math.max(1, 2 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#009846' }" />
            </template>
          </div>

          <!-- Center Branch Name -->
          <span
            class="font-sans font-medium uppercase text-black tracking-wide leading-none shrink-0"
            :style="{ fontSize: `${Math.max(4, 6.5 * scaleFactor).toFixed(2)}mm` }"
          >
            {{ page.branch?.trim() || 'BABAT 1' }}
          </span>

          <!-- Right Ribbon -->
          <div class="flex-1 flex flex-col">
            <template v-if="brand === 'laskar'">
              <div :style="{ height: `${Math.max(0.7, 1.3 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#fde000' }" />
              <div :style="{ height: `${Math.max(0.7, 1.3 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#22a047' }" />
              <div :style="{ height: `${Math.max(0.7, 1.3 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#ef3b3b' }" />
            </template>
            <template v-else>
              <div :style="{ height: `${Math.max(1, 2 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#ef2b2d' }" />
              <div :style="{ height: `${Math.max(1, 2 * scaleFactor).toFixed(2)}mm`, backgroundColor: '#009846' }" />
            </template>
          </div>
        </div>

        <!-- Bottom-Right QR Code + Vertical Barcode Text -->
        <div
          v-if="page.barcode && page.barcode.trim().length > 0"
          class="flex items-center shrink-0"
          :style="{ gap: `${(1.2 * scaleFactor).toFixed(2)}mm` }"
        >
          <QrcodeVue
            :value="page.barcode.trim()"
            :size="qrSizePx"
            level="M"
            render-as="svg"
            background="#ffffff"
            foreground="#000000"
          />
          <span
            class="font-sans font-normal text-black leading-none select-none"
            :style="{
              fontSize: `${Math.max(3, 3.6 * scaleFactor).toFixed(2)}mm`,
              writingMode: 'vertical-rl',
              transform: 'rotate(180deg)',
            }"
          >
            {{ page.barcode.trim() }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

