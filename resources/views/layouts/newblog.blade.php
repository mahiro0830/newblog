<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>

<body>
    <header class="l-header">
        <div class="l-header__inner">
            <h1 class="l-header__logo">
                <a href="{{ route('index') }}">newBlog</a>
            </h1><!-- /.l-header__logo -->
            <nav class="l-header__nav">
                <ul class="p-headerNav">
                    <li class="p-headerNav__item">
                        <a href="{{ route('admin.showLogin') }}">管理画面</a>
                    </li><!-- /.p-headerNav__item -->
                    <li class="p-headerNav__item">
                        <a href="#">カテゴリー</a>
                    </li><!-- /.p-headerNav__item -->
                    <li class="p-headerNav__item">
                        <a href="#">タグ</a>
                    </li><!-- /.p-headerNav__item -->
                </ul><!-- /.p-headerNav -->
            </nav><!-- /.l-header__nav -->
        </div><!-- /.l-header__inner -->
    </header><!-- /.l-header -->
    <main class="l-body">
        @yield('content')
    </main><!-- /.l-body -->
    <footer class="l-footer">
        <div class="l-container">
            <div class="l-footer__top">
                <div class="l-footer__top__info">
                    <a href="{{ route('index') }}">newBlog</a>
                </div><!-- /.l-footer__top__info -->
                <div class="l-footer__top__nav">
                    <ul class="p-footerNav">
                        <li class="p-footerNav__item">
                            <a href="#">管理画面</a>
                        </li><!-- /.p-footerNav__item -->
                        <li class="p-footerNav__item">
                            <a href="#">記事一覧</a>
                        </li><!-- /.p-footerNav__item -->
                    </ul><!-- /.p-footerNav -->
                </div><!-- /.l-footer__top__nav -->
            </div><!-- /.l-footer__top -->
        </div><!-- /.l-container -->
        <div class="l-footer__copy">
            <small class="p-footerCopy">
                &copy; 2022 newBlog
            </small><!-- /.p-footerCopy -->
        </div><!-- /.l-footer__copy -->
    </footer><!-- /.l-footer -->
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>