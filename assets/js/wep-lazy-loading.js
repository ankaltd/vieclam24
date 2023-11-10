class WEPLazy {
    constructor() {
        document.addEventListener('DOMContentLoaded', () => {
            var images = document.querySelectorAll('img:not([loading="lazy"])');

            images.forEach(function(img) {
                var imgPosition = img.offsetTop;
                var windowHeight = window.innerHeight;

                window.addEventListener('scroll', function() {
                    var windowPosition = window.pageYOffset || document.documentElement.scrollTop;
                    if (windowPosition > (imgPosition - windowHeight)) {
                        if (img.hasAttribute('data-src')) {
                            img.setAttribute('src', img.getAttribute('data-src'));
                            img.setAttribute('loading', 'lazy');
                        }
                    }
                });
            });
        });
    }
}

const lazy = new WEPLazy();
