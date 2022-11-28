@extends('layouts.newblog')

@section('title', '記事一覧')

@section('content')
<div class="l-container">
    <div class="l-body__1col">
        <h2 class="c-titleMain">ログイン画面</h2>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <table border="1" style="border-collapse: collapse;">
                <tr>
                    <th>メールアドレス</th>
                    <td><input type="text" name="email" id="email" value="{{ old('email') }}" style="border: 0;"></td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td><input type="password" name="password" id="password" style="border: 0;"></td>
                </tr>
                <tr>
                    <th>ログインする</th>
                    <td><input type="submit" value="ログイン"></td>
                </tr>
            </table>
            <h3>テストアカウント</h3>
            メールアド：example@test.com<br>
            パスワード：password
        </form>
    </div><!-- /.l-body__1col -->
</div><!-- /.l-container -->
@endsection