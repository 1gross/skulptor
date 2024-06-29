<?php
add_action('wp_ajax_getReviewsByDate', 'getReviewsByDate_function');
add_action('wp_ajax_nopriv_getReviewsByDate', 'getReviewsByDate_function');


function getReviewsByDate_function()
{
    if (isset($_POST['offset']) && isset($_POST['id'])) {
        $offset = $_POST['offset'];

        $key = (get_post_type($_POST['id']) === 'doctors') ? 'include_doctors' : 'include_pages';

        $args = array(
            'post_type' => 'reviews',
            'post_status' => 'publish',
            'posts_per_page' => 10,
            'offset' => $offset,
            'meta_key' => 'data_reviews_date',
            'meta_query' =>  array(
                'key' => $key,
                'value' => '"'.$_POST['id'].'"',
                'compare' => 'LIKE'
            ),
            'orderby' => 'meta_value_num',

        );

        $reviews = new WP_Query($args);

        $otzoviki = get_fields('general', 'option');

        $reviewsArray = [];
        foreach ($reviews->posts as $review) {
            $reviewLink = get_permalink($review->ID);
            $reviewFields = get_fields($review->ID);

            $address = $reviewFields['address'];
            $addressName = ($address === 'marksa') ? 'Карла Маркса, 34' : '70 лет Октября, 20';
            $otzovik = $reviewFields['reviews_service'];

            $doctorsId = $reviewFields['include_doctors'];


            $logoOtzovik = esc_url(get_template_directory_uri()) . "/source/img/otzoviki/" . $otzovik . ".svg";

            $currentOtzovik = $otzoviki[$address][$otzovik];
            $currentCountReviews = getCountReviewsByParameters($_POST['id'], $address, $otzovik);

            $countString = num_word($currentCountReviews, array('отзыв', 'отзыва', 'отзывов'), true);

            $linkText = ($otzovik === 'gis' || $otzovik === 'pd') ? 'Смотреть все отзывы' : 'Смотреть отзыв на сайте-отзовике';
            $otzovLink = ($otzovik === 'gis' || $otzovik === 'pd') ? $currentOtzovik['link'] : $reviewFields['data_reviews']['link'];

            $text = $reviewFields['data_reviews']['text'];
            if (strlen($text) > 300) {
                $text = substr($text, 0, 300);
            }
            $reviewHTML = "<li class=\"review-item splide__slide\">
            <a href=\"{$currentOtzovik['link']}\" target='_blank' class=\"review-item-header\">
                <div class=\"logo {$otzovik}\"><img src='{$logoOtzovik}' alt=''></div>
                <div class=\"rating\">{$currentOtzovik['raiting']}</div>
                <div class=\"total\">{$countString}</div>
            </a>
            <div class=\"review-item-body\">
                <div class=\"review-name\">{$review->post_title}</div>
                <div class=\"review-date\">{$reviewFields['data_reviews']['date']}</div>
                <div class=\"review-rate {$reviewFields['data_reviews']['rating']}\"><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span></div>
                <a href=\"{$reviewLink}\" target='_blank' class=\"review-text\">{$text}</a>
                <a href=\"{$otzovLink}\" target='_blank' class='review-link'>{$linkText}</a>";

            if (count($doctorsId) > 0) {
                foreach ($doctorsId as $doctorId) {
                    $doctorPhoto = get_field('photo_thumb', $doctorId);
                    $doctorName = get_the_title($doctorId);
                    $doctorLink = get_permalink($doctorId);

                    $reviewHTML .= "<a href='{$doctorLink}' target='_blank' class='review-doc'>
                    <div class='doc-img' style=\"background-image: url('{$doctorPhoto}');\"></div>
                    <div class='doc-name'>{$doctorName}</div>
                </a>";
                }
            }
            $reviewHTML .= "<div class='address vi-black-pseudo'>{$addressName}</div></div></li>";
            $reviewsArray[] = $reviewHTML;
        }

        ?>

        <?php $return = array('reviews' => $reviewsArray, 'max' => $reviews->found_posts, 'isLast' => $offset + 10 > $reviews->found_posts);
        wp_send_json($return, 200);
    } else {
        wp_send_json('Ошибка', 400);
    }
}
