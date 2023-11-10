class WEP_Mega_Menu {

    constructor() {
        // this.initEventListeners();
        this.handleDropdownLinks();
        this.is_expand = false;
        this.hideExtraItems();

    }

    hideExtraItems() {
        const dropdownItems = document.querySelectorAll('.dropdown-mega.level_3>li');
        if (!this.is_expand && dropdownItems.length > 3) { 
            for (let i = 3; i < dropdownItems.length; i++) {
                dropdownItems[i].style.display = 'none';
            }


            const readMoreItem = document.createElement('a');
            readMoreItem.textContent = 'Xem thêm';
            readMoreItem.classList.add('wep_readmore_child_menu');
            readMoreItem.addEventListener('click', () => {
                this.toggleItems(dropdownItems);

            });

            dropdownItems[2].parentNode.appendChild(readMoreItem);
            this.is_expand = true;
        }
    }

    initEventListeners() {
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('wep_readmore_child_menu')) {
                this.toggleItems(document.querySelectorAll('.dropdown-mega.level_3>li'));
            }
        });
    }

    toggleItems(items) {
        const readMoreItem = document.querySelector('.wep_readmore_child_menu');
               
        for (let i = 3; i < items.length; i++) {
            if (items[i].style.display === 'none') {
                items[i].style.display = 'block';
            } else {
                items[i].style.display = 'none';
            }
        }
    
        if (readMoreItem.textContent === 'Xem thêm') {
            readMoreItem.textContent = 'Thu gọn';
        } else {
            readMoreItem.textContent = 'Xem thêm';
        }
    
        this.is_expand = false;
        setTimeout(() => {
            this.is_expand = true;
        }, 1000); // Đặt thời gian cho phép toggle sau 1 giây
    }
    

    handleDropdownLinks() {
        const dropdownLinks = document.querySelectorAll('.dropdown-mega.level_2>li>a');
        dropdownLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const href = link.getAttribute('href');
                window.location.href = href;                
            });
        });
    }
}

// Sử dụng lớp WEP_Mega_Menu
const megaMenu = new WEP_Mega_Menu();
