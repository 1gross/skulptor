<?php


$fields = get_fields();
$topBlock = $fields['top_block'];


$worksTemp = getWorksByParameters();
$works = array();
$categories = new stdClass();
$doctors = new stdClass();
foreach ($worksTemp as $work) {
    $data = get_fields($work->ID);
    foreach ($data['categories'] as $category) {
        $categories->{$category->ID} = $category->post_title;
    }
    foreach ($data['doctor'] as $doctor) {
        $doc_mame = explode(' ', $doctor->post_title);
        if (count($doc_mame) === 3) {
            $doc_mame = $doc_mame[0] . ' ' . mb_substr($doc_mame[1], 0, 1) . '. ' . mb_substr($doc_mame[2], 0, 1) . '.';

            $doctors->{$doctor->ID} = $doc_mame;
        }
    }


    $works['data'][] = array('post' => $work, 'fields' => $data);
}

if (isset($_GET['category']) && strlen($_GET['category']) > 0){
    if (isset($categories->{$_GET['category']})){
        $targetCategory = $_GET['category'];
        $worksByCategory = getWorksByParameters('categories', $_GET['category']);

        $works['data'] = [];

        foreach ($worksByCategory as $work) {
            $data = get_fields($work->ID);

            $works['data'][] = array('post' => $work, 'fields' => $data);
        }
    }

}
$works['doctors'] = $doctors;
$works['categories'] = $categories;

get_header();
?>
<?php get_template_part('templates/get-jumbotron.php', 'jumbotron', array('topBlock' => $topBlock)); ?>
<section class="works">
    <div class="wrapper">
        <h2 class="center"><blue>Примеры</blue> работ</h2>
        <div class="filters-block">
            <div class="filter-item">
                <div class="filter-title">Категория</div>
                <div class="form-control-select">
                    <select name="" id="category-select" data-current="">
                        <option value="" selected>Все категории</option>
                        <?php foreach ($works['categories'] as $id => $category): ?>
                            <option <?php echo (isset($targetCategory) && $targetCategory === $id) ? 'selected="selected"' : ''; ?> value="<?php echo $id; ?>"><?php echo $category; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="filter-item">
                <div class="filter-title">Доктор</div>
                <div class="form-control-select">
                    <select name="" id="doctor-select" data-current="">
                        <option value="" selected>Все доктора</option>
                        <?php foreach ($works['doctors'] as $id => $doctor): ?>
                            <option value="<?php echo $id; ?>"><?php echo $doctor; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div id="works-list">
            <?php
            if ($works) { ?>
                <?php foreach ($works['data'] as $work):
                    ?>
                    <?php get_template_part('templates/get-work-item.php', 'work-item', array('id' => $work['post']->ID, 'description' => $work['post']->post_content, 'fields' => $work['fields'])); ?>
                <?php endforeach; ?>
            <?php }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
<script>
    const doctorSelect = document.getElementById('doctor-select');
    const categorySelect = document.getElementById('category-select');

    function toggleSelect(el) {
        el.parentNode.classList.toggle('loading');
        el.disabled = !el.disabled;
    }
    categorySelect.addEventListener('change', function (e) {
        categorySelect.dataset.current = e.target.value;
        doctorSelect.value = '';
        toggleSelect(e.target);
        ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            data: {
                action: 'getFilters',
                chooseIdCategory: e.target.value,
            },
        }).then((response) => {
            document.getElementById('works-list').innerHTML = JSON.parse(response).html;
            toggleSelect(e.target);
            observeImage();
            pixelCompare(document.querySelectorAll("[data-pixelcompare]"));
            demoSlider(document.querySelectorAll('#works-list .demo-slider'));
        });
    });
    doctorSelect.addEventListener('change', function (e) {
        doctorSelect.dataset.current = e.target.value;
        categorySelect.value = '';
        toggleSelect(e.target);
        ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            data: {
                action: 'getFilters',
                chooseIdDoctor: e.target.value,
            },
        }).then((response) => {
            document.getElementById('works-list').innerHTML = JSON.parse(response).html;
            toggleSelect(e.target);
            observeImage();
            pixelCompare(document.querySelectorAll("[data-pixelcompare]"));
            demoSlider(document.querySelectorAll('#works-list .demo-slider'));
        });
    });

    pixelCompare(document.querySelectorAll("[data-pixelcompare]"));
    demoSlider(document.querySelectorAll('#works-list .demo-slider'));
</script>
<?php get_footer(); ?>
<?php get_template_part('templates/get-sticky-footer-panel.php', 'sticky-footer-panel'); ?>