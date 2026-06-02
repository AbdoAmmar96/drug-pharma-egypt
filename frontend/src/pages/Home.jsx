import { Link } from 'react-router-dom'
import { useAsync } from '../lib/useAsync'
import { fetchCategories, fetchFeaturedProducts } from '../lib/api'
import ProductCard from '../components/ProductCard'
import { useLang } from '../i18n/index.jsx'

const CATEGORY_TONES = {
  'child-neonates':       { className: 'bg-navy text-white col-span-12 lg:col-span-6',                       cta: 'text-orange',       light: false, num: '01 / Featured' },
  'pregnant-women':       { className: 'bg-orange-200 text-[#1F1F2E] col-span-12 lg:col-span-6',             cta: 'text-orange-700',   light: false, num: '02' },
  'pain-management':      { className: 'bg-white text-[#1F1F2E] border border-line col-span-12 lg:col-span-6', cta: 'text-orange-700', light: true,  num: '03' },
  'neuro-support':        { className: 'bg-orange text-white col-span-12 lg:col-span-6',                     cta: 'text-white',        light: false, num: '04' },
  'bone':                 { className: 'bg-navy text-white col-span-12 lg:col-span-4',                       cta: 'text-orange',       light: false, num: '05' },
  'antioxidant-immunity': { className: 'bg-white text-[#1F1F2E] border border-line col-span-12 lg:col-span-4', cta: 'text-orange-700', light: true,  num: '06' },
  'git-gut-health':       { className: 'bg-orange-200 text-[#1F1F2E] col-span-12 lg:col-span-4',             cta: 'text-orange-700',   light: false, num: '07' },
  'skin-care':            { className: 'bg-white text-[#1F1F2E] border border-line col-span-12 lg:col-span-12', cta: 'text-orange-700', light: true, num: '08' },
}

const CATEGORY_IMAGES = {
  'child-neonates':       { src: '/images/products/three-sharks.webp', alt: 'Three Sharks' },
  'pregnant-women':       { src: '/images/products/ovawomen.webp',     alt: 'Ovawomen' },
  'pain-management':      { src: '/images/products/trypsalin.webp',    alt: 'Trypsalin' },
  'neuro-support':        { src: '/images/products/colifly-500.webp',  alt: 'ColiFly' },
  'bone':                 { src: '/images/products/cartino-plus.webp', alt: 'Cartino Plus' },
  'antioxidant-immunity': { src: '/images/products/sodi-sachet.webp',  alt: 'Sodi Sachet' },
  'git-gut-health':       { src: '/images/products/stomicope.webp',    alt: 'Stomicope' },
  'skin-care':            { src: '/images/products/biotin-one.webp',   alt: 'Biotin One' },
}

const CATEGORY_NAMES = {
  'child-neonates':       'Child & Neonates Care',
  'pregnant-women':       'Pregnant & Women Care',
  'pain-management':      'Pain Management & Anti-inflammatory',
  'neuro-support':        'Neuro Support',
  'bone':                 'Bone Care',
  'antioxidant-immunity': 'Antioxidant & Immunity',
  'git-gut-health':       'GIT & Gut Health',
  'skin-care':            'Skin Care',
}

const CATEGORY_DESCS = {
  'child-neonates':       'Pediatric drops, syrups, and supplements specially formulated for infants and children — including Three Sharks, Three Drops, Vitosel Kids, IVY Nutra, and more.',
  'pregnant-women':       'Prenatal nutrition for fertility, pregnancy and lactation — Ovawomen, Feraminx Fe, Calcidol, Umega D, Uhans CDE.',
  'pain-management':      'Enzyme blends and neuropathic-pain formulations — Trypsalin family, 3 Fly, SP Whites, 7Calm, NT 300/600.',
  'neuro-support':        'Citicoline-based cognitive support — ColiFly 500/1000, ColiFly Plus, ColiFly Syrup.',
  'bone':                 'Joint, cartilage and topical relief — Cartino Plus, Moonflex, Three N 10,000, Hicool, Dolarex.',
  'antioxidant-immunity': 'Daily antioxidant & immunity sachets — Sodi Sachet, Vitosel Sachet.',
  'git-gut-health':       'Gastric comfort and probiotic care — Stomicope, L.C. Flora.',
  'skin-care':            'Specialty hair, skin and nail formulations — Biotin One.',
}

