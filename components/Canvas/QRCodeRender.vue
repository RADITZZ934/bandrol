<script setup lang="ts">
import QrcodeVue from 'qrcode.vue'

interface Props {
  value: string
  size?: number
}

withDefaults(defineProps<Props>(), {
  size: 110,
})
</script>

<template>
  <div
    v-if="value && value.trim().length > 0"
    class="flex flex-col items-center justify-center shrink-0 select-none"
  >
    <QrcodeVue
      :value="value.trim()"
      :size="size"
      level="M"
      render-as="svg"
      background="#ffffff"
      foreground="#000000"
    />
    <span
      class="mt-1 font-display font-bold text-black tracking-wide leading-none"
      :style="{ fontSize: `${Math.max(10, Math.round(size * 0.14))}px` }"
    >
      {{ value.trim() }}
    </span>
  </div>
</template>

