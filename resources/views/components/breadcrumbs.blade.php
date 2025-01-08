<ul class="flex space-x-2 rtl:space-x-reverse">
    @foreach ($items as $index => $item)
        <li class="{{ $index !== 0 ? 'before:content-[\'/\'] ltr:before:mr-1 rtl:before:ml-1' : '' }}">
            @php
                $isActive = isset($item['route']) && Route::currentRouteName() === $item['route'];
            @endphp

            @if (isset($item['route']))
                <a href="{{ route($item['route'], $item['params'] ?? []) }}"
                    class="hover:underline {{ $isActive ? 'text-primary font-semibold' : 'text-[#888EA8]' }}">
                    {{ $item['label'] }}
                </a>
            @elseif (isset($item['url']))
                <a href="{{ $item['url'] }}"
                    class="hover:underline {{ $isActive ? 'text-primary font-semibold' : 'text-[#888EA8]' }}">
                    {{ $item['label'] }}
                </a>
            @else
                <span class="font-semibold {{ $isActive ? 'text-primary' : 'text-[#888EA8]' }}">
                    {{ $item['label'] }}
                </span>
            @endif
        </li>
    @endforeach
</ul>
