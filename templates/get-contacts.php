<?php
$phone = (get_field('fake_phone') || strlen(get_field('fake_phone')) > 0) ? get_field('fake_phone') : '+7 (3812) 38-26-06';
$cleared_phone = str_replace(array(' ', '(', ')', '-'), '', $phone);
?>
<section class="contacts">
    <div id="map" class="map">
        <div class="popover">
            <h2 class="popover-title">Ждём вас в гости</h2>
            <div class="contact-form">
                <a href="tel:<?php echo $cleared_phone; ?>" class="phone"><?php echo $phone; ?></a>
                <button class="btn simple" onclick="openModal('call', 'Заказать звонок', 'karta-zakazat-zvonok')">Заказать звонок</button>
            </div>
            <ul class="address-list">
                <li>
                    <iframe src="https://yandex.ru/sprav/widget/rating-badge/1386281159?type=rating" width="150" height="50" frameborder="0"></iframe>
                    Карла Маркса, 34</li>
                <li><iframe src="https://yandex.ru/sprav/widget/rating-badge/1122572840?type=rating" width="150" height="50" frameborder="0"></iframe>
                    70 лет Октября, 20</li>
            </ul>
            <div class="time">
                <div class="time-title">
                    Работаем ежедневно<br>
                    <b>09-00 до 20-00</b>
                </div>
            </div>
        </div>
    </div>
</section>