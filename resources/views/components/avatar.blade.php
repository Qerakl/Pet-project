@props(['user', 'size' => 45])

@if($user->getAvatarUrl())
    <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}"
         class="rounded-circle flex-shrink-0"
         style="width: {{ $size }}px; height: {{ $size }}px; object-fit: cover;">
@else
    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
         style="width: {{ $size }}px; height: {{ $size }}px;">
        <span class="fw-bold" style="font-size: {{ $size * 0.4 }}px;">{{ $user->getInitial() }}</span>
    </div>
@endif
