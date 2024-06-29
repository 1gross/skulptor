let isSwiperUpload = false;
let isPixelCompareUpload = false;

document.addEventListener('DOMContentLoaded', function () {
    observeSliders();
    observeWorks();
});

function loadSwiper() {
    if (!isSwiperUpload) {
        return Promise.all([
            loadLink("/source/libs/swiper-bundle.min.css", "stylesheet"),
            loadScript("/source/libs/swiper-bundle.min.js")
        ])
            .then(r => {
                isSwiperUpload = true;
            })
            .catch(error => {
                isSwiperUpload = false;
            });
    } else {
        return Promise.resolve();
    }
}

function loadPixelCompare() {
    if (!isPixelCompareUpload) {
        return Promise.all([
            loadLink("/source/libs/compareSlider/pixelcompare.min.css", "stylesheet"),
            loadScript("/source/libs/compareSlider/pixelcompare.min.js")
        ])
            .then(r => {
                isPixelCompareUpload = true;
            })
            .catch(error => {
                isPixelCompareUpload = false;
            });
    } else {
        return Promise.resolve();
    }
}

function observeWorks() {
    const works = document.getElementById('work-block');

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadPixelCompare().then(() => {
                    pixelCompare(document.querySelectorAll(".pixelcompare"));
                });
                demoSlider(document.querySelectorAll('.demo-slider'));
                observer.unobserve(works)
            }
        })
    }, options);
    if (works) {
        observer.observe(works);
    }

}

function observeSliders() {
    const sliders = document.getElementsByClassName('swiper');

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadSwiper().then(() => {
                    const slider = entry.target;
                    const sliderType = slider.dataset.sliderType;
                    if (typeof slider.swiper !== 'undefined' && sliderType !== 'summarys') {
                        slider.swiper.autoplay.start();
                        return false;
                    }
                    if (sliderType === 'reviews') {
                        initReviewSlider();
                    }
                    if (sliderType === 'doctors') {
                        initDoctorsSlider();
                    }
                    if (sliderType === 'mega-menu') {
                        initMegaMenuSlider();
                    }

                    if (sliderType === 'main-menu') {
                        initMainMenuSlider();
                    }
                    if (sliderType === 'big-menu') {
                        initBigMenuSlider();
                    }

                });
            } else {
                const slider = entry.target.swiper;
                const sliderType = entry.target.dataset.sliderType;
                if (typeof slider !== 'undefined' && sliderType !== 'summarys') {
                    slider.autoplay.stop();
                }
            }
        })
    }, options);
    for (let i = 0; i < sliders.length; i++) {
        observer.observe(sliders[i])
    }
}

function initMegaMenuSlider() {
    const progressBar = document.getElementById('mega-menu-progress').querySelector('.progress');
    const megaSlider = new Swiper(".mega-menu-slider", {
        init: false,
        slidesPerView: 2,
        spaceBetween: 1,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: document.getElementById('mega-menu-pagination'),
            dynamicBullets: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
        },
        timeLineStop: () => {
            progressBar.style.animationPlayState = "paused";
        },
        timeLineStart: () => {
            progressBar.style.animationPlayState = "running";
        },
        timeLineReset: function () {
            progressBar.style.animation = "none";
            void progressBar.offsetWidth;
            progressBar.style.animation = null;
            this.timeLineStart();
        },
        on: {
            autoplayPause() {
                this.passedParams.timeLineStop();
            },
            autoplayResume() {
                this.passedParams.timeLineStart();
            },

            autoplayStart() {
                this.passedParams.timeLineReset();
            },

            autoplayStop() {
                this.passedParams.timeLineStop();
            },
            slideChange() {
                this.passedParams.timeLineReset();
            }
        }
    });
    megaSlider.init();

}

function initMainMenuSlider() {
    const mainMenuSlider = new Swiper('#main-menu-slider', {
        init: false,
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 100000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: document.getElementById('main-menu-pagination'),
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '#main-menu-right',
            prevEl: '#main-menu-left',
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            767: {
                slidesPerView: 3,
            },
            1209: {
                slidesPerView: 4,
            }
        },
    });

    mainMenuSlider.init();

}

function initBigMenuSlider() {
    const bigMenuSlider = new Swiper("#big-menu-slider", {
        init: false,
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: document.getElementById('big-menu-pagination'),
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '#big-menu-right',
            prevEl: '#big-menu-left',
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            767: {
                slidesPerView: 2,
            },
            1209: {
                slidesPerView: 2,
            }
        },
    });
    bigMenuSlider.init();

}

