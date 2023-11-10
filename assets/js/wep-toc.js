export default class TocItems {
    constructor(elements, tocContainer, buttonContainer, toc_button = false) {
        this.toc_items = [];
        this.stt = 0;

        // Sử dụng elements, tocContainer và buttonContainer được truyền từ bên ngoài
        this.elements = elements;
        this.tocContainer = tocContainer;
        this.buttonContainer = buttonContainer;

        if (toc_button) {
            this.createTocButton();
        }

        this.toggleTocContainer();
        this.scan();
        this.createLinks();
    }

    createTocButton() {
        const button = document.createElement('a');
        button.className = 'wep_toc_button';
        button.href = 'javascript:void(0)';
        button.innerHTML = `
            <svg fill="#000000" height="18px" width="18px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 0 487.3 487.3" xml:space="preserve">
                <g>
                    <g>
                        <path d="M487.2,69.7c0,12.9-10.5,23.4-23.4,23.4h-322c-12.9,0-23.4-10.5-23.4-23.4s10.5-23.4,23.4-23.4h322.1
                            C476.8,46.4,487.2,56.8,487.2,69.7z M463.9,162.3H141.8c-12.9,0-23.4,10.5-23.4,23.4s10.5,23.4,23.4,23.4h322.1
                            c12.9,0,23.4-10.5,23.4-23.4C487.2,172.8,476.8,162.3,463.9,162.3z M463.9,278.3H141.8c-12.9,0-23.4,10.5-23.4,23.4
                            s10.5,23.4,23.4,23.4h322.1c12.9,0,23.4-10.5,23.4-23.4C487.2,288.8,476.8,278.3,463.9,278.3z M463.9,394.3H141.8
                            c-12.9,0-23.4,10.5-23.4,23.4s10.5,23.4,23.4,23.4h322.1c12.9,0,23.4-10.5,23.4-23.4C487.2,404.8,476.8,394.3,463.9,394.3z
                            M38.9,30.8C17.4,30.8,0,48.2,0,69.7s17.4,39,38.9,39s38.9-17.5,38.9-39S60.4,30.8,38.9,30.8z M38.9,146.8
                            C17.4,146.8,0,164.2,0,185.7s17.4,38.9,38.9,38.9s38.9-17.4,38.9-38.9S60.4,146.8,38.9,146.8z M38.9,262.8
                            C17.4,262.8,0,280.2,0,301.7s17.4,38.9,38.9,38.9s38.9-17.4,38.9-38.9S60.4,262.8,38.9,262.8z M38.9,378.7
                            C17.4,378.7,0,396.1,0,417.6s17.4,38.9,38.9,38.9s38.9-17.4,38.9-38.9C77.8,396.2,60.4,378.7,38.9,378.7z"/>
                    </g>
                </g>
            </svg>
        `;

        button.addEventListener('click', () => {
            this.toggleTocContainer();
        });

        // Thêm hover style để biến con trỏ thành hình bàn tay khi di chuột qua nút
        button.style.cursor = 'pointer';

        // Thêm nút TOC vào buttonContainer nếu có, ngược lại thêm vào thẻ body
        if (this.buttonContainer) {
            this.buttonContainer.appendChild(button);
        } else {
            document.body.appendChild(button);
        }
    }

    toggleTocContainer() {
        if (this.tocContainer.style.display === 'none' || !this.tocContainer.style.display) {
            this.tocContainer.style.display = 'block';
        } else {
            this.tocContainer.style.display = 'none';
        }
    }

    scan() {
        // Sử dụng elements được truyền từ bên ngoài
        this.elements.forEach((element) => {
            let id = element.id;
            if (!id) {
                id = 'heading_' + this.stt;
                element.id = id;
                this.stt++;
            }
            this.toc_items.push({ key: id, value: element.textContent, tag: element.tagName.toLowerCase() });
        });
    }

    createLinks() {
        // Tạo và thêm các toc item vào tocContainer
        this.toc_items.forEach((item) => {
            const a = document.createElement('a');
            a.href = '#' + item.key;
            a.textContent = item.value;
            a.className = 'toc_item_' + item.tag;
            this.tocContainer.appendChild(a);
        });
    }
}


/* TOC for single Post */
const elements = document.querySelectorAll(".wep_content_html > .wep_single_content h2, .wep_content_html > .wep_single_content h3, .wep_content_html > .wep_single_content h4, .wep_content_html > .wep_single_content h5, .wep_content_html > .wep_single_content h6");
const tocContainer = document.querySelector(".widget_content.widget_content__toc");
const buttonContainer = document.querySelector(".widget_heading"); // Thay bằng selector thực tế của buttonContainer

if (tocContainer && tocContainer && elements) {
  new TocItems(elements, tocContainer, buttonContainer, true); // Sử dụng true nếu bạn muốn hiển thị nút TOC ban đầu
}

/* TOC for Tab Content */
const tab_elements = document.querySelectorAll("#productTabsContent .wep_content_html > .wep_single_content h2, #productTabsContent .wep_content_html > .wep_single_content h3, #productTabsContent .wep_content_html > .wep_single_content h4, #productTabsContent .wep_content_html > .wep_single_content h5, #productTabsContent .wep_content_html > .wep_single_content h6");
const tab_tocContainer = document.querySelector("#productTabsContent .tab-pane.active.show .widget_button__toc");
const tab_buttonContainer = document.querySelector("#productTabsContent .tab-pane.active.show .widget_content__toc"); // Thay bằng selector thực tế của buttonContainer

if (tab_tocContainer && tab_tocContainer && tab_elements) {
  new TocItems(tab_elements, tab_tocContainer, tab_tocContainer, false); // Sử dụng true nếu bạn muốn hiển thị nút TOC ban đầu
}

