@extends('layouts.newblog')

@section('title', '記事一覧')

@section('content')
<div class="l-container">

    <div class="l-body__main">
        <h2 class="c-titleMain">{{ $item->title }}</h2>
        <div class="p-entryHead">
            @if ( $item->find( $id )->relation_category['category']['name'] != null )
                <a href="{{ $category_slug }}" class="p-entryHead__category">
                    {{ $item->find( $id )->relation_category['category']['name'] }}
                </a><!-- /.p-entryHead__category -->
            @else
                <div class="p-entryHead__category nocategory">
                    未分類
                </div><!-- /.p-entryHead__category -->
            @endif
            <time class="p-entryHead__time">
                {{ $item['created_at'] }}
            </time><!-- /.p-entryHead__time -->
        </div><!-- /.p-entryHead -->
        <p class="p-entryContent">{{ $item->content }}</p>
        <div class="u-tac">
            <a href="{{ route('index') }}" class="c-buttonMini">記事一覧へ戻る</a>
        </div><!-- /.u-tac -->
    </div><!-- /.l-body__main -->

    <!-- サイドバー -->
    @component( 'components.sidebar', ['categories' => $categories, 'tags' => $tags] )
    @endcomponent

</div><!-- /.l-container -->
@endsection