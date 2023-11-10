/**
 * Class ColorModule dùng để quản lý các mục màu và cập nhật giá bán.
 */
export default class ColorModule {
  /**
   * Khởi tạo ColorModule.
   */
  constructor() {
    this.colorItems = document.querySelectorAll(".wep_service__attributes--color_item");
    this.salePriceElement = document.querySelector(".wep_service__meta .wep_service__meta_pricing>.sale_price");

    this.setupColorItems();
  }

  // Bổ sung phương thức mới để xử lý sự kiện click
  handleThumbnailClick(target) {
    const thumbnailSlides = document.querySelectorAll("#thumbnail-carousel-list > .splide__slide > img");


    thumbnailSlides.forEach((thumbnail) => {
      if (thumbnail.getAttribute("src") === target) {
        thumbnail.click(); // Kích hoạt sự kiện click
      }
    });
  }

  /**
   * Thiết lập sự kiện click cho các mục màu.
   * Khi một mục màu được click, nó sẽ trở thành mục được chọn và giá bán sẽ được cập nhật.
   */
  setupColorItems() {
    this.colorItems.forEach((colorItem) => {
      colorItem.addEventListener("click", (event) => {
        event.preventDefault();
        this.colorItems.forEach((item) => {
          item.classList.remove("selected");
        });
        colorItem.classList.add("selected");

        const price = colorItem.querySelector(".wep_service__attributes--color_item_price").textContent;
        this.updateSalePrice(price);

        // Lấy nguồn của hình ảnh bên trong colorItem
        const img = colorItem.querySelector(".wep_service__attributes--color_item_thumbnail img");
        if (img) {

          const target = img.getAttribute("src");

          console.log(target);

          // Gọi phương thức để xử lý click trên carousel
          this.handleThumbnailClick(target);
        }
      });
    });
  }

  /**
   * Cập nhật giá bán.
   * @param {string} price - Giá mới cần cập nhật.
   */
  updateSalePrice(price) {
    this.salePriceElement.textContent = price;
  }
}

// Gọi hàm để thực hiện việc kiểm tra và thêm class "selected"
const colorModule = new ColorModule();