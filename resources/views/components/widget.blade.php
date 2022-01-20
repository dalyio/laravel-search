<div class="widget d-flex flex-wrap p-3">
    
    @foreach ($layouts as $layout)
    
        @switch ($layout['type'])
            @case('box')
                @for ($i = 1; $i <= $layout['show']; $i++)
                    @if($widgetBoxes->count())
                    {{ $widgetBoxes->shift()->setWidth($layout['width'])->render() }}
                    @endif
                @endfor
                @break
            @case('chart')
                @for ($i = 1; $i <= $layout['show']; $i++)
                    @if($widgetCharts->count())
                    {{ $widgetCharts->shift()->setWidth($layout['width'])->render() }}
                    @endif
                @endfor
                @break
            @case('grid')
                @for ($i = 1; $i <= $layout['show']; $i++)
                    @if($widgetGrids->count())
                    {{ $widgetGrids->shift()->setWidth($layout['width'])->render() }}
                    @endif
                @endfor
                @break
        @endswitch
    
    @endforeach
    
</div>
