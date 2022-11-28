@extends('layouts.newblog')

@section('title', '記事一覧')

@section('content')
<div class="l-container">
    <div class="l-body__main">
        <h2 class="c-titleMain">記事一覧</h2>
        <div class="p-entries">
            @foreach($items as $item)
                <a href="{{ route( 'index' ) . '/post/' . $item->id }}" class="p-entries__item">
                    <span class="p-entries__category">
                        @if( $item->relation_category['category']['name'] != null )
                            <span class="category">{{ $item->relation_category['category']['name'] }}</span>
                        @else 
                            <span class="uncategory">未分類</span>
                        @endif
                    </span>
                    <time class="p-entries__time">{{ $item->created_at }}</time>
                    @if ( count( $item->relation_tags ) > 0 )
                        <div class="p-entries__tags">
                            @foreach ( $item->relation_tags as $relation_tag )
                                <span>#{{ $relation_tag['tags']['name'] }}</span>
                            @endforeach
                        </div><!-- /.p-entries__tags -->
                    @endif
                    <h3 class="p-entries__title">{{ $item->title }}</h3>
                </a>
            @endforeach
        </div><!-- /.p-entries -->
        <div class="p-laravellinks">
            {{ $items->links() }}
        </div><!-- /.p-laravellinks -->
    </div><!-- /.l-body__main -->

    <!-- サイドバー -->
    @component( 'components.sidebar', ['categories' => $categories, 'tags' => $tags] )
    @endcomponent

</div><!-- /.l-container -->
@endsection