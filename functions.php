<?php

require_once(get_stylesheet_directory() . '/functions/acf-fields.php');
require_once(get_stylesheet_directory() . '/ajax/ajax-get-review.php');
require_once(get_stylesheet_directory() . '/ajax/ajax-get-review-by-date.php');
require_once(get_stylesheet_directory() . '/ajax/ajax-send-form.php');
require_once(get_stylesheet_directory() . '/ajax/ajax-filters.php');
require_once(get_stylesheet_directory() . '/ajax/ajax-get-works-in-post.php');

require_once(get_stylesheet_directory() . '/functions/picture-functions.php');

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

if (function_exists('add_theme_support')) {
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'theme_register_nav_menu');
function theme_register_nav_menu()
{
    register_nav_menu('main', 'Шапка сайта');
    register_nav_menu('footer', 'Подвал сайта');
}

if ('disable_gutenberg') {
    add_filter('use_block_editor_for_post_type', '__return_false', 100);
    // Move the Privacy Policy help notice back under the title field.
    add_action('admin_init', function () {
        remove_action('admin_notices', ['WP_Privacy_Policy_Content', 'notice']);
        add_action('edit_form_after_title', ['WP_Privacy_Policy_Content', 'notice']);
    });
}

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Основные настройки',
        'menu_title' => 'Настройки темы',
        'menu_slug' => 'theme-general-settings',
        'post_id' => 'general',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

}


add_filter('intermediate_image_sizes', function ($sizes) {
    return array_diff($sizes, ['medium_large'], ['1536x1536'], ['2048x2048']);  // Medium Large (768 x 0)
});

function smartwp_remove_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
}

add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);

function ti_custom_javascript()
{
    if (is_singular('doctors') || is_page(3754)) {
        wp_enqueue_style('compare', get_stylesheet_directory_uri() . '/source/libs/compareSlider/pixelcompare.min.css');
        wp_enqueue_script('compare-js', get_stylesheet_directory_uri() . '/source/libs/compareSlider/pixelcompare.min.js');
    }
}

add_action('wp_head', 'ti_custom_javascript');

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style('normalize', get_stylesheet_directory_uri() . '/source/libs/normalize.css');
    wp_enqueue_script('inputmask-js', get_stylesheet_directory_uri() . '/source/libs/inputmask.min.js', '', '', true);
    wp_enqueue_style('fancy-css', get_stylesheet_directory_uri() . '/source/libs/fancy/fancybox.css');
    wp_enqueue_script('fancy-js', get_stylesheet_directory_uri() . '/source/libs/fancy/fancybox.umd.js', '', '', true);
    wp_enqueue_style('main', get_stylesheet_directory_uri() . '/source/css/style.css', array(), '1.0');
    wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/source/js/main.js', '', '', true);
    wp_enqueue_script('sliders-js', get_stylesheet_directory_uri() . '/source/js/sliders.js', '', '', true);
    wp_enqueue_script('summarys-js', get_stylesheet_directory_uri() . '/source/js/summarys.js', '', '', true);
    wp_enqueue_script('vi-js', get_stylesheet_directory_uri() . '/source/js/vi.js', '', '', true);


});

/**
 * Склонение существительных после числительных.
 *
 * @param string $value Значение
 * @param array $words Массив вариантов, например: array('товар', 'товара', 'товаров')
 * @param bool $show Включает значение $value в результирующею строку
 * @return string
 */
function num_word($value, $words, $show = true)
{
    $num = $value % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    $out = ($show) ? $value . ' ' : '';
    switch ($num) {
        case 1:
            $out .= $words[0];
            break;
        case 2:
        case 3:
        case 4:
            $out .= $words[1];
            break;
        default:
            $out .= $words[2];
            break;
    }

    return $out;
}


function add_specific_menu_location_atts($atts, $item, $args)
{

    // check if the item is in the primary menu
    if ($args->menu->term_id == 4) {
        // add the desired attributes:
        $atts['class'] = 'menu-link';
    }
    return $atts;
}

add_filter('nav_menu_link_attributes', 'add_specific_menu_location_atts', 10, 3);

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts()
{
    echo '<style>
    .blue{
    background-color: #e2f1ff;
    }
    
  </style>';
}

function translit($value)
{
    $converter = array(
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
        'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
        'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
    );

    $value = mb_strtolower($value);
    $value = strtr($value, $converter);
    $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
    $value = mb_ereg_replace('[-]+', '-', $value);
    $value = trim($value, '-');

    return $value;
}

