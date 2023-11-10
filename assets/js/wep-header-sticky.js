/**
 * Class StickyHeader dùng để tạo hiệu ứng sticky (dính) cho header khi cuộn trang.
 */
export class StickyHeader {
  /**
   * Khởi tạo StickyHeader.
   * @param {string} selector - CSS selector của header cần áp dụng hiệu ứng sticky.
   * @param {number} threshold - Khoảng cách cuộn tối thiểu để header bắt đầu hiển thị.
   * @param {string} topActive - Vị trí top của header khi đang hiển thị.
   * @param {string} topInactive - Vị trí top của header khi không hiển thị.
   */
  constructor(
    selector = ".wep_single_service_header_sticky",
    threshold = 1000,
    topActive = "154px",
    topInactive = "50px"
  ) {
    this.selector = selector;
    this.threshold = threshold;
    this.topActive = topActive;
    this.topInactive = topInactive;
    this.headerSticky = document.querySelector(this.selector);
    this.adminBar = document.getElementById("wpadminbar");

    if (this.headerSticky) {
      window.addEventListener("scroll", this.handleScroll.bind(this));
    }
  }

  /**
   * Xử lý sự kiện cuộn trang.
   * Khi cuộn trang vượt quá ngưỡng đã định, header sẽ hiển thị với vị trí top và độ mờ được chỉ định.
   * Khi cuộn trang không đạt ngưỡng, header sẽ ẩn đi và không hiển thị.
   */
  handleScroll() {
    // Check is admin bar
    if (this.adminBar !== null) {
      this.topActive = "186px";
    }

    // Add
    if (window.scrollY >= this.threshold) {
      this.headerSticky.style.top = this.topActive;
      this.headerSticky.style.opacity = "1";
      this.headerSticky.style.display = "block";
      this.headerSticky.classList.add("active");
    } else {
      this.headerSticky.style.top = this.topInactive;
      this.headerSticky.style.opacity = "0";
      this.headerSticky.style.display = "none";
      this.headerSticky.classList.remove("active");
    }
  }
}

export default StickyHeader;

/* Khởi tạo chức năng sticky header single */
new StickyHeader(".wep_single_service_header_sticky");
