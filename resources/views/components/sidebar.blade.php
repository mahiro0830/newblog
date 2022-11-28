<aside class="l-body__aside">
    <section class="l-aside">
        <h2 class="c-titleUnderline">
            カテゴリー一覧
        </h2><!-- /.c-titleUnderline -->
        @if ( $categories != null )
            <ul class="p-categories">
                @foreach ( $categories as $category )
                    <li>
                        <a href="{{ route( 'index' ) . '/category/' . $category['slug'] }}">
                            @for ( $i = 2; $i < mb_substr_count( $category['path'], '/' ); $i++ )
                                -
                            @endfor
                            {{ $category['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul><!-- /.p-categories -->
        @endif
    </section><!-- /.l-aside -->
    <section class="l-aside">
        <h2 class="c-titleUnderline">
            タグ一覧
        </h2><!-- /.c-titleUnderline -->
        @if ( $tags != null )
            <div class="p-tags">
                @foreach ( $tags as $tag )
                    <a href="{{ route( 'index' ) . '/tag/' . $tag['slug'] }}">
                        #{{ $tag['name'] }}
                    </a>
                @endforeach
            </div><!-- /.p-tags -->
        @endif
    </section><!-- /.l-aside -->
</aside>