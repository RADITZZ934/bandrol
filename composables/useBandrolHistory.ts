import { ref, watch } from 'vue'
import { useRefHistory, watchDebounced } from '@vueuse/core'
import { useBandrolStore } from '~/stores/bandrolStore'

export function useBandrolHistory() {
  const store = useBandrolStore()
  const snapshotRef = ref(store.getSnapshot())
  let isApplying = false

  const { undo: rawUndo, redo: rawRedo, canUndo, canRedo, pause, resume } =
    useRefHistory(snapshotRef, {
      capacity: 50,
    })

  // Record store changes into snapshotRef (debounced so typing stays smooth)
  watchDebounced(
    () => store.getSnapshot(),
    (next) => {
      if (isApplying) return
      if (next !== snapshotRef.value) {
        snapshotRef.value = next
      }
    },
    { debounce: 180, maxWait: 600 }
  )

  watch(snapshotRef, (val) => {
    if (!isApplying) return
    store.applySnapshot(val)
  })

  function undo() {
    if (!canUndo.value) return
    isApplying = true
    pause()
    rawUndo()
    store.applySnapshot(snapshotRef.value)
    resume()
    setTimeout(() => {
      isApplying = false
    }, 50)
  }

  function redo() {
    if (!canRedo.value) return
    isApplying = true
    pause()
    rawRedo()
    store.applySnapshot(snapshotRef.value)
    resume()
    setTimeout(() => {
      isApplying = false
    }, 50)
  }

  return {
    undo,
    redo,
    canUndo,
    canRedo,
  }
}

