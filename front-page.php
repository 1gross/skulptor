<?php get_header(); ?>
<?php
$fields = get_fields();
$constructor = $fields['constructor'];

?>
<section class="about-us">
    <div class="about-us-track">
        <div class="about-us-thumb l-load-bg" data-image="<?php echo esc_url(get_template_directory_uri()); ?>/source/img/bird.svg">
            <div class="wrapper">
                <div class="about-us-container">
                    <div class="about-us-block l-load-bg" data-image="<?php echo $fields['first_block']['image']; ?>">
                        <div class="info">
                            <?php if (!empty($fields['first_block']['mini_title'])): ?>
                                <div class="mini-title"><?php echo $fields['first_block']['mini_title']; ?></div>
                            <?php endif; ?>
                            <?php if (!empty($fields['first_block']['title'])): ?>
                                <h2><?php echo $fields['first_block']['title']; ?></h2>
                            <?php endif; ?>
                            <div class="years vi-black l-load-bg"
                                 data-image="<?php echo esc_url(get_template_directory_uri()); ?>/source/img/25-years.svg"></div>
                        </div>
                    </div>
                    <?php if (!empty($fields['three_block'])): ?>
                        <nav id="mega-menu" class="mega-menu">
                            <ul class="mega-menu-ul">
                                <?php foreach ($fields['three_block'] as $item): ?>
                                    <li>
                                        <a class="mega-menu-item" href="<?php echo get_page_link($item['page']->ID) ?>">
                                            <span class="item-title"><?php echo $item['page']->post_title; ?></span>
                                            <div class="icon vi-black">
                                                <?php echo file_get_contents($item['image']); ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($fields['three_block'])): ?>
    <div class="mobile-mega-menu">
        <div class="wrapper">
            <div class="mega-menu-slider-container">
                <div id="mega-menu-slider" class="swiper mega-menu-slider" data-slider-type="mega-menu">
                    <div id="mega-menu-progress" class="swiper-progress"><div class="progress"></div></div>
                    <div class="swiper-wrapper">
                        <?php foreach ($fields['three_block'] as $id => $item): ?>
                            <a class="swiper-slide mega-menu-item <?php echo ($id === 0) ? 'first' : ''; ?> <?php echo ($id === 1) ? 'second' : ''; ?> <?php echo ($id === count($fields['three_block']) - 1) ? 'last' : ''; ?>" href="<?php echo get_page_link($item['page']->ID) ?>">
                                <span class="item-title"><?php echo $item['page']->post_title; ?></span>
                                <div class="icon vi-black">
                                    <?php echo file_get_contents($item['image']); ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="mega-menu-pagination" class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>

<div id="reviews"></div>
<?php get_template_part('templates/get-reviews.php', 'reviews'); ?>

<?php get_template_part('templates/get-doctors.php', 'doctors'); ?>

<?php get_template_part('templates/get-navigation.php', 'navigation'); ?>

<?php
if ($constructor) {
    foreach ($constructor as $section) { ?>
        <section class="block-constructor">
            <div class="wrapper">
                <?php $summaryId = ($section['summarys']['is_display_summary'] && strlen($section['summarys']['title_summary']) > 0) ? translit($section['summarys']['title_summary']) : ''; ?>
                <?php if ($section['summarys']['is_display_summary']) { ?>
                    <div id="<?php echo $summaryId ?>" class="anchor"></div>
                <?php } ?>
                <div class="block-items">
                    <?php if (!empty($section['title'])): ?>
                        <h2 class="block-title"><?php echo $section['title']; ?></h2>
                    <?php endif; ?>
                    <?php
                    if (!empty($section['tamplate'])) {
                        foreach ($section['tamplate'] as $template) {
                            $summaryId = ($template['summarys']['is_display_summary'] && strlen($template['summarys']['title_summary']) > 0) ? translit($template['summarys']['title_summary']) : '';
                            $view = $template['view']; ?>
                            <div class="block-template <?php echo $view; ?>">
                                <?php if ($template['summarys']['is_display_summary']) { ?>
                                    <div id="<?php echo $summaryId ?>" class="anchor"></div>
                                <?php } ?>
                                <?php if ($view === 'column1' && !empty($template['1column']['blocks'])) {
                                    $color = $template['1column']['block_background'];

                                    if ($color !== 'none') {
                                        echo '<div class="colored-block ' . $color . ($color === 'white' ? ' toggle-bg' : ' toggle-color-blue') . '">';
                                    }
                                    blocksGenerator($template['1column']['blocks']);
                                    if ($color !== 'none') {
                                        echo '</div>';
                                    }
                                } ?>

                                <?php if ($view === 'column2') {
                                    if (!empty($template['2columns']['1column']['blocks'])):
                                        echo '<div class="column">';

                                        $color = $template['2columns']['1column']['block_background'];

                                        if ($color !== 'none') {
                                            echo '<div class="colored-block ' . $color . ($color === 'white' ? ' toggle-bg' : ' toggle-color-blue') . '">';
                                        }
                                        blocksGenerator($template['2columns']['1column']['blocks']);
                                        if ($color !== 'none') {
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    endif;
                                    if (!empty($template['2columns']['2column']['blocks'])):
                                        echo '<div class="column">';

                                        $color = $template['2columns']['2column']['block_background'];

                                        if ($color !== 'none') {
                                            echo '<div class="colored-block ' . $color . ($color === 'white' ? ' toggle-bg' : ' toggle-color-blue') . '">';
                                        }
                                        blocksGenerator($template['2columns']['2column']['blocks']);
                                        if ($color !== 'none') {
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    endif;
                                } ?>

                                <?php if ($view === 'column3') {
                                    if (!empty($template['3columns']['1column']['blocks'])):
                                        echo '<div class="column">';

                                        $color = $template['3columns']['1column']['block_background'];

                                        if ($color !== 'none') {
                                            echo '<div class="colored-block ' . $color . ($color === 'white' ? ' toggle-bg' : ' toggle-color-blue') . '">';
                                        }
                                        blocksGenerator($template['3columns']['1column']['blocks']);
                                        if ($color !== 'none') {
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    endif;
                                    if (!empty($template['3columns']['2column']['blocks'])):
                                        echo '<div class="column">';

                                        $color = $template['3columns']['2column']['block_background'];

                                        if ($color !== 'none') {
                                            echo '<div class="colored-block ' . $color . ($color === 'white' ? ' toggle-bg' : ' toggle-color-blue') . '">';
                                        }
                                        blocksGenerator($template['3columns']['2column']['blocks']);
                                        if ($color !== 'none') {
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    endif;
                                    if (!empty($template['3columns']['3column']['blocks'])):
                                        echo '<div class="column">';

                                        $color = $template['3columns']['3column']['block_background'];

                                        if ($color !== 'none') {
                                            echo '<div class="colored-block ' . $color . ($color === 'white' ? ' toggle-bg' : ' toggle-color-blue') . '">';
                                        }
                                        blocksGenerator($template['3columns']['3column']['blocks']);
                                        if ($color !== 'none') {
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    endif;
                                } ?>
                            </div>
                        <?php }
                    }


                    ?>
                </div>
            </div>
        </section>
    <?php }
}
?>

<?php get_footer(); ?>
