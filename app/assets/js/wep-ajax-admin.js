jQuery(document).ready(function($) {
    // Xử lý sự kiện khi người dùng thay đổi lựa chọn
    $('.page-template-select').change(function() {
        var selectedTemplate = $(this).val();
        var postId = $(this).data('post-id');

        // Gửi dữ liệu thông qua AJAX để lưu template cho trang
        $.ajax({
            url: ajaxurl, // ajaxurl là biến toàn cục được WordPress định nghĩa
            type: 'POST',
            data: {
                action: 'apply_page_template',
                post_id: postId,
                page_template: selectedTemplate,
            },
            success: function(response) {
                // Xử lý kết quả nếu cần
                console.log(response);
            }
        });
    });
});
