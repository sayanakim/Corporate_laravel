
{{--2 способ--}}
@if($menu)
    <div class="menu classic">
        <ul id="nav" class="menu">
            @include(env('THEME').'.customMenuItems', ['items'=>$menu->roots()])
        </ul>

    </div>
@endif

{{-- 1 способ--}}
{{--@if($menu)--}}

{{--    {!! $MyNav->asUl() !!}--}}

{{--@endif--}}

