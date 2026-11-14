import { ref } from 'vue'
import type { ProductItem } from '~/types'

export const productCatalog = ref<ProductItem[]>([])
let loadPromise: Promise<void> | null = null

export async function ensureProductsLoaded(): Promise<void> {
  if (productCatalog.value.length > 0) return
  if (loadPromise) return loadPromise

  loadPromise = $fetch<ProductItem[]>('/api/products')
    .then((items) => {
      productCatalog.value = items
    })
    .catch((err) => {
      console.error('Failed to load product catalog:', err)
    })
    .finally(() => {
      loadPromise = null
    })

  return loadPromise
}

export function searchProducts(query: string, limit = 15): ProductItem[] {
  const q = query.trim().toUpperCase()
  if (!q) return []

  const results: ProductItem[] = []
  for (const item of productCatalog.value) {
    if (
      item.name.toUpperCase().includes(q) ||
      item.code.toUpperCase().includes(q)
    ) {
      results.push(item)
      if (results.length >= limit) break
    }
  }
  return results
}
