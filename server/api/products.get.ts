import { readFileSync } from 'node:fs'
import { createRequire } from 'node:module'
import { resolve } from 'node:path'
import type { ProductItem } from '~/types'

const require = createRequire(import.meta.url)
const XLSX = require('xlsx') as typeof import('xlsx')

let cachedProducts: ProductItem[] | null = null

export default defineEventHandler((): ProductItem[] => {
  if (cachedProducts) {
    return cachedProducts
  }

  const filePath = resolve(process.cwd(), 'api/hardcoded/data_produk.xls')
  const buffer = readFileSync(filePath)
  const workbook = XLSX.read(buffer, { type: 'buffer' })
  const sheetName = workbook.SheetNames[0]
  if (!sheetName) return []

  const sheet = workbook.Sheets[sheetName]
  const rows = XLSX.utils.sheet_to_json<Record<string, unknown>>(sheet)

  cachedProducts = rows
    .map((row) => ({
      code: String(row['Kode Produk'] ?? '').trim(),
      name: String(row['Nama Produk'] ?? '').trim(),
      uom: String(row['UOM'] ?? 'PCS').trim().toUpperCase() || 'PCS',
      price:
        row['Price'] !== undefined && row['Price'] !== null
          ? String(Math.round(Number(row['Price']) || 0))
          : '',
    }))
    .filter((item) => item.name.length > 0)

  return cachedProducts
})
