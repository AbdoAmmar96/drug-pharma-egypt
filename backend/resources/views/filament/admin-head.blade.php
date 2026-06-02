{{-- 
    Drug Pharma Egypt — Admin panel styles
    Loaded into <head> of every admin page via panels::head.end render hook.
--}}
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --dp-navy:        #1B2360;
        --dp-navy-700:    #2A337A;
        --dp-navy-900:    #11163F;
        --dp-orange:      #E87330;
        --dp-orange-700:  #C95A1B;
        --dp-orange-200:  #FBE3D2;
        --dp-orange-50:   #FEF5EE;
        --dp-text:        #1F1F2E;
        --dp-muted:       #6B6B7A;
        --dp-line:        #E8E8EA;
        --dp-bg-page:     #F4F4F2;
        --dp-bg-card:     #FFFFFF;
    }

    /* ============================================================
       SIDEBAR
       ============================================================ */
    .fi-sidebar { border-inline-end: 1px solid rgba(0, 0, 0, 0.05); }
    .fi-sidebar-nav-groups .fi-sidebar-group-label {
        font-size: 0.7rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.12em !important;
        font-weight: 700 !important;
        color: var(--dp-navy) !important;
        opacity: 0.75 !important;
    }
    .dark .fi-sidebar-nav-groups .fi-sidebar-group-label { color: #fff !important; }
    .fi-sidebar-item-active .fi-sidebar-item-button {
        background: var(--dp-orange-200) !important;
        color: var(--dp-orange-700) !important;
    }
    .fi-sidebar-item-active .fi-sidebar-item-icon { color: var(--dp-orange-700) !important; }

    /* Dark mode: white circular background behind sidebar item icons (below Dashboard) */
    .dark .fi-sidebar-nav-groups .fi-sidebar-item .fi-sidebar-item-icon {
        background: #fff;
        border-radius: 8px;
        padding: 4px;
        width: 28px;
        height: 28px;
        box-sizing: content-box;
        color: var(--dp-navy) !important;
        flex-shrink: 0;
    }
    .dark .fi-sidebar-nav-groups .fi-sidebar-item-active .fi-sidebar-item-icon {
        background: #fff;
        color: var(--dp-orange-700) !important;
    }

    /* Topbar */
    .fi-topbar { backdrop-filter: blur(12px); }

    /* RTL Cairo */
    html[dir="rtl"] body { font-family: 'Cairo', system-ui, sans-serif; }

    /* ============================================================
       LANGUAGE TOGGLE
       ============================================================ */
    .fi-topbar .dp-lang-toggle,
    .dp-lang-toggle--on-light {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        margin-inline-end: 12px;
        border-radius: 999px;
        font-family: 'Outfit', 'Cairo', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-decoration: none;
        background: var(--dp-orange-50);
        color: var(--dp-orange-700);
        border: 1.5px solid var(--dp-orange-200);
        transition: all 0.18s ease;
    }
    .fi-topbar .dp-lang-toggle:hover,
    .dp-lang-toggle--on-light:hover {
        background: var(--dp-orange);
        color: #fff;
        border-color: var(--dp-orange);
        transform: translateY(-1px);
    }
    .dark .fi-topbar .dp-lang-toggle,
    .dark .dp-lang-toggle--on-light {
        background: rgba(232, 115, 48, 0.12);
        color: var(--dp-orange);
        border-color: rgba(232, 115, 48, 0.30);
    }

    /* ============================================================
       1. HERO BANNER
       ============================================================ */
    .dp-hero {
        position: relative;
        background:
            radial-gradient(ellipse at top right, rgba(232, 115, 48, 0.40) 0%, transparent 55%),
            linear-gradient(135deg, var(--dp-navy) 0%, var(--dp-navy-900) 100%);
        border-radius: 20px;
        padding: 32px 40px;
        color: white;
        overflow: hidden;
        isolation: isolate;
        box-shadow: 0 12px 32px -10px rgba(27, 35, 96, 0.35);
    }
    .dp-hero__pattern {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
        background-size: 22px 22px;
        z-index: 0;
        pointer-events: none;
    }
    .dp-hero__blob {
        position: absolute;
        top: -120px; right: -80px;
        width: 360px; height: 360px;
        border-radius: 50%;
        background: rgba(232, 115, 48, 0.25);
        filter: blur(70px);
        z-index: 0;
        pointer-events: none;
    }
    .dp-hero__inner {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 32px;
        align-items: center;
    }
    @media (max-width: 720px) {
        .dp-hero { padding: 24px 22px; }
        .dp-hero__inner { grid-template-columns: 1fr; }
        .dp-hero__art { display: none; }
    }
    .dp-hero__date {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.75);
        font-weight: 500;
        margin-bottom: 14px;
    }
    .dp-hero__title {
        font-family: 'Outfit', 'Cairo', sans-serif !important;
        font-size: 30px !important;
        font-weight: 800 !important;
        line-height: 1.15 !important;
        margin: 0 0 8px 0 !important;
        color: white !important;
        letter-spacing: -0.02em;
    }
    .dp-hero__name {
        color: var(--dp-orange);
        font-weight: 700;
    }
    .dp-hero__wave {
        display: inline-block;
        animation: dp-wave 2.5s ease-in-out infinite;
        transform-origin: 70% 70%;
    }
    @keyframes dp-wave {
        0%, 60%, 100% { transform: rotate(0deg); }
        10%, 30%      { transform: rotate(14deg); }
        20%           { transform: rotate(-8deg); }
        40%, 50%      { transform: rotate(10deg); }
    }
    .dp-hero__subtitle {
        font-size: 14.5px;
        color: rgba(255, 255, 255, 0.78);
        margin: 0 0 24px 0;
    }
    .dp-hero__stats {
        display: flex;
        align-items: center;
        gap: 22px;
    }
    .dp-hero-stat { display: flex; align-items: baseline; gap: 6px; }
    .dp-hero-stat__num {
        font-family: 'Outfit', 'Cairo', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: var(--dp-orange);
        line-height: 1;
    }
    .dp-hero-stat__label {
        font-size: 11.5px;
        color: rgba(255, 255, 255, 0.65);
        letter-spacing: 0.02em;
    }
    .dp-hero-stat__divider {
        width: 1px;
        height: 18px;
        background: rgba(255, 255, 255, 0.20);
    }
    .dp-hero__art { width: 150px; height: 150px; flex-shrink: 0; }
    .dp-hero__art svg {
        width: 100%; height: 100%;
        filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.18));
    }

    /* ============================================================
       2. KEY METRICS — clean cards (no icons), accent strip on left
       ============================================================ */
    .dp-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
    }
    .dp-metric {
        position: relative;
        background: var(--dp-bg-card);
        border: 1px solid var(--dp-line);
        border-radius: 16px;
        padding: 22px 24px;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .dp-metric::before {
        content: "";
        position: absolute;
        top: 0; inset-inline-start: 0;
        width: 4px; height: 100%;
        background: transparent;
    }
    .dp-metric--accent-orange::before      { background: var(--dp-orange); }
    .dp-metric--accent-transparent::before { background: transparent; }
    .dp-metric:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 28px -10px rgba(27, 35, 96, 0.18);
    }
    .dp-metric__label {
        font-family: 'Outfit', 'Cairo', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: var(--dp-navy);
        margin-bottom: 14px;
    }
    .dark .dp-metric__label { color: white; }
    .dp-metric__value {
        font-family: 'Outfit', 'Cairo', sans-serif;
        font-size: 36px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 8px;
    }
    .dp-metric__value--navy   { color: var(--dp-navy); }
    .dp-metric__value--orange { color: var(--dp-orange); }
    .dark .dp-metric__value--navy { color: white; }

    .dp-metric__meta {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12.5px;
        font-weight: 500;
    }
    .dp-metric__meta--orange { color: var(--dp-orange); }
    .dp-metric__meta--muted  { color: var(--dp-text); }
    .dp-metric__symbol { font-size: 10px; }

    .dark .dp-metric {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.08);
    }
    .dark .dp-metric__meta--muted { color: rgba(255, 255, 255, 0.65); }

    /* ============================================================
       3. QUICK ACTIONS — 4 cards in a row, vertical layout
       ============================================================ */
    .dp-quickactions-wrap {
        background: transparent;
        border: none;
        padding: 0;
    }
    .dp-quickactions-head { margin-bottom: 16px; }
    .dp-quickactions-head__title {
        font-family: 'Outfit', 'Cairo', sans-serif !important;
        font-size: 22px !important;
        font-weight: 800 !important;
        color: var(--dp-navy) !important;
        margin: 0 0 4px 0 !important;
        letter-spacing: -0.01em;
    }
    .dark .dp-quickactions-head__title { color: white !important; }
    .dp-quickactions-head__sub {
        font-size: 13.5px;
        color: var(--dp-muted);
        margin: 0;
    }

    .dp-quickactions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
    }
    .dp-qa-card {
        display: flex;
        flex-direction: column;
        gap: 18px;
        padding: 18px 20px;
        background: var(--dp-bg-card);
        border: 1px solid var(--dp-line);
        border-radius: 16px;
        text-decoration: none;
        color: var(--dp-text);
        transition: all 0.2s ease;
    }
    .dp-qa-card:hover {
        transform: translateY(-3px);
        border-color: var(--dp-orange);
        box-shadow: 0 14px 28px -10px rgba(27, 35, 96, 0.18);
    }
    .dp-qa-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .dp-qa-card__icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .dp-qa-card--orange .dp-qa-card__icon      { background: var(--dp-orange-200); color: var(--dp-orange-700); }
    .dp-qa-card--navy .dp-qa-card__icon        { background: var(--dp-navy);        color: white; }
    .dp-qa-card--orange-soft .dp-qa-card__icon { background: var(--dp-orange-50);   color: var(--dp-orange); }
    .dp-qa-card--navy-soft .dp-qa-card__icon   { background: rgba(27, 35, 96, 0.08); color: var(--dp-navy); }
    .dp-qa-card__arrow {
        color: var(--dp-orange);
        flex-shrink: 0;
        transition: transform 0.2s;
    }
    .dp-qa-card:hover .dp-qa-card__arrow { transform: translateX(3px); }
    html[dir="rtl"] .dp-qa-card:hover .dp-qa-card__arrow { transform: translateX(-3px); }

    .dp-qa-card__body { display: flex; flex-direction: column; gap: 4px; }
    .dp-qa-card__title {
        font-family: 'Outfit', 'Cairo', sans-serif;
        font-weight: 800;
        font-size: 15px;
        color: var(--dp-navy);
        letter-spacing: -0.01em;
    }
    .dark .dp-qa-card__title { color: white; }
    .dp-qa-card__desc {
        font-size: 12px;
        color: var(--dp-muted);
        line-height: 1.4;
    }
    .dark .dp-qa-card {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.08);
        color: white;
    }

    /* ============================================================
       4. INBOX — clean list rows
       ============================================================ */
    .dp-inbox-card {
        background: var(--dp-bg-card);
        border: 1px solid var(--dp-line);
        border-radius: 16px;
        padding: 24px 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .dark .dp-inbox-card {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.08);
    }
    .dp-inbox-card__header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--dp-line);
    }
    .dp-inbox-card__title {
        font-family: 'Outfit', 'Cairo', sans-serif !important;
        font-size: 20px !important;
        font-weight: 800 !important;
        color: var(--dp-navy) !important;
        margin: 0 0 4px 0 !important;
        letter-spacing: -0.01em;
    }
    .dark .dp-inbox-card__title { color: white !important; }
    .dp-inbox-card__sub {
        font-size: 12.5px;
        color: var(--dp-muted);
        margin: 0;
    }
    .dp-inbox-card__link {
        font-size: 12px;
        font-weight: 700;
        color: var(--dp-orange-700);
        text-decoration: none;
    }
    .dp-inbox-card__link:hover {
        color: var(--dp-orange);
        text-decoration: underline;
    }

    .dp-inbox-list {
        display: flex;
        flex-direction: column;
    }
    .dp-inbox-row {
        display: grid;
        grid-template-columns: 16px minmax(120px, 1.2fr) minmax(160px, 1.6fr) auto auto;
        align-items: center;
        gap: 18px;
        padding: 14px 4px;
        border-bottom: 1px solid var(--dp-line);
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .dp-inbox-row:last-child { border-bottom: none; }
    .dp-inbox-row:hover {
        background: var(--dp-orange-50);
        margin: 0 -10px;
        padding: 14px 14px;
        border-radius: 8px;
        border-bottom-color: transparent;
    }
    .dp-inbox-row__dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #D3D1C7;
        flex-shrink: 0;
    }
    .dp-inbox-row--unread .dp-inbox-row__dot { background: var(--dp-orange); }
    .dp-inbox-row__name {
        font-family: 'Outfit', 'Cairo', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: var(--dp-navy);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .dp-inbox-row--unread .dp-inbox-row__name { font-weight: 800; }
    .dp-inbox-row:not(.dp-inbox-row--unread) .dp-inbox-row__name {
        color: var(--dp-text);
        font-weight: 500;
    }
    .dark .dp-inbox-row__name { color: white; }
    .dp-inbox-row__email {
        font-size: 13px;
        color: var(--dp-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .dp-inbox-row__topic {
        background: var(--dp-orange-200);
        color: var(--dp-orange-700);
        font-family: 'Outfit', 'Cairo', sans-serif;
        font-weight: 700;
        font-size: 10.5px;
        letter-spacing: 0.06em;
        padding: 4px 12px;
        border-radius: 999px;
        white-space: nowrap;
    }
    .dp-inbox-row__topic--muted {
        background: #F1EFE8;
        color: #888780;
    }
    .dp-inbox-row__time {
        font-size: 12px;
        color: var(--dp-muted);
        white-space: nowrap;
        text-align: end;
    }
    .dp-inbox-empty {
        text-align: center;
        padding: 48px 16px;
        color: var(--dp-muted);
    }

    /* Mobile: stack the inbox row */
    @media (max-width: 720px) {
        .dp-inbox-row {
            grid-template-columns: 16px 1fr auto;
            gap: 12px;
        }
        .dp-inbox-row__email,
        .dp-inbox-row__topic {
            grid-column: 2 / -1;
            justify-self: start;
        }
    }

    /* ============================================================
       Filament chrome polish (covers other admin pages)
       ============================================================ */
    .fi-section {
        border-radius: 16px !important;
        border: 1px solid var(--dp-line) !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
    }
    .fi-section-header-heading {
        font-family: 'Outfit', 'Cairo', sans-serif !important;
        font-weight: 700 !important;
        color: var(--dp-navy) !important;
    }
    .dark .fi-section-header-heading { color: white !important; }
</style>
