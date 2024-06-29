
<div class="work-item">
    <?php if (isset($args['fields']['work_title'])): ?>
    <div class="work-item-category">
        <?php echo $args['fields']['work_title']; ?>
    </div>
    <?php endif; ?>
    <div class="work-item-title">
        <?php if ($args['fields']['categories']): ?>
            <?php foreach ($args['fields']['categories'] as $category) { ?>
                <span><?php echo $category->post_title . '. '; ?></span>
            <?php } ?>
        <?php endif; ?>
    </div>
    <?php if ($args['fields']['doctor']): ?>
        <div class="work-item-doctor">
            <?php
            $doc_mames = '';
            foreach ($args['fields']['doctor'] as $id => $doctor){
                $doc_mame = explode(' ', $doctor->post_title);
                if (count($doc_mame) === 3) {
                    $doc_mames .= (($id > 0) ? ', ' : '') . $doc_mame[0] . ' ' . mb_substr($doc_mame[1], 0, 1) . '. ' . mb_substr($doc_mame[2], 0, 1) . '.';
                }
            }

            echo 'Врач: ' . $doc_mames;
            ?>
        </div>
    <?php endif; ?>
    <div class="work-item-description"><?php echo $args['description']; ?></div>
    <?php if ($args['fields']['gallery']): ?>
    <?php foreach ($args['fields']['gallery'] as $key => $gallery): ?>
    <?php if ($gallery['type'] === "compare"): ?>
        <div class="compare-slider">
            <div class="pixelcompare" data-pixelcompare="">
                <img class="l-load-bg" alt="<?php echo get_post_meta($gallery['compareSlider']['photo1'], '_wp_attachment_image_alt', true) ?>" data-image="<?php echo wp_get_attachment_image_src($gallery['compareSlider']['photo1'], 'large')[0]; ?>" width="100%">
                <img class="l-load-bg" alt="<?php echo get_post_meta($gallery['compareSlider']['photo2'], '_wp_attachment_image_alt', true) ?>" data-image="<?php echo wp_get_attachment_image_src($gallery['compareSlider']['photo2'], 'large')[0]; ?>" width="100%">
            </div>
        </div>
    <?php endif; ?>
    <?php if ($gallery['type'] === "demo"): ?>
    <div class="demo-slider">
        <div class="main-photo">
            <div class="lazy-image l-load-bg loading"
                 data-image="<?php echo wp_get_attachment_image_src($gallery['demoSlider'][0]['image'], 'medium')[0]; ?>"
                 data-alt="<?php echo get_post_meta($gallery['demoSlider'][0]['image'], '_wp_attachment_image_alt', true) ?>"></div>
            <a class="fancy-link" href="<?php echo wp_get_attachment_image_url($gallery['demoSlider'][0]['image'], 'full'); ?>" data-fancybox="demo-slider-<?php echo $args['id'] . '-'. $key; ?>"></a>
        </div>
        <div class="thumbs">
            <?php foreach ($gallery['demoSlider'] as $i => $slide): ?>
            <div class="thumb-item <?php echo ($i === 0) ? 'active' : ''; ?>" data-alt="<?php echo get_post_meta($gallery['compareSlider']['photo1'], '_wp_attachment_image_alt', true) ?>" data-image-thumb="<?php echo wp_get_attachment_image_url($slide['image'], 'medium'); ?>" data-image-full="<?php echo wp_get_attachment_image_url($slide['image'], 'full'); ?>"">
            <div class="thumb-img">
                <div class="lazy-image l-load-bg loading"
                     data-image="<?php echo wp_get_attachment_image_src($slide['image'], 'thumbnail')[0]; ?>"
                     data-alt="<?php echo get_post_meta($slide['image'], '_wp_attachment_image_alt', true) ?>"></div>
            </div>
            <?php if ($slide['image_caption']): ?>
                <div class="thumb-caption"><?php echo $slide['image_caption']; ?></div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
</div>