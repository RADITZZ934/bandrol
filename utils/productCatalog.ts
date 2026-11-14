import csvRaw from '~/api/hardcoded/data_produk.csv?raw'
import type { ProductItem } from '~/types'

function parseProductCsv(raw: string): ProductItem[] {
  const lines = raw.split(/\r?\n/)
  const items: ProductItem[] = []

  for (let i = 0; i < lines.length; i++) {
    const line = lines[i].trim()
    if (!line) continue

    const commaIndex = line.indexOf(',')
    if (commaIndex === -1) continue

    const rawCode = line.slice(0, commaIndex).trim().replace(/^"|"$/g, '')
    const rawName = line.slice(commaIndex + 1).trim().replace(/^"|"$/g, '')

    // Skip header row
    if (
      i === 0 &&
      rawCode.toLowerCase().includes('kode') &&
      rawName.toLowerCase().includes('nama')
    ) {
      continue
    }

    if (rawName) {
      items.push({ code: rawCode, name: rawName })
    }
  }

  return items
}

export const PRODUCT_CATALOG: ProductItem[] = parseProductCsv(csvRaw)

export function searchProducts(query: string, limit = 15): ProductItem[] {
  const q = query.trim().toUpperCase()
  if (!q) return []

  const results: ProductItem[] = []
  for (const item of PRODUCT_CATALOG) {
    if (item.name.toUpperCase().includes(q) || item.code.toUpperCase().includes(q)) {
      results.push(item)
      if (results.length >= limit) break
    }
  }
  return results
}

