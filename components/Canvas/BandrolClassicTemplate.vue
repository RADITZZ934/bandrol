<script setup lang="ts">
import { computed } from 'vue'
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

// Scale proportionally relative to the classic 330x210mm F4 base
const scaleFactor = computed(() =>
  Math.min(props.preset.widthMm / 330, props.preset.heightMm / 210)
)

const isGray = computed(() => props.colorMode === 'grayscale')
const isPromo = computed(() => Boolean(props.preset.isPromo))

const borderThickness = computed(() => `${Math.max(2, 7.5 * scaleFactor.value).toFixed(2)}mm`)
const titleSize = computed(() => {
  const len = (props.page.itemName || '').length
  let base = 20 * scaleFactor.value
  if (len > 28) base *= 0.78
  else if (len > 20) base *= 0.88
  return `${Math.max(8, base).toFixed(2)}mm`
})

const priceSize = computed(() => {
  const len = formattedPrice.value.length
  let base = 62 * scaleFactor.value
  if (len >= 7) base *= 0.65
  else if (len >= 6) base *= 0.78
  else if (len >= 5) base *= 0.9
  return `${Math.max(18, base).toFixed(2)}mm`
})

const rpSize = computed(() => `${Math.max(6, 17 * scaleFactor.value).toFixed(2)}mm`)
const storeSize = computed(() => `${Math.max(5, 13 * scaleFactor.value).toFixed(2)}mm`)
const triangleScale = computed(() => Math.max(0.35, scaleFactor.value))
</script>

