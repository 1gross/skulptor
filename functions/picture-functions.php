<?php 
/**
 * Генерирует webp копии изображений сразу после загрузки изображения в медиабиблиотеку
 * 
 * - новые файлы сохраняет с именем name.ext.webp, например, thumb.jpg.webp
 */
function gt_webp_generation($metadata) {
	$uploads = wp_upload_dir(); // получает папку для загрузки медиафайлов
	$file = $uploads['basedir'] . '/' . $metadata['file']; // получает исходный файл
    $tempFile = explode("/", $metadata['file']);
	$ext = wp_check_filetype($file); // получает расширение файла
	if ( $ext['type'] == 'image/jpeg' ) { // в зависимости от расширения обрабатаывает файлы разными функциями
		$image = imagecreatefromjpeg($file); // создает изображение из jpg
	} elseif ( $ext['type'] == 'image/png' ){
		$image = imagecreatefrompng($file); // создает изображение из png
		imagepalettetotruecolor($image); // восстанавливает цвета
		imagealphablending($image, false); // выключает режим сопряжения цветов
		imagesavealpha($image, true); // сохраняет прозрачность
	}
	if ($ext['type'] == 'image/jpeg' ||  $ext['type'] == 'image/png'){
        imagewebp($image, $uploads['basedir'] . '/' . $metadata['file'] . '.webp', 90); // сохраняет файл в webp
    }

	foreach ($metadata['sizes'] as $size) { // перебирает все размеры файла и также сохраняет в webp
        $file = $uploads['basedir'] . '/' . $tempFile[0] . '/' . $tempFile[1] . '/' . $size['file'];
        $ext = wp_check_filetype($file);
		if ( $ext['type'] == 'image/jpeg' ) {
			$image = imagecreatefromjpeg($file);
		} elseif ( $ext['type'] == 'image/png' ){
			$image = imagecreatefrompng($file);
			imagepalettetotruecolor($image);
			imagealphablending($image, false);
			imagesavealpha($image, true);
		}
        if ($ext['type'] == 'image/jpeg' ||  $ext['type'] == 'image/png'){
            imagewebp($image, $file . '.webp', 90); // сохраняет файл в webp
        }
	}

	return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'gt_webp_generation');

/**
 * Выводит тег picture с нужными размерами и расширениями по ссылке на файл
 *
 * - если рядом с файлом лежит его webp копия, то выведет ссылку и на него
 * - webp должен иметь расширение на конце file.jpg.webp и лежать рядом с файлов в wp-content/...
 *
 * Примеры использования:
 * - <?php gt_picture('../menu.png', 'class__pic', 'меню ресторана'); ?>
 *
 * @param 	string $img 	ссылка на изображение
 * @param  	string $class 	класс к picture
 * @param  	string $alt 	alt к img
 */
function gt_picture($img, $class = '', $alt = ''){
	$explodedName = explode('/', $img);
	$name = $explodedName[count($explodedName)-1]; // имя файла

	$ext = 'image/' . explode('.', $name)[1]; // расширение файла

	$webp_check_url = get_site_url() . '/wp-content' . explode('wp-content', $img)[1] . '.webp';
	?>
	<picture class="<?php echo $class; ?>">

		<?php if (does_url_exists($webp_check_url)): // проверяет наличие webp копии ?>
			  <source srcset="<?php echo $img; ?>.webp" type="image/webp">
		<?php endif ?>

		  <source srcset="<?php echo $img; ?>" type="<?php echo $ext; ?>">
		  <img src="<?php echo $img; ?>" alt="<?php echo $alt; ?>">
	</picture>

	<?php
}

function does_url_exists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}