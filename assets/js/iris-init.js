jQuery(document).ready(function ($) {

    $('.lgpd-color-picker').iris({
        hide: true,
        palettes: true
    });
    $(document).click(function (e) {
        if (!$(e.target).is(".lgpd-color-picker, .iris-picker, .iris-picker-inner")) {
            $('.lgpd-color-picker').iris('hide');
        }
    });
    $('.lgpd-color-picker').click(function (event) {
        $('.lgpd-color-picker').iris('hide');
        $(this).iris('show');
        return false;
    });

});