function getListSummarys($fields)
{

    if (!$fields['summarys']['page_summarys']) {
        return false;
    }

    $summaryList = array();
    $fixedSummarys = $fields['summarys'];

    foreach ($fixedSummarys as $id => $summary) {
        if ($summary['is_display_summary'] && strlen($summary['title_summary']) > 0) {
            $summaryList[] = array($id, $summary['title_summary']);
        }
    }

    foreach ($fields['constructor'] as $section_id => $section) {
        if (summaryCheck($section['summarys'])) {
            $summaryList[] = summaryCheck($section['summarys']);
        }

        if (!empty($section['tamplate'])) {
            foreach ($section['tamplate'] as $block_id => $template) {
                if (summaryCheck($template['summarys'])) {
                    $summaryList[] = summaryCheck($template['summarys']);
                }
            }
        }
    }

    return count($summaryList) > 0 ? $summaryList : false;
}

function summaryCheck($summary)
{
    if ($summary['is_display_summary'] && strlen($summary['title_summary']) > 0) {
        return array(translit($summary['title_summary']), $summary['title_summary']);
    }
    return false;
}

function generateSummary($constructor)
{
    $summary = '';

    if (!$constructor && $constructor['page_summarys']) {
        return false;
    }
    $formatLink = '<li><a class="summary-link" href="#%s">%s</a></li>';
    foreach ($constructor as $section_id => $section) {
        if ($section['summarys']['is_display_summary'] && strlen($section['summarys']['title_summary']) > 0) {
            $summary .= sprintf($formatLink, translit($section['summarys']['title_summary']), $section['summarys']['title_summary']);
        }
        //var_dump($section);
        if (!empty($section['tamplate'])) {
            foreach ($section['tamplate'] as $block_id => $template) {
                //var_dump($template['summarys']);
                if ($template['summarys']['is_display_summary'] && strlen($template['summarys']['title_summary']) > 0) {
                    $summary .= sprintf($formatLink, translit($template['summarys']['title_summary']), $template['summarys']['title_summary']);
                }
            }
        }
    }
    if (strlen($summary) === 0) {
        return false;
    }

    return '<ul class="summarys-list">' . $summary . '</ul>';
}

