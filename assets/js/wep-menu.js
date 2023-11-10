/**
 * Class chứa các phương thức để thiết lập menu có thể thu gọn.
 */
export class CollapsibleMenu {
  /**
   * Thiết lập các nút để hiển thị và ẩn các panel thu gọn.
   * Sử dụng: CollapsibleMenu.setupMenus();
   */
  static setupMenus() {
    const buttons = document.querySelectorAll(".collapse-button");
    buttons.forEach((button) => {
      button.addEventListener("click", (event) => {
        if (window.innerWidth <= 768) {
          // Chỉ ngăn chặn chuyển hướng trên thiết bị di động
          event.preventDefault(); // Ngăn chặn chuyển hướng mặc định

          // Loại bỏ class active từ tất cả các .collapse-button
          buttons.forEach((btn) => {
            btn.classList.remove("expanded");
          });

          // Thêm class active cho .collapse-button được click
          button.classList.add("expanded");
        }

        // Ẩn tất cả các .collapse-panel
        const panels = document.querySelectorAll(".collapse-panel");
        panels.forEach((panel) => {
          panel.style.display = "none";
        });

        // Tìm .collapse-panel kế tiếp và thêm lớp .active để hiển thị
        const nextPanel = button.nextElementSibling;
        if (nextPanel && nextPanel.classList.contains("collapse-panel")) {
          nextPanel.style.display = "block";
        }
      });
    });
  }
}

// Gọi chức năng setupCollapsibleMenus để thiết lập menu trong wep.js
CollapsibleMenu.setupMenus();