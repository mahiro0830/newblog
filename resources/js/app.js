import $ from "jquery";
// import objectFitImages from "object-fit-images";
// import "../scss/app.scss";

/* ==========================================================================
** ライブラリの発火
\* ======================================================================== */
// ObjectFitImages
// objectFitImages();

/* ==========================================================================
** グローバル変数・定数
\* ======================================================================== */
// Remが変化しはじめるウィンドウ幅
// ※ 変化させない場合は pcWidth と同じ値に設定する。
const maxWidth = 1300;
// コンテンツがはみ出しはじめるウィンドウ幅（PC）
const pcWidth = 1200;
// コンテンツがはみ出しはじめるウィンドウ幅（SP）
const spWidth = 375;
// ブレイクポイント
const breakpoint = 750;
// ウィンドウ幅の取得
var windowWidth = $(window).width();
// リサイズ時にウィンドウ幅を取得
window.addEventListener("resize", function () {
    windowWidth = $(window).width();
});

/* ==========================================================================
** REMの計算
\* ======================================================================== */
$(function () {
    calcRem();
});

window.addEventListener("resize", function () {
    calcRem();
});

function calcRem() {
    var rem = 0;
    var rate = 0;
    const html = document.getElementsByTagName("html");

    // 画面幅：∞ 〜 maxWidth
    if ( windowWidth >= maxWidth ) {
        rem = 62.5;
    }
    // 画面幅：maxWidth-1 〜 pcWidth
    else if ( windowWidth >= pcWidth && windowWidth < maxWidth ) {
        rate = maxWidth / pcWidth;
        rem = ( 62.5 - 62.5 / rate ) * ( ( windowWidth - breakpoint ) / ( maxWidth - breakpoint ) ) + 62.5 / rate;
    }
    // 画面幅：pcWidth-1 〜 breakpoint+1
    else if ( windowWidth < pcWidth && windowWidth > breakpoint ) {
        rate = maxWidth / pcWidth;
        rem = ( 62.5 - 62.5 / rate ) * ( ( pcWidth - breakpoint ) / ( maxWidth - breakpoint ) ) + 62.5 / rate;
    }
    // 画面幅：breakpoint 〜 spWidth
    else if ( windowWidth >= spWidth && windowWidth <= breakpoint ) {
        rate = ( breakpoint / spWidth );
        rem = ( ( 62.5 - 62.5 / rate ) * ( ( windowWidth - spWidth ) / ( breakpoint - spWidth ) ) + 62.5 / rate ) * 2;
    }
    // 画面幅：spWidth-1 〜 0px
    else {
        rate = ( breakpoint / spWidth );
        rem = ( ( 62.5 - 62.5 / rate ) * ( ( spWidth - spWidth ) / ( breakpoint - spWidth ) ) + 62.5 / rate );
        rem *= 2;
    }

    html[0].style.fontSize = "" + rem + "%";
}

/* ==========================================================================
** vhの調整
\* ======================================================================== */
$(function () {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty("--vh", vh + "px");
    window.addEventListener("resize", function () {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty("--vh", vh + "px");
    });
});

/* ==========================================================================
** ViewPort
\* ======================================================================== */
$(function () {
    if (window.matchMedia("screen and (max-width: " + pcWidth + "px)").matches && window.matchMedia("screen and (min-width: " + (breakpoint+1) + "px)").matches) {
        var rate = windowWidth / pcWidth;
        var viewport_content = $('meta[name="viewport"]').attr("content");
        viewport_content = viewport_content.slice(0, -1);
        $('meta[name="viewport"]').attr("content", viewport_content + rate);
    }
    if (window.matchMedia("screen and (max-width: " + spWidth + "px)").matches) {
        var rate = windowWidth / spWidth;
        var viewport_content = $('meta[name="viewport"]').attr("content");
        viewport_content = viewport_content.slice(0, -1);
        $('meta[name="viewport"]').attr("content", viewport_content + rate);
    }
});

/* ==========================================================================
** はみ出たヘッダーをスクロールで位置調整
\* ======================================================================== */
$(window).scroll(function () {
    $(".l-header").css("left", -$(this).scrollLeft() + "px");
});

/* ==========================================================================
** TOPに戻るボタン
\* ======================================================================== */
$("a[href='#']").click(function() {
	$("html, body").animate({scrollTop: 0}, 300);
	return false;
});


$('.data-edit').click(function() {
    $('.l-taxonomy__modal').fadeIn();

    $('input[name="new_id"]').val($(this).data('id'));
    $('input[name="new_name"]').val($(this).data('name'));
    $('input[name="new_slug"]').val($(this).data('slug'));
    $('select[name="new_path"] option[value="'+$(this).data('path')+'"]').prop('selected', true);
});

$('.l-taxonomy__modal .close').click(function() {
    $('.l-taxonomy__modal').fadeOut();
});