<!-- START CONTENT -->
<div id="content-blog" class="content group">

    @if($articles)

        @foreach($articles as $article)

            <div class="sticky hentry hentry-post blog-big group">
                <!-- post featured & title -->
                <div class="thumbnail">
                    <!-- post title -->
                    <h2 class="post-title"><a href="{{ route('articles.show', ['alias'=>$article->alias]) }}">{{ $article->title }}</a></h2>
                    <!-- post featured -->
                    <div class="image-wrap">
                        <img src="{{ asset(env('THEME')) }}/images/articles/{{ $article->img->max }}" alt="001" title="001" />
                    </div>
                    <p class="date">
                        <span class="month">{{ $article->created_at->format('M') }}</span>
                        <span class="day">{{ $article->created_at->format('d') }}</span>
                    </p>
                </div>

                <!-- post meta -->
                <div class="meta group">
                    <p class="author"><span>by <a href="#" title="Posts by {{ $article->user->name }}" rel="author">{{ $article->user->name }}</a></span></p>
                    <p class="categories"><span>In: <a href="{{ route('articlesCat', ['cat_alias' => $article->category->alias]) }}"
                                                       title="{{ $article->category->title }}"
                                                       rel="category tag">{{ $article->category->title }}</a>
                    <p class="comments"><span><a href="{{ route('articles.show', ['alias'=>$article->alias]) }}#respond"
                                                 title="">{{ count($article->comments) ? count($article->comments) : '0' }}
                                {{ \Illuminate\Support\Facades\Lang::choice('ru.comments', count($article->comments)) }}</a></span></p>
                </div>

                <!-- post content -->
                <div class="the-content group">
                     {!! $article->desc !!}
                     <p><a href="{{ route('articles.show', ['alias' => $article->alias]) }}" class="btn btn-beetle-bus-goes-jamba-juice-4 btn-more-link">→
                         {{ \Illuminate\Support\Facades\Lang::get('ru.read_more') }}</a></p>
                </div>
                <div class="clear"></div>
            </div>

        @endforeach

        {{--pagination--}}
            <div class="general-pagination group">

                @if($articles->lastPage() > 1)

                    @if($articles->currentPage() !== 1)
                        <a href="{{ $articles->url(($articles->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a>
                    @endif

                    @for($i = 1; $i <= $articles->lastPage(); $i++)
                        @if($articles->currentPage() == $i)
                            <a class="selected disabled">{{ $i }}</a>
                        @else
                            <a href="{{ $articles->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($articles->currentPage() !== $articles->lastPage())
                        <a href="{{ $articles->url(($articles->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a>
                    @endif


                @endif

            </div>

    @else
        {!! \Illuminate\Support\Facades\Lang::get('ru.articles_no') !!}
    @endif

</div>
<!-- END CONTENT -->
