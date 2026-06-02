import { useState } from 'react'
import { NavLink, Link } from 'react-router-dom'
import { useLang } from '../i18n/index.jsx'

export default function Header() {
  const [open, setOpen] = useState(false)
  const { t } = useLang()

  const linkClass = ({ isActive }) =>
    `px-4 py-2 rounded-full font-medium text-[14.5px] transition-colors ${
      isActive
        ? 'bg-navy text-white'
        : 'text-[#1F1F2E] hover:bg-orange-200 hover:text-orange-700'
    }`

  return (
    <>
      {/* Top utility bar */}
      <div className="bg-navy text-white text-[13px]">
        <div className="max-w-[1240px] mx-auto px-6 py-2.5 flex items-center justify-between flex-wrap gap-3">
          <div className="flex items-center gap-6 flex-wrap">
            <a href="mailto:hr@drugpharmaeg.com" className="opacity-90 hover:opacity-100 transition-opacity">📧 hr@drugpharmaeg.com</a>
            <a href="tel:01285164907" className="opacity-90 hover:opacity-100 transition-opacity">📞 01285164907</a>
            <a
              href="https://www.google.com/maps/search/?api=1&query=Drug+Pharma+Egypt&query_place_id=&center=30.024,31.453"
              target="_blank"
              rel="noopener noreferrer"
              className="opacity-90 hover:opacity-100 transition-opacity"
            >📍 {t('topbar.locations')}</a>
          </div>
        </div>
      </div>

      {/* Header */}
      <header className="sticky top-0 z-[80] bg-white/85 backdrop-blur-md border-b border-line">
        <nav className="max-w-[1240px] mx-auto px-6 py-3.5 flex justify-between items-center">
          <Link to="/" className="flex items-center gap-2.5">
            <img src="/logo-header.jpeg" alt="Drug Pharma Egypt" className="h-14 w-auto" />
          </Link>

          <ul className="hidden md:flex items-center gap-1 list-none">
            <li><NavLink to="/" end className={linkClass}>{t('nav.home')}</NavLink></li>
            <li><NavLink to="/about" className={linkClass}>{t('nav.about')}</NavLink></li>
            <li><NavLink to="/products" className={linkClass}>{t('nav.products')}</NavLink></li>
            <li>
              <Link
                to="/contact"
                className="ms-1 bg-orange text-white px-5 py-2.5 rounded-full font-semibold text-sm shadow-orange hover:-translate-y-0.5 transition-transform inline-flex items-center gap-2"
              >
                {t('nav.cta')} <span className="arrow">→</span>
              </Link>
            </li>
          </ul>

          <button
            type="button"
            aria-label="Open menu"
            onClick={() => setOpen((v) => !v)}
            className="md:hidden bg-navy text-white px-3.5 py-2.5 rounded-full"
          >
            ☰
          </button>
        </nav>

        {/* Mobile menu */}
        {open && (
          <div className="md:hidden border-t border-line bg-white px-4 py-3 flex flex-col gap-1">
            <NavLink to="/"         end className={linkClass} onClick={() => setOpen(false)}>{t('nav.home')}</NavLink>
            <NavLink to="/about"        className={linkClass} onClick={() => setOpen(false)}>{t('nav.about')}</NavLink>
            <NavLink to="/products"     className={linkClass} onClick={() => setOpen(false)}>{t('nav.products')}</NavLink>
          </div>
        )}
      </header>
    </>
  )
}
