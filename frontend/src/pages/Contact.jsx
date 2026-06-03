import { useState } from 'react'
import { Link } from 'react-router-dom'
import ContactIllustration from '../components/ContactIllustration'
import ContactForm from '../components/ContactForm.jsx'
import { useLang } from '../i18n/index.jsx'

export default function Contact() {
  const { t } = useLang()
  const [openFaq, setOpenFaq] = useState(0)

  const faqs = t('contact.faq') // returns array

  return (
    <>
      {/* Hero */}
      <section className="relative py-20 overflow-hidden">
        <div className="absolute -top-52 -left-52 w-[500px] h-[500px] rounded-full"
             style={{ background: 'radial-gradient(circle, rgba(27, 35, 96, 0.08) 0%, transparent 70%)', filter: 'blur(60px)' }} />
        <div className="absolute -bottom-24 -right-24 w-[400px] h-[400px] rounded-full"
             style={{ background: 'radial-gradient(circle, var(--orange-200) 0%, transparent 70%)', filter: 'blur(60px)', opacity: 0.6 }} />

        <div className="hero-image-first relative max-w-[1240px] mx-auto px-6 grid lg:grid-cols-[1.1fr_0.9fr] gap-12 items-center">
          <div>
            <div className="flex gap-2 items-center text-sm text-[#6B6B7A] mb-3.5">
              <Link to="/" className="hover:text-orange transition-colors">{t('common.breadcrumbHome')}</Link>
              <span className="opacity-50">/</span>
              <span>{t('contact.breadcrumb')}</span>
            </div>
            <h1 className="text-[clamp(40px,6vw,72px)] font-extrabold mb-6">
              {t('contact.heroTitle1')} <span className="text-orange font-extrabold font-display">{t('contact.heroTitleAccent')}</span>{t('contact.heroTitle2')}
            </h1>
            <p className="text-lg text-[#6B6B7A] max-w-[560px]">{t('contact.heroSubtitle')}</p>
          </div>

          <div className="hero-image-block relative h-[380px] flex items-center justify-center">
            <div className="hero-backdrop"></div>
            <div className="hero-product-circle hero-product-circle--illustration">
              <ContactIllustration />
            </div>
            <div className="floating-card fc-1">
              <span className="icon-circle">⚡</span>
              <span>{t('contact.quickReply')}</span>
            </div>
            <div className="floating-card fc-2">
              <span className="icon-circle">📨</span>
              <span>{t('contact.response24h')}</span>
            </div>
          </div>
        </div>
      </section>

      {/* Info cards */}
      <section className="py-10">
        <div className="max-w-[1240px] mx-auto px-6 grid md:grid-cols-3 gap-5">
          <div className="bg-white p-8 rounded-2xl border border-line">
            <span className="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-orange-200 text-orange-700 text-2xl mb-4">📍</span>
            <h3 className="text-lg mb-2">{t('contact.visitTitle')}</h3>
            <p className="text-[#6B6B7A] text-[14.5px] leading-relaxed">{t('contact.visitBody')}</p>
          </div>
          <div className="bg-white p-8 rounded-2xl border border-line">
            <span className="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-orange-200 text-orange-700 text-2xl mb-4">📞</span>
            <h3 className="text-lg mb-2">{t('contact.callTitle')}</h3>
            <a href="tel:01285164907" className="text-[#1F1F2E] text-[14.5px] font-semibold hover:text-orange transition-colors block mb-1">01285164907</a>
            <a href="tel:01285164907" className="text-orange-700 text-sm font-semibold">{t('contact.callCta')} →</a>
          </div>
          <div className="bg-white p-8 rounded-2xl border border-line">
            <span className="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-orange-200 text-orange-700 text-2xl mb-4">✉️</span>
            <h3 className="text-lg mb-2">{t('contact.emailTitle')}</h3>
            <a href="mailto:hr@drugpharmaeg.com" className="text-[#1F1F2E] text-[14.5px] font-semibold hover:text-orange transition-colors block mb-1">hr@drugpharmaeg.com</a>
            <a href="mailto:export@drugpharmaeg.com" className="text-[#1F1F2E] text-[14.5px] font-semibold hover:text-orange transition-colors block mb-1">export@drugpharmaeg.com</a>
            <a href="mailto:hr@drugpharmaeg.com" className="text-orange-700 text-sm font-semibold">{t('contact.emailCta')} →</a>
          </div>
        </div>
      </section>

      {/* Form */}
      <section className="py-16">
        <div className="max-w-[1240px] mx-auto px-6">
          <div className="rounded-3xl bg-white border border-line p-10 lg:p-14 grid lg:grid-cols-[0.9fr_1.1fr] gap-12">
            <div>
              <span className="inline-block text-orange-700 font-semibold text-[13px] tracking-[0.15em] uppercase mb-3.5">{t('contact.formEyebrow')}</span>
              <h2 className="text-[clamp(28px,3.5vw,42px)] font-bold mb-4">{t('contact.formTitle')}</h2>
              <p className="text-[#6B6B7A] text-[16px]">{t('contact.formSubtitle')}</p>
            </div>

            <ContactForm />
          </div>
        </div>
      </section>

      {/* Map */}
      <section className="py-10">
        <div className="max-w-[1240px] mx-auto px-6">
          <div className="rounded-3xl overflow-hidden border border-line bg-white">
            <div className="px-8 py-6 border-b border-line">
              <h3 className="text-2xl mb-1">{t('contact.mapTitle')}</h3>
              <p className="text-[#6B6B7A] text-sm">{t('contact.mapSubtitle')}</p>
            </div>
            <iframe
              title="Drug Pharma Egypt location"
              src="https://www.openstreetmap.org/export/embed.html?bbox=31.41%2C30.00%2C31.49%2C30.05&layer=mapnik&marker=30.024%2C31.453"
              className="w-full h-[360px] border-0"
              loading="lazy"
            />
          </div>
        </div>
      </section>

      {/* FAQ */}
      <section className="py-20">
        <div className="max-w-[900px] mx-auto px-6">
          <div className="text-center mb-10">
            <span className="inline-block text-orange-700 font-semibold text-[13px] tracking-[0.15em] uppercase mb-3.5">{t('contact.faqEyebrow')}</span>
            <h2 className="text-[clamp(28px,3.5vw,42px)] font-bold mb-3">{t('contact.faqTitle')}</h2>
            <p className="text-[#6B6B7A]">{t('contact.faqSubtitle')}</p>
          </div>

          <div className="space-y-3">
            {Array.isArray(faqs) && faqs.map((f, i) => (
              <div key={i} className="bg-white border border-line rounded-2xl overflow-hidden">
                <button
                  type="button"
                  onClick={() => setOpenFaq(openFaq === i ? -1 : i)}
                  className="w-full p-6 text-start flex justify-between items-center font-semibold text-[#1F1F2E] hover:bg-orange-200/30 transition-colors"
                >
                  <span>{f.q}</span>
                  <span className={`text-orange transition-transform ${openFaq === i ? 'rotate-45' : ''}`}>+</span>
                </button>
                {openFaq === i && (
                  <div className="px-6 pb-5 text-[#6B6B7A] leading-relaxed">{f.a}</div>
                )}
              </div>
            ))}
          </div>
        </div>
      </section>
    </>
  )
}
