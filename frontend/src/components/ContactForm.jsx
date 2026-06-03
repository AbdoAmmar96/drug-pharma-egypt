import { useState } from 'react'
import { submitContact } from '../lib/api'
import { useLang } from '../i18n/index.jsx'

export default function ContactForm({ defaultTopic = 'general', defaultMessage = '', onSuccess }) {
  const { t } = useLang()
  const [form, setForm] = useState({
    name: '', email: '', phone: '', topic: defaultTopic, message: defaultMessage,
  })
  const [status, setStatus] = useState({ state: 'idle', msg: '' })

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
      setForm({ name: '', email: '', phone: '', topic: defaultTopic, message: '' })
      onSuccess?.()
    } catch (err) {
      setStatus({ state: 'error', msg: err?.response?.data?.message ?? t('contact.errorGeneric') })
    }
  }

  const topics = t('contact.topics')

  return (
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
            <option value="apis">{topics.apis ?? 'Active Pharmaceutical Ingredients'}</option>
            <option value="manufacturing">{topics.manufacturing ?? 'Contract Manufacturing'}</option>
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
  )
}
