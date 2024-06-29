<?php
add_action('wp_ajax_sendForm', 'sendForm_function');
add_action('wp_ajax_nopriv_sendForm', 'sendForm_function');

function sendForm_function()
{
    $onlyNums = preg_replace("/[^0-9]/", '', $_POST['phone']);

    if (isset($_POST['title']) && strlen($onlyNums) === 11 && isset($_POST['token'])) {

        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6Lej_50lAAAAANDzcDaguTfR7t-OWdSgBSyseBgw';
        $recaptcha_response = $_POST['token'];

        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);

        $recaptcha = json_decode($recaptcha);

        if ($recaptcha->success == true && $recaptcha->score >= 0.5 && $recaptcha->action == 'submit') {
            $phone = '+'.str_replace(array('(', ')', ' ', '-'), "", $_POST['phone']);
            $titlePage = get_the_title(url_to_postid(wp_get_referer()));
            $titlePage = (strlen($titlePage) > 0 ? $titlePage : 'Сайт');
            include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/skulptor/amo/create_lead.php';
            $amoResponseStatus = '🟢 Успешно доставлено!';
            try {
                $amoCrm = new AmoCRM();
                $lead_data = array();

                $lead_data['NAME'] =  'Контакт Без имени';
                $lead_data['PHONE'] =  $phone;

                $lead_data['LEAD_NAME'] = $_POST['title'] . ' ('.$titlePage.')';
                $amoCrm->add_lead($lead_data);
            } catch (Exception $e) {
                $amoResponseStatus = '🔴 Произошла ошибка! ' . $e->getMessage();
            }


            $chat_name = "-1002150857517";
            $token = "7181824181:AAFtN3HoOCmmy7MFv-OBlcCotoYXfvY5bnU";
            $message = "<b>✍️ Форма:</b> " . $_POST['title'] . "\n\n" . "<b>📞Телефон:</b> " . $_POST['phone'] . "\n\n" . "<b>📶Статус доставки:</b> " . $amoResponseStatus . "\n\n" . "<i>🔗Страница:</i> " . "<a href='".wp_get_referer()."'>".$titlePage."</a>" . "\n\n";

            $text = urlencode($message);
            $url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_name}&text={$text}&parse_mode=html";

            $ch = curl_init();
            $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
            );
            curl_setopt_array($ch, $optArray);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result);

            if ($result->ok) {
                status_header(200);
            } else {
                status_header(400);
            }

//           include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/skulptor/amo/create_lead.php';
//
//           $amoCrm = new AmoCRM();
//           $lead_data = array();
//
//           $lead_data['NAME'] =  'Контакт Без имени';
//           $lead_data['PHONE'] =  $phone;
//
//           $lead_data['LEAD_NAME'] = 'Обратный звонок с сайта';
//
//           $amoCrm->add_lead($lead_data);
//
//           $multiple_to_recipients = array(
//               'mailskulptor@gmail.com',
//               'i.temkin@mail.ru',
//               'skulptorlb@mail.ru',
//               'viktorgrosss@yandex.ru'
//           );
//           $headers = array('Content-Type: text/html; charset=UTF-8');
//
//           add_filter('wp_mail_content_type', function( $content_type ) {
//               return 'text/html';
//           });
//
//           $text = '<h1>'.$_POST['title'].'</h1>';
//
//           $text .= '<b>Телефон: </b>' . $_POST['phone'] . '<br>';
//
//           if (wp_mail( $multiple_to_recipients, 'Форма', $text, $headers )){
//               status_header(200);
//           } else {
//               status_header(400);
//           }
//
//           remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
//
//           function set_html_content_type() {
//               return 'text/html';
//           }
        } else {
            status_header(400);
        }

        wp_die();
    }
}
