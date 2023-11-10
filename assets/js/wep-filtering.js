// Trong tệp FilterLinksProcessor.js
export default class FilterLinksProcessor {
  constructor() {
    this.selectedAttributes = document.querySelectorAll(
      ".wep_filter_box__att.selected"
    );
    this.filterData = [];

    this.processFilterLinks();
  }

  processFilterLinks() {
    this.selectedAttributes.forEach((selectedAttribute) => {
      const link = selectedAttribute.querySelector("a");
      const href = link.getAttribute("href");
      const text = link.textContent;

      // Kiểm tra xem giá trị đã tồn tại trong mảng chưa
      const exists = this.filterData.some(
        (item) => item.href === href && item.text === text
      );

      // Nếu giá trị chưa tồn tại, thêm vào mảng
      if (!exists) {
        this.filterData.push({ href, text });
      }
    });

    const filteringLinksContainer = document.querySelector(
      ".wep_category_service_grid__filtering>.wep_category_service_grid__links"
    );

    this.filterData.forEach((data) => {
      const filterLink = document.createElement("a");
      filterLink.setAttribute("class", "wep-filtering-att");
      filterLink.setAttribute("href", data.href);
      filterLink.textContent = data.text;
      filteringLinksContainer.insertBefore(
        filterLink,
        filteringLinksContainer.firstChild
      );
    });
  }
}

// Tạo link filtering bar
document.addEventListener("DOMContentLoaded", () => {
  new FilterLinksProcessor();
});
