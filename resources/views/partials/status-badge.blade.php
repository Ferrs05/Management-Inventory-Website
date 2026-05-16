@php
    $classes = [
        'pending' => 'badge-soft-warning',
        'approved' => 'badge-soft-success',
        'rejected' => 'badge-soft-danger',
        'returned' => 'text-bg-secondary',
    ];
@endphp
<span class="badge {{ $classes[$status] ?? 'text-bg-secondary' }}">{{ ucfirst($status) }}</span>
