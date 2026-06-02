{{-- Drug Pharma — Dashboard Hero Banner --}}
<x-filament-widgets::widget>
    <div class="dp-hero">
        <div class="dp-hero__pattern" aria-hidden="true"></div>
        <div class="dp-hero__blob" aria-hidden="true"></div>

        <div class="dp-hero__inner">
            <div class="dp-hero__text">
                <div class="dp-hero__date">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.7">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $date }}
                </div>

                <h1 class="dp-hero__title">
                    {{ $greeting }},
                    <span class="dp-hero__name">{{ $name }}</span>
                    <span class="dp-hero__wave">👋</span>
                </h1>

                <p class="dp-hero__subtitle">
                    Here's what's happening at Drug Pharma Egypt today.
                </p>

                <div class="dp-hero__stats">
                    <div class="dp-hero-stat">
                        <span class="dp-hero-stat__num">{{ $productsActive }}</span>
                        <span class="dp-hero-stat__label">Active products</span>
                    </div>
                    <span class="dp-hero-stat__divider"></span>
                    <div class="dp-hero-stat">
                        <span class="dp-hero-stat__num">{{ $messagesUnread }}</span>
                        <span class="dp-hero-stat__label">New messages</span>
                    </div>
                </div>
            </div>

            <div class="dp-hero__art" aria-hidden="true">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="hero-bottle" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#ffffff" stop-opacity="1"/>
                            <stop offset="100%" stop-color="#ffffff" stop-opacity="0.85"/>
                        </linearGradient>
                    </defs>
                    {{-- Bottle body --}}
                    <rect x="62" y="56" width="76" height="116" rx="10" fill="url(#hero-bottle)"/>
                    {{-- Cap --}}
                    <rect x="70" y="36" width="60" height="28" rx="6" fill="#E87330"/>
                    <rect x="70" y="36" width="60" height="6" rx="3" fill="#C95A1B"/>
                    {{-- Label --}}
                    <rect x="62" y="100" width="76" height="44" fill="#1B2360" opacity="0.08"/>
                    {{-- Medical cross --}}
                    <g transform="translate(100, 122)">
                        <rect x="-12" y="-3" width="24" height="6" rx="1.5" fill="#E87330"/>
                        <rect x="-3" y="-12" width="6" height="24" rx="1.5" fill="#E87330"/>
                    </g>
                    {{-- Loose pills --}}
                    <g transform="translate(28, 158) rotate(-20)">
                        <rect width="36" height="14" rx="7" fill="#FBE3D2"/>
                        <rect width="18" height="14" rx="7" fill="#E87330"/>
                    </g>
                    <g transform="translate(150, 168) rotate(15)">
                        <rect width="30" height="12" rx="6" fill="#1B2360"/>
                        <rect width="15" height="12" rx="6" fill="#E87330"/>
                    </g>
                    {{-- Sparkles --}}
                    <circle cx="40" cy="50" r="3" fill="#E87330" opacity="0.7"/>
                    <circle cx="170" cy="80" r="2.5" fill="#FBE3D2"/>
                    <circle cx="180" cy="40" r="2" fill="#E87330" opacity="0.5"/>
                </svg>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
