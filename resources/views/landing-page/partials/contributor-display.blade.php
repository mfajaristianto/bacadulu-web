@php
    $names = array_values(array_filter($names ?? [], fn ($name) => trim((string) $name) !== ''));
    $mode = in_array($mode ?? 'inline', ['inline', 'stacked', 'primary'], true) ? $mode : 'inline';
    $primary = trim((string) ($primary ?? ''));
    if ($primary === '' || !in_array($primary, $names, true)) $primary = $names[0] ?? null;
    $others = array_values(array_filter($names, fn ($name) => $name !== $primary));
    $role = trim((string) ($role ?? ''));
    $showRoleLabels = (bool) ($showRoleLabels ?? false);
@endphp

@if($names !== [])
    @if($mode === 'stacked')
        <div class="space-y-0.5">
            @foreach($names as $name)
                <div>{{ $name }}</div>
            @endforeach
        </div>
    @elseif($mode === 'primary' && $primary)
        <div class="space-y-2">
            <div>
                @if($showRoleLabels && $role !== '')
                    <div class="text-[10px] font-bold uppercase tracking-[0.12em] opacity-60">{{ $role }} Utama</div>
                @endif
                <div class="font-semibold">{{ $primary }}</div>
            </div>

            @if($others !== [])
                <div>
                    @if($showRoleLabels && $role !== '')
                        <div class="text-[10px] font-bold uppercase tracking-[0.12em] opacity-60">{{ $role }} Lainnya</div>
                    @endif
                    <div>{{ implode(', ', $others) }}</div>
                </div>
            @endif
        </div>
    @else
        {{ implode(', ', $names) }}
    @endif
@endif
