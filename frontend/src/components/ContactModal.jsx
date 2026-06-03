import { useEffect } from 'react'
import ContactForm from './ContactForm.jsx'
import { useLang } from '../i18n/index.jsx'

export default function ContactModal({ open, onClose, title, subtitle, defaultTopic, defaultMessage }) {
  const { t } = useLang()

  useEffect(() => {
    if (!open) return
    const onKey = (e) => { if (e.key === 'Escape') onClose() }
    document.addEventListener('keydown', onKey)
    const prev = document.body.style.overflow
    document.body.style.overflow = 'hidden'
    return () => {
      document.removeEventListener('keydown', onKey)
      document.body.style.overflow = prev
    }
  }, [open, onClose])

  if (!open) return null

  return (
    <div
      className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
      onClick={onClose}
      role="dialog"
      aria-modal="true"
    >
      <div
        className="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] overflow-y-auto shadow-2xl"
        onClick={(e) => e.stopPropagation()}
      >
        <div className="flex items-start justify-between p-7 pb-2">
          <div>
            <span className="inline-block text-orange-700 font-semibold text-[12px] tracking-[0.15em] uppercase mb-2">
              {t('contact.formEyebrow')}
            </span>
            <h3 className="text-2xl font-bold mb-1">{title || t('contact.formTitle')}</h3>
            {subtitle && <p className="text-[#6B6B7A] text-[14.5px]">{subtitle}</p>}
          </div>
          <button
            type="button"
            onClick={onClose}
            aria-label="Close"
            className="text-2xl leading-none text-[#6B6B7A] hover:text-[#1F1F2E] transition-colors w-9 h-9 rounded-full flex items-center justify-center hover:bg-line/50 -mt-1"
          >
            ×
          </button>
        </div>
        <div className="px-7 pb-7">
          <ContactForm defaultTopic={defaultTopic} defaultMessage={defaultMessage} />
        </div>
      </div>
    </div>
  )
}
