import { Link } from 'react-router-dom'
import AboutIllustration from '../components/AboutIllustration'
import { useLang } from '../i18n/index.jsx'

export default function About() {
  const { t } = useLang()

  // Helper to render text with **bold** markers as <strong>
  const renderBold = (str) => {
    const parts = str.split(/(\*\*[^*]+\*\*)/g)
    return parts.map((p, i) => p.startsWith('**') && p.endsWith('**')
      ? <strong key={i} className="text-navy">{p.slice(2, -2)}</strong>
      : p)
  }

  return (
    <>
      {/* Page head */}
      <section className="relative py-20 overflow-hidden">
        <div className="absolute -top-52 -left-52 w-[500px] h-[500px] rounded-full"
             style={{ background: 'radial-gradient(circle, rgba(27, 35, 96, 0.08) 0%, transparent 70%)', filter: 'blur(60px)' }} />
        <div className="absolute -bottom-24 -right-24 w-[400px] h-[400px] rounded-full"
             style={{ background: 'radial-gradient(circle, var(--orange-200) 0%, transparent 70%)', filter: 'blur(60px)', opacity: 0.6 }} />

        <div className="hero-image-first relative max-w-[1240px] mx-auto px-6 grid lg:grid-cols-[1.15fr_0.85fr] gap-12 items-center">
          <div>
            <div className="flex gap-2 items-center text-sm text-[#6B6B7A] mb-3.5">
              <Link to="/" className="hover:text-orange transition-colors">{t('common.breadcrumbHome')}</Link>
              <span className="opacity-50">/</span>
              <span>{t('about.breadcrumb')}</span>
            </div>
            <h1 className="text-[clamp(40px,6vw,72px)] font-extrabold mb-6">
              {t('about.heroTitle1')} <span className="text-orange font-extrabold font-display">{t('about.heroTitleAccent')}</span>{t('about.heroTitle2')}
            </h1>
            <p className="text-lg text-[#6B6B7A] max-w-[720px]">{t('about.heroSubtitle')}</p>
          </div>

          <div className="hero-image-block relative h-[380px] flex items-center justify-center">
            <div className="hero-backdrop"></div>
            <div className="hero-product-circle hero-product-circle--illustration">
              <AboutIllustration />
            </div>
            <div className="floating-card fc-1">
              <span className="icon-circle">📅</span>
              <span>{t('about.since2016')}</span>
            </div>
            <div className="floating-card fc-2">
              <span className="icon-circle">🏭</span>
              <span>{t('about.nfsaApproved')}</span>
            </div>
          </div>
        </div>
      </section>

      {/* Story */}
      <section className="py-20">
        <div className="max-w-[1240px] mx-auto px-6 grid lg:grid-cols-[0.8fr_1.2fr] gap-16 items-start">
          <div>
            <span className="inline-block text-orange-700 font-semibold text-[13px] tracking-[0.15em] uppercase mb-3.5">{t('about.storyEyebrow')}</span>
            <h2 className="text-[clamp(32px,4vw,48px)] font-bold mb-6">{t('about.storyTitle')}</h2>
          </div>
          <div className="text-[#1F1F2E]">
            <p className="text-[17px] leading-loose mb-5">{renderBold(t('about.storyP1'))}</p>
            <p className="text-[17px] leading-loose mb-5 text-[#6B6B7A]">{t('about.storyP2')}</p>
            <p className="text-[17px] leading-loose mb-7 text-[#6B6B7A]">{renderBold(t('about.storyP3'))}</p>
            <ul className="list-none">
              {[1, 2, 3, 4].map((n) => (
                <li key={n} className="flex items-start gap-3.5 py-3.5 border-b border-dashed border-line text-[15.5px] last:border-0">
                  <span className="w-7 h-7 rounded-full bg-orange flex-shrink-0 flex items-center justify-center text-white text-sm">✓</span>
                  {t(`about.bullet${n}`)}
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>

      {/* Pillars */}
      <section className="py-20 bg-white">
        <div className="max-w-[1240px] mx-auto px-6">
          <span className="inline-block text-orange-700 font-semibold text-[13px] tracking-[0.15em] uppercase mb-3.5">{t('about.pillarsEyebrow')}</span>
          <h2 className="text-[clamp(32px,4vw,48px)] font-bold mb-3">{t('about.pillarsTitle')}</h2>
          <p className="text-[#6B6B7A] text-[17px] max-w-[600px] mb-12">{t('about.pillarsSubtitle')}</p>

          <div className="grid md:grid-cols-3 gap-5">
            {['01', '02', '03'].map((num, i) => (
              <div key={num} className="bg-white p-9 rounded-3xl border border-line transition-all hover:-translate-y-1.5 hover:shadow-card relative overflow-hidden group">
                <div className="text-orange-200 text-6xl font-extrabold leading-none mb-4 font-display">{num}</div>
                <h3 className="text-2xl mb-3">{t(`about.pillar${i+1}Title`)}</h3>
                <p className="text-[14.5px] text-[#6B6B7A]">{t(`about.pillar${i+1}Desc`)}</p>
                <div className="absolute top-0 left-0 w-full h-1 bg-orange origin-left scale-x-0 transition-transform duration-500 group-hover:scale-x-100" />
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Timeline */}
      <section className="py-20 timeline-section">
        <div className="max-w-[1240px] mx-auto px-6">
          <div className="timeline-card rounded-3xl p-16 lg:p-20 text-white relative overflow-hidden"
               style={{ background: 'var(--navy)' }}>
            <div className="absolute top-0 right-0 w-[400px] h-[400px] rounded-full"
                 style={{ background: 'radial-gradient(circle, var(--orange) 0%, transparent 70%)', opacity: 0.15, filter: 'blur(40px)' }} />
            <div className="relative">
              <span className="timeline-eyebrow inline-block text-orange font-semibold text-[13px] tracking-[0.15em] uppercase mb-3.5">{t('about.timelineEyebrow')}</span>
              <h2 className="timeline-title !text-white text-[clamp(28px,3.5vw,42px)] mb-4">{t('about.timelineTitle')}</h2>
              <p className="timeline-subtitle text-white/75 text-[17px] max-w-[600px] mb-14">{t('about.timelineSubtitle')}</p>

              <div className="timeline-grid grid grid-cols-2 lg:grid-cols-4 gap-8 relative">
                <div className="timeline-line-h hidden lg:block absolute top-2 left-6 right-6 h-0.5 bg-white/15" />
                <div className="timeline-line-v hidden absolute top-2 bottom-2 w-0.5 bg-white/15" style={{ insetInlineStart: '8px' }} />
                {[
                  ['2016', 1],
                  ['2019', 2],
                  ['2022', 3],
                  ['2023', 4],
                ].map(([year, n]) => (
                  <div key={year} className="timeline-item relative">
                    <div className="timeline-dot w-4 h-4 rounded-full bg-orange mb-7 relative z-10"
                         style={{ boxShadow: '0 0 0 4px rgba(232, 115, 48, 0.3)' }} />
                    <div className="timeline-year text-orange text-3xl font-extrabold mb-2 font-display">{year}</div>
                    <h4 className="timeline-item-title !text-white text-[17px] mb-2">{t(`about.ms${n}Title`)}</h4>
                    <p className="timeline-item-desc text-white/70 text-sm leading-relaxed">{t(`about.ms${n}Desc`)}</p>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-12">
        <div className="max-w-[1240px] mx-auto px-6">
          <div className="rounded-3xl p-16 text-center text-white relative overflow-hidden"
               style={{ background: 'linear-gradient(135deg, var(--navy) 0%, var(--navy-900) 100%)' }}>
            <div className="absolute -top-24 -right-24 w-[400px] h-[400px] rounded-full pointer-events-none"
                 style={{ background: 'radial-gradient(circle, var(--orange) 0%, transparent 70%)', opacity: 0.2, filter: 'blur(40px)' }} />
            <div className="relative">
              <h2 className="!text-white text-[clamp(28px,3.5vw,44px)] font-bold mb-4">{t('about.finalCtaTitle')}</h2>
              <p className="text-white/80 text-[17px] mb-8 max-w-[600px] mx-auto">{t('about.finalCtaText')}</p>
              <Link to="/contact" className="btn btn-orange">{t('home.finalCtaBtn')} <span className="arrow">→</span></Link>
            </div>
          </div>
        </div>
      </section>
    </>
  )
}
