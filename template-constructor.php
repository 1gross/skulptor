<?php
/* Template Name: Конструктор */

$fields = get_fields();
$topBlock = $fields['top_block'];

$summarysList = getListSummarys($fields);

$navigation = get_field('navigation');

if (is_null($navigation) || !$navigation) {
    $parents = get_post_ancestors($post->ID);
    $navigation = get_field('navigation', $parents[count($parents) - 1]);
}

$constructor = $fields['constructor'];

get_header();

?>

<?php get_template_part('templates/get', 'jumbotron', array('topBlock' => $topBlock, 'summarysList' => $summarysList)); ?>

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