global.$ = global.jQuery = require('jquery');

(function() {
    'use strict';

    // フラッシュメッセージのフェードアウト
    $(function() {
        $('.js-flash_message').fadeIn(2000).fadeOut(4000);
    });

    // フッターを最下部に固定
    const $ftr = $('.js-footer');
    // if (window.innerHeight > $ftr.offset().top + $ftr.outerHeight()) {
    if (window.outerHeight > $ftr.offset().top + $ftr.outerHeight()) {
        $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) + 'px;'});
    }

      // フロートヘッダーメニュー
    let targetHeight = $('.js-float-menu-target').height();
    $(window).on('scroll', function() {
        $('.js-float-menu').toggleClass('float-active', $(this).scrollTop() > targetHeight);
    });

      // SPメニュー
    $('.js-toggle-sp-menu').on('click', function() {
        $(this).toggleClass('is-active');
        $('.js-toggle-sp-menu-target').toggleClass('is-active');
    });
    $('.js-sp-menu-item').on('click', function() {
        $('.js-toggle-sp-menu').toggleClass('is-active');
        $('.js-toggle-sp-menu-target').toggleClass('is-active');
    });

})();