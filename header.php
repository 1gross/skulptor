<?php

if (isset($_GET["utm_source"])) setcookie("utm_source", $_GET["utm_source"], time() + 3600 * 24 * 30, "/");
if (isset($_GET["utm_medium"])) setcookie("utm_medium", $_GET["utm_medium"], time() + 3600 * 24 * 30, "/");
if (isset($_GET["utm_campaign"])) setcookie("utm_campaign", $_GET["utm_campaign"], time() + 3600 * 24 * 30, "/");
if (isset($_GET["utm_content"])) setcookie("utm_content", $_GET["utm_content"], time() + 3600 * 24 * 30, "/");
if (isset($_GET["utm_term"])) setcookie("utm_term", $_GET["utm_term"], time() + 3600 * 24 * 30, "/");

$phone = (get_field('fake_phone') || strlen(get_field('fake_phone')) > 0) ? get_field('fake_phone') : '+7 (3812) 38-26-06';
$cleared_phone = str_replace(array(' ', '(', ')', '-'), '', $phone);

$summarysList = getListSummarys(get_fields());

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta id="dynamicViewPort" name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <script>
        var WEBP = false;
        if (screen.width < 375) {
            let mvp = document.getElementById('dynamicViewPort');
            mvp.setAttribute('content', 'width=375');
        }
        const webP = new Image();
        webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
        webP.onload = webP.onerror = function () {
            WEBP = webP.height === 2;
        };
        const viDefaultSettings = {
            font: 'Arial',
            fontSize: 'small',
            bg: 'color1',
            images: 'on',
            fontSpacing: 'small',
        }
        const currentViStatus = localStorage.getItem('vi');
        const currentViSettings = (localStorage.getItem('viSettings')) ? JSON.parse(localStorage.getItem('viSettings')) : viDefaultSettings;

        if (currentViStatus === 'on' && currentViSettings) {
            document.documentElement.classList.add('vi-on', 'font-' + currentViSettings.font, 'fontSize-' + currentViSettings.fontSize, 'bg-' + currentViSettings.bg, 'images-' + currentViSettings.images, 'fontSpacing-' + currentViSettings.fontSpacing);
        }

        function loadScript(src) {
            return new Promise(function (resolve, reject) {
                let script = document.createElement('script');
                if (src.startsWith('http')) {
                    script.src = src;
                } else {
                    script.src = window.location.origin + '/wp-content/themes/skulptor' + src;
                }

                script.onload = () => resolve(script);
                script.onerror = () => reject(`Ошибка загрузки скрипта ${src}`);
                document.head.append(script);
            });
        }

        function loadLink(href, rel) {
            return new Promise(function (resolve, reject) {
                let link = document.createElement('link');
                link.href = window.location.origin + '/wp-content/themes/skulptor' + href;
                link.rel = rel;
                link.onload = () => resolve(link);
                link.onerror = () => reject(`Ошибка загрузки ресурса ${href}`);
                document.head.append(link);
            });
        }
    </script>
    <!--    <script src="https://www.google.com/recaptcha/api.js?render=6Lej_50lAAAAALffZs7elPNDcSV7RCqC_i5hBAoP"></script>-->
    <meta name="yandex-verification" content="0f81347ba59811ee"/>
    <meta name="google-site-verification" content="AzSyou4xuP7QxXtYPiP0TmpzBYyraNEODvqH7lkAeVc"/>
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo get_template_directory_uri() . '/source/favicons/apple-touch-icon.png' ?>">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo get_template_directory_uri() . '/source/favicons/favicon-32x32.png' ?>">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo get_template_directory_uri() . '/source/favicons/favicon-16x16.png' ?>">
    <link rel="icon" href="<?php echo get_template_directory_uri() . '/source/favicons/favicon.svg' ?>">
    <link rel="manifest" href="<?php echo get_template_directory_uri() . '/source/favicons/site.webmanifest' ?>">
    <link rel="mask-icon" href="<?php echo get_template_directory_uri() . '/source/favicons/safari-pinned-tab.svg' ?>"
          color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?php wp_head(); ?>
</head>

<?php
$additional_classes = ($summarysList && count($summarysList) > 0) ? 'with-summarys' : '';
?>

