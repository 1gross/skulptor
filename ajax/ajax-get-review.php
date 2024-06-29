<?php
add_action('wp_ajax_getReview', 'getReview_function');
add_action('wp_ajax_nopriv_getReview', 'getReview_function');


function getReview_function()
{
    if (isset($_POST['address']) && isset($_POST['otzovik']) && isset($_POST['page']) && isset($_POST['id'])) {
        $reviews = getReviewsByParameters($_POST['id'], $_POST['address'], $_POST['otzovik'], $_POST['page']);

        $reviewFields = get_fields($reviews->posts[0]->ID);
        $review = '';

        $review .= '<div class="info">';
        $review .= '<div class="date">' . $reviewFields['data_reviews']['date'] . '</div>';
        $review .= '<div class="rate ' . $reviewFields['data_reviews']['rating'] . '"><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span></div>';
        $review .= '<a href="' . $reviewFields['data_reviews']['link'] . '" target="_blank">Посмотреть отзыв на сайте</a>';
        $review .= '</div>';
        $review .= '<div class="text"><div class="author">Автор: ' . $reviews->posts[0]->post_title . '</div>' . $reviewFields['data_reviews']['text'] . '</div>';
        ?>

        <?php $return = array(
            'review' => $review,
            'isLast' => ($_POST['page'] + 1 === $reviews->found_posts)
        );
        wp_send_json($return, 200);
    } else {
        wp_send_json('Ошибка', 400);
    }
}
