{{-- Drug Pharma — Latest Messages (clean rows like image 2) --}}
<x-filament-widgets::widget>
    <div class="dp-inbox-card">
        <div class="dp-inbox-card__header">
            <div>
                <h3 class="dp-inbox-card__title">Latest Messages</h3>
                <p class="dp-inbox-card__sub">Most recent customer enquiries</p>
            </div>
            <a href="{{ $allUrl }}" class="dp-inbox-card__link">View all →</a>
        </div>

        @if ($messages->isEmpty())
            <div class="dp-inbox-empty">No messages yet</div>
        @else
            <div class="dp-inbox-list">
                @foreach ($messages as $msg)
                    @php $url = \App\Filament\Resources\ContactMessageResource::getUrl('view', ['record' => $msg->id]); @endphp
                    <a href="{{ $url }}" class="dp-inbox-row @if (! $msg->is_read) dp-inbox-row--unread @endif">
                        <span class="dp-inbox-row__dot" aria-hidden="true"></span>
                        <span class="dp-inbox-row__name">{{ $msg->name }}</span>
                        <span class="dp-inbox-row__email">{{ $msg->email }}</span>
                        @if ($msg->topic)
                            <span class="dp-inbox-row__topic">{{ \Illuminate\Support\Str::upper($msg->topic) }}</span>
                        @else
                            <span class="dp-inbox-row__topic dp-inbox-row__topic--muted">—</span>
                        @endif
                        <span class="dp-inbox-row__time">{{ $msg->created_at?->diffForHumans() }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-widgets::widget>
