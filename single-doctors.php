<?php get_header(); ?>
<?php
$doctorInfo = get_fields();

$works = getWorksByParameters('doctor', get_the_ID());
?>

<section class="doctors-jumbotron">
    <div class="wrapper">
        <div class="doctor" style="background-image: url('<?php echo $doctorInfo['photo']; ?>')">
            <h1 class="doctor-name">
                <?php echo get_the_title(); ?>
            </h1>
            <div class="doctor-info">
                <span><?php echo $doctorInfo['profession']; ?></span>  <span><?php echo $doctorInfo['work_experience']; ?></span>
            </div>
            <div class="doctor-description">
                <?php echo $doctorInfo['description']; ?>
            </div>
            <div class="doctor-links">
                <a href="#reviews" class="btn small blue">Отзывы</a>
                <?php if ($works): ?>
                    <a href="#works" class="btn small outline">Примеры работ</a>
                <?php endif; ?>
                <button class="btn small blue" onclick="openModal('call', 'Записаться на прием', 'zapisatsya_vrach')">Записаться</button>
            </div>
            <?php if(!empty($doctorInfo['certificates'])): ?>
                <ul class="certificates">
                    <?php foreach ($doctorInfo['certificates'] as $i => $certificate): ?>
                        <li>
                            <a class="certificate" data-fancybox="certificate-<?php echo get_the_ID(); ?>" data-caption="<?php echo $certificate['name'] ?>" href="<?php echo $certificate['certificate'] ?>"><?php echo $certificate['name'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php get_template_part('templates/get-reviews.php', 'reviews'); ?>

<?php
if ($works){ ?>
    <?php get_template_part('templates/get-works.php', 'works', $works); ?>
<?php }
?>

<?php get_footer(); ?>

<script>
    pixelCompare(document.querySelectorAll("[data-pixelcompare]"));
    demoSlider(document.querySelectorAll('.demo-slider'));
</script>

