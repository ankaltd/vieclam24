// Định nghĩa class WEP_Sidebar
class WEP_Sidebar {
  constructor() {
    // Các phương thức và thuộc tính khác của lớp WEP_Sidebar
  }

  moveBlocksOnMobile() {
    if (window.innerWidth <= 768) {
      var addressBlock = document.querySelector(".wep_service__address");
      var sameCategoryBlock = document.querySelector(
        ".wep_same_category_service"
      );
      var relatedBlock = document.querySelector(".wep_service__related");
      var serviceTab = document.querySelector(".wep_service__tabs");
      var faqBlock = document.querySelector(".wep_faqs");

      // Kiểm tra xem các khối tồn tại trước khi di chuyển
      if (addressBlock && sameCategoryBlock && relatedBlock) {
        relatedBlock.insertAdjacentElement("afterend", sameCategoryBlock);
        relatedBlock.insertAdjacentElement("afterend", addressBlock);
      } else if (!relatedBlock) {
        if (!faqBlock) {
          serviceTab.insertAdjacentElement("afterend", sameCategoryBlock);
          serviceTab.insertAdjacentElement("afterend", addressBlock);
        } else {
          faqBlock.insertAdjacentElement("afterend", sameCategoryBlock);
          faqBlock.insertAdjacentElement("afterend", addressBlock);
        }
      }
    }
  }
}

// Tạo một đối tượng từ class WEP_Sidebar và gọi phương thức moveBlocksOnMobile

var addressBlock = document.querySelector(".wep_service__address");
var sameCategoryBlock = document.querySelector(".wep_same_category_service");
var relatedBlock = document.querySelector(".wep_service__related");
var serviceTab = document.querySelector(".wep_service__tabs");
var faqBlock = document.querySelector(".wep_faqs");

if (addressBlock) {
  var wepSidebar = new WEP_Sidebar();
  wepSidebar.moveBlocksOnMobile();
  window.addEventListener("load", function () {
    window.addEventListener("resize", wepSidebar.moveBlocksOnMobile);
  });
}