<body <?php body_class($additional_classes); ?> >
<div id="visually-impaired">
    <div class="wrapper">
        <div class="vi-block">
            <div>
                <div class="vi-title">
                    Размер шрифта:
                </div>
                <div class="vi-buttons">
                    <button class="vi-btn vi-font-size s" data-type="fontSize" data-value="small">A</button>
                    <button class="vi-btn vi-font-size m" data-type="fontSize" data-value="middle">A</button>
                    <button class="vi-btn vi-font-size l" data-type="fontSize" data-value="large">A</button>
                </div>
            </div>
            <div>
                <div class="vi-title">
                    Цвет сайта:
                </div>
                <div class="vi-buttons bg">
                    <button class="vi-btn vi-bg white" data-type="bg" data-value="color1">A</button>
                    <button class="vi-btn vi-bg black" data-type="bg" data-value="color2">A</button>
                    <button class="vi-btn vi-bg blue" data-type="bg" data-value="color3">A</button>
                    <button class="vi-btn vi-bg brown" data-type="bg" data-value="color4">A</button>
                    <button class="vi-btn vi-bg green" data-type="bg" data-value="color5">A</button>
                </div>
            </div>
            <div>
                <div class="vi-title">
                    Шрифт:
                </div>
                <div class="vi-buttons">
                    <button class="vi-btn vi-font" data-type="font" data-value="Arial">Без засечек</button>
                    <button class="vi-btn vi-font" data-type="font" data-value="Times">С засечками</button>
                </div>
            </div>
            <div>
                <div class="vi-title">
                    Изображения:
                </div>
                <div class="vi-buttons">
                    <button class="vi-btn vi-images" data-type="images" data-value="on">вкл</button>
                    <button class="vi-btn vi-images" data-type="images" data-value="off">выкл</button>
                </div>
            </div>
            <div>
                <div class="vi-title">
                    Интервал между буквами:
                </div>
                <div class="vi-buttons">
                    <button class="vi-btn vi-font-spacing" data-type="fontSpacing" data-value="small">Нормальный</button>
                    <button class="vi-btn vi-font-spacing" data-type="fontSpacing" data-value="middle">Средний</button>
                    <button class="vi-btn vi-font-spacing" data-type="fontSpacing" data-value="large">Большой</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        for (var j = 0; j < document.scripts.length; j++) {
            if (document.scripts[j].src === r) {
                return;
            }
        }
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(55389889, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true
    });
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/55389889" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->

<!-- Top.Mail.Ru counter -->
<script type="text/javascript">
    var _tmr = window._tmr || (window._tmr = []);
    _tmr.push({id: "3516905", type: "pageView", start: (new Date()).getTime()});
    (function (d, w, id) {
        if (d.getElementById(id)) return;
        var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
        ts.src = "https://top-fwz1.mail.ru/js/code.js";
        var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
        if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
    })(document, window, "tmr-code");
</script>
<noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3516905;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
<!-- /Top.Mail.Ru counter -->

<?php wp_body_open(); ?>
<div id="menu">
    <div class="wrapper">
        <div class="menu-block">
            <div class="menu-header">
                <button class="menu-toggle close">
                    <span class="menu-inner"></span>
                </button>
                <div class="menu-title vi-black"></div>
                <button id="vi-toggle" class="btn simple vi-black-pseudo">Версия для слабовидящих</button>
            </div>
            <?php wp_nav_menu(
                [
                    'theme_location' => 'main',
                    'container' => 'nav',
                    'menu_class' => 'header-menu',
                    'menu_id' => 'main-menu',
                ]
            ); ?>
            <div class="menu-bottom">
                <div class="address vi-black-pseudo">г. Омск, 70 лет Октября, 20</div>
                <div class="address vi-black-pseudo">Карла Маркса проспект, 34</div>
                <a href="tel:<?php echo $cleared_phone; ?>" class="phone vi-black-pseudo"><?php echo $phone; ?></a>
                <div class="time vi-black-pseudo">Работаем ежедневно с <br><span>09:00</span> до <span>20:00</span>
                </div>
            </div>
        </div>
    </div>
</div>
<header id="header">
    <div class="wrapper">
        <div class="header-top">
            <div class="address vi-black-pseudo">г. Омск, 70 лет Октября, 20</div>
            <div class="address vi-black-pseudo">Карла Маркса проспект, 34</div>
            <a href="tel:<?php echo $cleared_phone; ?>" class="phone vi-black-pseudo"><?php echo $phone; ?></a>
            <div class="time vi-black-pseudo">Работаем ежедневно с <br><span>09:00</span> до <span>19:00</span></div>
        </div>
        <div class="header-bottom">
            <div class="header-section">
                <button class="menu-toggle">
                    <span class="menu-inner"></span>
                </button>
            </div>
            <div class="header-section">
                <a href="<?php echo get_site_url(); ?>" class="logo" rel="home"><img
                            src="<?php echo get_template_directory_uri() . '/source/img/logo.svg' ?>" alt="Логотип"></a>
            </div>
            <div class="header-section">
                <button class="btn small outline rounded"
                        onclick="openModal('call', 'Заказать звонок', 'shapka-zakazat-zvonok')">Заказать обратный звонок
                </button>
                <a href="tel:<?php echo $cleared_phone; ?>" class="phone"><?php echo $phone; ?></a>
            </div>
        </div>
    </div>
</header>
<div id="scroll-top-panel">
    <div class="wrapper">
        <div class="scroll-top-panel-block">
            <button class="menu-toggle">
                <span class="menu-inner"></span>
            </button>
            <a href="tel:<?php echo $cleared_phone; ?>" class="phone"><?php echo $phone; ?></a>
            <button class="btn small outline rounded"
                    onclick="openModal('call', 'Заказать звонок', 'shapka-zakazat-zvonok')">Заказать обратный звонок
            </button>
        </div>
        <?php get_template_part('templates/get-summarys-top-panel.php', 'summarys-top-panel', array('summarys-list' => $summarysList)); ?>
    </div>
</div>
<div id="line"></div>
<main>