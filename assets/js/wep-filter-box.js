/**
 * Lớp FilterBox thực hiện việc quản lý hộp lọc và tương tác với nó.
 */
export class FilterBox {
  /**
   * Constructor của lớp FilterBox.
   * @param {HTMLElement} container - Phần tử chứa hộp lọc.
   */
  constructor(container) {
    this.container = container;
    this.title = this.container.querySelector(".wep_filter_box__title");
    this.attributes = this.container.querySelector(
      ".wep_filter_box__attributes"
    );
    this.expandButton = this.container.querySelector(".wep_button--expand");
    this.expandButtonIcon = this.container.querySelector(
      ".wep_button--expand .icon"
    );
    this.expandButtonText = this.container.querySelector(
      ".wep_filter_box__showmore_text"
    );
    this.attributeList = this.container.querySelectorAll(
      ".wep_filter_box__attributes"
    );

    this.searchInput = this.container.querySelector(".wep_filter_box__search");
    this.searchClear = this.container.querySelector(
      ".wep_filter_box__search-icon"
    );

    // Bắt sự kiện khi người dùng nhập dữ liệu vào ô tìm kiếm
    if (this.searchInput) {
      this.searchInput.addEventListener("input", () => this.handleSearch());
    }

    // Bắt sự kiện khi người dùng nhấp vào biểu tượng xóa
    if (this.searchClear) {
      this.searchClear.addEventListener("click", () => this.clearSearch());
    }

    // Bắt sự kiện khi nhấn phím Esc để xóa nội dung tìm kiếm
    if (this.searchInput) {
      this.searchInput.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
          this.clearSearch();
        }
      });
    }

    // Bắt sự kiện khi tiêu đề được nhấp để mở/rút gọn hộp lọc
    if (this.title) {
      this.title.addEventListener("click", () => this.toggleTitle());
    }

    if (this.expandButton) {
      // Bắt sự kiện khi nút mở rộng được nhấp để mở rộng/thu gọn hộp lọc
      this.expandButton.addEventListener("click", () => this.toggleExpand());
    }

    // Đếm số lượng mục .wep_filter_box__att và ẩn nút mở rộng nếu ít hơn hoặc bằng 3
    var itemCount = this.countAttItems();
    if (itemCount) {
      if (itemCount <= 5) {
        if (this.expandButton) {
          this.expandButton.style.display = "none";
        }
        this.attributes.style.height = "auto";
      } else {
        if (this.expandButton) {
          this.expandButton.style.display = "block";
        }
      }
    }

    // Chỉnh độ cao
    this.adjustHeight();
  }

  // Chỉnh độ cao của Filter để scrolls
  adjustHeight() {
    document.addEventListener("DOMContentLoaded", function () {
      var mainElement = document.querySelector(".wep_category_main");
      var sidebarElement = document.querySelector(".wep_category_sidebar .wep_sidebar");

      if (mainElement && sidebarElement) {
        var mainHeight = mainElement.offsetHeight;
        sidebarElement.style.height = (mainHeight - 90) + "px";
      }
    });
  }

  // Phương thức để xóa nội dung tìm kiếm
  clearSearch() {
    if (this.searchInput) {
      this.searchInput.value = ""; // Xóa nội dung ô tìm kiếm
      this.handleSearch(); // Hiển thị lại tất cả thành phần
    }
  }

  // Phương thức để xử lý tìm kiếm
  handleSearch() {
    const searchTerm = this.searchInput.value.toLowerCase();

    if (this.attributeList) {
      this.attributeList.forEach((attribute) => {
        const attItems = attribute.querySelectorAll(".wep_filter_box__att");
        let countItem = 0;

        attItems.forEach((attItem) => {
          const link = attItem.querySelector(".wep_filter_box__link");
          const itemText = link.textContent.toLowerCase();

          // Kiểm tra nếu văn bản chứa từ khóa tìm kiếm
          if (itemText.includes(searchTerm)) {
            countItem++;
            attItem.style.display = "block";
            if (this.attributes) {
              this.attributes.style.height = "auto";
            }
          } else {
            attItem.style.display = "none";
          }
        });

        // Button
        if (countItem > 5) {
          if (this.expandButton) {
            this.expandButton.style.display = "block";
          }
        } else {
          if (this.expandButton) {
            this.expandButton.style.display = "none";
          }
        }
      });
    }
  }

  /**
   * Phương thức để đếm số lượng mục .wep_filter_box__att trong hộp lọc.
   * @returns {number} - Số lượng mục .wep_filter_box__att.
   */
  countAttItems() {
    var itemCount = 0;

    // Duyệt qua danh sách .wep_filter_box__attributes
    this.attributeList.forEach(function (attribute) {
      // Sử dụng querySelectorAll bên trong mỗi .wep_filter_box__attributes để lấy .wep_filter_box__att
      var attItems = attribute.querySelectorAll(".wep_filter_box__att");

      // Cộng số lượng phần tử .wep_filter_box__att vào biến itemCount
      itemCount += attItems.length;
    });

    return itemCount;
  }

  /**
   * Phương thức để mở/rút gọn tiêu đề hộp lọc.
   */
  toggleTitle() {
    var itemCount = this.countAttItems();
    if (itemCount) {
      if (
        this.attributes.style.height === "182px" ||
        this.attributes.style.height === ""
      ) {
        this.attributes.style.height = "0";
        if (this.expandButton) {
          this.expandButtonText.textContent = "Mở rộng";
        }
      } else {
        if (itemCount <= 5) {
          this.attributes.style.height = "auto";
        } else {
          this.attributes.style.height = "182px";
        }

        if (this.expandButton) {
          this.expandButtonText.textContent = "Thu lại";
        }
      }
    }
  }

  /**
   * Phương thức để mở rộng/thu gọn hộp lọc.
   */
  toggleExpand() {
    var itemCount = this.countAttItems();
    if (itemCount) {
      if (this.attributes.offsetHeight == 182) {
        this.attributes.style.height = "auto";
        this.expandButtonText.textContent = "Thu gọn";
        this.expandButtonIcon.style.transform = "rotate(180deg)";
      } else {
        if (itemCount <= 5) {
          this.attributes.style.height = "auto";
        } else {
          this.attributes.style.height = "182px";
        }
        this.expandButtonText.textContent = "Xem thêm";
        this.expandButtonIcon.style.transform = "rotate(0deg)";
      }
    }
  }
}

// Lấy tất cả các phần tử FilterBox có cùng class
const filterBoxElements = document.querySelectorAll(".wep_filter_box");

// Tạo một FilterBox cho mỗi phần tử
if (filterBoxElements) {
  filterBoxElements.forEach((element) => {
    new FilterBox(element);
  });
}
