import { Link } from 'react-router-dom'
import { useLang } from '../i18n/index.jsx'

const FOOTER_CATEGORIES = [
  { slug: 'child-neonates',       label: 'Child & Neonates' },
  { slug: 'pregnant-women',       label: 'Pregnant & Women' },
  { slug: 'pain-management',      label: 'Pain Management' },
  { slug: 'neuro-support',        label: 'Neuro Support' },
  { slug: 'bone',                 label: 'Bone Care' },
  { slug: 'antioxidant-immunity', label: 'Antioxidant & Immunity' },
  { slug: 'git-gut-health',       label: 'GIT & Gut Health' },
  { slug: 'skin-care',            label: 'Skin Care' },
]

export default function Footer() {
  const { t } = useLang()
  const year = new Date().getFullYear()

  return (
    <footer className="bg-navy-900 text-white/70 pt-20 pb-8 mt-20">
      <div className="max-w-[1240px] mx-auto px-6">
        <div className="grid md:grid-cols-[1.5fr_1fr_1fr_1fr] gap-12 pb-14 border-b border-white/10">
          <div>
            <Link to="/" className="inline-block mb-4">
              <img src="/logo-footer.png" alt="Drug Pharma Egypt" className="h-[120px] w-auto brightness-110" />
            </Link>
            <p className="text-[14.5px] max-w-[320px] leading-relaxed">{t('footer.tagline')}</p>
          </div>

          <div>
            <h4 className="!text-white text-sm font-bold tracking-[0.12em] uppercase mb-5 font-display">{t('footer.company')}</h4>
            <ul className="space-y-2.5 text-[14.5px]">
              <li><Link to="/about"    className="hover:text-orange transition-colors">{t('footer.aboutUs')}</Link></li>
              <li><Link to="/products" className="hover:text-orange transition-colors">{t('footer.products')}</Link></li>
              <li><Link to="/contact"  className="hover:text-orange transition-colors">{t('footer.contact')}</Link></li>
            </ul>
          </div>

          <div>
            <h4 className="!text-white text-sm font-bold tracking-[0.12em] uppercase mb-5 font-display">{t('footer.categories')}</h4>
            <ul className="space-y-2.5 text-[14.5px]">
              {FOOTER_CATEGORIES.map((c) => (
                <li key={c.slug}>
                  <Link to={`/products?category=${c.slug}`} className="hover:text-orange transition-colors">
                    {c.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h4 className="!text-white text-sm font-bold tracking-[0.12em] uppercase mb-5 font-display">{t('footer.contacts')}</h4>
            <ul className="space-y-2.5 text-[14.5px]">
              <li className="whitespace-pre-line">{t('footer.address')}</li>
              <li><a href="tel:01285164907" className="hover:text-orange transition-colors">+20 1285164907</a></li>
              <li><a href="mailto:hr@drugpharmaeg.com" className="hover:text-orange transition-colors">hr@drugpharmaeg.com</a></li>
              <li><a href="mailto:export@drugpharmaeg.com" className="hover:text-orange transition-colors">export@drugpharmaeg.com</a></li>
            </ul>

            <div className="flex items-center gap-3 mt-5">
              <a
                href="https://www.facebook.com/share/14mRRRezySX/"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Facebook"
                className="w-9 h-9 rounded-full bg-white/10 hover:bg-orange flex items-center justify-center transition-colors"
              >
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" className="text-white" aria-hidden="true">
                  <path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5 3.66 9.15 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.52 1.5-3.91 3.78-3.91 1.09 0 2.24.2 2.24.2v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.77l-.44 2.91h-2.33V22c4.78-.79 8.43-4.94 8.43-9.94z"/>
                </svg>
              </a>
              <a
                href="https://www.linkedin.com/company/drug-pharma-egypt/"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="LinkedIn"
                className="w-9 h-9 rounded-full bg-white/10 hover:bg-orange flex items-center justify-center transition-colors"
              >
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" className="text-white" aria-hidden="true">
                  <path d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.95v5.66H9.34V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.61 0 4.28 2.38 4.28 5.47v6.27zM5.34 7.43a2.07 2.07 0 1 1 0-4.14 2.07 2.07 0 0 1 0 4.14zM7.12 20.45H3.56V9h3.56v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.72V1.72C24 .77 23.2 0 22.22 0z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>

        <div className="pt-7 flex justify-between items-center flex-wrap gap-3 text-[13px]">
          <span>{t('footer.copyright', { year })}</span>
          <span className="opacity-70">{t('footer.brandName')}</span>
        </div>
      </div>
    </footer>
  )
}
