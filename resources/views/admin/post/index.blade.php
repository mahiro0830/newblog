@extends('layouts.admin')

@section('title', '管理画面')

@section('content')
<h2 class="c-titleMain">投稿記事一覧</h2>
<div class="l-postList">
    <div class="l-postList__new">
        <a href="{{ route('admin.post.add') }}" class="c-buttonMini">
            新規投稿
        </a><!-- /.c-buttonMini -->
    </div><!-- /.l-postList__new -->
</div><!-- /.l-postList -->
<p style="color: red;">{{ session('delete_message') }}</p>
<p style="color: green;">{{ session('replicate_message') }}</p>
<div class="p-showNum">
    <p class="p-showNum__right">全｢{{ $request->allCount }}｣件</p>
</div><!-- /.p-showNum -->
<table class="l-postList__table p-postTable">
    <thead>
        <tr>
            <th>タイトル</th>
            <th>カテゴリー</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
        <tr>
            <th>
                <a href="{{ route('admin.post.edit') }}?post_id={{ $entry->id }}">{{ $entry->title }}</a>
                <a href="{{ route('admin.post.replicate') }}?post_id={{ $entry->id }}">複製</a>
                <a href="{{ route('admin.post.delete') }}?post_id={{ $entry->id }}" style="color: red;">削除</a>
            </th>
            <td style="vertical-align: middle;">
            @if( $entry->relation_category && $entry->relation_category->category )
                {{ $entry->relation_category->category->name }}
            @else
                -
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table><!-- /.l-postList__table -->
@if( $entries->hasPages() )
<div class="p-paginate">
    <a href="{{ $entries->onFirstPage() ? 'javascript:void(0)' : $entries->previousPageUrl() }}">&lt;</a>
    @if(($request->allCount / $request->showNum) < 5)
        @for($i = 0; $i < ($request->allCount / $request->showNum); $i++)
        <a {{ ($entries->currentPage() == ($i + 1)) ? 'href=javascript:void(0) class=current' : 'href=' . $entries->url($i + 1) }}>{{ $i + 1 }}</a>
        @endfor
    @else
        <a {{ $entries->onFirstPage() ? 'href=javascript:void(0) class=current' : 'href=' . $entries->url(1) }}>1</a>
        <a href="javascript:void(0)">...</a>
        @if(ceil($request->allCount / $request->showNum) - $entries->currentPage() > 3)
        <a href="{{ $entries->onFirstPage() ? $entries->url(2) : $entries->url($entries->currentPage()) }}" class="@if(!$entries->onFirstPage()) current @endif">{{ $entries->onFirstPage() ? 2 : $entries->currentPage() }}</a>
        <a href="{{ $entries->onFirstPage() ? $entries->url(3) : $entries->url($entries->currentPage() + 1) }}">{{ $entries->onFirstPage() ? 3 : $entries->currentPage() + 1 }}</a>
        <a href="{{ $entries->onFirstPage() ? $entries->url(4) : $entries->url($entries->currentPage() + 2) }}">{{ $entries->onFirstPage() ? 4 : $entries->currentPage() + 2 }}</a>
        <a href="javascript:void(0)">...</a>
        <a href="{{ $entries->url((10 - ($entries->currentPage() % 10)) + $entries->currentPage()) }}">{{ (10 - ($entries->currentPage() % 10)) + $entries->currentPage() }}</a>
        @else
        <a href="{{ $entries->url(ceil($request->allCount / $request->showNum) - 3) }}" class="@if($entries->currentPage() == ceil($request->allCount / $request->showNum) - 3) current @endif">{{ ceil($request->allCount / $request->showNum) - 3 }}</a>
        <a href="{{ $entries->url(ceil($request->allCount / $request->showNum) - 2) }}" class="@if($entries->currentPage() == ceil($request->allCount / $request->showNum) - 2) current @endif">{{ ceil($request->allCount / $request->showNum) - 2 }}</a>
        <a href="{{ $entries->url(ceil($request->allCount / $request->showNum) - 1) }}" class="@if($entries->currentPage() == ceil($request->allCount / $request->showNum) - 1) current @endif">{{ ceil($request->allCount / $request->showNum) - 1 }}</a>
        <a href="{{ $entries->url(ceil($request->allCount / $request->showNum)) }}" class="@if($entries->currentPage() == ceil($request->allCount / $request->showNum)) current @endif">{{ ceil($request->allCount / $request->showNum) }}</a>
        @endif
    @endif
    <a href="{{ $entries->onLastPage() ? 'javascript:void(0)' : $entries->NextPageUrl() }}">&gt;</a>
</div><!-- /.p-paginate -->
@endif
@endsection