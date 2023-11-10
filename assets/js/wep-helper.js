export class WEPHelper {
  /**
   * Kiểm tra xem thiết bị hiện tại có phải là mobile hay không.
   * Sử dụng: WEPHelper.isMobileDevice();
   * Trả về: true nếu là mobile, false nếu không.
   */
  static isMobileDevice() {
    const screenWidth = window.innerWidth;
    const mobileWidthThreshold = 768;
    return screenWidth < mobileWidthThreshold;
  }

  /**
   * Kiểm tra xem thiết bị hiện tại có phải là mobile hay không dựa vào user agent.
   * Sử dụng: WEPHelper.isMobile();
   * Trả về: true nếu là mobile, false nếu không.
   */
  static isMobile() {
    const userAgent = navigator.userAgent.toLowerCase();
    const mobileKeywords = [
      "mobile",
      "android",
      "iphone",
      "ipad",
      "windows phone",
    ];
    return mobileKeywords.some((keyword) => userAgent.includes(keyword));
  }

  /**
   * Cuộn đến một phần tử trên trang.
   * Sử dụng: WEPHelper.scrollToSection(event);
   * Trong đó, event là một đối tượng Event.
   */
  static scrollToSection(event) {
    event.preventDefault();
    const target = event.target.getAttribute("href");
    if (target !== null) {
      const targetElement = document.querySelector(target);
      const targetOffset = targetElement.offsetTop - 100;
      window.scrollTo({
        top: targetOffset,
        behavior: "smooth",
      });
    }
  }

  /**
   * Đọc nội dung từ một file JSON và trả về một mảng.
   * Sử dụng: WEPHelper.readJsonFromFile('/path/to/your/file.json');
   * Trong đó, '/path/to/your/file.json' là đường dẫn đến file JSON của bạn.
   * Trả về: Một Promise giải quyết với một mảng chứa dữ liệu từ file JSON.
   */
  static readJsonFromFile(filePath) {
    return fetch(filePath)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        return data;
      })
      .catch((error) => console.error("Error:", error));
  }

  /**
   * Đặt chiều cao bằng nhau cho tất cả các phần tử được chọn.
   * Sử dụng: WEPHelper.setEqualHeight(selector, content);
   * Trong đó, selector là một chuỗi CSS selector để chọn các phần tử,
   * và content là một chuỗi CSS selector để chọn nội dung bên trong các phần tử.
   */
  static setEqualHeight(selector, content) {
    const elements = document.querySelectorAll(selector);
    const contents = document.querySelectorAll(content);
    let maxHeight = 0;

    elements.forEach((element) => {
      const elementHeight = element.offsetHeight;
      if (elementHeight > maxHeight) {
        maxHeight = elementHeight;
      }
    });

    elements.forEach((element) => {
      element.style.height = `${maxHeight}px`;
    });

    contents.forEach((element) => {
      element.style.height = `${maxHeight - 2}px`;
    });
  }

  /**
   * Xử lý sự kiện khi người dùng click vào nút mở rộng/thu nhỏ.
   * Sử dụng: WEPHelper.handleExpandButtonClick(button);
   * Trong đó, button là phần tử nút cần xử lý.
   */
  static handleExpandButtonClick(button) {

    button.addEventListener("click", () => {

      const isExpanded = button.getAttribute("aria-expanded") === "true";
      button.setAttribute("aria-expanded", !isExpanded);

      // Tìm thẻ span có class .wep_button__text bên trong button
      const buttonText = button.querySelector(".wep_button__text");

      // Đảm bảo tồn tại thẻ span và có nội dung để thay đổi
      if (buttonText) {
        buttonText.textContent = `${isExpanded ? "Thu gọn" : "Xem thêm"}`;
      }

      const buttonIcon = button.querySelector(".icon");
      if (buttonIcon) {
        // Quay biểu tượng 180 độ khi mở ra và 0 độ khi thu lại
        buttonIcon.style.transform = isExpanded
          ? "rotate(180deg)"
          : "rotate(0deg)";
      }
    });
  }

  // Phương thức kiểm tra xem một phần tử có trong khung nhìn không
  static isElementInViewport(el) {
    let elementTop = el.offsetTop;
    let elementBottom = elementTop + el.offsetHeight;
    let viewportTop = window.pageYOffset;
    let viewportBottom = viewportTop + window.innerHeight;

    return elementBottom > viewportTop && elementTop < viewportBottom;
  }

  // Phương thức ghi log và đánh dấu khi một thành phần xuất hiện trong khung nhìn
  static logWhenComponentAppears(componentClass) {
    let hasShown = false;

    window.addEventListener("scroll", function () {
      document.querySelectorAll(componentClass).forEach(function (element) {
        if (WEPHelper.isElementInViewport(element) && !hasShown) {
          console.log("Tên của khối: " + element.className);
          element.classList.add("has-shown");
          hasShown = true;
        }
      });
    });
  }

  // Phương thức static để hiển thị một thành phần dần dần khi cuộn chuột tới vị trí nó
  static fadeInElementOnScroll(componentName) {
    let hasShown = false;
    let component = document.querySelector(componentName);

    let childElements = component.querySelectorAll("*");

    // Ẩn các thành phần con
    childElements.forEach(function (element) {
      element.style.opacity = 0;
      element.style.transition = "opacity 2s";
    });

    // Đặt thuộc tính 'has-shown' ban đầu
    component.setAttribute("has-shown", "false");

    // Xử lý sự kiện scroll
    window.addEventListener("scroll", function () {
      if (WEPHelper.isElementInViewport(component) && !hasShown) {
        let childElements = component.querySelectorAll("*");

        childElements.forEach(function (element) {
          fadeIn(element);
        });

        hasShown = true;
      }
    });

    // Hiệu ứng hiển thị dần dần
    function fadeIn(element) {
      // element.style.display = "block";
      let op = 0.5; // Độ mờ ban đầu
      let timer = setInterval(function () {
        if (op >= 1) {
          clearInterval(timer);
          let childOp = 1;
          let childTimer = setInterval(function () {
            if (childOp >= 1) {
              clearInterval(childTimer);
            }
            // Hiển thị các thành phần con dần dần
            childElements.forEach(function (child) {
              child.style.opacity = childOp;
            });
            childOp += childOp * 5;
          }, 2);
        }
        // Đặt thuộc tính khi hiển thị xong
        element.style.opacity = op;
        element.setAttribute("has-shown", "true");
        op += op * 5;
      }, 2);
    }
  }
}
