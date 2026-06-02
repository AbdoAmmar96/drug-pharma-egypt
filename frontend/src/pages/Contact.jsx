import { useState } from 'react'
import { Link } from 'react-router-dom'
import { submitContact } from '../lib/api'
import ContactIllustration from '../components/ContactIllustration'
import { useLang } from '../i18n/index.jsx'

export default function Contact() {
  const { t } = useLang()
  const [form, setForm] = useState({
    name: '', email: '', phone: '', topic: 'general', message: '',
  })
  const [status, setStatus] = useState({ state: 'idle', msg: '' })
  const [openFaq, setOpenFaq] = useState(0)

  const onChange = (k) => (e) => setForm((f) => ({ ...f, [k]: e.target.value }))

  const onSubmit = async (e) => {
    e.preventDefault()
    if (!form.name || !form.email || !form.message) {
      setStatus({ state: 'error', msg: t('contact.errorRequired') })
      return
    }
    setStatus({ state: 'sending', msg: '' })
    try {
      await submitContact(form)
      setStatus({ state: 'success', msg: t('contact.successMsg') })
      setForm({ name: '', email: '', phone: '', topic: 'general', message: '' })
    } catch (err) {
      setStatus({ state: 'error', msg: err?.response?.data?.message ?? t('contact.errorGeneric') })
    }
  }

  const faqs = t('contact.faq') // returns array
  const topics = t('contact.topics')

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

            <form onSubmit={onSubmit} className="space-y-5">
              <div className="grid sm:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-semibold mb-1.5">{t('contact.fName')}</label>
                  <input
                    type="text" value={form.name} onChange={onChange('name')}
                    className="w-full px-4 py-3 border border-line bg-white rounded-xl text-sm focus:outline-none focus:border-navy transition-colors"
                  />
                </div>
                <div>
                  <label className="block text-sm font-semibold mb-1.5">{t('contact.fEmail')}</label>
                  <input
                    type="email" value={form.email} onChange={onChange('email')}
                    className="w-full px-4 py-3 border border-line bg-white rounded-xl text-sm focus:outline-none focus:border-navy transition-colors"
                  />
                </div>
              </div>
              <div className="grid sm:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-semibold mb-1.5">{t('contact.fPhone')}</label>
                  <input
                    type="tel" value={form.phone} onChange={onChange('phone')}
                    className="w-full px-4 py-3 border border-line bg-white rounded-xl text-sm focus:outline-none focus:border-navy transition-colors"
                  />
                </div>
                <div>
                  <label className="block text-sm font-semibold mb-1.5">{t('contact.fTopic')}</label>
                  <select
                    value={form.topic} onChange={onChange('topic')}
                    className="w-full px-4 py-3 border border-line bg-white rounded-xl text-sm focus:outline-none focus:border-navy transition-colors"
                  >
                    <option value="general">{topics.general}</option>
                    <option value="pharmacy">{topics.pharmacy}</option>
                    <option value="partnership">{topics.partnership}</option>
                    <option value="product">{topics.product}</option>
                    <option value="careers">{topics.careers}</option>
                    <option value="other">{topics.other}</option>
                  </select>
                </div>
              </div>
              <div>
                <label className="block text-sm font-semibold mb-1.5">{t('contact.fMessage')}</label>
                <textarea
                  rows="5" value={form.message} onChange={onChange('message')}
                  className="w-full px-4 py-3 border border-line bg-white rounded-xl text-sm focus:outline-none focus:border-navy transition-colors resize-y"
                />
              </div>

              {status.state === 'error' && (
                <div className="bg-red-50 border border-red-200 text-red-700 text-sm p-3.5 rounded-xl">{status.msg}</div>
              )}
              {status.state === 'success' && (
                <div className="bg-green-50 border border-green-200 text-green-700 text-sm p-3.5 rounded-xl">{status.msg}</div>
              )}

              <button
                type="submit"
                disabled={status.state === 'sending'}
                className="bg-orange text-white px-7 py-3.5 rounded-full font-semibold text-sm shadow-orange hover:-translate-y-0.5 transition-transform inline-flex items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
              >
                {status.state === 'sending' ? t('contact.sending') : t('contact.submit')} <span className="arrow">→</span>
              </button>
            </form>
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
