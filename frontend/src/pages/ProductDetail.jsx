import { useEffect, useState } from 'react'
import { Link, useNavigate, useParams } from 'react-router-dom'
import { fetchProduct } from '../lib/api'
import ProductCard from '../components/ProductCard'
import { useLang } from '../i18n/index.jsx'

export default function ProductDetail() {
  const { slug } = useParams()
  const navigate = useNavigate()
  const { t } = useLang()
  const [data, setData] = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    let cancelled = false
    setLoading(true)
    fetchProduct(slug)
      .then((res) => { if (!cancelled) setData(res) })
      .catch(() => { if (!cancelled) navigate('/products') })
      .finally(() => { if (!cancelled) setLoading(false) })
    return () => { cancelled = true }
  }, [slug, navigate])

  if (loading) {
    return (
      <div className="max-w-[1240px] mx-auto px-6 py-32 text-center text-[#6B6B7A]">
        {t('home.loading')}
      </div>
    )
  }
  if (!data) return null

  const { product, related } = data
  const localCatName = (cat) => cat?.name

  return (
    <>
      <section className="py-12">
        <div className="max-w-[1240px] mx-auto px-6">
          <div className="flex gap-2 items-center text-sm text-[#6B6B7A] mb-8 flex-wrap">
            <Link to="/" className="hover:text-orange transition-colors">{t('common.breadcrumbHome')}</Link>
            <span className="opacity-50">/</span>
            <Link to="/products" className="hover:text-orange transition-colors">{t('products.breadcrumb')}</Link>
            <span className="opacity-50">/</span>
            <span className="text-[#1F1F2E]">{product.name}</span>
          </div>

          <div className="grid lg:grid-cols-[1fr_1.1fr] gap-12">
            {/* Image */}
            <div className="lg:sticky lg:top-32 self-start">
              <div className="aspect-square bg-white rounded-3xl border border-line p-8 flex items-center justify-center">
                {product.image_url ? (
                  <img src={product.image_url} alt={product.name} className="max-h-full max-w-full object-contain" />
                ) : (
                  <div className="text-8xl opacity-50">💊</div>
                )}
              </div>
            </div>

            {/* Info */}
            <div>
              {product.category && (
                <Link
                  to={`/products?category=${product.category.slug}`}
                  className="inline-block bg-orange-200 text-orange-700 px-3.5 py-1.5 rounded-full text-xs font-semibold mb-4"
                >
                  {localCatName(product.category)}
                </Link>
              )}
              <h1 className="text-[clamp(32px,4vw,52px)] font-extrabold mb-3">{product.name}</h1>
              {product.form && <p className="text-orange-700 font-semibold mb-4">{product.form}</p>}
              {product.description && <p className="text-[17px] text-[#6B6B7A] leading-relaxed mb-8">{product.description}</p>}

              {product.composition && (
                <div className="mb-7">
                  <h3 className="text-base font-bold tracking-wide uppercase text-orange-700 mb-3">{t('detail.composition')}</h3>
                  <p className="text-[#1F1F2E] whitespace-pre-line">{product.composition}</p>
                </div>
              )}
              {product.uses && (
                <div className="mb-7">
                  <h3 className="text-base font-bold tracking-wide uppercase text-orange-700 mb-3">{t('detail.uses')}</h3>
                  <ul className="space-y-2 text-[#1F1F2E]">
                    {product.uses
                      .split(/\r?\n|[،,.;•·]/)
                      .map((s) => s.trim())
                      .filter(Boolean)
                      .map((use, i) => (
                        <li key={i} className="flex items-baseline gap-2.5">
                          <span className="text-orange text-[10px] leading-none flex-shrink-0">●</span>
                          <span>{use}</span>
                        </li>
                      ))}
                  </ul>
                </div>
              )}
              {product.dose && (
                <div className="mb-9">
                  <h3 className="text-base font-bold tracking-wide uppercase text-orange-700 mb-3">{t('detail.dose')}</h3>
                  <p className="text-[#1F1F2E] whitespace-pre-line">{product.dose}</p>
                </div>
              )}

              <div className="flex gap-3 flex-wrap">
                <Link to="/contact" className="btn btn-primary">
                  {t('detail.ctaContact')} <span className="arrow">→</span>
                </Link>
                <Link to="/products" className="btn btn-ghost">{t('detail.ctaBack')}</Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Related */}
      {related && related.length > 0 && (
        <section className="py-20">
          <div className="max-w-[1240px] mx-auto px-6">
            <h2 className="text-3xl font-bold mb-8">
              {t('detail.relatedTitle', { category: localCatName(product.category) })}
            </h2>
            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              {related.map((p) => <ProductCard key={p.id} product={p} />)}
            </div>
          </div>
        </section>
      )}
    </>
  )
}
