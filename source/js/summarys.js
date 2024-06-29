let summarySlider;
document.addEventListener('DOMContentLoaded', function () {
    if (document.body.classList.contains('with-summarys')){
        loadSwiper().then(() => {
            summarySlider = new Swiper(".summarys-slider", {
                slidesPerView: 'auto',
                spaceBetween: 100,
                freeMode: true,
                grabCursor: true,
                breakpoints: {
                    320: {
                        spaceBetween: 10,
                    },
                    768: {
                        spaceBetween: 50,
                    },
                    1210: {
                        spaceBetween: 100,
                    },
                },
                on: {
                    beforeInit: function (swiper) {
                        swiper.el.classList.remove('loading');
                    },
                },
            });
            observeAnchors();
        });
    }


});

function observeAnchors() {
    const anchors = document.getElementsByClassName('anchor');
    const offsetObserver = -window.innerHeight + document.getElementsByClassName('anchor')[0].offsetHeight  + 'px';

    const options = {
        root: null,
        rootMargin: `0px 0px ${offsetObserver}`,
        threshold: 0.75
    };
    let index;
    let lastScrollPosition = window.scrollY;

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadSwiper().then(() => {
                    index = summarySlider.slides.findIndex(slide => slide.id === 'slide-' + entry.target.id);
                    if (index >= 0) {
                        summarySlider.slides.forEach((slide) => {
                            if (slide.classList.contains('active')) {
                                slide.classList.remove('active');
                            }
                        });
                        summarySlider.slides[index].classList.add('active');
                        summarySlider.slideTo(index, 1000);
                    }

                });
            } else {
                const currentScrollPosition = window.scrollY;

                if (currentScrollPosition < lastScrollPosition && index === 0) {
                    summarySlider.slides[0].classList.remove('active');
                }

                lastScrollPosition = currentScrollPosition;
            }
        })
    }, options);

    for (let i = 0; i < anchors.length; i++) {
        observer.observe(anchors[i])
    }
}