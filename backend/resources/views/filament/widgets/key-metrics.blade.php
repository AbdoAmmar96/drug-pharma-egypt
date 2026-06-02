{{-- Drug Pharma — KPI cards matching the dashboard mockup --}}
<x-filament-widgets::widget>
    <div class="dp-metrics">
        @foreach ($metrics as $metric)
            <div class="dp-metric dp-metric--accent-{{ $metric['accent'] }}">
                <div class="dp-metric__label">{{ $metric['label'] }}</div>
                <div class="dp-metric__value dp-metric__value--{{ $metric['valueTone'] }}">{{ $metric['value'] }}</div>
                <div class="dp-metric__meta dp-metric__meta--{{ $metric['metaTone'] }}">
                    @if ($metric['symbol'])
                        <span class="dp-metric__symbol">{{ $metric['symbol'] }}</span>
                    @endif
                    {{ $metric['meta'] }}
                </div>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
