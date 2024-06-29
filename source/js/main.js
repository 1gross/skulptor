document.addEventListener("DOMContentLoaded", function (event, $) {

    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);

    const megaMenu = document.getElementById('mega-menu');
    if (megaMenu && window.innerWidth > 1210) {

        const startPos = 169;
        const endPos = 1920 + startPos;

        const defaultPos = 100 / 3 * 2;
        const finishPos = 0;

        let currScroll = 0;
        let ticking = false;

        let isEnd = false;
        let isStart = false;

        function update() {
            ticking = false;

            const scaledValue = (currScroll - startPos) / (endPos - startPos);

            let mappedValue = scaledValue * (finishPos - defaultPos) + defaultPos;

            if (mappedValue < finishPos) {
                mappedValue = finishPos;
            }
            if (mappedValue > defaultPos) {
                mappedValue = defaultPos;
            }

            megaMenu.style.transform = 'translateX(' + mappedValue + '%)';
        }


        function onScroll() {
            currScroll = window.scrollY;

            if (currScroll >= startPos && currScroll <= endPos) {
                isEnd = false;
                isStart = false;
                requestTick();
            }
            if (currScroll > endPos && !isEnd) {
                isEnd = true;
                requestTick();
            }
            if (currScroll < startPos && !isStart) {
                isStart = true;
                requestTick();
            }
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(update);
            }
            ticking = true;
        }

        window.addEventListener('scroll', onScroll, false);

        onScroll();
    }

    observeImage();
    observeMap();

    let phone = document.querySelectorAll(".form-control.phone");

    Inputmask({'mask': '+7 (999) 999-9999', "clearIncomplete": true, placeholder: '_'}).mask(phone);

    const menuBtns = document.getElementsByClassName('menu-toggle');

    for (const menuBtn of menuBtns) {
        menuBtn.addEventListener('click', toggleMenu);
    }

    if (document.querySelectorAll('.block-accordion')) {
        let accordion = document.querySelectorAll('.block-accordion');
        for (let i = 0; i < accordion.length; i++) {
            [...accordion[i].querySelectorAll('.accordion-title')].map(el => {
                el.addEventListener('click', event => {
                    event.target.parentElement.classList.toggle('open');
                });
            });
        }
    }
    if (document.querySelectorAll('.block-tabs')) {
        let tabs = document.querySelectorAll('.block-tabs');

        for (let i = 0; i < tabs.length; i++) {
            [...tabs[i].querySelectorAll('.tab-item')].map((tab, index) => {
                tab.addEventListener('click', event => {
                    if (!event.target.classList.contains('active')) {

                        [...tabs[i].querySelectorAll('.tab-item.active')].map(tab => tab.classList.remove('active'));
                        event.target.classList.add('active');

                        [...tabs[i].querySelectorAll('.tabs-body .tab-body.active')].map(tabBody => tabBody.classList.remove('active'));
                        tabs[i].querySelectorAll('.tabs-body .tab-body')[index].classList.add('active');
                    }
                });
            });
        }
    }
    if (document.querySelectorAll('.block-table')) {
        const tables = document.querySelectorAll('.block-table');
        for (const table of tables) {
            if (table.querySelectorAll('tbody tr').length > 7) {
                table.classList.add('spoilered-table');
                table.nextSibling.classList.remove('hide');
                table.nextSibling.addEventListener('click', function () {
                    table.classList.toggle('open');
                });
            }
        }
    }
    let forms = document.querySelectorAll('.send-email');
    forms.forEach((form) => {
        form.addEventListener('submit', validateform);
    });

    const priceToggle = document.getElementsByClassName('price-toggle');
    for (let i = 0; i < priceToggle.length; i++) {
        priceToggle[i].addEventListener('click', (e) => {
            const btn = e.currentTarget;
            let content = btn.nextElementSibling;
            if (!btn.classList.contains('active')) {
                content.classList.add("active");
                btn.classList.add("active");
            } else {
                content.classList.remove("active");
                btn.classList.remove("active");
            }
        })
    }

});



const menuBlock = document.getElementById('menu');
const toggleMenu = () =>{
    if (!menuBlock.classList.contains('show')) {
        document.getElementsByTagName('body')[0].classList.add('overflow');
        menuBlock.classList.add('show');
    } else {
        document.getElementsByTagName('body')[0].classList.remove('overflow');
        menuBlock.classList.remove('show');
    }
}


window.addEventListener('scroll', toggleTopPanel, {passive: true});

