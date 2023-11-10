export function initSplides() {
  // Code Slider ==============================
  const wep_select_device = document.getElementById("wep_select_device");
  const wep_accessory = document.getElementById("wep_accessory");
  var splideElements = document.querySelectorAll(".splide");
  var wep_gallery = document.getElementById("thumbnail-carousel");
  var wep_realphoto = document.getElementById("wep_service__real_photos");
  var wep_related = document.getElementById("single_related_products");

  // /* Home Banner */
  if (splideElements.length > 0) {
    new Splide(".splide", {
      pagination: false,
      lazyLoad: 'nearby'
    }).mount();
  }

  /* Select Device */
  if (wep_select_device) {
    new Splide("#wep_select_device", {
      type: "slide",
      autoHeight: true,
      pagination: false,
      start: 0,
      padding: 10,
      arrows: false,
      perPage: 6,
      breakpoints: {
        768: {
          trimSpace: true,
          autoHeight: true,
          perPage: 3,
        },
      },
    }).mount();
  }

  /* Service by Device wep_service_by_device */
  var slider = document.getElementsByClassName("wep_service_by_device__slider");
  if (slider) {
    for (var i = 0; i < slider.length; i++) {
      new Splide(slider[i], {
        type: "slide",
        autoHeight: true,
        pagination: false,
        lazyLoad: 'nearby',
        start: 0,
        padding: 0,
        perPage: 4,
        breakpoints: {
          768: {
            autoHeight: true,
            perPage: 2,
          },
        },
      }).mount();
    }
  }
  
  /* Service by Device wep_service_by_device 12 cols*/
  var slider12 = document.getElementsByClassName("wep_service_by_device__slider--col12");
  if (slider12) {
    for (var i = 0; i < slider12.length; i++) {
      new Splide(slider12[i], {
        type: "slide",
        autoHeight: true,
        pagination: false,
        lazyLoad: 'nearby',
        start: 0,
        padding: 0,
        perPage: 5,
        breakpoints: {
          768: {
            autoHeight: true,
            perPage: 2,
          },
        },
      }).mount();
    }
  }

  // Keywords
  var keyword = document.getElementsByClassName(
    "wep_service_by_device__keywords"
  );

  if (keyword) {
    for (var i = 0; i < keyword.length; i++) {
      new Splide(keyword[i], {
        type: "slide",
        autoHeight: true,
        autoWidth: true,
        pagination: false,
        arrows: false,
        start: 0,
        padding: 0,
        perPage: 5,
        breakpoints: {
          768: {
            padding: 0,
            autoHeight: true,
            autoWidth: true,
            perPage: 2,
          },
        },
      }).mount();
    }
  }

  /* Accessory */
  if (wep_accessory) {
    new Splide("#wep_accessory", {
      type: "slide",
      autoHeight: true,
      pagination: false,
      lazyLoad: 'nearby',
      start: 0,
      padding: { top: 0, right: 10, bottom: 0, left: 10 },
      perPage: 4,
      breakpoints: {
        768: {
          padding: { top: 0, right: 10, bottom: 0, left: 10 },
          autoHeight: true,
          perPage: 2,
        },
      },
    }).mount();
  }

  /* Service Single Gallery */
  document.addEventListener("DOMContentLoaded", function () {
    if (wep_gallery) {
      var main = new Splide("#main-carousel", {
        type: "fade",
        rewind: true,
        pagination: false,
        lazyLoad: 'nearby',
        arrows: false,
      });

      var thumbnails = new Splide("#thumbnail-carousel", {
        fixedWidth: 80,
        fixedHeight: 80,
        gap: 10,
        rewind: true,
        pagination: false,
        lazyLoad: 'nearby',
        arrows: false,
        isNavigation: true,
        breakpoints: {
          600: {
            fixedWidth: 60,
            fixedHeight: 60,
          },
        },
      });

      main.sync(thumbnails);
      main.mount();
      thumbnails.mount();
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    if (wep_realphoto) {
      new Splide("#wep_service__real_photos", {
        type: "slide",
        autoHeight: true,
        pagination: false,
        lazyLoad: 'nearby',
        start: 0,
        padding: 0,
        arrows: false,
        perPage: 5,
        fixedWidth: 200,
        fixedHeight: 200,
        breakpoints: {
          768: {
            padding: 0,
            fixedWidth: 60,
            fixedHeight: 60,
            perPage: 2,
          },
        },
      }).mount();
    }
  });
}
