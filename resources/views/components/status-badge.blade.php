@php
    $baseClass = $outline ? 'badge-outline-' : 'bg-';
    $classes = match ($status) {
        'Pending' => $baseClass . 'dark',
        'Approved' => $baseClass . 'primary',
        'Rejected' => $baseClass . 'danger',
        'Low' => $baseClass . 'warning',
        'High' => $baseClass . 'danger',
        default => $baseClass . 'secondary',
    };
@endphp

<span class="badge {{ $classes }} rounded-full">
    {{ $status }}
</span>