<template>
  <div
    class="classic-root w-full h-full bg-white box-border select-none flex items-stretch justify-stretch p-[2mm]"
    :class="{ grayscale: isGray }"
  >
    <!-- Border 1: Laskar (Yellow) / Bazzar (Red) / Monochrome (Black) / Promo (Yellow) -->
    <div
      class="w-full h-full flex flex-col box-border"
      :style="{
        borderWidth: isGray ? `${Math.max(2, 5 * scaleFactor).toFixed(2)}mm` : borderThickness,
        borderStyle: 'solid',
        borderColor: isGray
          ? '#000000'
          : isPromo
            ? '#fef213'
            : brand === 'laskar'
              ? '#fef213'
              : '#ff0000',
        borderRadius: isGray || isPromo ? '0mm' : `${(14 * scaleFactor).toFixed(2)}mm`,
        padding: isGray ? '0mm' : `${(1 * scaleFactor).toFixed(2)}mm`,
      }"
    >
      <!-- Border 2: Green (#00ff0d) for Laskar & Bazzar (hidden in Grayscale/Promo) -->
      <div
        class="w-full h-full flex flex-col box-border"
        :style="{
          borderWidth: isGray || isPromo ? '0mm' : borderThickness,
          borderStyle: 'solid',
          borderColor: '#00ff0d',
          borderRadius: `${(8 * scaleFactor).toFixed(2)}mm`,
          padding: isGray || isPromo ? '0mm' : `${(1 * scaleFactor).toFixed(2)}mm`,
        }"
      >
        <!-- Border 3: Red (#ff0000) for Laskar (hidden in Bazzar/Grayscale/Promo) -->
        <div
          class="w-full h-full flex flex-col justify-between box-border overflow-hidden"
          :style="{
            borderWidth:
              isGray || isPromo || brand === 'bazzar' ? '0mm' : borderThickness,
            borderStyle: 'solid',
            borderColor: '#ff0000',
            borderRadius: `${(6 * scaleFactor).toFixed(2)}mm`,
          }"
        >
          <!-- Top: Product Name -->
          <div
            class="flex items-center justify-center text-center px-[4mm] shrink-0"
            :style="{
              height: `${(44 * scaleFactor).toFixed(2)}mm`,
              borderBottom: `${Math.max(1, 2.5 * scaleFactor).toFixed(2)}mm solid ${
                isGray ? '#000000' : isPromo ? '#fef213' : '#000000'
              }`,
            }"
          >
            <span
              class="classic-anton uppercase leading-[1.15] w-full truncate"
              :style="{
                fontSize: titleSize,
                color: isGray ? '#000000' : '#ff0000',
                textShadow: isGray
                  ? 'none'
                  : `-${(0.8 * scaleFactor).toFixed(2)}mm -${(0.8 * scaleFactor).toFixed(2)}mm 0 #000, ${(0.8 * scaleFactor).toFixed(2)}mm -${(0.8 * scaleFactor).toFixed(2)}mm 0 #000, -${(0.8 * scaleFactor).toFixed(2)}mm ${(0.8 * scaleFactor).toFixed(2)}mm 0 #000, ${(0.8 * scaleFactor).toFixed(2)}mm ${(0.8 * scaleFactor).toFixed(2)}mm 0 #000`,
              }"
            >
              {{ page.itemName?.trim() || 'NAMA ITEM' }}
            </span>
          </div>

          <!-- Middle: RP. + Price + /UOM -->
          <div
            class="flex-1 flex items-center justify-center gap-[3mm] px-[4mm] min-h-0"
          >
            <span
              class="classic-poppins font-bold leading-none self-center"
              :style="{
                fontSize: rpSize,
                color: isPromo && !isGray ? '#ff0000' : '#000000',
              }"
            >
              RP.
            </span>
            <span
              class="classic-anton leading-[0.82] tracking-tight whitespace-nowrap"
              :style="{
                fontSize: priceSize,
                color: isPromo && !isGray ? '#ff0000' : '#000000',
              }"
            >
              {{ formattedPrice }}
            </span>
            <span
              class="classic-poppins font-bold leading-none self-center"
              :style="{
                fontSize: rpSize,
                color: isPromo && !isGray ? '#ff0000' : '#000000',
              }"
            >
              /{{ page.uom }}
            </span>
          </div>

          <!-- Bottom: Left Logo + Store Name + Right Logo -->
          <div
            class="flex items-center justify-between px-[8mm] shrink-0"
            :style="{ height: `${(28 * scaleFactor).toFixed(2)}mm` }"
          >
            <!-- Left Logo (Laskar: Triangle, Bazzar: bazzar-footer.png) -->
            <div
              v-if="brand === 'laskar'"
              class="classic-triangle-wrap"
              :style="{ transform: `scale(${triangleScale})` }"
            >
              <div class="tri tri-yellow" />
              <div class="tri tri-green" />
              <div class="tri tri-red" />
              <div class="tri tri-white" />
            </div>
            <img
              v-else
              src="~/assets/images/bazzar-footer.png"
              alt="Bazzar"
              class="w-auto object-contain shrink-0"
              :style="{ height: `${Math.max(10, 24 * scaleFactor).toFixed(2)}mm` }"
            />

            <span
              class="classic-poppins font-bold uppercase tracking-tight leading-none text-center truncate px-2"
              :style="{
                fontSize: storeSize,
                color: isGray ? '#000000' : '#00268f',
              }"
            >
              {{ page.branch?.trim() || 'BABAT 1' }}
            </span>

            <!-- Right Logo (Laskar: Triangle, Bazzar: bazzar-footer.png) -->
            <div
              v-if="brand === 'laskar'"
              class="classic-triangle-wrap"
              :style="{ transform: `scale(${triangleScale})` }"
            >
              <div class="tri tri-yellow" />
              <div class="tri tri-green" />
              <div class="tri tri-red" />
              <div class="tri tri-white" />
            </div>
            <img
              v-else
              src="~/assets/images/bazzar-footer.png"
              alt="Bazzar"
              class="w-auto object-contain shrink-0"
              :style="{ height: `${Math.max(10, 24 * scaleFactor).toFixed(2)}mm` }"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.classic-anton {
  font-family: 'Anton', Impact, sans-serif;
  font-weight: 400;
}

.classic-poppins {
  font-family: 'Poppins', system-ui, sans-serif;
}

.classic-triangle-wrap {
  position: relative;
  width: 34mm;
  height: 24mm;
  transform-origin: center;
  flex-shrink: 0;
}

.tri {
  position: absolute;
  width: 0;
  height: 0;
  left: 50%;
  transform: translateX(-50%);
  border-left: 17mm solid transparent;
  border-right: 17mm solid transparent;
}

.tri-yellow {
  top: 0;
  border-bottom: 24mm solid #ffd700;
}

.tri-green {
  top: 4.8mm;
  border-bottom: 19.2mm solid #00a650;
}

.tri-red {
  top: 9.6mm;
  border-bottom: 14.4mm solid #ff0000;
}

.tri-white {
  top: 14.4mm;
  border-bottom: 9.6mm solid #ffffff;
}
</style>

