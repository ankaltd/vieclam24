export default class WoocommerceSorting {
  constructor() {
    this.init();
  }

  init() {
    // Add your JavaScript code here to handle radio button clicks and URL updates.
    jQuery(document).ready(function ($) {
      $(".wep-control-input").on("change", function () {
        var orderby = $(this).val();
        var currentUrl = window.location.href;
        var newUrl = currentUrl.split("?")[0]; // Lấy phần trước dấu ?

        if (newUrl.endsWith("/")) {
          newUrl += "?orderby=" + orderby;
        } else {
          newUrl += "/?orderby=" + orderby;
        }

        window.location.href = newUrl;
      });
    });

    jQuery(document).ready(function ($) {
      // Thêm lớp 'form-control' cho các trường input
      $(".woocommerce .input-text").addClass("form-control");

      // Thêm lớp 'form-control' cho các trường input comment
      $("#author, #email, #url").addClass("form-control");

      // Xử lý khi mở click mật khẩu
      jQuery(".open-nd-password").click(function () {
        var i = 1;
        var time = jQuery(this).attr("data-time");
        var txt = jQuery(this).parent().find(".alert-success").html();
        var html = txt.charAt(0);
        var id = jQuery(this)
          .parent()
          .find(".alert-success")
          .html(html)
          .removeClass("d-none")
          .attr("id");
        jQuery(this).attr("disabled", "disabled");
        var Interval = setInterval(function () {
          if (i < txt.length) {
            html += txt.charAt(i);
            jQuery("#" + id).html(html);
            i++;
          } else {
            clearInterval(Interval);
          }
        }, time);
      });
    });
  }
}

// Initialize the class
new WoocommerceSorting();
