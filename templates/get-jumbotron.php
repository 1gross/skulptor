<?php
if (array_key_exists('topBlock', $args) || array_key_exists('summarysList', $args)){ ?>
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
                            onclick="openModal('call', 'Записаться на прием', 'zapisatsya-na-priem-pervyj-blok')">Записаться
                        на консультацию
                    </button>
                </div>
                <?php if ($args['topBlock']['bg_image']): ?>
                    <div class="jumbotron-image">
                        <div class="lazy-image l-load-bg loading"
                             data-image="<?php echo wp_get_attachment_image_src($args['topBlock']['bg_image'], 'medium')[0]; ?>"
                             data-alt="<?php echo get_post_meta($args['topBlock']['bg_image'], '_wp_attachment_image_alt', true) ?>"></div>
                    </div>
                <?php endif; ?>
            </div>

            <?php get_template_part('templates/get', 'summarys', array('summarys-list' => $args['summarysList'])); ?>

            <?php if (!empty($args['topBlock']['description'])): ?>
                <div class="description">
                    <?php echo $args['topBlock']['description']; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php }
?>