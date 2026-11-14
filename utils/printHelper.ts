import type { BandrolSizePreset } from '~/types'
import { getF4LayoutInfo } from '~/utils/constants'

/**
 * Injects a dynamic @page CSS rule matching the active preset dimensions (in mm)
 * and invokes window.print(), then cleans up the temporary style tag.
 */
export function triggerBandrolPrint(preset: BandrolSizePreset): void {
  if (typeof window === 'undefined') return

  const layout = getF4LayoutInfo(preset)
  const useF4Imposition = layout.isTiledPoster || preset.id === 'mini-mikro'
  const pageWidthMm = useF4Imposition ? layout.sheetWidthMm : preset.widthMm
  const pageHeightMm = useF4Imposition ? layout.sheetHeightMm : preset.heightMm

  const styleId = 'bandrol-dynamic-page-style'
  let styleEl = document.getElementById(styleId) as HTMLStyleElement | null
  if (!styleEl) {
    styleEl = document.createElement('style')
    styleEl.id = styleId
    document.head.appendChild(styleEl)
  }

  styleEl.textContent = `
    @page {
      size: ${pageWidthMm}mm ${pageHeightMm}mm;
      margin: 0;
    }
  `

  const cleanup = () => {
    styleEl?.remove()
    window.removeEventListener('afterprint', cleanup)
  }
  window.addEventListener('afterprint', cleanup)

  window.print()
}

