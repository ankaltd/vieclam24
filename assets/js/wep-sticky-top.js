export function initStickyNavbar(initHeight = 0) {

  window.onscroll = function () {
    sticky_function();
  };



  var navbar = document.getElementById("wep_goto_section");
  if (navbar) {
    var sticky = navbar.offsetTop - initHeight;
  }



  function sticky_function() {
    if (navbar) {
      if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky");
      } else {
        navbar.classList.remove("sticky");
      }

    }

  }

}

