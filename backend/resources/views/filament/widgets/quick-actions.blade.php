{{-- Drug Pharma — Quick Actions (4 vertical cards in a row) --}}
<x-filament-widgets::widget>
    <div class="dp-quickactions-wrap">
        <div class="dp-quickactions-head">
            <h2 class="dp-quickactions-head__title">{{ $heading }}</h2>
            <p class="dp-quickactions-head__sub">{{ $sub }}</p>
        </div>

        <div class="dp-quickactions-grid">
            @foreach ($actions as $action)
                <a
                    href="{{ $action['url'] }}"
                    class="dp-qa-card dp-qa-card--{{ $action['tone'] }}"
                    @if (! empty($action['external'])) target="_blank" rel="noopener" @endif
                >
                    <div class="dp-qa-card__top">
                        <span class="dp-qa-card__icon">
                            @switch($action['icon'])
                                @case('plus')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    @break
                                @case('folder')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                                    @break
                                @case('chat')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="8" y1="10" x2="8.01" y2="10"/><line x1="12" y1="10" x2="12.01" y2="10"/><line x1="16" y1="10" x2="16.01" y2="10"/></svg>
                                    @break
                                @case('globe')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    @break
                            @endswitch
                        </span>
                        <span class="dp-qa-card__arrow" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </span>
                    </div>
                    <div class="dp-qa-card__body">
                        <div class="dp-qa-card__title">{{ $action['title'] }}</div>
                        <div class="dp-qa-card__desc">{{ $action['desc'] }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-filament-widgets::widget>