function blocksGenerator($blocks)
{
    foreach ($blocks as $block) {
        switch ($block['acf_fc_layout']) {
            case 'text_w100': ?>
                <div class="block-text-container <?php echo $block['line'] ?>">
                    <div class="block-text child-margined">
                        <?php echo $block['text'] ?>
                    </div>
                </div>
                <?php break; ?>

            <?php case 'images_2column': ?>
            <div class="block-2-images">
                <?php foreach ($block['images'] as $image): ?>
                    <div class="image-item" style="background-image: url('<?php echo $image['image']; ?>');"></div>
                <?php endforeach; ?>
            </div>
            <?php break; ?>

        <?php case 'blue_block_right_text': ?>
            <div class="block-blue-with-right-text">
                <div class="blue-block">
                    <div class="blue-block-title"><?php echo $block['blue_block']['title']; ?></div>
                    <ul class="blue-block-list">
                        <?php foreach ($block['blue_block']['list'] as $item): ?>
                            <li><?php echo $item['item']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="blue-block-text">
                    <?php echo $block['blue_block']['text']; ?>
                </div>
            </div>
            <?php break; ?>
        <?php case 'price': ?>
            <?php
            $header_table = get_field('header_price_table', $block['table']);
            $table = get_field('price_table', $block['table']);
            ?>
            <!--            <div>--><?php //echo $header_table['header_title']; ?><!--</div>-->
            <?php generatePrice($table); ?>
            <?php break; ?>
        <?php case 'table': ?>
            <?php
            $table = $block['table'];
            if (!empty ($table)) {
                echo '<div class="responsive-table">';
                echo '<table class="block-table">';
                if (!empty($table['caption'])) {
                    echo '<caption>' . $table['caption'] . '</caption>';
                }
                if (!empty($table['header'])) {
                    echo '<thead>';
                    echo '<tr>';
                    foreach ($table['header'] as $th) {
                        echo '<th>';
                        echo $th['c'];
                        echo '</th>';
                    }
                    echo '</tr>';
                    echo '</thead>';
                }
                echo '<tbody class="toggle-bg">';
                foreach ($table['body'] as $tr) {
                    echo '<tr>';
                    foreach ($tr as $td) {
                        echo '<td>';
                        echo $td['c'];
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '<button class="toggle-table hide"></button>';
                echo '</div>';
            }
            ?>
            <?php break; ?>

        <?php case 'feature': ?>
            <div class="block-feature <?php echo $block['direction']; ?>">
                <?php if (!empty($block['pluses'])): ?>
                    <div class="pluses toggle-bg">
                        <div class="feature-title vi-black-pseudo">Плюсы</div>
                        <ul class="feature-list">
                            <?php foreach ($block['pluses'] as $plus): ?>
                                <li><?php echo $plus['text'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                <?php endif; ?>
                <?php if (!empty($block['minuses'])): ?>
                    <div class="minuses">
                        <div class="feature-title vi-black-pseudo">Минусы</div>
                        <ul class="feature-list">
                            <?php foreach ($block['minuses'] as $minus): ?>
                                <li><?php echo $minus['text'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <?php break; ?>

        <?php case 'image': ?>
            <div class="block-1-image">
                <div class="lazy-image l-load-bg loading"
                     data-image="<?php echo wp_get_attachment_image_src($block['image'], 'full')[0]; ?>"
                     data-alt="<?php echo get_post_meta($block['image'], '_wp_attachment_image_alt', true) ?>"></div>

            </div>
            <?php break; ?>

        <?php case 'spoilers': ?>
            <div class="block-accordion">
                <?php foreach ($block['spoiler'] as $spoiler) { ?>
                    <div class="accordion-item">
                        <button class="accordion-title"><?php echo $spoiler['title']; ?></button>
                        <div class="accordion-body child-margined toggle-color-blue">
                            <?php echo $spoiler['text']; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php break; ?>
        <?php case 'tabs': ?>
            <div class="block-tabs">
                <ul class="tabs-items">
                    <?php foreach ($block['tab'] as $i => $tab) { ?>
                        <li>
                            <button type="button" class="tab-item <?php echo ($i === 0) ? 'active' : ''; ?>">
                                <?php echo $tab['title']; ?>
                            </button>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tabs-body">
                    <?php foreach ($block['tab'] as $i => $tab) { ?>
                        <div class="tab-body <?php echo ($i === 0) ? 'active' : ''; ?>">
                            <?php echo $tab['text']; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php break; ?>
        <?php case 'list': ?>
            <div class="block-list">
                <ul class="filled-list <?php echo $block['type']; ?>">
                    <?php foreach ($block['list'] as $list): ?>
                        <li class="toggle-bg"><?php echo $list['text'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php break; ?>

        <?php case 'get_consult': ?>
            <?php get_template_part('templates/get-consult-short.php', 'consult-short'); ?>
            <?php break; ?>

        <?php }
    }
}

function generatePrice($table)
{
    $page_id =get_queried_object_id();
    if ($table) { ?>
        <div class="block-price">
            <?php foreach ($table as $key => $block) {
                switch ($block['acf_fc_layout']) {
                    case 'price_block':
                        echo generatePriceRow($block);
                        break; ?>
                    <?php case 'price_group': ?>
                    <?php if (strlen($block['separator_title']) > 0 || strlen($block['separator_description']) > 0) { ?>
                        <div class="price-group">
                            <button class="price-toggle separator <?php echo ($block['is_open'] && $page_id !== 849 ? 'default-open' : '') ?>">
                                <span class="separator-data">
                                    <?php echo strlen($block['separator_title']) > 0 ? '<span class="separator_title">' . $block['separator_title'] . '</span>' : ''; ?>
                                    <?php echo strlen($block['separator_description']) > 0 ? '<span class="separator_description">' . $block['separator_description'] . '</span>' : ''; ?>
                                </span>
                                <span class="header-more"></span>
                            </button>
                            <div class="block-price <?php echo ($block['is_open'] && $page_id !== 849 ? 'default-open' : '') ?>">
                                <?php foreach ($block['price_block'] as $price){ echo generatePriceRow($price); } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php break; ?>
                <?php }
            } ?>
        </div>
    <?php }
}

function generatePriceRow($block){
    ob_start(); ?>
    <div class="price-row">
        <div class="info">
            <?php echo strlen($block['info']['price_title']) > 0 ? '<div class="price_title">' . $block['info']['price_title'] . '</div>' : ''; ?>
            <?php echo strlen($block['info']['price_description']) > 0 ? '<div class="price_description">' . $block['info']['price_description'] . '</div>' : ''; ?>
        </div>
        <div class="cost">
            <?php echo strlen($block['cost']['new']) > 0 ? '<div class="new">' . $block['cost']['new'] . '</div>' : ''; ?>
            <?php echo strlen($block['cost']['old']) > 0 ? '<div class="old">' . $block['cost']['old'] . '</div>' : ''; ?>
        </div>
        <?php echo strlen($block['info']['price_description']) > 0 ? '<div class="price_description_mob">' . $block['info']['price_description'] . '</div>' : ''; ?>
        <div class="consult">
            <button class="price-btn" onclick="openModal('call', 'Получить консультацию', 'zayavka_na_bespl_konsultaciyu_prajs')">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12.5" cy="12.5" r="12.5"/>
                    <path d="M19.1667 9.00612C19.1613 9.30085 19.0013 9.65206 18.7048 9.94803C16.8642 11.7865 15.0248 13.6263 13.1857 15.466C12.2445 16.4074 11.3055 17.3513 10.361 18.2895C10.2932 18.3569 10.1938 18.4084 10.1002 18.4322C9.1471 18.6739 8.19176 18.908 7.2374 19.1448C6.94017 19.2186 6.71675 19.1071 6.67217 18.85C6.65879 18.7735 6.67341 18.6878 6.69248 18.6103C6.91813 17.6946 7.15096 16.7809 7.3719 15.8643C7.41945 15.6669 7.50615 15.5133 7.65154 15.3684C9.9412 13.0868 12.2259 10.8 14.5116 8.51423C14.9721 8.0538 15.4323 7.59262 15.8935 7.13269C16.5154 6.51275 17.4064 6.51176 18.0276 7.12972C18.2701 7.37095 18.5128 7.61169 18.7523 7.8559C19.025 8.1338 19.1672 8.49169 19.1667 9.00612ZM16.5722 10.9291C16.0151 10.3721 15.4583 9.81552 14.9168 9.2741C12.75 11.4405 10.5723 13.6179 8.40576 15.784C8.95365 16.3319 9.51071 16.8889 10.0616 17.4398C12.2306 15.2706 14.4083 13.093 16.5722 10.9291ZM17.1728 10.3309C17.5164 9.99335 17.8765 9.65775 18.2143 9.3011C18.4539 9.04822 18.4274 8.66209 18.1787 8.40624C17.9406 8.16129 17.6977 7.9208 17.4544 7.68104C17.1565 7.3873 16.7668 7.38854 16.4681 7.68426C16.1617 7.98767 15.8578 8.29355 15.5531 8.59869C15.5314 8.62048 15.5128 8.64575 15.5016 8.65912C16.0654 9.22308 16.6224 9.78035 17.1728 10.3309ZM8.01193 16.6001C7.87966 17.1312 7.74517 17.6721 7.60547 18.2328C8.16872 18.0924 8.70968 17.9577 9.24048 17.8251C8.82981 17.4157 8.42285 17.01 8.01193 16.6001Z"
                          fill="white"/>
                </svg>
                <span>Заявка на бесплатную консультацию</span>
            </button>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function my_admin_enqueue_scripts()
{

    wp_enqueue_script('my-admin-js', get_template_directory_uri() . '/source/js/acf-settings.js', array(), '1.0.0', true);

}

add_action('acf/input/admin_enqueue_scripts', 'my_admin_enqueue_scripts');

function getReviewsByParameters($pageID, $address, $otzovik, $offset = 0)
{
    $key = (get_post_type($pageID) === 'doctors') ? 'include_doctors' : 'include_pages';

    $args = array(
        'post_type' => 'reviews',
        'posts_per_page' => 1,
        'offset' => $offset,
        'meta_key' => 'data_reviews_date',
        'meta_query' => array(
            array(
                'relation' => 'AND',
                array(
                    'key' => $key,
                    'value' => $pageID,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'address',
                    'value' => $address
                ),
                array(
                    'key' => 'reviews_service',
                    'value' => $otzovik
                )
            ),
        ),
        'orderby' => 'meta_value_num',

    );

    return new WP_Query($args);

}

function getCountReviewsByParameters($pageID, $address, $otzovik)
{
    $key = (get_post_type($pageID) === 'doctors') ? 'include_doctors' : 'include_pages';
    $args = array(
        'post_type' => 'reviews',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'no_found_rows' => true,
        'meta_key' => 'data_reviews_date',
        'meta_query' => array(
            array(
                'relation' => 'AND',
                array(
                    'key' => $key,
                    'value' => $pageID,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'address',
                    'value' => $address
                ),
                array(
                    'key' => 'reviews_service',
                    'value' => $otzovik
                )
            ),
        ),
        'orderby' => 'meta_value_num',

    );
    $query = new WP_Query($args);

    return count($query->posts);

}

function getReviewsByDate($pageID, $address, $otzovik, $offset = 0)
{
    $key = (get_post_type($pageID) === 'doctors') ? 'include_doctors' : 'include_pages';

    $args = array(
        'post_type' => 'reviews',
        'posts_per_page' => 1,
        'offset' => $offset,
        'meta_key' => 'data_reviews_date',
        'meta_query' => array(
            array(
                'relation' => 'AND',
                array(
                    'key' => $key,
                    'value' => $pageID,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'address',
                    'value' => $address
                ),
                array(
                    'key' => 'reviews_service',
                    'value' => $otzovik
                )
            ),
        ),
        'orderby' => 'meta_value_num',

    );

    return new WP_Query($args);

}

function getWorksByParameters($metaKey = null, $metaValue = null)
{
    $args = array(
        'post_type' => 'works',
        'posts_per_page' => -1,
        'orderby' => 'date',
    );

    if ($metaKey === 'categories') {
        $args['meta_query'] = array(
            'relation' => 'OR',
            array(
                'relation' => 'AND',
                array(
                    'key' => 'categories',
                    'value' => $metaValue,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'categories',
                    'value' => ':',
                    'compare' => 'NOT LIKE',
                )
            ),
            array(
                'key' => 'categories',
                'value' => '"' . $metaValue . '"',
                'compare' => 'LIKE'
            ),
        );

    }
    if ($metaKey === 'doctor') {

        $args['meta_query'] = array(
            'relation' => 'OR',
            array(
                'relation' => 'AND',
                array(
                    'key' => 'doctor',
                    'value' => $metaValue,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'doctor',
                    'value' => ':',
                    'compare' => 'NOT LIKE',
                )
            ),
            array(
                'key' => 'doctor',
                'value' => '"' . $metaValue . '"',
                'compare' => 'LIKE'
            ),
        );
    }

    $works = get_posts($args);

    return $works;
}

function getWorksByMultiplyParameters($doctor = null, $category = null)
{
    $args = array(
        'post_type' => 'works',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'meta_query' => array(
            array(
                'relation' => 'AND',
            ),
        ),
    );
    if (strlen($category) > 0) {
        $args['meta_query'][][] = array(
            'key' => 'categories',
            'value' => $category,
            'compare' => 'LIKE'
        );
    }
    if (strlen($doctor) > 0) {
        $args['meta_query'][][] = array(
            'key' => 'doctor',
            'value' => $doctor,
            'compare' => 'LIKE'
        );
    }

    $works = get_posts($args);
    return $works;
}


add_filter( 'acf/fields/wysiwyg/toolbars' , 'dw_add_buttons_to_acf_wysiwyg_editor'  );
function dw_add_buttons_to_acf_wysiwyg_editor( $toolbars ){
    $toolbars['Full'][1][] = 'forecolor';
    $toolbars['Full'][1][] = '1111';

    return $toolbars;
}



function mytheme_change_tinymce_colors( $init ) {
    $default_colours = '
        "000000", "Черный",
        "FFFFFF", "Белый"
        ';
    $custom_colours = '
        "11BFF5", "Синий",
        "ff1944", "Красный",
        ';

    $init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']';
    $init['textcolor_rows'] = 6; // expand colour grid to 6 rows
    return $init;
}
add_filter('tiny_mce_before_init', 'mytheme_change_tinymce_colors');


add_action( 'after_setup_theme', 'arch_theme_setup' );
if ( ! function_exists( 'arch_theme_setup' ) ) {
    function arch_theme_setup(){
        add_action( 'init', 'arch_buttons' );
    }
}

if ( ! function_exists( 'arch_buttons' ) ) {
    function arch_buttons() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }
        add_filter( 'mce_external_plugins', 'arch_add_buttons' );
        add_filter( 'mce_buttons', 'arch_register_buttons' );
    }
}
if ( ! function_exists( 'arch_add_buttons' ) ) {
    function arch_add_buttons( $plugin_array ) {
        $plugin_array['archbtn'] = get_template_directory_uri() . '/source/js/shortcode_tmc.js';
        return $plugin_array;
    }
}
if ( ! function_exists( 'arch_register_buttons' ) ) {
    function arch_register_buttons( $buttons ) {
        array_push( $buttons, 'archbtn' );
        return $buttons;
    }
}

function phone_external( $atts ) {
    $phone = (get_field('fake_phone') || strlen(get_field('fake_phone')) > 0) ? get_field('fake_phone') : '+7 (3812) 38-26-06';
    $cleared_phone = str_replace(array(' ', '(', ')', '-'), '', $phone);

    $params = shortcode_atts(
        array( // в массиве укажите значения параметров по умолчанию
            'text' => $phone, // параметр 1
        ),
        $atts
    );
    return '<a href="tel:'.$cleared_phone.'" class="phone phone-in-text vi-black-pseudo">' . $params[ 'text' ] . '</a>';
}
add_shortcode( 'phone', 'phone_external' );