
jQuery(document).ready(function() {
    jQuery('#dong-bo').click(function() {
        const ajaxUrl = wepAjaxAdmin.ajaxUrl; 
        const ajaxNonce = wepAjaxAdmin.ajaxNonce; // Lấy nonce từ biến đã truyền từ PHP

        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: ajaxUrl,
            data: {
                'action': "google_sheet_bvdt",
                'code': jQuery('input[name="code_sheet"]').val(),
                'nonce': ajaxNonce,
            },
            beforeSend: function() {
                jQuery('#list-ajax').html('Xin hãy đợi, đang đồng bộ...');
            },
            success: function(response) {
                jQuery('input[name="code_sheet"]').val('');
                if (response.stt == 1) {
                    jQuery('#list-ajax').html(response.data);
                } else if (response.stt == 2) {
                    list_salon = response.data;

                    function ajax_each(index, value) {
                        const ajaxUrl = wepAjaxAdmin.ajaxUrl; // Lấy nonce từ biến đã truyền từ PHP
                        const ajaxNonceUpdate = wepAjaxAdmin.ajaxNonceUpdate; // Lấy nonce từ biến đã truyền từ PHP

                        maxValue = list_salon.length;
                        if (index < maxValue) {
                            jQuery(window).unload(function() {
                                var r = confirm('Are you sure?');
                            });
                        }
                        jQuery.ajax({
                            type: "post",
                            dataType: "json",
                            url: ajaxUrl,
                            data: {
                                salon: value[index],
                                action: 'google_sheet_bvdt_update',
                                nonce: ajaxNonceUpdate,
                            },
                            beforeSend: function() {
                                if (index == 0) {
                                    jQuery('#list-ajax').html('Loading ...<br>');
                                }
                            }
                        }).success(function(response) {
                            html = (index + 1) + '. ' + response.data + '.<br>';
                            jQuery('#list-ajax').prepend(html);
                            index++;
                            if (index < maxValue) {
                                ajax_each(index, list_salon);
                            } else {
                                jQuery('#list-ajax').prepend('<h3>Danh sách sản phẩm</h3>Đã đồng bộ xong!<br>');
                                jQuery(window).unbind('beforeunload');
                            }
                            if (response.stt == 2) {
                                jQuery('#ds-error').removeClass('hidden').append(html);
                            }
                        });
                    }
                    ajax_each(0, list_salon);
                }
            }
        });
    });
});
