<?php get_header(); ?>
<?php
$reviewInfo = get_fields();
$otzovik = $reviewInfo['reviews_service'];
$address = $reviewInfo['address'];

$linkText = ($otzovik === 'gis' || $otzovik === 'pd') ? 'Смотреть все отзывы' : 'Смотреть отзыв на сайте-отзовике';
$otzovLink = ($otzovik === 'gis' || $otzovik === 'pd') ? get_fields('general', 'option')[$address][$otzovik]['link'] : $reviewInfo['data_reviews']['link'];
?>

<section class="reviews-jumbotron">
    <div class="wrapper">
        <div class="review">
            <h1 class="review-name size-h2">
                Автор: <?php echo get_the_title(); ?>
            </h1>
            <div class="review-data">
                <div class="info">
                    <div class="date"><?php echo $reviewInfo['data_reviews']['date']; ?></div>
                    <div class="rate <?php echo $reviewInfo['data_reviews']['rating']; ?>">
                        <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                    </div>
                    <a href="<?php echo $otzovLink; ?>" target="_blank"><?php echo $linkText; ?></a>
                </div>
                <div class="text">
                    <?php echo $reviewInfo['data_reviews']['text'] ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

<script>
    pixelCompare(document.querySelectorAll("[data-pixelcompare]"));
    demoSlider(document.querySelectorAll('.demo-slider'));
</script>

