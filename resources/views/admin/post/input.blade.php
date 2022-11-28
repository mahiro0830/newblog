@extends('layouts.admin')

@section('title', '管理画面')

@section('content')
    <form action="{{ Request::is('admin/post/add') ? route('admin.post.add') : route('admin.post.edit') . '?post_id=' . $request->id }}" method="POST" class="l-input">
        <div class="l-input__main">
            <h2 class="c-titleMain">{{ Request::is('admin/post/add') ? '新規投稿' : '記事編集' }}</h2>
            <p style="color: green;">{{ session('update_message') }}</p>
            <div class="p-postInput">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="p-postInput__title">
                    <input type="text" name="title" value="{{ isset($entry) ? $entry->title : '' }}" placeholder="タイトルを入力してしください">
                </div><!-- /.p-postInput__title -->
                <div class="p-postInput__content">
                    <textarea name="content" cols="30" rows="10">{{ isset($entry) ? $entry->content : old('content') }}</textarea>
                </div><!-- /.p-postInput__content -->
                <input type="submit" value="保存" class="c-buttonMini">
            </div>
        </div><!-- /.l-input__main -->
        <div class="l-input__sidebar">
            <div class="p-inputSide">
                <h2>カテゴリー選択</h2>
                <div class="p-inputCategory" style="font-size: 1.4rem;">
                    <div class="p-inputCategory__item">
                        <input type="radio" name="category" id="0" value="0" <?php if(empty($selected_category)) echo 'checked'; ?>>
                        <label for="0">
                            なし
                        </label>
                    </div><!-- /.p-inputCategory__item -->
                    @foreach($categories as $category)
                    <div class="p-inputCategory__item">
                        <?php
                        if ( count( $category->relationCategories ) != 0 && isset($request->post_id) )
                        {
                            $relation_categories = $category->relationCategories;
                            foreach ($relation_categories as $value )
                            {
                                if ( $value->post_id == $request->post_id )
                                {
                                    $flag = true;
                                    break;
                                }
                                else
                                {
                                    $flag = false;
                                }
                            }
                        }
                        else
                        {
                            $flag = false;
                        }
                        ?>
                        <input type="radio" name="category" id="{{ $category->id }}" value="{{ $category->id }}" <?php if($flag) echo 'checked'; ?>>
                        <label for="{{ $category->id }}">
                            @for($i = 2; $i < mb_substr_count( $category['path'], '/' ); $i++)
                            −
                            @endfor
                            {{ $category->name }}
                        </label>
                    </div><!-- /.p-inputCategory__item -->
                    @endforeach
                </div><!-- /.p-inputCategory -->
            </div><!-- /.p-inputSide -->
            <div class="p-inputSide">
                <h2>タグ選択</h2>
                <div class="p-inputTag" style="font-size: 1.4rem;">
                    @foreach($tags as $key => $tag)
                    <div class="p-inputTag__item">
                        <?php
                        if ( count( $tag->relationTags ) != 0 && isset($request->post_id) )
                        {
                            $relation_tags = $tag->relationTags;
                            foreach ($relation_tags as $value )
                            {
                                if ( $value->post_id == $request->post_id )
                                {
                                    $flag = true;
                                    break;
                                }
                                else 
                                {
                                    $flag = false;
                                }
                            }
                        }
                        else
                        {
                            $flag = false;
                        }
                        ?>
                        <input type="checkbox" name="tag[]" id="{{ $tag->id }}" value="{{ $tag->id }}" <?php if($flag) echo 'checked'; ?>>
                        <label for="{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div><!-- /.p-inputCategory__item -->
                    @endforeach
                </div><!-- /.p-inputCategory -->
            </div><!-- /.p-inputSide -->
        </div><!-- /.l-input__sidebar -->
    </div><!-- /.l-input -->
@endsection