const scrollGap = (window.location.pathname === '/' && window.innerWidth >= 1210) ? 3200 : 700;
const scrollTopPanel = document.getElementById('scroll-top-panel');
function toggleTopPanel() {

    if (window.scrollY > scrollGap) {
        if (!scrollTopPanel.classList.contains('show')) {
            scrollTopPanel.classList.add('show');
        }
    } else {

        if (typeof summarySlider !== "undefined"){
            summarySlider.slideTo(0);
            summarySlider.slides.forEach((slide) => {
                if (slide.classList.contains('active')) {
                    slide.classList.remove('active');
                }
            });
        }

        scrollTopPanel.classList.remove('show');

    }
}


function getImage(url) {
    return new Promise(function (resolve, reject) {
        let img = new Image();
        img.onload = function () {
            resolve(url)
        };
        img.onerror = function () {
            reject(url)
        };
        img.src = url
    })
}

function observeMap() {
    const map = document.getElementById('map');
    const options = {
        // родитель целевого элемента - область просмотра
        root: null,
        // без отступов
        rootMargin: '0px',
        // процент пересечения - половина изображения
        threshold: 0
    };

    // создаем наблюдатель
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            // если элемент является наблюдаемым
            if (entry.isIntersecting) {
                let script = document.createElement("script");
                script.type = "text/javascript";
                script.src = "https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=2535956d-6107-48cb-a9f9-b543f11450ed&onload=initMap";
                map.appendChild(script);
                observer.unobserve(entry.target)

            }
        })
    }, options);

    observer.observe(map)
}

function initMap() {
    let myMap = new ymaps.Map('map', {
        center: [54.970501, 73.359968],
        zoom: 14,
        controls: [],
    }, {
        maxAnimationZoomDifference: Infinity,
        suppressMapOpenBlock: true
    });

    myMap.controls.add('zoomControl');

    myMap.behaviors.disable('scrollZoom');

    let marksa = new ymaps.Placemark([54.959645, 73.386160], {
        hintContent: 'просп. Карла Маркса, 34',
    }, {
        iconLayout: 'default#imageWithContent',
        iconImageHref: '/wp-content/themes/skulptor/source/img/ballon.svg',
        iconImageSize: [60, 68],
        iconImageOffset: [-30, -68],
        hideIconOnBalloonOpen: false,
    });
    let leviyBereg = new ymaps.Placemark([54.982156, 73.321976], {
        hintContent: 'ул. 70 лет Октября, 20',
    }, {
        iconLayout: 'default#imageWithContent',
        iconImageHref: '/wp-content/themes/skulptor/source/img/ballon.svg',
        iconImageSize: [60, 68],
        iconImageOffset: [-30, -68],
        hideIconOnBalloonOpen: false,
    });
    let calcWrapper = (window.innerWidth - (document.querySelector('.wrapper').offsetWidth - 30)) / 2;
    let zoomMargin = [0, calcWrapper + 460, 0, calcWrapper];
    if (window.innerWidth < 768) {
        zoomMargin = [15];
    }
    myMap.geoObjects
        .add(marksa)
        .add(leviyBereg);
    myMap.setBounds(myMap.geoObjects.getBounds(), {
        checkZoomRange: true,
        zoomMargin: zoomMargin
    });
}

function observeImage() {
    const imageList = document.querySelectorAll('.l-load-bg');
    const options = {
        // родитель целевого элемента - область просмотра
        root: null,
        // без отступов
        rootMargin: '0px',
        // процент пересечения - половина изображения
        threshold: 0
    };

    // создаем наблюдатель
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            // если элемент является наблюдаемым
            if (entry.isIntersecting) {
                const imageBlock = entry.target;

                const image = getFormatedImageUrl(imageBlock.dataset.image);

                getImage(image).then(function (successUrl) {
                    if (entry.target.tagName === 'DIV' && entry.target.classList.contains('lazy-image')) {
                        let img = document.createElement('img');
                        img.src = successUrl;
                        img.alt = imageBlock.dataset.alt;
                        imageBlock.appendChild(img);
                    } else if (entry.target.tagName === 'IMG') {
                        imageBlock.src = successUrl;
                    } else {
                        imageBlock.style.backgroundImage = 'url(' + successUrl + ')';
                    }
                    imageBlock.classList.remove('l-load-bg');
                    observer.unobserve(imageBlock)
                }).catch(function (errorUrl) {
                    console.log(errorUrl);
                });


            }
        })
    }, options);

    imageList.forEach(i => {
        observer.observe(i)
    })
}

function getFormatedImageUrl(url) {
    const ext = url.match(/\.([a-zA-Z]+)$/)[1];
    return (WEBP && ext !== 'svg' && ext !== 'gif') ? url + '.webp' : url;
}

