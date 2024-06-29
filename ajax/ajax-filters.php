<?php
add_action('wp_ajax_getFilters', 'getFilters_function');
add_action('wp_ajax_nopriv_getFilters', 'getFilters_function');


function getFilters_function()
{

    if (isset($_POST['chooseIdDoctor']) || isset($_POST['chooseIdCategory'])) {
        if (isset($_POST['chooseIdDoctor'])) {
            if (strlen($_POST['chooseIdDoctor']) === 0){
                $works = getWorksByParameters();
            } else {
                $works = getWorksByParameters('doctor', $_POST['chooseIdDoctor']);
            }

        }
        if (isset($_POST['chooseIdCategory'])) {
            if (strlen($_POST['chooseIdCategory']) === 0){
                $works = getWorksByParameters();
            } else {
                $works = getWorksByParameters('categories', $_POST['chooseIdCategory']);
            }

        }

        $workshtml = '';
        ob_start();
        foreach ($works as $work) {
            $data = get_fields($work->ID);
            get_template_part('templates/get', 'work-item', array('id' => $work->ID, 'title' => $work->post_title, 'description' => $work->post_content, 'fields' => $data));
        }
        $workshtml = ob_get_contents();
        ob_end_clean();
        wp_send_json(array('html' => $workshtml), 200);
    }
}
