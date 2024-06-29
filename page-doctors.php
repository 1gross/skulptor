<?php
get_header();
$fields = get_fields();
$topBlock = $fields['top_block'];
$pages = get_field('reviews_categories');
$doctors = get_field('reviews_doctors');
$summarysList = getListSummarys($fields);
?>
<?php
$doctors = get_posts( [
    'posts_per_page' => -1,
    'post_type' => 'doctors',
     'post_status'    => 'publish',
    'order'=> 'ASC',
    'orderby' => 'date'
] );


?>
<?php get_template_part('templates/get-jumbotron.php', 'jumbotron', array('topBlock' => $topBlock, 'summarysList' => $summarysList)); ?>

<?php get_template_part('templates/get-navigation.php', 'navigation'); ?>

<?php get_template_part('templates/get-doctors.php', 'doctors'); ?>

<?php get_template_part('templates/get-price.php', 'price'); ?>

<?php get_template_part('templates/get-offer.php', 'offer'); ?>

<?php
$works = get_field('work_examples');
if ($works) {
    get_template_part('templates/get-works-slider.php', 'works-slider', $works);
} ?>
<div class="ribbon-doctors">
    <?php foreach ($doctors as $doctor): $doctorInfo = get_fields($doctor->ID); ?>
        <section>
            <div class="wrapper">
                <div class="doctor l-load-bg no-animation" data-image="<?php echo $doctorInfo['photo']; ?>">
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
                                    <a class="certificate vi-black-pseudo" data-fancybox="certificate-<?php echo $doctor->ID; ?>" data-caption="<?php echo $certificate['name'] ?>" href="<?php echo $certificate['certificate'] ?>"><span><?php echo $certificate['name'] ?></span></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
</div>


<?php get_footer(); ?>

