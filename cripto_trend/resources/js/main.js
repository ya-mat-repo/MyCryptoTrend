global.$ = global.jQuery = require('jquery');

(function() {
    'use strict';

    // フラッシュメッセージのフェードアウト
    $(function() {
        $('.js-flash_message').fadeIn(2000).fadeOut(4000);
    });

    // フッターを最下部に固定
    const $ftr = $('.js-footer');
    if (window.innerHeight > $ftr.offset().top + $ftr.outerHeight()) {
        $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) + 'px;'});
    }
})();