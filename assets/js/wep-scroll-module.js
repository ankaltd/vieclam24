export function setupCustomScroll(scrollContainer) {
  scrollContainer.addEventListener("mousedown", (e) => {
    const startX = e.pageX - scrollContainer.offsetLeft;
    const scrollLeft = scrollContainer.scrollLeft;

    function scrollContent(e) {
      const x = e.pageX - scrollContainer.offsetLeft;
      const walk = (x - startX) * 2; // Điều chỉnh tốc độ cuộn
      scrollContainer.scrollLeft = scrollLeft - walk;
    }

    function stopScrolling() {
      document.removeEventListener("mousemove", scrollContent);
      document.removeEventListener("mouseup", stopScrolling);
    }

    document.addEventListener("mousemove", scrollContent);
    document.addEventListener("mouseup", stopScrolling);
  });
}

/* Gọi scrolling */
const scrollContainer = document.querySelector(".scrollable_hoz");
setupCustomScroll(scrollContainer);

/* Fixed sidebar when scroll */
class setupFixedScroll {
  constructor() {
    // Các phương thức và thuộc tính khác của lớp setupCustomScroll
  }

  trackScrollPosition() {
    // Lấy phần tử thể hiện thanh cuộn
    var scrollElement = document.documentElement;

    // Lấy phần tử .wep_sidebar
    // var sidebarElement = document.querySelector(".wep_sidebar");

    var mainElement = document.querySelector(".wep_category_main");
    var sidebarElement = document.querySelector(
      ".wep_category_sidebar .wep_sidebar"
    );

    // Thêm sự kiện cuộn
    window.addEventListener("scroll", function () {
      // Lấy vị trí cuộn của trang
      var scrollPosition = scrollElement.scrollTop;

      // In ra vị trí cuộn trong console
      // console.log("Vị trí cuộn: " + scrollPosition);

      // Cập nhật các thao tác khác dựa trên vị trí cuộn tại đây
      // Thêm mã JavaScript tùy chỉnh của bạn ở đây

      if (sidebarElement) {
        // Khi vị trí đầu
        if (scrollPosition == 0) {
          sidebarElement.style.position = "static";
        }

        // Kiểm tra nếu vị trí cuộn lớn hơn 0 bắt đầu cuộn
        if (scrollPosition > 0) {
          sidebarElement.style.display = "block";
          sidebarElement.style.width =
            document.querySelector(".wep_category_sidebar").offsetWidth -
            20 +
            "px";
          sidebarElement.style.position = "fixed";
          sidebarElement.style.top = 515 - scrollPosition + "px";
        }

        // Khi đỉnh của sidebar chạm header đứng im top
        if (scrollPosition >= 300) {
          sidebarElement.style.display = "block";
          sidebarElement.style.position = "fixed";
          sidebarElement.style.top = "200px";
        }

        // Khi tới phần cuối
        if (scrollPosition >= 790) {
          if (mainElement && sidebarElement) {
            var mainHeight = mainElement.offsetHeight;
            sidebarElement.style.display = "block";
            sidebarElement.style.height =
              mainHeight - scrollPosition + 210 + "px";
          }
        }

        // Khi vị trí cuối
        if (scrollPosition >= 1475) {
          sidebarElement.style.display = "none";
        }
      }
    });
  }
}

// Sử dụng phương thức trackScrollPosition của class setupCustomScroll
var customScroll = new setupFixedScroll();
customScroll.trackScrollPosition();

/* Class tạo fixed thành phần sidebar single post */
class SidebarSticky {
  constructor() {
    this.sidebar = document.querySelector(".single_post_sidebar");
    this.widget = document.querySelector(".wep_toc_widget");
    this.body = document.querySelector("body");

    if (this.sidebar) {
      this.sidebar_left = this.sidebar.offsetLeft + 12;
    }
    this.bottom_fixed = this.body.offsetHeight - 1677;
    this.position_change = this.body.offsetHeight - 1259;

    if (this.sidebar && this.widget) {
      window.addEventListener("scroll", this.handleScroll.bind(this));
    }
  }

  handleScroll() {
    const scrollPosition = window.scrollY;
    // console.log('Tọa độ scroll ' + scrollPosition);
    // console.log('Trang cao ' + this.body.offsetHeight);
    // console.log('Trái ' + this.sidebar_left);

    if (scrollPosition < 216) {
      this.sidebar.style.position = "relative";
      this.widget.style.position = "static";
    } else if (
      scrollPosition >= 216 &&
      scrollPosition <= this.position_change
    ) {
      this.sidebar.style.position = "relative";
      this.widget.style.position = "fixed";
      this.widget.style.width = this.sidebar.offsetWidth - 20 + "px";
      this.widget.style.top = "220px";
      this.widget.style.left = this.sidebar_left + "px";
    } else if (scrollPosition > this.position_change) {
      this.sidebar.style.position = "relative";
      this.widget.style.position = "absolute";
      this.widget.style.top = "auto";
      this.widget.style.left = "0";
      this.widget.style.right = "0";
      this.widget.style.bottom = "0";
    }
  }
}

const sidebarSticky = new SidebarSticky();
