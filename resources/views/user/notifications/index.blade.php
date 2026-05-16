@extends('layouts.public')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="h3 mb-4">Notifikasi</h1>
        <div class="d-grid gap-3">
            @foreach($notifications as $notification)
                <div class="admin-panel p-3 {{ $notification->read_at ? '' : 'border-success' }}">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <h2 class="h6 mb-1">{{ $notification->data['title'] ?? 'Notifikasi' }}</h2>
                            <p class="mb-1 text-muted">{{ $notification->data['message'] ?? '' }}</p>
                            @if(!empty($notification->data['url']))
                                <a href="{{ $notification->data['url'] }}" class="small">Buka detail</a>
                            @endif
                        </div>
                        @unless($notification->read_at)
                            <form method="POST" action="{{ route('user.notifications.read', $notification) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-success">Tandai Dibaca</button>
                            </form>
                        @endunless
                    </div>
                </div>
            @endforeach
            {{ $notifications->links() }}
        </div>
    </div>
</section>
@endsection
