@extends('layouts.admin', ['heading' => 'Notifikasi'])

@section('content')
<div class="d-grid gap-3">
    @foreach($notifications as $notification)
        <div class="admin-panel p-3 {{ $notification->read_at ? '' : 'border-success' }}">
            <div class="d-flex justify-content-between">
                <div>
                    <h2 class="h6">{{ $notification->data['title'] ?? 'Notifikasi' }}</h2>
                    <p class="text-muted mb-1">{{ $notification->data['message'] ?? '' }}</p>
                    @if(!empty($notification->data['url']))
                        <a href="{{ $notification->data['url'] }}" class="small">Buka detail</a>
                    @endif
                </div>
                @unless($notification->read_at)
                    <form method="POST" action="{{ route('admin.notifications.read', $notification) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-success">Dibaca</button>
                    </form>
                @endunless
            </div>
        </div>
    @endforeach
    {{ $notifications->links() }}
</div>
@endsection
