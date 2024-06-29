<?php
add_action('wp_ajax_getWorksByPost', 'getWorksByPost_function');
add_action('wp_ajax_nopriv_getWorksByPost', 'getWorksByPost_function');


function getWorksByPost_function()
{

    if (isset($_POST['offset']) && isset($_POST['postId'])) {
        $works = get_field('work_examples', $_POST['postId']);
        $work = $works[$_POST['offset']];
        $workhtml = '';
        ob_start();
            $data = get_fields($work->ID);
            get_template_part('templates/get', 'work-item', array('id' => $work->ID, 'title' => $work->post_title, 'description' => $work->post_content, 'fields' => $data));
        $workhtml = ob_get_contents();
        ob_end_clean();

        wp_send_json(array('html' => $workhtml, 'isLast' => ($_POST['offset'] + 1 >= count($works) ? true : false)), 200);
    }
}
