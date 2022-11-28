@extends('layouts.admin')

@section('title', '管理画面')

@section('content')

<h2 class="c-titleMain">各種設定</h2>
<p style="color: green;">{{ session('update_message') }}</p>

<form action="{{ route( 'admin.config.save' ) }}" method="post">
    @csrf
    <dl class="p-configItem">
        <dt class="p-configItem__head">
            管理画面の記事表示数：
        </dt><!-- /.p-configItem__head -->
        <dd class="p-configItem__body">
            <input type="number" name="admin_post_num" value="{{ $admin_post_num }}">
        </dd><!-- /.p-configItem__body -->
    </dl><!-- /.p-configItem -->
    <dl class="p-configItem">
        <dt class="p-configItem__head">
            ユーザー画面の記事表示数：
        </dt><!-- /.p-configItem__head -->
        <dd class="p-configItem__body">
            <input type="number" name="post_num" value="{{ $post_num }}">
        </dd><!-- /.p-configItem__body -->
    </dl><!-- /.p-configItem -->
    <input type="submit" value="設定を保存" class="c-buttonMini">
</form>

@endsection