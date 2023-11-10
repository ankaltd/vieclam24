/* 

    Đảm bảo rằng bạn đã thêm lớp "fadeIn" vào các thành phần mà bạn muốn áp dụng hiệu ứng xuất hiện. 

    Sau đó, khi cuộn trang, các thành phần này sẽ xuất hiện dần dần khi chúng được cuộn tới.

*/



function fadeInElements() {

  var elements = document.getElementsByClassName("fadeIn");

  for (var i = 0; i < elements.length; i++) {

    var element = elements[i];

    var position = element.getBoundingClientRect().top;

    var windowHeight = window.innerHeight;



    if (position < windowHeight) {

      element.classList.add("visible");

    }

  }

}



function fadeOutElements() {

  var elements = document.getElementsByClassName("fadeOut");

  for (var i = 0; i < elements.length; i++) {

    var element = elements[i];

    var position = element.getBoundingClientRect().top;

    var windowHeight = window.innerHeight;



    if (position > windowHeight) {

      element.classList.add("hidden");

    } else {

      element.classList.remove("hidden");

    }

  }

}



function sideUpElements() {

    var elements = document.getElementsByClassName("sideUp");

    for (var i = 0; i < elements.length; i++) {

      var element = elements[i];

      var position = element.getBoundingClientRect().top;

      var windowHeight = window.innerHeight;

  

      if (position < windowHeight) {

        element.classList.add("visible");

      }

    }

  }

  

  function sideDownElements() {

    var elements = document.getElementsByClassName("sideDown");

    for (var i = 0; i < elements.length; i++) {

      var element = elements[i];

      var position = element.getBoundingClientRect().top;

      var windowHeight = window.innerHeight;

  

      if (position > windowHeight) {

        element.classList.add("hidden");

      } else {

        element.classList.remove("hidden");

      }

    }

  }



function handleScroll() {

  fadeInElements();

  fadeOutElements();

  sideUpElements();

  sideDownElements();

}



window.addEventListener("scroll", handleScroll);

window.addEventListener("load", handleScroll);

