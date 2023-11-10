// Hàm kiểm tra xem một phần tử có hiển thị trong khung nhìn hay không
function isElementInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }
  
  // Hàm xử lý khi cuộn trang
  function handleScroll() {
    const aosItems = document.querySelectorAll('[no-hidden="true"]');
    aosItems.forEach((item) => {
      item.classList.add('no-hidden');
      
      if (isElementInViewport(item)) {        
        item.classList.remove('aos-animate');
        item.removeAttribute('data-aos');      
      } 
    });
  }
  
  // Gọi hàm handleScroll khi trang đã được tải và khi cuộn trang
  window.addEventListener('DOMContentLoaded', handleScroll);
  window.addEventListener('scroll', handleScroll);
  
  export { handleScroll };
  