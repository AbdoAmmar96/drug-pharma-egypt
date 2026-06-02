import { createContext, useContext } from 'react'

const translations = {
  // ===== Navigation =====
  nav: {
    home: 'Home',
    about: 'About',
    products: 'Products',
    cta: 'Get in Touch',
  },
  // ===== Topbar =====
  topbar: {
    locations: 'Our Locations',
  },
  // ===== Footer =====
  footer: {
    tagline: 'Drug Pharma Egypt — An established Egyptian pharmaceutical company since 2016. We are the future of nutraceutical and pharmaceutical innovation.',
    company: 'Company',
    categories: 'Categories',
    contacts: 'Contacts',
    aboutUs: 'About Us',
    products: 'Products',
    contact: 'Contact',
    address: 'Villa 18, Street 42, Second District,\nThird Region — Fifth Settlement',
    copyright: '© {year} Business Partner for Information Technology. All rights reserved.',
    brandName: 'Drug Pharma Egypt',
    catChild: 'Child & Neonates',
    catWomen: 'Pregnant & Women',
    catBone: 'Bone Care',
    catMulti: 'Multi-Care',
    catAdult: 'For Adult',
  },
  // ===== Home =====
  home: {
    heroEyebrow: 'Egyptian Pharmaceutical Excellence Since 2016',
    heroTitle1: 'Drug Pharma',
    heroTitleAccent: 'we are',
    heroTitle2: '',
    heroTitle3: 'the future.',
    heroSubtitle: 'Drug Pharma Egypt was founded with a new take on nutraceutical and pharmaceutical products — bridging the gap with affordable prices, world-class quality, and an NFSA-approved factory.',
    ctaExplore: 'Explore Our Products',
    ctaAbout: 'About the Company',

    trust1Label: 'Established as an Egyptian pharmaceutical company',
    trust2Label: 'Products across nutraceuticals & pharmaceuticals',
    trust3Label: 'Specialized therapeutic categories',
    trust4Label: 'NFSA, EDA Regulations  & GMP Certified Manufacturing',
    trust1Value: '2016',
    trust2Value: '46+',
    trust3Value: '8',
    trust4Value: '100%',

    catEyebrow: 'Our Portfolio',
    catTitle: 'Care for every life stage.',
    catSubtitle: "From a baby's first drops to an adult's daily support, our portfolio spans eight focused therapeutic categories.",

    featEyebrow: 'Featured',
    featTitle: 'Spotlight on our heroes.',
    featSubtitle: 'A small selection of our most-loved formulations across categories.',
    featAll: 'See all 46+ products',
    featNone: 'No featured products yet.',

    finalCtaTitle: 'Looking for a partner you can trust?',
    finalCtaText: "Whether you're a pharmacy, a hospital, or a distributor — let's talk about how Drug Pharma Egypt can support your formulary.",
    finalCtaBtn: 'Get in Touch',

    loading: 'Loading…',
    viewProducts: 'View {count} products',
  },
  // ===== About =====
  about: {
    breadcrumb: 'About Us',
    heroTitle1: 'An Egyptian story',
    heroTitleAccent: 'in pharma',
    heroTitle2: ', since 2016.',
    heroSubtitle: 'Drug Pharma Egypt was established with a new concept of nutraceutical products — built to fill a real gap with new ideas, fair pricing, and an NFSA-approved manufacturing facility.',
    since2016: 'Since 2016',
    nfsaApproved: 'NFSA Approved',

    storyEyebrow: 'Our Story',
    storyTitle: 'Filling the gap with new ideas.',
    storyP1: 'Drug Pharma Egypt is an **established Egyptian business** founded in 2016, with a single guiding principle: **nutraceutical products done differently**.',
    storyP2: 'Where many established players prioritize legacy formulations and premium pricing, Drug Pharma Egypt set out to deliver a focused portfolio in pediatrics, orthopedics, and gynecology at affordable prices — without compromising on quality, sourcing, or regulatory standards.',
    storyP3: 'Our factory, approved by **NFSA Egypt**, lets us close the loop from formulation to fulfillment under one roof.',
    bullet1: 'Egyptian-owned, with deep market knowledge of regional needs',
    bullet2: 'Fair-priced portfolio designed for everyday accessibility',
    bullet3: 'Strict compliance with NFSA Egypt regulatory requirements',
    bullet4: 'Three pillars: nutraceuticals, OTC, and pharmaceuticals',

    pillarsEyebrow: 'Portfolio Mix',
    pillarsTitle: 'Three product pillars.',
    pillarsSubtitle: 'A complementary product mix that addresses everyday wellbeing, point-of-need OTC use, and pharmaceutical needs.',
    pillar1Title: 'Nutraceuticals',
    pillar1Desc: 'Specialized formulations in pediatrics, orthopedics, and gynecology — vitamins, minerals, omega-3, probiotics, and joint support.',
    pillar2Title: 'OTC Products',
    pillar2Desc: 'Over-the-counter solutions for everyday patient needs — accessible, well-formulated, and competitively priced.',
    pillar3Title: 'Pharmaceutical Products',
    pillar3Desc: 'Therapeutic pharmaceuticals manufactured under NFSA-approved standards with full traceability and quality control.',

    timelineEyebrow: 'Milestones',
    timelineTitle: 'Built step by step.',
    timelineSubtitle: 'From an established vision to an approved factory — a brief look at the journey.',
    ms1Title: 'Company Founded',
    ms1Desc: 'Drug Pharma Egypt established as a company focused on nutraceutical innovation.',
    ms2Title: 'Pediatric Range Launch',
    ms2Desc: 'Three Sharks, Vitosel Kids, IVY NUTRA and other pediatric formulations enter pharmacies.',
    ms3Title: 'Bone & Adult Range',
    ms3Desc: 'Portfolio expands with Trypsalin, Moonflex, FREESAMINE, and adult-care products.',
    ms4Title: 'NFSA-Approved Factory',
    ms4Desc: 'Q4 2023 launch of an NFSA-approved manufacturing facility.',

    finalCtaTitle: 'Want to partner with us?',
    finalCtaText: 'We work with pharmacies, distributors, hospitals, and clinics across Egypt and the region.',
  },
  // ===== Products =====
  products: {
    breadcrumb: 'Products',
    heroTitle1: 'Our complete',
    heroTitleAccent: 'portfolio',
    heroTitle2: '.',
    heroSubtitle: 'Nutraceutical and pharmaceutical products across five specialized categories — formulated, manufactured, and quality-checked at our NFSA-approved facility.',
    filterAll: 'All',
    searchPlaceholder: 'Search products...',
    showing: 'Showing',
    product: 'product',
    productPlural: 'products',
    matching: 'matching',
    noResults: 'No products found',
    noResultsHint: 'Try a different search or category.',
  },
  // ===== Product detail =====
  detail: {
    composition: 'Composition',
    uses: 'Uses',
    dose: 'Dose',
    ctaContact: 'Contact us about this product',
    ctaBack: 'Back to all products',
    relatedTitle: 'More from {category}',
  },
  // ===== Contact =====
  contact: {
    breadcrumb: 'Contact',
    heroTitle1: "Let's",
    heroTitleAccent: 'talk',
    heroTitle2: '.',
    heroSubtitle: "Whether you're a pharmacy, distributor, healthcare professional, or simply have a question about our products — drop us a line and we'll get back to you within one business day.",
    quickReply: 'Quick Reply',
    response24h: '24h Response',

    visitTitle: 'Visit our office',
    visitBody: 'Villa 18, Street 42, Second District, Third Region — Fifth Settlement, Cairo, Egypt',
    callTitle: 'Call us',
    callCta: 'Call now',
    emailTitle: 'Email us',
    emailCta: 'Send email',

    formEyebrow: 'Send a Message',
    formTitle: "We'd love to hear from you.",
    formSubtitle: 'Fill out the form and our team will reply within one business day.',
    fName: 'Your name *',
    fEmail: 'Email address *',
    fPhone: 'Phone (optional)',
    fTopic: 'Topic',
    fMessage: 'Your message *',
    submit: 'Send message',
    sending: 'Sending…',
    successMsg: "Thanks! We'll get back to you within one business day.",
    errorRequired: 'Please fill in name, email, and message.',
    errorGeneric: 'Something went wrong. Please try again or email us directly.',

    mapTitle: 'Visit us',
    mapSubtitle: 'Fifth Settlement, New Cairo',

    faqEyebrow: 'FAQ',
    faqTitle: 'Common questions.',
    faqSubtitle: "Can't find what you're looking for? Just send us a message above.",

    topics: {
      general: 'General Inquiry',
      pharmacy: 'Pharmacy / Distribution',
      partnership: 'Partnership',
      product: 'Product Question',
      careers: 'Careers',
      other: 'Other',
    },

    faq: [
      { q: 'How can pharmacies order Drug Pharma products?',
        a: 'Pharmacies can place orders through our authorized distributors across Egypt. Please use the contact form above with the topic "Pharmacy / Distribution" and our commercial team will get back to you within one business day with pricing, MOQs, and delivery terms.' },
      { q: 'Do you ship outside Egypt?',
        a: 'Yes — we work with selected partners in the Gulf and Arabic-speaking markets. For export inquiries, send us a message with the topic "Partnership" and include your country and the product range you\'re interested in.' },
      { q: 'Are your products NFSA-approved?',
        a: 'Absolutely. All Drug Pharma Egypt products are manufactured in our NFSA-approved factory (launched Q4 2023) following strict regulatory standards. Each product carries its NFSA registration on the packaging.' },
      { q: 'Can I get medical or dosing advice from you?',
        a: 'We provide product information, composition, and approved usage on each product page — but actual medical advice should always come from your physician or pharmacist. We\'re happy to answer technical questions about formulations and ingredients.' },
      { q: 'Are you hiring?',
        a: 'We\'re a growing company and frequently look for talented people in production, QA/QC, regulatory affairs, sales, and marketing. Send your CV with the topic "Careers" — we keep applications on file even when no specific opening is posted.' },
    ],
  },
  // ===== 404 =====
  notFound: {
    title1: 'Page not',
    titleAccent: 'found',
    title2: '.',
    subtitle: "The page you're looking for doesn't exist, was moved, or never existed in the first place.",
    ctaHome: 'Go home',
    ctaProducts: 'Browse products',
  },
  // ===== Common =====
  common: {
    breadcrumbHome: 'Home',
  },
}

const Context = createContext({
  lang: 'en',
  t: (key) => key,
  isRtl: false,
})

export function LanguageProvider({ children }) {
  if (typeof document !== 'undefined') {
    document.documentElement.lang = 'en'
    document.documentElement.dir = 'ltr'
  }

  // t('home.heroTitle1') OR t('home.viewProducts', { count: 5 })
  const t = (key, vars = {}) => {
    const parts = key.split('.')
    let value = translations
    for (const p of parts) {
      value = value?.[p]
      if (value === undefined) break
    }
    if (value === undefined) return key
    if (typeof value !== 'string') return value
    return value.replace(/\{(\w+)\}/g, (_, k) => vars[k] ?? `{${k}}`)
  }

  return (
    <Context.Provider value={{ lang: 'en', t, isRtl: false }}>
      {children}
    </Context.Provider>
  )
}

export function useLang() {
  return useContext(Context)
}
