import { ref } from 'vue'
import html2canvas from 'html2canvas'
import { jsPDF } from 'jspdf'
import { useBandrolStore } from '~/stores/bandrolStore'
import { getPresetById } from '~/utils/constants'

export function usePdfExport() {
  const store = useBandrolStore()
  const isExporting = ref(false)
  const exportError = ref<string | null>(null)

  async function exportToPdf() {
    if (typeof window === 'undefined' || isExporting.value) return

    isExporting.value = true
    exportError.value = null

    try {
      const pageElements = Array.from(
        document.querySelectorAll<HTMLElement>('.bandrol-print-page')
      )

      if (pageElements.length === 0) {
        throw new Error('Tidak ada halaman bandrol untuk diekspor.')
      }

      let pdf: jsPDF | null = null

      for (let i = 0; i < pageElements.length; i++) {
        const el = pageElements[i]
        const fallbackPreset = getPresetById(store.pages[i]?.sizeId ?? 'f4-landscape')
        const widthMm = Number(el.dataset.widthMm) || fallbackPreset.widthMm
        const heightMm = Number(el.dataset.heightMm) || fallbackPreset.heightMm
        const orientation = widthMm >= heightMm ? 'landscape' : 'portrait'

        const canvas = await html2canvas(el, {
          scale: 2,
          useCORS: true,
          backgroundColor: '#ffffff',
          logging: false,
        })

        const imgData = canvas.toDataURL('image/png')

        if (!pdf) {
          pdf = new jsPDF({
            orientation,
            unit: 'mm',
            format: [widthMm, heightMm],
          })
        } else {
          pdf.addPage([widthMm, heightMm], orientation)
        }

        pdf.addImage(
          imgData,
          'PNG',
          0,
          0,
          widthMm,
          heightMm,
          undefined,
          'FAST'
        )
      }

      if (pdf) {
        const rawName = (store.fileName || 'bandrol').trim()
        const finalName = rawName.toLowerCase().endsWith('.pdf')
          ? rawName
          : `${rawName}.pdf`
        pdf.save(finalName)
      }
    } catch (err) {
      exportError.value =
        err instanceof Error ? err.message : 'Gagal mengekspor PDF.'
      console.error('PDF Export Error:', err)
    } finally {
      isExporting.value = false
    }
  }

  return {
    isExporting,
    exportError,
    exportToPdf,
  }
}

