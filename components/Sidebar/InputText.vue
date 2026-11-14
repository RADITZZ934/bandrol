<script setup lang="ts">
import { Lock } from 'lucide-vue-next'

interface Props {
  label: string
  modelValue: string
  placeholder?: string
  type?: 'text' | 'number'
  numericOnly?: boolean
  disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  placeholder: '',
  type: 'text',
  numericOnly: false,
  disabled: false,
})

const emit = defineEmits<{
  'update:modelValue': [value: string]
}>()

function onInput(event: Event) {
  if (props.disabled) return
  let val = (event.target as HTMLInputElement).value
  if (props.numericOnly) {
    val = val.replace(/\D/g, '')
  }
  emit('update:modelValue', val)
}
</script>

<template>
  <div class="space-y-1">
    <div class="flex items-center justify-between">
      <label class="block text-[11px] font-medium text-gray-700">
        {{ label }}
      </label>
      <span
        v-if="disabled"
        class="inline-flex items-center gap-0.5 text-[9px] font-medium text-amber-700"
      >
        <Lock class="w-2.5 h-2.5" />
        Terkunci
      </span>
    </div>
    <input
      :value="modelValue"
      :type="type"
      :placeholder="placeholder"
      :disabled="disabled"
      class="w-full rounded-md px-2.5 py-1.5 text-xs border transition"
      :class="
        disabled
          ? 'bg-gray-300/80 text-gray-600 border-gray-300 cursor-not-allowed'
          : 'bg-gray-200/90 text-gray-900 placeholder:text-gray-400 border-transparent focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-600/40 focus:border-green-600/40'
      "
      @input="onInput"
    />
  </div>
</template>
