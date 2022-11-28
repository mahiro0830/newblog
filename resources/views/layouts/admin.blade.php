<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>

<body style="height: 100vh;">
    <div class="l-toolbar">
        <div class="p-toolbarNav">
            <a href="{{ route('index') }}" class="p-toolbarNav__top">
                TOP
            </a><!-- /.p-toolbarNav__top -->
            <div class="p-toolbarNav__siteName">
                サイト名：newBlog
            </div><!-- /.p-toolbarNav__siteName -->
            <div class="p-toolbarNav__user">
                ｢{{ Auth::user()->name; }}」さんとしてログイン中
            </div><!-- /.l-toolbarNav__user -->
            <a href="{{ route('admin.logout') }}" class="p-toolbarNav__logout">
                ログアウト
            </a><!-- /.p-toolbarNav__logout -->
        </div><!-- /.p-toolbarNav -->
    </div><!-- /.l-toolbar -->
    <div class="l-adminNav">
        <div class="l-adminNav__inner">
            <ul class="p-adminNav">
                <li>
                    <a href="{{ route('admin.index') }}">管理画面TOP</a>
                </li>
                <li>
                    <a href="{{ route('admin.post.index') }}">記事</a>
                    <ul {!! (Request::is('admin/post*') ? 'class="show"' : '') !!}>
                        <li>
                            <a href="{{ route('admin.post.add') }}">新規投稿</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.categories') }}">カテゴリー</a>
                </li>
                <li>
                    <a href="{{ route('admin.tags') }}">タグ</a>
                </li>
                <li>
                    <a href="{{ route('admin.config') }}">設定</a>
                </li>
            </ul><!-- /.p-adminNav -->
        </div><!-- /.l-adminNav__inner -->
    </div><!-- /.l-adminNav -->
    <div class="l-adminBody">
        <div class="l-adminBody__inner">
            @yield('content')
        </div><!-- /.l-adminBody__inner -->
    </div><!-- /.l-adminBody -->
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>