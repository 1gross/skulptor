<?php
/* Template Name: Прайс */

$fields = get_fields();
$topBlock = $fields['top_block'];

$summarysList = getListSummarys($fields);

$navigation = get_field('navigation');

if (is_null($navigation) || !$navigation) {
    $parents = get_post_ancestors($post->ID);
    $navigation = get_field('navigation', $parents[count($parents) - 1]);
}

$price_list = $fields['price_list'];

get_header();

?>

    <section class="jumbotron">
        <div class="wrapper">
            <div class="jumbotron-block">
                <div class="jumbotron-info">
                    <?php
                    if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<nav class="breadcrumbs">', '</nav>');
                    }
                    ?>
                    <h1><?php echo get_the_title(); ?></h1>
                    <button class="btn big"
                            onclick="openModal('call', 'Записаться на прием', 'zapisatsya-na-priem-pervyj-blok')">
                        Записаться
                        на консультацию
                    </button>
                </div>
                <?php if ($topBlock['bg_image']): ?>
                    <div class="jumbotron-image">
                        <div class="lazy-image l-load-bg loading"
                             data-image="<?php echo wp_get_attachment_image_src($topBlock['bg_image'], 'medium')[0]; ?>"
                             data-alt="<?php echo get_post_meta($topBlock['bg_image'], '_wp_attachment_image_alt', true) ?>"></div>
                    </div>
                <?php endif; ?>
            </div>

            <?php get_template_part('templates/get', 'summarys', array('summarys-list' => $summarysList)); ?>

            <?php if (!empty($topBlock['description'])): ?>
                <div class="description">
                    <?php echo $topBlock['description']; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php get_template_part('templates/get', 'navigation'); ?>

<?php get_template_part('templates/get', 'reviews'); ?>

<?php get_template_part('templates/get', 'doctors'); ?>

<?php get_template_part('templates/get', 'price'); ?>

<?php get_template_part('templates/get', 'offer'); ?>

<?php
$works = get_field('work_examples');
if ($works) {
    get_template_part('templates/get', 'works-slider', $works);
} ?>


    <section class="price-block">
        <div class="wrapper">
            <?php
            foreach ($price_list as $price_id) {
                $header_table = get_field('header_price_table', $price_id['price']); ?>
                <div class="collapse-price">
                    <button class="price-toggle price-header">
                        <?php
                        if ($header_table['header_icon']) {
                            echo '<img class="header-icon" src="' . wp_get_attachment_image_url($header_table['header_icon']) . '" alt="' . $header_table['header_title'] . '" />';
                        }
                        ?>
                        <span class="header-title"><?php echo $header_table['header_title'] ?></span>
                        <span class="header-more"></span>
                    </button>
                    <?php $table = get_field('price_table', $price_id['price']);
                    generatePrice($table); ?>
                </div>
            <?php }

            ?>
        </div>
    </section>

<?php get_footer(); ?>
<?php get_template_part('templates/get', 'sticky-footer-panel'); ?>
