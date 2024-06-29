<?php get_template_part('templates/get-consult.php', 'consult'); ?>
<?php get_template_part('templates/get-contacts.php', 'contacts'); ?>
<?php get_template_part('templates/get-service.php', 'service'); ?>

</main>

<footer id="footer">
    <div class="wrapper">
        <div class="footer-bottom">
            <div class="footer-left">
                <a href="" class="logo" rel="home"><img src="<?php echo get_template_directory_uri() . '/source/img/logo.svg' ?>" alt="Logo"></a>
            </div>
            <div class="footer-right">
                <?php wp_nav_menu(
                    [
                        'theme_location' => 'footer',
                        'container' => 'nav',
                        'container_class' => 'footer-menu',
                        'menu_class' => 'menu',
                        'menu_id' => 'footer-menu',
                    ]
                ); ?>

                <div class="copyright">
                    © Работаем с 1999 г. <br>
                    Все права защищены. Сайт является информационным и не является публичной офертой.
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="modal" id="call">

    <div class="modal-block">
        <button class="close" onclick="closeModal()"></button>

        <div class="container">
            <form action="" class="send-email">
                <div class="modal-title">Заказать звонок</div>
                <div class="modal-description">
                    В ближайшее время с вами свяжется администратор нашей стоматологии.
                </div>
                <input type="text" class="form-control phone w100" placeholder="Ваш телефон" required="">
                <div class="politic">
                    Нажимая кнопку, вы принимаете условия сайта по работе с <a href="<?php echo get_page_link(3) ?>">персональными данными</a>.
                </div>
                <button type="submit" class="btn big blue w100">Отправить</button>
                <input type="hidden" id="ya-location" class="ya-location">
            </form>
        </div>
    </div>

</div>
<?php wp_footer(); ?>
<?php get_template_part('templates/get-sticky-footer-panel.php', 'sticky-footer-panel'); ?>
<?php
//$summarys = get_field('page_summarys');
//
//if ($summarys){
//    echo '<script src="' . get_template_directory_uri() . '/source/js/summarys.js' . '" async>';
//}
//?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let calibri = document.createElement('script');
        calibri.src = 'https://cdn.callibri.ru/callibri.js';
        calibri.async = true;
        document.body.appendChild(calibri);
    }, false);
</script>

</body>
</html>