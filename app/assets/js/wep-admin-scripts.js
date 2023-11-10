jQuery(document).ready(function($) {
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    var tabValue = getParameterByName('tab'); // Lấy giá trị của tham số 'tab' từ URL

    if (window.location.href.indexOf('page=acf-options-cai-dat-bvdt') > -1 && tabValue) {
        $('.acf-tab-group').find('li').removeClass('active');
        var activeTab = $('.acf-tab-group').find('a[data-key="' + tabValue + '"]').parent();
        var activeTabLink = $('.acf-tab-group').find('a[data-key="' + tabValue + '"]');

        // activeTab.trigger('click');
        activeTabLink.trigger('click');
        activeTab.addClass('active');
    }
});


jQuery(document).ready(function($) {
    // Tìm tất cả các hình ảnh trong phần admin WordPress
    $('.wep_content_html img').each(function() {
        var img = $(this);
        var imgPosition = img.offset().top;
        var windowHeight = $(window).height();
        
        // Kiểm tra xem khi nào người dùng cuộn đến vị trí hình ảnh
        $(window).scroll(function() {
            var windowPosition = $(window).scrollTop();
            if (windowPosition > (imgPosition - windowHeight)) {
                // Thay thế thuộc tính "data-src" bằng "src" để hiển thị ảnh
                img.attr('src', img.attr('data-src'));
            }
        });
    });
});
