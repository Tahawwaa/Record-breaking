<div dir="ltr">
    <div class="text-xs mb-2.5" style="color: color-mix(in srgb, var(--color-text) 65%, transparent)">{{ $title }}</div>
    <div class="flex gap-2">
        <div class="flex-none flex flex-col justify-between text-right" style="width:30px;font-size:11px;color:var(--color-muted);padding:2px 0">
            <span>{{ $chart['hi'] }}</span><span>{{ $chart['mid'] }}</span><span>{{ $chart['lo'] }}</span>
        </div>
        <div class="relative flex-1" style="height:150px">
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="block w-full h-full" style="overflow:visible">
                <line x1="0" x2="100" y1="0" y2="0" stroke="var(--color-divider)" stroke-dasharray="2 3" vector-effect="non-scaling-stroke"/>
                <line x1="0" x2="100" y1="50" y2="50" stroke="var(--color-divider)" stroke-dasharray="2 3" vector-effect="non-scaling-stroke"/>
                <line x1="0" x2="100" y1="100" y2="100" stroke="var(--color-divider)" stroke-dasharray="2 3" vector-effect="non-scaling-stroke"/>
                <path d="{{ $chart['areaPath'] }}" fill="{{ $areaColor }}"/>
                <polyline points="{{ $chart['linePoints'] }}" fill="none" stroke="{{ $color }}" stroke-width="2" vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            @foreach ($chart['points'] as $p)
                <div class="absolute" style="left:{{ $p['x'] }}%;top:{{ $p['y'] }}%;transform:translate(-50%,-50%);width:8px;height:8px;border-radius:50%;background:var(--color-bg);border:2px solid {{ $color }}"></div>
            @endforeach
            @foreach ($chart['points'] as $p)
                <div class="absolute text-xs font-semibold whitespace-nowrap" style="left:{{ $p['x'] }}%;top:{{ $p['y'] }}%;transform:translate(-50%,-150%);color:var(--color-text)">{{ $p['value'] }}</div>
            @endforeach
        </div>
    </div>
    <div class="flex justify-between mt-1.5" style="padding-left:38px">
        @foreach ($labels as $label)
            <span class="text-[10px]" style="color:var(--color-muted)">{{ $label }}</span>
        @endforeach
    </div>
</div>
