export default class ScrollToTopManager {
  constructor(buttonId) {
    // Lấy tham chiếu đến nút scroll to top dựa trên ID
    this.btnScrollTop = document.getElementById(buttonId);

    if (!this.btnScrollTop) {
      console.error(`Element with ID "${buttonId}" not found.`);
      return;
    }

    // Gắn sự kiện click và scroll
    this.btnScrollTop.addEventListener("click", this.scrollToTop.bind(this));
    window.addEventListener("scroll", this.toggleScrollTopButton.bind(this));
  }

  scrollToTop(event) {
    // Loại bỏ sự kiện mặc định (ví dụ: chặn liên kết chuyển trang)
    event.preventDefault();

    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  toggleScrollTopButton() {
    if (window.pageYOffset > 300) {
      this.btnScrollTop.classList.add("show");
    } else {
      this.btnScrollTop.classList.remove("show");
    }
  }
}

/* SCROLL TO TOP*/
new ScrollToTopManager("but_scroll_top");
