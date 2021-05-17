
@extends(env('THEME').'.layouts.site')

@section('content')
    <!-- START CONTENT -->
<div id="content-index" class="content group">
    <img class="error-404-image group" src="{{ asset(env('THEME')) }}/images/features/404.png" title="Error 404" alt="404" />
    <div class="error-404-text group">
        <h2>Страница не найдена!</h2>
    </div>
</div>
<!-- END CONTENT -->
@endsection


@section('footer')
    @include(env('THEME').'.footer')
@endsection
