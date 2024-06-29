<?php
get_header();
$fields = get_fields();
$topBlock = $fields['top_block'];
$pages = get_field('reviews_categories');
$doctors = get_field('reviews_doctors');
$summarysList = getListSummarys($fields);
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
<section>
    <div class="wrapper">
        <div class="reviews-filters-block">
            <div class="filter-item">
                <div class="filter-title">Категория</div>
                <div class="form-control-select">
                    <select name="" id="category-select">
                        <option value="" selected>Все категории</option>
                        <?php foreach ($pages as $category): ?>
                            <option value="<?php echo $category->ID; ?>"><?php echo $category->post_title; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="filter-item">
                <div class="filter-title">Доктор</div>
                <div class="form-control-select">
                    <select name="" id="doctor-select">
                        <option value="" selected>Все доктора</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?php echo $doctor->ID; ?>"><?php echo $doctor->post_title; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_template_part('templates/get-reviews.php', 'reviews'); ?>
<?php get_footer(); ?>
<script>

    const doctorSelect = document.getElementById('doctor-select');
    const categorySelect = document.getElementById('category-select');
    const reviewsTitle = document.getElementById('reviews-title');

    function toggleSelect(el) {
        el.parentNode.classList.toggle('loading');
        el.disabled = !el.disabled;
    }

    doctorSelect.addEventListener('change', function(e) {
        const pageId = (e.target.value.length > 0) ? e.target.value : 841;
        let title;

        if (e.target.value.length > 0){
            let tempTitle = e.target.options[e.target.selectedIndex].text.split(' ');
            title = 'Отзывы ' +  tempTitle[0] + ' ' + tempTitle[1];
        } else {
            title = 'Отзывы на независимых площадках';
        }

        categorySelect.value = '';
        reInitSlider(pageId);
        reviewsTitle.innerText = title;

    });
    categorySelect.addEventListener('change', function(e) {
        const pageId = (e.target.value.length > 0) ? e.target.value : 841;
        let title;

        doctorSelect.value = '';

        if (e.target.value.length > 0){
            title = 'Отзывы ' +  e.target.options[e.target.selectedIndex].text.toLowerCase();
        } else {
            title = 'Отзывы на независимых площадках';
        }

        reInitSlider(pageId);
        reviewsTitle.innerText = title;

    });

   function reInitSlider(pageId = 841){
       const reviewsSlider = document.getElementById('reviews-slider').swiper;
       reviewsSlider.wrapperEl.dataset.pageId = pageId;
       reviewsSlider.virtual.removeAllSlides();
       document.getElementById('circle-counter').innerText = '';
       reviewsSlider.wrapperEl.classList.add('load');
       reviewsSlider.destroy();

       initReviewSlider();
   }




</script>
