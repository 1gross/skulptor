<?php if ($args): ?>
    <div id="works" class="anchor"></div>
    <section class="works">
        <div class="wrapper">
            <h2 class="center"><blue>Примеры</blue> работ</h2>
            <div id="work-block" class="works-list">
                <?php
                $data = get_fields($args->ID);
                ?>

                <?php get_template_part('templates/get', 'work-item', array('id' => $args->ID,  'title'=>$args->post_title, 'description'=>$args->post_content, 'fields'=>$data)); ?>
            </div>
            <div class="show-more-works-block">
                <a href="<?php echo get_permalink(3754) . '?category=' . get_the_ID(); ?>" target="_blank" id="show-more-works" class="btn blue big show-more-works">Посмотреть все</a>
            </div>

        </div>
    </section>
<?php endif; ?>
