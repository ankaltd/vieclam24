(function() {
    tinymce.PluginManager.add('shortcode_button', function(editor, url) {
        editor.addButton('shortcode_button', {
            text: 'Chèn Shortcode',
            icon: 'dashicons-admin-page', // Sử dụng Dashicon
            onclick: function() {
                editor.windowManager.open({
                    title: 'Chèn Shortcode', 
                    body: [
                        {
                            type: 'listbox',
                            name: 'shortcode',
                            label: 'Chọn Shortcode',
                            values: [
                                { text: 'WEP Shortcode', value: 'wep_shortcode' },
                                { text: 'Shortcode 2', value: 'shortcode_2' },
                               
                                // Thêm các shortcode khác vào đây
                            ]
                        },
                        {
                            type: 'textbox',
                            name: 'text_param',
                            label: 'Text Parameter',
                        },
                        {
                            type: 'listbox',
                            name: 'select_param',
                            label: 'Select Parameter',
                            values: [
                                { text: 'Option 1', value: 'option_1' },
                                { text: 'Option 2', value: 'option_2' },
                                // Thêm các tùy chọn khác vào đây
                            ]
                        },
                        {
                            type: 'checkbox',
                            name: 'checkbox_param',
                            label: 'Checkbox Parameter',
                        },
                        {
                            type: 'radio',
                            name: 'radio_param',
                            label: 'Radio Parameter',
                            values: [
                                { text: 'Option A', value: 'option_a' },
                                { text: 'Option B', value: 'option_b' },
                                // Thêm các tùy chọn khác vào đây
                            ]
                        }
                    ],
                    onsubmit: function(e) {
                        var shortcode = e.data.shortcode;
                        var text_param = e.data.text_param;
                        var select_param = e.data.select_param;
                        var checkbox_param = e.data.checkbox_param;
                        var radio_param = e.data.radio_param;

                        // Chèn shortcode vào trình soạn thảo với tham số
                        editor.insertContent('[' + shortcode + ' text_param="' + text_param + '" select_param="' + select_param + '" checkbox_param="' + checkbox_param + '" radio_param="' + radio_param + '"]');
                    }
                });
            }
        });
    });
})();