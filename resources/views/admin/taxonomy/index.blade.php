@extends('layouts.admin')

@section('title', '管理画面')

@section('content')
<h2 class="c-titleMain">{{ $taxonomy }}</h2>
<div class="l-taxonomy">
    <div class="l-taxonomy__input">
        <form action="{{ Request::is('admin/categories') ? route('admin.categories.register') : route('admin.tags.register') }}" method="post" class="p-taxonomyInput">
            @csrf
            <dl>
                <dt>{{ $taxonomy }}名</dt>
                <dd><input type="text" name="name"></dd>
            </dl>
            <dl>
                <dt>スラッグ名<br>（※未入力の場合は10桁の英数字が割り振られます）</dt>
                <dd><input type="text" name="slug"></dd>
            </dl>
            @if( Request::is('admin/categories') )
            <dl>
                <dt>親カテゴリー</dt>
                <dd>
                    <select name="path">
                        <option value="">なし</option>
                        @foreach($items as $item)
                        <option value="{{ $item['path'] }}">
                            @for($i = 2; $i < mb_substr_count( $item['path'], '/' ); $i++)
                            −
                            @endfor
                            {{ $item['name'] }}
                        </option>
                        @endforeach
                    </select>
                </dd>
            </dl>
            @endif
            <input type="submit" value="登録">
        </form>
    </div><!-- /.l-taxonomy__input -->
    <div class="l-taxonomy__list">
        <table class="p-taxonomyList">
            <thead>
                <tr class="p-taxonomyList__item">
                    <th>{{ $taxonomy }}名</th>
                    <td>スラッグ名</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <th>
                        @for($i = 2; $i < mb_substr_count( $item['path'], '/' ); $i++)
                        −
                        @endfor
                        {{ $item['name'] }}
                    </th>
                    <td>{{ $item['slug'] }}</td>
                    <td><a href="{{ Request::is('admin/categories') ? route('admin.categories.delete') : route('admin.tags.delete') }}?id={{ $item['id'] }}">削除</a></td>
                    @if(Request::is('admin/categories'))
                    <?php
                    if ( mb_substr_count( $item['path'], '/' ) > 2 ) 
                    {
                        $parent_path = str_replace('/' . $item['id'] . '/', '/', $item['path']);
                    }
                    else
                    {
                        $parent_path = '';
                    }
                    ?>
                    <td><a href="#" class="data-edit" data-id="{{ $item['id'] }}" data-name="{{ $item['name'] }}" data-slug="{{ $item['slug'] }}" data-path="{{ $parent_path }}">編集</a></td>
                    @else
                    <td><a href="#" class="data-edit" data-id="{{ $item['id'] }}" data-name="{{ $item['name'] }}" data-slug="{{ $item['slug'] }}">編集</a></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table><!-- /.p-taxonomyList -->
    </div><!-- /.l-taxonomy__list -->
    <div class="l-taxonomy__modal">
        <form action="{{ Request::is('admin/categories') ? route('admin.categories.update') : route('admin.tags.update') }}" method="post" id="modal">
            @csrf
            <input type="hidden" name="new_id">
            {{ $taxonomy }}名<br>
            <input type="text" name="new_name"><br>
            <br>
            スラッグ名<br>
            <input type="text" name="new_slug"><br>
            @if(Request::is('admin/categories'))
            <br>
            親カテゴリー<br>
            <select name="new_path">
                <option value="">なし</option>
                @foreach($items as $item)
                    <option value="{{ $item['path'] }}">
                        @for($i = 2; $i < mb_substr_count( $item['path'], '/' ); $i++)
                        −
                        @endfor
                        {{ $item['name'] }}
                    </option>
                @endforeach
            </select>
            @endif
            <br>
            <br>
            <input type="submit" value="更新">
        </form>
        <div class="close"></div><!-- /.close -->
    </div><!-- /.l-taxonomy__modal -->
</div><!-- /.l-taxonomy -->
@endsection