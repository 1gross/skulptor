<?php
    $doctors = get_field('doctors');
?>
<?php if (!empty($doctors)): ?>
<div id="doctors" class="anchor"></div>
<section class="doctors">
    <div class="wrapper">
        <div class="doctors-slider-block">
            <div class="doctors-arrows">
                <button id="doctors-left" class="doctors-arrow slider-arrow left"></button>
                <button id="doctors-right" class="doctors-arrow slider-arrow right"></button>
            </div>
            <div id="doctors-slider" class="swiper doctors-slider" data-slider-type="doctors">
                <div id="doctors-progress" class="swiper-progress">
                    <div class="progress"></div>
                </div>
                <div class="swiper-wrapper">
                    <?php foreach ($doctors as $doctor): $doctorInfo = get_fields($doctor->ID); ?>
                        <div class="doctor swiper-slide l-load-bg no-animation" data-image="<?php echo $doctorInfo['photo']; ?>">
                            <div class="doctor-name">
                                <?php echo $doctor->post_title; ?>
                            </div>
                            <div class="doctor-info">
                                <span><?php echo $doctorInfo['profession']; ?></span>  <span><?php echo $doctorInfo['work_experience']; ?></span>
                            </div>
                            <div class="doctor-description">
                                <?php echo $doctorInfo['description']; ?>
                            </div>
                            <div class="doctor-links">
                                <a href="<?php echo get_permalink($doctor->ID) . '#reviews'; ?>" class="btn small blue">Отзывы</a>
                                <a href="<?php echo get_permalink($doctor->ID) . '#works'; ?>" class="btn small outline">Примеры работ</a>
                                <button class="btn small blue" onclick="openModal('call', 'Записаться на прием', 'zapisatsya_vrach')">Записаться</button>
                            </div>
                            <?php if(!empty($doctorInfo['certificates'])): ?>
                                <ul class="certificates">
                                    <?php foreach ($doctorInfo['certificates'] as $i => $certificate): ?>
                                        <li>
                                            <a class="certificate vi-black-pseudo" data-fancybox="certificate-<?php echo $doctor->ID; ?>" data-caption="<?php echo $certificate['name'] ?>" href="<?php echo $certificate['certificate'] ?>"><div><?php echo $certificate['name'] ?></div></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="doctors-pagination" class="swiper-pagination"></div>
        </div>
    </div>
</section>
    <script>
        if (typeof Fancybox !== 'undefined'){
            Fancybox.bind('[data-fancybox="certificate"]', {
                infinite: false
            });
        }

    </script>
<?php endif; ?>