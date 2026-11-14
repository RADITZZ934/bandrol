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
      class="font-display font-bold text-black tracking-wide leading-none"
      :style="{
        marginTop: `${Math.max(1, Math.round(size * 0.03))}px`,
        fontSize: `${Math.max(5, Math.round(size * 0.15))}px`,
      }"
    >
      {{ value.trim() }}
    </span>
  </div>
</template>

