import { useEffect, useState } from 'react'
import { Link, useSearchParams } from 'react-router-dom'
import { fetchCategories, fetchProducts } from '../lib/api'
import ProductCard from '../components/ProductCard'
import { useLang } from '../i18n/index.jsx'

export default function Products() {
  const [searchParams, setSearchParams] = useSearchParams()
  const { t } = useLang()

  const initialCategory = searchParams.get('category') ?? 'all'
  const initialSearch = searchParams.get('q') ?? ''

  const [categories, setCategories] = useState([])
  const [products, setProducts] = useState([])
  const [meta, setMeta] = useState(null)
  const [loading, setLoading] = useState(true)
  const [activeCat, setActiveCat] = useState(initialCategory)
  const [query, setQuery] = useState(initialSearch)
  const [debouncedQ, setDebouncedQ] = useState(initialSearch)
  const [filterOpen, setFilterOpen] = useState(false)

  useEffect(() => {
    fetchCategories().then(setCategories).catch(() => {})
  }, [])

  useEffect(() => {
    const tm = setTimeout(() => setDebouncedQ(query), 300)
    return () => clearTimeout(tm)
  }, [query])

  useEffect(() => {
    const params = {}
    if (activeCat && activeCat !== 'all') params.category = activeCat
    if (debouncedQ) params.q = debouncedQ
    setSearchParams(params, { replace: true })
  }, [activeCat, debouncedQ, setSearchParams])

  useEffect(() => {
    let cancelled = false
    setLoading(true)
    fetchProducts({
      category: activeCat === 'all' ? '' : activeCat,
      search: debouncedQ,
      perPage: 50,
    })
      .then(({ items, meta }) => {
        if (cancelled) return
        setProducts(items)
        setMeta(meta)
      })
      .catch(() => { if (!cancelled) setProducts([]) })
      .finally(() => { if (!cancelled) setLoading(false) })
    return () => { cancelled = true }
  }, [activeCat, debouncedQ])

  const totalCount = meta?.total ?? products.length
  const localCatName = (cat) => cat.name

  return (
    <>
      <section className="relative py-20 overflow-hidden">
        <div className="absolute -top-52 -right-52 w-[500px] h-[500px] rounded-full"
             style={{ background: 'radial-gradient(circle, var(--orange-200) 0%, transparent 70%)', filter: 'blur(60px)', opacity: 0.6 }} />
        <div className="relative max-w-[1240px] mx-auto px-6">
          <div className="flex gap-2 items-center text-sm text-[#6B6B7A] mb-3.5">
            <Link to="/" className="hover:text-orange transition-colors">{t('common.breadcrumbHome')}</Link>
            <span className="opacity-50">/</span>
            <span>{t('products.breadcrumb')}</span>
          </div>
          <h1 className="text-[clamp(40px,6vw,64px)] font-extrabold mb-4">
            {t('products.heroTitle1')} <span className="text-orange font-extrabold font-display">{t('products.heroTitleAccent')}</span>{t('products.heroTitle2')}
          </h1>
          <p className="text-lg text-[#6B6B7A] max-w-[600px]">{t('products.heroSubtitle')}</p>
        </div>
      </section>

      <div className="sticky top-[76px] z-[60] bg-bg py-6 border-b border-line mb-12">
        <div className="max-w-[1240px] mx-auto px-6 flex gap-3 items-center flex-wrap">
          {/* Desktop: chips inline. Mobile: hidden, replaced by icon button. */}
          <div className="hidden md:flex gap-2 flex-wrap flex-1">
            <button
              type="button"
              onClick={() => setActiveCat('all')}
              className={`px-5 py-2.5 rounded-full text-[13.5px] font-semibold border transition-colors whitespace-nowrap ${
                activeCat === 'all'
                  ? 'bg-navy text-white border-navy'
                  : 'bg-white border-line hover:border-navy text-[#1F1F2E]'
              }`}
            >
              {t('products.filterAll')} <span className="opacity-60 ms-1 font-medium">{categories.reduce((s, c) => s + (c.products_count ?? 0), 0) || ''}</span>
            </button>
            {categories.map((cat) => (
              <button
                key={cat.id}
                type="button"
                onClick={() => setActiveCat(cat.slug)}
                className={`px-5 py-2.5 rounded-full text-[13.5px] font-semibold border transition-colors whitespace-nowrap ${
                  activeCat === cat.slug
                    ? 'bg-navy text-white border-navy'
                    : 'bg-white border-line hover:border-navy text-[#1F1F2E]'
                }`}
              >
                {localCatName(cat)} <span className="opacity-60 ms-1 font-medium">{cat.products_count}</span>
              </button>
            ))}
          </div>

          {/* Mobile-only: filter icon button */}
          <button
            type="button"
            onClick={() => setFilterOpen(true)}
            aria-label="Open filters"
            className="md:hidden inline-flex items-center justify-center gap-2 bg-navy text-white px-4 py-2.5 rounded-full text-[13px] font-semibold"
          >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
              <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
            Filter
            {activeCat !== 'all' && <span className="bg-orange w-2 h-2 rounded-full" />}
          </button>

          <div className="relative w-full md:w-72 flex-1 md:flex-none">
            <input
              type="text"
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              placeholder={t('products.searchPlaceholder')}
              className="w-full ps-10 pe-5 py-2.5 border border-line bg-white rounded-full text-sm focus:outline-none focus:border-navy transition-colors"
            />
            <span className="absolute start-4 top-1/2 -translate-y-1/2 opacity-60 text-sm">🔍</span>
          </div>
        </div>
      </div>

      {/* Mobile filter drawer */}
      {filterOpen && (
        <div className="md:hidden fixed inset-0 z-[100] bg-black/40" onClick={() => setFilterOpen(false)}>
          <div
            className="absolute bottom-0 inset-x-0 bg-white rounded-t-3xl p-6 max-h-[80vh] overflow-y-auto"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-lg font-bold">Filter Products</h3>
              <button
                type="button"
                onClick={() => setFilterOpen(false)}
                aria-label="Close"
                className="w-9 h-9 rounded-full bg-bg flex items-center justify-center text-xl"
              >×</button>
            </div>
            <div className="flex flex-col gap-2">
              <button
                type="button"
                onClick={() => { setActiveCat('all'); setFilterOpen(false) }}
                className={`text-start px-5 py-3 rounded-2xl text-[14px] font-semibold border transition-colors ${
                  activeCat === 'all'
                    ? 'bg-navy text-white border-navy'
                    : 'bg-white border-line text-[#1F1F2E]'
                }`}
              >
                {t('products.filterAll')} <span className="opacity-60 ms-2 font-medium">{categories.reduce((s, c) => s + (c.products_count ?? 0), 0) || ''}</span>
              </button>
              {categories.map((cat) => (
                <button
                  key={cat.id}
                  type="button"
                  onClick={() => { setActiveCat(cat.slug); setFilterOpen(false) }}
                  className={`text-start px-5 py-3 rounded-2xl text-[14px] font-semibold border transition-colors ${
                    activeCat === cat.slug
                      ? 'bg-navy text-white border-navy'
                      : 'bg-white border-line text-[#1F1F2E]'
                  }`}
                >
                  {localCatName(cat)} <span className="opacity-60 ms-2 font-medium">{cat.products_count}</span>
                </button>
              ))}
            </div>
          </div>
        </div>
      )}

      <div className="max-w-[1240px] mx-auto px-6">
        <div className="pb-6 text-[#6B6B7A] text-sm">
          {loading ? t('home.loading') : (
            <>
              {t('products.showing')} <strong className="text-[#1F1F2E]">{totalCount}</strong>{' '}
              {totalCount === 1 ? t('products.product') : t('products.productPlural')}
              {debouncedQ ? <> {t('products.matching')} "<strong className="text-[#1F1F2E]">{debouncedQ}</strong>"</> : null}
            </>
          )}
        </div>

        {!loading && products.length === 0 ? (
          <div className="py-20 text-center text-[#6B6B7A]">
            <h3 className="text-2xl !text-[#1F1F2E] mb-2">{t('products.noResults')}</h3>
            <p>{t('products.noResultsHint')}</p>
          </div>
        ) : (
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-20">
            {products.map((p) => <ProductCard key={p.id} product={p} />)}
          </div>
        )}
      </div>
    </>
  )
}