function validateform(e) {
    e.preventDefault();

    const title = this.getElementsByClassName('modal-title')[0].innerText;
    const phone = this.getElementsByClassName('phone')[0].value;
    const locationInput = this.getElementsByClassName('ya-location')[0];
    let formLocation = '';

    if (locationInput) {
        formLocation = this.getElementsByClassName('ya-location')[0].value;
    }

    const btn = this.getElementsByClassName('btn')[0];
    grecaptcha.ready(function () {
        grecaptcha.execute('6Lej_50lAAAAALffZs7elPNDcSV7RCqC_i5hBAoP', {action: 'submit'}).then(function (token) {


            toggleLoad(btn);

            ajax({
                url: '/wp-admin/admin-ajax.php',
                method: 'POST',
                data: {
                    action: 'sendForm',
                    title: title,
                    phone: phone,
                    token: token
                },
                target: btn,
            }).then((data) => {
                if (formLocation.length > 0) {
                    ym(55389889, 'reachGoal', formLocation);
                }
                toggleLoad(btn);
                btn.disabled = true;
                btn.innerText = 'Отправлено'
            });
        });
    });
}

function toggleLoad(button) {
    button.disabled = !button.disabled;

    button.classList.toggle('load');
}


function callback() {
    const scrollTopPanel = document.getElementById('scroll-top-panel');
    if (window.scrollY > 250) {
        if (!scrollTopPanel.classList.contains('show')) {
            scrollTopPanel.classList.add('show');
        }
    } else {
        scrollTopPanel.classList.remove('show');
    }
}


function ajax(params) {
    return new Promise((resolve, reject) => {
        let request = new XMLHttpRequest();
        request.open(params.method || 'GET', params.url || window.location.href, params.async || true);
        request.setRequestHeader('Content-Type', params.contentType || 'application/x-www-form-urlencoded; charset=UTF-8');
        request.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status >= 200 && this.status < 400) {
                    resolve(this.response);
                } else {
                    reject(this);

                }
            }
        };

        let string = Object.keys(params.data).reduce(function (sum, key, index) {
            let comma = (index === Object.keys(params.data).length - 1) ? "" : "&";

            return sum + key + '=' + params.data[key] + comma;

        }, '');

        request.send(params.data ? string : '');
        request = null;
    });
}


function openModal(id, title, location) {
    const modal = document.querySelector('.modal#' + id);
    if (modal) {
        document.getElementsByTagName('body')[0].classList.add('overflow');
        modal.querySelector('.modal-title').innerHTML = title;
        if (location) {
            modal.querySelector('#ya-location').value = location;
        }
        modal.classList.add('show');
    }
}

function closeModal() {
    document.getElementsByTagName('body')[0].classList.remove('overflow');
    let forms = document.querySelector('.modal.show');
    forms.querySelector('button[type=submit]').disabled = false;
    forms.querySelector('.phone').value = '';
    forms.querySelector('#ya-location').value = '';
    forms.querySelector('button[type=submit]').innerText = 'Отправить';
    forms.classList.remove('show');
}

function demoSlider(sliders) {
    if (sliders) {
        for (const demoSlider of sliders) {
            const thumbs = demoSlider.querySelectorAll('.demo-slider .thumb-item');
            for (const thumb of thumbs) {
                thumb.addEventListener('click', function (e) {
                    const thumbBlock = e.currentTarget;
                    if (!thumbBlock.classList.contains('active')) {
                        const mainPhoto = demoSlider.querySelector('.main-photo');
                        const mainPhotoImg = mainPhoto.getElementsByClassName('lazy-image')[0];
                        [...thumbs].forEach((thumb) => thumb.classList.remove('active'));
                        thumbBlock.classList.add('active');
                        mainPhoto.classList.add('loading');


                        const image = getFormatedImageUrl(thumbBlock.dataset.imageThumb);

                        getImage(image).then(function (successUrl) {
                            mainPhotoImg.innerHTML = '';

                            let img = document.createElement('img');
                            img.src = successUrl;
                            img.alt = thumbBlock.dataset.alt;
                            mainPhotoImg.appendChild(img);

                            mainPhoto.classList.remove('loading');

                            const full = thumbBlock.dataset.imageFull;
                            const fancyLink = thumbBlock.parentNode.parentNode.querySelector('.fancy-link');
                            fancyLink.href = full;
                        }).catch(function (errorUrl) {
                            console.log(errorUrl);
                        });
                    }
                });
            }
        }

    }
}

const key = '6Lej_50lAAAAALffZs7elPNDcSV7RCqC_i5hBAoP';

function loadCaptcha() {
    let script = document.createElement('script');
    script.src = 'https://www.google.com/recaptcha/api.js?render=6Lej_50lAAAAALffZs7elPNDcSV7RCqC_i5hBAoP';
    script.async = true;
    document.body.appendChild(script);
}

const inputs = document.querySelectorAll('input.phone');
for (let i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener("click", function () {
        if (typeof grecaptcha === 'undefined') {
            loadCaptcha();
        }
    });
}

