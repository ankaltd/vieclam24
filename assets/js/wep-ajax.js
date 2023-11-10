class ProductTabs {
  constructor() {
    this.setupEventListeners();
  }

  /* Thay #productTabs bằng các Tab cụ thể trong các nội dung */
  setupEventListeners() {
    jQuery(document).ready(($) => {
      $("#productTabs .nav-link").on("click", (e) => {
        e.preventDefault();

        const tabLink = $(e.currentTarget);
        const content_id = tabLink.attr("href");
        const key_tag = tabLink.attr("aria-controls");
        const product_id = tabLink.attr("pid");
        const default_policy_id = tabLink.attr("dpid");

        const more_button = $(".wep_description__showmore");

        // Tạo một đối tượng jQuery chứa thành phần spinner
        const spinner = $("<span>", { class: "wep-spinner" });

        // Kiểm tra xem có nội dung trong .wep_content_html không
        const wepContentHtml = $(content_id).find(".wep_content_html");
        const hasContent = wepContentHtml.attr("has-content");

        // Chỉ tải nội dung nếu chưa có
        if (typeof hasContent === "undefined" || hasContent === "false") {
          const ajaxNonce = wepAjax.ajaxNonce; // Lấy nonce từ biến đã truyền từ PHP

          // Thêm thẻ <span> vào phần tử có id là "webContentHtml"
          more_button.prepend(spinner);
          more_button.find(".wep-spinner").css("visibility", "visible");

          // Gửi AJAX request
          $.ajax({
            url: wepAjax.ajaxUrl,
            type: "POST",
            data: {
              action: "get_tab_content",
              key: key_tag,
              pid: product_id,
              dpid: default_policy_id,
              nonce: ajaxNonce,
            },
            success: (response) => {
              // Thêm đánh dấu đã có nội dung
              wepContentHtml.attr({ "has-content": "true" });

              console.log("OK");

              // Đưa nội dung trả về vào .wep_content_html
              wepContentHtml.html(response);

              // Ẩn biểu tượng spinner và hiển thị nội dung
              more_button.find(".wep-spinner").css("visibility", "hidden");
              more_button.find(".wep-spinner").remove();
            },
          });
        } // endif
      });
    });
  }
}

// Sử dụng lớp ProductTabs để khởi tạo và xử lý sự kiện
const productTabs = new ProductTabs();

class ProductLazyLoad {
  constructor() {
    this.setupScrollListeners();
  }

  setupScrollListeners() {
    jQuery(document).ready(($) => {
      const spinner = $("<span>", { class: "wep-spinner" });

      $(window).on("scroll", () => {
        $(".wep_service__related").each(function () {
          const elementTop = $(this).offset().top;
          const viewportTop = $(window).scrollTop();
          const windowHeight = $(window).height();

          if (elementTop < viewportTop + windowHeight) {
            const productID = $(this).attr("pid");

            const relatedContent = $(this).find(".related_products");
            const hasContent = relatedContent.attr("has-content");

            if (typeof hasContent === "undefined" || hasContent === "false") {
              const ajaxNonce = wepAjax.ajaxNonce;

              // Thêm spinner khi đang tải nội dung
              $(this).prepend(spinner);
              $(this).find(".wep-spinner").css("visibility", "visible");

              // Đánh dấu rằng đã có nội dung
              relatedContent.attr({ "has-content": "true" });

              // Gửi yêu cầu AJAX
              $.ajax({
                url: wepAjax.ajaxUrl,
                type: "POST",
                data: {
                  action: "get_related_content",
                  pid: productID,
                  nonce: ajaxNonce,
                },
                success: (response) => {
                  // Đánh dấu rằng đã có nội dung
                  relatedContent.attr({ "has-content": "true" });

                  // Đưa nội dung trả về vào .related_content_html
                  relatedContent.html(response);

                  // Ẩn spinner và hiển thị nội dung
                  $(this).find(".wep-spinner").css("visibility", "hidden");
                  $(this).find(".wep-spinner").remove();
                },
              });
            }
          }
        });
      });
    });
  }
}

// Sử dụng lớp ProductLazyLoad để khởi tạo và xử lý sự kiện
const productLazyLoad = new ProductLazyLoad();
