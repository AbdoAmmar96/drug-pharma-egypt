import { Link } from 'react-router-dom'
import { useLang } from '../i18n/index.jsx'

export default function NotFound() {
  const { t } = useLang()
  return (
    <section className="py-32">
      <div className="max-w-[700px] mx-auto px-6 text-center">
        <div className="text-[140px] font-extrabold leading-none text-orange opacity-20 mb-4 font-display">404</div>
        <h1 className="text-[clamp(32px,4vw,52px)] font-bold mb-4">
          {t('notFound.title1')} <span className="text-orange font-extrabold font-display">{t('notFound.titleAccent')}</span>{t('notFound.title2')}
        </h1>
        <p className="text-[#6B6B7A] text-[17px] mb-8">{t('notFound.subtitle')}</p>
        <div className="flex gap-3 justify-center flex-wrap">
          <Link to="/" className="btn btn-primary">{t('notFound.ctaHome')} <span className="arrow">→</span></Link>
          <Link to="/products" className="btn btn-ghost">{t('notFound.ctaProducts')}</Link>
        </div>
      </div>
    </section>
  )
}