export default function Home() {
  const { data: categories } = useAsync(fetchCategories, [])
  const { data: featured } = useAsync(fetchFeaturedProducts, [])
  const { t } = useLang()

  return (
    <>
      {/* ============ Hero ============ */}
      <section className="relative py-24 lg:py-28 overflow-hidden">
        <div className="absolute -top-52 -right-52 w-[600px] h-[600px] rounded-full"
             style={{ background: 'radial-gradient(circle, var(--orange-200) 0%, transparent 70%)', filter: 'blur(60px)', opacity: 0.7 }} />
        <div className="absolute -bottom-72 -left-52 w-[700px] h-[700px] rounded-full"
             style={{ background: 'radial-gradient(circle, rgba(27, 35, 96, 0.08) 0%, transparent 70%)', filter: 'blur(60px)' }} />

        <div className="hero-image-first relative z-10 max-w-[1240px] mx-auto px-6 grid lg:grid-cols-[1.1fr_0.9fr] gap-14 items-center">
          <div>
            <span className="inline-flex items-center gap-2.5 bg-orange/10 text-orange-700 px-4 py-2 rounded-full text-[13px] font-semibold mb-6">
              <span className="w-1.5 h-1.5 bg-orange rounded-full animate-pulse-dot" />
              {t('home.heroEyebrow')}
            </span>
            <h1 className="text-[clamp(40px,6vw,78px)] font-extrabold leading-[1.05] tracking-tight mb-6">
              {t('home.heroTitle1')} <br /> {t('home.heroTitle2')} <span className="text-orange font-extrabold font-display">{t('home.heroTitleAccent')}</span> <br /> {t('home.heroTitle3')}
            </h1>
            <p className="text-lg text-[#6B6B7A] max-w-[520px] mb-9">{t('home.heroSubtitle')}</p>
            <div className="flex gap-3.5 flex-wrap">
              <Link to="/products" className="btn btn-primary">
                {t('home.ctaExplore')} <span className="arrow">→</span>
              </Link>
              <Link to="/about" className="btn btn-ghost">{t('home.ctaAbout')}</Link>
            </div>
          </div>

          <div className="hero-image-block relative h-[540px] flex items-center justify-center">
            <div className="hero-backdrop"></div>
            <img
              src="/images/products/vitosel-drops.webp"
              alt="Vitosel Drops"
              className="hero-product-circle"
              loading="eager"
            />
            <div className="floating-card fc-1">
              <span className="icon-circle">💊</span>
              <span>46+ Products</span>
            </div>
            <div className="floating-card fc-2">
              <span className="icon-circle">🌿</span>
              <span>Nutraceuticals</span>
            </div>
          </div>
        </div>
      </section>

      {/* ============ Trust strip ============ */}
      <section className="bg-navy text-white py-12 relative overflow-hidden">
        <div className="absolute inset-0 pointer-events-none"
             style={{ backgroundImage: 'radial-gradient(circle at 20% 50%, rgba(232, 115, 48, 0.15) 0%, transparent 50%)' }} />
        <div className="relative max-w-[1240px] mx-auto px-6 grid grid-cols-2 lg:grid-cols-4 gap-8">
          {[
            ['2016',  t('home.trust1Label')],
            ['46+',   t('home.trust2Label')],
            ['8',     t('home.trust3Label')],
            ['100%',  t('home.trust4Label')],
          ].map(([num, label]) => (
            <div key={num}>
              <h3 className="text-orange text-4xl font-extrabold leading-none mb-2 font-display">{num}</h3>
              <p className="text-white/75 text-sm">{label}</p>
            </div>
          ))}
        </div>
      </section>

      {/* ============ Categories ============ */}
      <section className="py-24">
        <div className="max-w-[1240px] mx-auto px-6">
          <div className="text-center mb-14 max-w-[700px] mx-auto">
            <span className="inline-block text-orange-700 font-semibold text-[13px] tracking-[0.15em] uppercase mb-3.5">{t('home.catEyebrow')}</span>
            <h2 className="text-[clamp(32px,4vw,52px)] font-bold mb-4">{t('home.catTitle')}</h2>
            <p className="text-[#6B6B7A] text-[17px]">{t('home.catSubtitle')}</p>
          </div>

          <div className="grid grid-cols-12 gap-5">
            {categories ? categories.map((cat) => {
              const tone = CATEGORY_TONES[cat.slug] || CATEGORY_TONES['for-adult']
              const img = CATEGORY_IMAGES[cat.slug]
              const localName = CATEGORY_NAMES[cat.slug] ?? cat.name
              const localDesc = CATEGORY_DESCS[cat.slug] ?? cat.description
              return (
                <Link
                  key={cat.id}
                  to={`/products?category=${cat.slug}`}
                  className={`cat-card ${tone.className} ${tone.light ? 'cat-light' : ''}`}
                >
                  <div className="cat-content">
                    <span className="num">{tone.num}</span>
                    <div>
                      <h3 className={tone.className.includes('text-white') ? '!text-white' : ''}>{localName}</h3>
                      <p>{localDesc}</p>
                      <span className="cat-cta" style={{ color: tone.cta.startsWith('text-') ? undefined : tone.cta }}>
                        {t('home.viewProducts', { count: cat.products_count })} →
                      </span>
                    </div>
                  </div>
                  <div className="cat-product-frame">
                    {img ? (
                      <img src={img.src} alt={img.alt} loading="lazy" />
                    ) : (
                      <div className="text-5xl">{cat.icon ?? '💊'}</div>
                    )}
                  </div>
                </Link>
              )
            }) : (
              <div className="col-span-12 py-20 text-center text-[#6B6B7A]">{t('home.loading')}</div>
            )}
          </div>
        </div>
      </section>

      {/* ============ Featured products ============ */}
      <section className="py-24" style={{ background: 'linear-gradient(180deg, transparent 0%, #fff 50%, transparent 100%)' }}>
        <div className="max-w-[1240px] mx-auto px-6">
          <div className="text-center mb-14 max-w-[700px] mx-auto">
            <span className="inline-block text-orange-700 font-semibold text-[13px] tracking-[0.15em] uppercase mb-3.5">{t('home.featEyebrow')}</span>
            <h2 className="text-[clamp(32px,4vw,52px)] font-bold mb-4">{t('home.featTitle')}</h2>
            <p className="text-[#6B6B7A] text-[17px]">{t('home.featSubtitle')}</p>
          </div>

          <div className="grid grid-cols-2 lg:grid-cols-4 gap-6">
            {featured ? (
              featured.length === 0 ? (
                <p className="col-span-full text-center text-[#6B6B7A] py-10">{t('home.featNone')}</p>
              ) : (
                featured.slice(0, 4).map((p) => <ProductCard key={p.id} product={p} />)
              )
            ) : (
              <div className="col-span-full text-center text-[#6B6B7A] py-10">{t('home.loading')}</div>
            )}
          </div>

          <div className="text-center mt-14">
            <Link to="/products" className="btn btn-orange">
              {t('home.featAll')} <span className="arrow">→</span>
            </Link>
          </div>
        </div>
      </section>

      {/* ============ CTA ============ */}
      <section className="py-12">
        <div className="max-w-[1240px] mx-auto px-6">
          <div className="rounded-3xl p-16 text-center text-white relative overflow-hidden"
               style={{ background: 'linear-gradient(135deg, var(--navy) 0%, var(--navy-900) 100%)' }}>
            <div className="absolute -top-24 -right-24 w-[400px] h-[400px] rounded-full pointer-events-none"
                 style={{ background: 'radial-gradient(circle, var(--orange) 0%, transparent 70%)', opacity: 0.2, filter: 'blur(40px)' }} />
            <div className="relative">
              <h2 className="!text-white text-[clamp(28px,3.5vw,44px)] font-bold mb-4">{t('home.finalCtaTitle')}</h2>
              <p className="text-white/80 text-[17px] mb-8 max-w-[600px] mx-auto">{t('home.finalCtaText')}</p>
              <Link to="/contact" className="btn btn-orange">{t('home.finalCtaBtn')} <span className="arrow">→</span></Link>
            </div>
          </div>
        </div>
      </section>
    </>
  )
}
