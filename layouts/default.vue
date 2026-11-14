<script setup lang="ts">
import { onMounted } from 'vue'
import { useBandrolStore } from '~/stores/bandrolStore'
import ActionBar from '~/components/Header/ActionBar.vue'
import ControlPanel from '~/components/Sidebar/ControlPanel.vue'
import F4SheetPreview from '~/components/Canvas/F4SheetPreview.vue'

const store = useBandrolStore()

onMounted(() => {
  store.$subscribe((_mutation, state) => {
    try {
      window.sessionStorage.setItem(
        'bandrol-maker-session',
        JSON.stringify(state)
      )
    } catch {
      // Ignore storage quota errors
    }
  })
})
</script>

<template>
  <div
    class="h-screen w-screen overflow-hidden flex flex-col bg-[#d4d4d8] print:h-auto print:w-auto print:overflow-visible print:bg-white"
  >
    <ActionBar />

    <div class="flex-1 flex min-h-0 print:block">
      <ControlPanel />

      <main class="flex-1 flex min-w-0 min-h-0 relative print:block">
        <slot />
      </main>

      <F4SheetPreview />
    </div>
  </div>
</template>