function initDoctorsSlider() {
    const progressBar = document.getElementById('doctors-progress').querySelector('.progress');
    const doctorsSlider = new Swiper(".doctors-slider", {
        init: false,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: '#doctors-right',
            prevEl: '#doctors-left',
        },
        pagination: {
            el: document.getElementById('doctors-pagination'),
            dynamicBullets: true,
        },
        timeLineStop: () => {
            progressBar.style.animationPlayState = "paused";
        },
        timeLineStart: () => {
            progressBar.style.animationPlayState = "running";
        },
        timeLineReset: function () {
            progressBar.style.animation = "none";
            void progressBar.offsetWidth;
            progressBar.style.animation = null;
            this.timeLineStart();
        },
        on: {
            autoplayPause() {
                this.passedParams.timeLineStop();
            },
            autoplayResume() {
                this.passedParams.timeLineStart();
            },

            autoplayStart() {
                this.passedParams.timeLineReset();
            },

            autoplayStop() {
                this.passedParams.timeLineStop();
            },
            slideChange() {
                this.passedParams.timeLineReset();
            }
        }
    });
    doctorsSlider.init();

}

function initReviewSlider() {
    const progressBar = document.getElementById('reviews-progress');
    let offset = 0;
    let isLast = false;
    let isLoad = false;
    const reviewsSlider = new Swiper('.reviews-slider', {
        init: false,
        slidesPerView: 2,
        spaceBetween: 30,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: document.getElementById('current-slide'),
            type: 'custom',
            renderCustom: function (swiper, current, total) {
                let bp = null;
                if (window.innerWidth < 768) {
                    bp = 320;
                }
                const currentSlidesView = (!bp) ? swiper.passedParams.slidesPerView : swiper.passedParams.breakpoints[bp].slidesPerView;

                return current + currentSlidesView - 1;
            }
        },
        navigation: {
            nextEl: '#reviews-right',
            prevEl: '#reviews-left',
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
        },
        timeLineStop: () => {
            progressBar.style.animationPlayState = "paused";
        },
        timeLineStart: () => {
            progressBar.style.animationPlayState = "running";
        },
        timeLineReset: function () {
            progressBar.style.animation = "none";
            void progressBar.offsetWidth;
            progressBar.style.animation = null;
            this.timeLineStart();
        },
        on: {
            beforeInit: function (swiper) {
                const slides = getReviewsByDate(offset, swiper.wrapperEl.dataset.pageId).then((data) => {
                    document.getElementById('circle-counter').innerText = data.max;
                    document.getElementById('max-slide').innerText = data.max;
                    if (data.isLast) {
                        isLast = data.isLast
                    }
                    swiper.wrapperEl.classList.remove('load');
                    swiper.virtual.appendSlide(data.reviews);
                    offset = offset + 10;
                });

            },
            slideChange: function (swiper) {
                this.passedParams.timeLineReset();
                const shownSlides = swiper.activeIndex + swiper.passedParams.slidesPerView;

                if (shownSlides >= swiper.slidesGrid.length - 5 && !isLoad && swiper.slidesGrid.length !== 0) {

                    isLoad = true;
                    getReviewsByDate(offset, swiper.wrapperEl.dataset.pageId).then((data) => {
                        isLoad = false;
                        swiper.virtual.appendSlide(data.reviews);
                        offset = offset + 10;
                        if (data.isLast) {
                            isLast = data.isLast
                        }
                    });
                }
            },
            autoplayPause() {
                this.passedParams.timeLineStop();
            },
            autoplayResume() {
                this.passedParams.timeLineStart();
            },

            autoplayStart() {
                this.passedParams.timeLineReset();
            },

            autoplayStop() {
                this.passedParams.timeLineStop();
            },
        },
        virtual: {},
    });
    reviewsSlider.init();

}


function getReviewsByDate(offset, id) {

    const params = {
        url: '/wp-admin/admin-ajax.php',
        method: 'POST',
        data: {
            action: 'getReviewsByDate',
            offset: offset,
            id: id,
        }
    };

    return ajax(params).then((data) => {
        const response = JSON.parse(data);
        const slides = response.reviews;
        return Promise.resolve(response);
    });

}



