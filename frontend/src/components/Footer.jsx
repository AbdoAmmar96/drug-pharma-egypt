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
