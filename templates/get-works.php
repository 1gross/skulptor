<?php if ($args): ?>
    <div id="works" class="anchor"></div>
    <section class="works">
        <div class="wrapper">
            <h2 class="center"><blue>Примеры</blue> работ</h2>
            <?php foreach ($args as $work):
                $data = get_fields($work->ID);
                ?>
                <?php get_template_part('templates/get', 'work-item', array('id' => $work->ID,  'title'=>$work->post_title, 'description'=>$work->post_content, 'fields'=>$data)); ?>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
