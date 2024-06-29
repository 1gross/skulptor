<?php
if ($args['summarys-list']) { ?>
    <div id="summarys-slider" class="swiper summarys-slider loading" data-slider-type="summarys">
        <div class="swiper-wrapper">
            <?php foreach ($args['summarys-list'] as $summary){
                echo sprintf('<div id="slide-%s" class="swiper-slide summary-item"><a class="summary-link" href="#%s">%s</a></div>', $summary[0], $summary[0], $summary[1]);
            } ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <?php
}

