/**
 * Lớp WepAjaxHandler quản lý xử lý AJAX.
 */
class WepAjaxHandler {
  constructor($) {
    // Khởi tạo các sự kiện lắng nghe khi tạo một đối tượng WepAjaxHandler mới.
    this.setupEventListeners($);
  }

  setupEventListeners($) {
    // Khi người dùng nhấp vào liên kết logo Client
    $(".logo-content-link").on("click", (e) => {
      e.preventDefault();

      const contentId = $(e.currentTarget).data("content-id");
      const ajaxNonce = wepAjax.ajaxNonce; // Lấy nonce từ biến đã truyền từ PHP

      // Hiển thị biểu tượng spinner
      $(".loading-spinner").addClass("ajax-loading");

      // Gửi AJAX request
      $.ajax({
        url: wepAjax.ajaxUrl,
        type: "POST",
        data: {
          action: "get_client_detail", // Sử dụng action mới cho get_client_detail
          contentId: contentId,
          nonce: ajaxNonce, // Truyền nonce vào yêu cầu AJAX
        },
        success: (response) => {
          const clientData = JSON.parse(response);

          // Điền dữ liệu vào các thành phần trong popup
          $("#staticBackdropLabel").text(clientData.title);
          $(".client_logo").attr("src", clientData.thumbnail);
          $(".client_logo").attr("alt", clientData.title);
          $(".client_website").attr("href", clientData.client_goto_link);
          $(".client_website_url").text(clientData.client_goto_link);
          $(".client_detail").html(clientData.client_service_detail);

          // Hiển thị nội dung popup và ẩn biểu tượng spinner
          $(".loading-spinner").removeClass("ajax-loading");
          $(".popup-content").show();

          // Hiển thị popup khi nội dung đã được gán và thực hiện hiệu ứng fadeIn
          $("#staticBackdrop").modal("show");
        },
      });
    });

    // Ẩn popup khi nhấn ra ngoài nội dung hoặc nhấn phím Esc
    $(document).on("keydown", (event) => {
      if (event.key === "Escape") {
        $("#staticBackdrop").modal("hide");
      }
    });

    // Ẩn popup khi click bên ngoài nội dung
    $(document).on("click", (event) => {
      if ($(event.target).hasClass("modal")) {
        $("#staticBackdrop").modal("hide");
      }
    });

    // Tải thêm dữ liệu khi nhấn nút Load More
    let currentPage = 1;
    $("#load-more").on("click", (e) => {
      e.preventDefault();
      e.stopPropagation();

      currentPage++; // Do currentPage + 1, because we want to load the next page
      const listCategories = $("#wep_news_categories").val().split(",");
      const ajaxNonce = wepAjax.ajaxNonce; // Lấy nonce từ biến đã truyền từ PHP

      $.ajax({
        type: "POST",
        url: wepAjax.ajaxUrl,
        dataType: "json", // <-- Change dataType from 'html' to 'json'
        data: {
          action: "wep_news_load_more",
          paged: currentPage,
          category_ids: listCategories,
          nonce: ajaxNonce, // Truyền nonce vào yêu cầu AJAX
        },
        success: (res) => {
          paged = currentPage;
          if (paged >= res.max) {
            $("#load-more").hide();
          }

          $(".publication-list").append(res.html);
        },
      });

      return false;
    });
  }
}

// Sử dụng class WepAjaxHandler để khởi tạo và xử lý sự kiện
jQuery(document).ready(($) => {
  const wepAjaxHandler = new WepAjaxHandler($); // Truyền jQuery vào constructor
});
