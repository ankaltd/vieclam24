import { WEPHelper } from "./js/wep-helper.js";
import { initSplides } from "./js/wep-setup-splides.js";
import "./js/wep-menu.js";
import "./js/wep-mega-menu.js";
import "./js/wep-scroll-module.js";
import "./js/wep-filter-box.js";
import "./js/wep-header-sticky.js";
import "./js/wep-attribute.js";
import "./js/wep-gototop.js";
import "./js/wep-modal-image.js";
import "./js/wep-filtering.js";
import "./js/wep-toc.js";
import "./js/wep-jquery.js";
import "./js/wep-comments.js";
import "./js/wep-sidebar.js";
// import "./js/wep-lazy-loading.js";

// Sử dụng lớp WEPHelper để xử lý sự kiện cho nút mở rộng/thu nhỏ
const expandButton = document.querySelector(".wep_description__showmore .wep_button--expand");
if (expandButton) {
  WEPHelper.handleExpandButtonClick(expandButton);
}

/* Gọi setup all Splides */
initSplides();
