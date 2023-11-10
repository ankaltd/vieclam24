// Sử dụng jQuery thay vì $
jQuery(document).ready(function ($) {
  class WEP_Admin_Sticky {
    constructor() {
      this.createStickyElement();
      // this.createTodoButton();
      this.applyCss();
      this.bindEvents();
    }

    createStickyElement() {
      const svgNS = "http://www.w3.org/2000/svg";
      const svg = document.createElementNS(svgNS, "svg");
      svg.setAttribute("width", "24");
      svg.setAttribute("height", "24");
      svg.setAttribute("style", "vertical-align: inherit;");
      svg.setAttribute("aria-hidden", "true");
      svg.setAttribute("focusable", "false");
      svg.setAttribute("data-prefix", "far");
      svg.setAttribute("data-icon", "chevron-up");
      svg.setAttribute("role", "img");
      svg.setAttribute("viewBox", "0 0 448 512");
      svg.setAttribute("class", "svg-inline--fa fa-chevron-up fa-w-14 fa-2x");
      svg.style.outline = "none"; // Loại bỏ viền khi click

      const path = document.createElementNS(svgNS, "path");
      path.setAttribute("fill", "white");
      path.setAttribute(
        "d",
        "M6.101 359.293L25.9 379.092c4.686 4.686 12.284 4.686 16.971 0L224 198.393l181.13 180.698c4.686 4.686 12.284 4.686 16.971 0l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L232.485 132.908c-4.686-4.686-12.284-4.686-16.971 0L6.101 342.322c-4.687 4.687-4.687 12.285 0 16.971z"
      );

      svg.appendChild(path);

      const wepGotopDiv = $("<div/>", {
        class: "wep_gotop",
      });

      const wepGotopLink = $("<a/>", {
        href: "#",
        class: "wep_gotop__icon",
        id: "but_scroll_top",
      });

      const svgString = new XMLSerializer().serializeToString(svg);
      const svgHtml = $.parseHTML(svgString);

      $(wepGotopLink).append(svgHtml);
      $(wepGotopDiv).append(wepGotopLink);
      $("body").append(wepGotopDiv);
    }

    createTodoButton() {
      const wepAdminStickyPanel = $("<div/>", {
        id: "wep_admin_sticky_panel",
      });

      // Thêm danh sách Todo
      const wepTodoList = $("<ul/>", {
        class: "wep_todo_list",
      });

      const wepTodoItem = $("<li/>", {
        class: "wep_todo_item",
      }).append(
        $("<a/>", {
          href: "#bought_together_ws24h",
          text: "Thêm sản phẩm mua kèm",
        })
      );

      const wepTodosButton = $("<div/>", {
        class: "wep_todos_button",
      }).html(`
            <svg fill="#000000" style="cursor:pointer" height="18px" width="18px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 487.3 487.3" xml:space="preserve">
            <g>
                <g>
                    <path d="M487.2,69.7c0,12.9-10.5,23.4-23.4,23.4h-322c-12.9,0-23.4-10.5-23.4-23.4s10.5-23.4,23.4-23.4h322.1
                        C476.8,46.4,487.2,56.8,487.2,69.7z M463.9,162.3H141.8c-12.9,0-23.4,10.5-23.4,23.4s10.5,23.4,23.4,23.4h322.1
                        c12.9,0,23.4-10.5,23.4-23.4C487.2,172.8,476.8,162.3,463.9,162.3z M463.9,278.3H141.8c-12.9,0-23.4,10.5-23.4,23.4
                        s10.5,23.4,23.4,23.4h322.1c12.9,0,23.4-10.5,23.4-23.4C487.2,288.8,476.8,278.3,463.9,278.3z M463.9,394.3H141.8
                        c-12.9,0-23.4,10.5-23.4,23.4s10.5,23.4,23.4,23.4h322.1c12.9,0,23.4-10.5,23.4-23.4C487.2,404.8,476.8,394.3,463.9,394.3z
                        M38.9,30.8C17.4,30.8,0,48.2,0,69.7s17.4,39,38.9,39s38.9-17.5,38.9-39S60.4,30.8,38.9,30.8z M38.9,146.8
                        C17.4,146.8,0,164.2,0,185.7s17.4,38.9,38.9,38.9s38.9-17.4,38.9-38.9S60.4,146.8,38.9,146.8z M38.9,262.8
                        C17.4,262.8,0,280.2,0,301.7s17.4,38.9,38.9,38.9s38.9-17.4,38.9-38.9S60.4,262.8,38.9,262.8z M38.9,378.7
                        C17.4,378.7,0,396.1,0,417.6s17.4,38.9,38.9,38.9s38.9-17.4,38.9-38.9C77.8,396.2,60.4,378.7,38.9,378.7z"></path>
                </g>
            </g>
        </svg>
            `);

      $(wepAdminStickyPanel).append(wepTodosButton);
      $(wepTodoList).append(wepTodoItem);
      $(wepAdminStickyPanel).append(wepTodoList);
      $("body").append(wepAdminStickyPanel);
    }

    applyCss() {
      $(".wep_gotop").css({
        bottom: "20px",
        position: "fixed",
        right: "20px",
        background: "#e41d30",
        width: "44px",
        height: "44px",
        "border-radius": "6px",
        display: "flex",
        "justify-content": "center",
        "align-items": "center",
      });

      $(".wep_gotop__icon").css({
        outline: "none", // Loại bỏ đường viền
      });

      $("#wep_admin_sticky_panel").css({
        position: "fixed",
        bottom: "80px",
        right: "20px",
        width: "258px",
        height: "144px",
        background: "#ffffff",
        overflow: "hidden",
        border: "1px solid #c5c5c5",
        "border-radius": "6px",
        padding: "10px",
      });

      $(".wep_todos_button").css({
        "text-decoration": "none",
        border: "solid 1px #ddd",
        "border-radius": "6px",
        padding: "3px 5px",
        margin: "0 5px 0 0",
        width: "30px",
        height: "30px",
        "line-height": "30px",
        display: "flex",
        "justify-content": "center",
        "align-items": "center",
        float: "left",
      });

      $(".wep_todos").css({
        "list-style-type": "none",
        display: "none",
      });

      $(".wep_todo_list").css({
        margin: "0 10px 10px 50px",
      });
      $(".wep_todo_list a").css({
        "text-decoration": "none",
      });
    }

    bindEvents() {
      $("#but_scroll_top").on("click", function () {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
      });

      $(".wep_todos_button").on("click", function () {
        $(".wep_todos").toggle();

        const wepAdminStickyPanel = $("#wep_admin_sticky_panel");
        if (wepAdminStickyPanel.height() === 144) {
          wepAdminStickyPanel.css({ height: "40px" });
        } else {
          wepAdminStickyPanel.css({ height: "144px" });
        }

        if (wepAdminStickyPanel.width() === 258) {
          wepAdminStickyPanel.css({ width: "40px" });
        } else {
          wepAdminStickyPanel.css({ width: "258px" });
        }
      });

      // Sự kiện cuộn tới vị trí id trên màn hình
      $("a[href^='#']").on("click", function (event) {
        var target = $(this.getAttribute("href"));
        if (target.length) {
          event.preventDefault();
          $("html, body").stop().animate(
            {
              scrollTop: target.offset().top,
            },
            1000
          );
        }
      });
    }
  }

  // Sử dụng class
  const wepAdminSticky = new WEP_Admin_Sticky();
});
