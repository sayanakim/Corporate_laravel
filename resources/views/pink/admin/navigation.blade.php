@if($menu)
    <div class="menu classic">

        {!! $menu->asUl(['class' => 'menu']) !!}

    </div>
@endif

{{--аналогично--}}
{{--<ul>--}}
{{--    <li class="menu"></li>--}}
{{--</ul>--}}
