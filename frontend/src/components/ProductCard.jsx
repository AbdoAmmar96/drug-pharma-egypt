import { Link } from 'react-router-dom'

// Slugs whose images need extra zoom (smaller-rendered source files).
// LARGER ≈ 75% bigger than baseline (92% → 161%).
// EXTRA_LARGE ≈ 75% + 25% bigger (92% → 201%).
const LARGER_IMAGE_SLUGS = new Set([
  '3-fly-syrup',
  'three-drops',
  'three-agar',
  'dolarex-massage',
  'lc-flora',
])
const EXTRA_LARGE_IMAGE_SLUGS = new Set([
  '7calm',
  'nt-300',
  'nt-600',
])

export default function ProductCard({ product }) {
  const initials = product.name?.slice(0, 2).toUpperCase() ?? '—'
  const zoomLarge = LARGER_IMAGE_SLUGS.has(product.slug)
  const zoomExtra = EXTRA_LARGE_IMAGE_SLUGS.has(product.slug)

  return (
    <Link
      to={`/products/${product.slug}`}
      className="product-card group bg-white rounded-3xl p-5 border border-line transition-all hover:-translate-y-1.5 hover:shadow-card hover:border-transparent flex flex-col"
    >
      <div className="product-card-image-wrap w-full aspect-square bg-gradient-to-br from-bg to-white rounded-2xl flex items-center justify-center mb-4 overflow-hidden">
        {product.image_url ? (
          <img
            src={product.image_url}
            alt={product.name}
            loading="lazy"
            className={`object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110 ${
              zoomExtra ? 'max-w-[201%] max-h-[201%]'
                : zoomLarge ? 'max-w-[161%] max-h-[161%]'
                : 'max-w-[92%] max-h-[92%]'
            }`}
          />
        ) : (
          <div className="relative w-3/4 h-3/4 flex items-center justify-center">
            <div className="absolute inset-0 rounded-full"
                 style={{
                   background: 'linear-gradient(180deg, #E87330 50%, #1B2360 50%)',
                   borderRadius: '999px',
                 }}
            />
            <span className="relative text-white font-bold font-display text-base">{initials}</span>
          </div>
        )}
      </div>

      {product.category && (
        <span className="product-card-badge self-start text-[10.5px] font-bold text-orange-700 bg-orange-200 px-2.5 py-1 rounded-full tracking-wider uppercase mb-2.5">
          {product.category.name}
        </span>
      )}

      <h4 className="product-card-name text-[18px] !text-navy mb-1.5 font-bold">{product.name}</h4>

      {product.description && (
        <p className="text-[13px] text-[#6B6B7A] leading-snug flex-1 product-card-desc">{product.description}</p>
      )}

      {product.form && (
        <div className="product-card-form mt-4 pt-3.5 border-t border-line text-xs flex justify-between items-center">
          <strong className="text-navy font-bold">{product.form}</strong>
          <span className="form-arrow w-7 h-7 rounded-full bg-bg flex items-center justify-center transition-all group-hover:bg-orange group-hover:text-white">→</span>
        </div>
      )}
    </Link>
  )
}
