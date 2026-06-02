import axios from 'axios'

const baseURL = (import.meta.env.VITE_API_BASE || '') + '/api/v1'

const api = axios.create({
  baseURL,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
  timeout: 12_000,
})

// In-memory cache to avoid re-fetching the same endpoint within a session.
const cache = new Map()
const TTL = 5 * 60 * 1000 // 5 minutes

const cached = async (key, loader) => {
  const hit = cache.get(key)
  if (hit && Date.now() - hit.at < TTL) return hit.value
  const value = await loader()
  cache.set(key, { value, at: Date.now() })
  return value
}

// ==========================================================
// Categories
// ==========================================================
export const fetchCategories = () =>
  cached('categories', async () => {
    const { data } = await api.get('/categories')
    return data.data
  })

export const fetchCategory = (slug) =>
  cached(`category:${slug}`, async () => {
    const { data } = await api.get(`/categories/${slug}`)
    return data.data
  })

// ==========================================================
// Products
// ==========================================================
export const fetchProducts = ({ category = '', search = '', featured = false, perPage = 50 } = {}) => {
  const key = `products:${category}|${search}|${featured}|${perPage}`
  return cached(key, async () => {
    const params = {}
    if (category) params.category = category
    if (search) params.search = search
    if (featured) params.featured = 1
    if (perPage) params.per_page = perPage

    const { data } = await api.get('/products', { params })
    return {
      items: data.data ?? [],
      meta: data.meta ?? null,
    }
  })
}

export const fetchFeaturedProducts = () =>
  cached('featured', async () => {
    const { data } = await api.get('/products/featured')
    return data.data
  })

export const fetchProduct = (slug) =>
  cached(`product:${slug}`, async () => {
    const { data } = await api.get(`/products/${slug}`)
    return {
      product: data.data,
      related: data.related ?? [],
    }
  })

// ==========================================================
// Contact
// ==========================================================
export const submitContact = async (payload) => {
  const { data } = await api.post('/contact', payload)
  return data
}

export default api
