<?php
$list = get_field('legal_list');

get_header(); ?>
    <main>
        <div class="wrapper">
            <div class="simple-page legal">
                <h1><?php the_title(); ?></h1>
                <ul>
                    <?php foreach ($list as $i => $item): ?>
                        <li>
                            <a class="document-link" data-fancybox="gallery-<?php echo $i; ?>" href="<?php echo $item['document'] ?>"><?php echo $item['title'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>
<?php get_footer(); ?>

<script>
    // Customization example
    Fancybox.bind('[data-fancybox="gallery"]', {
        infinite: false
    });
</script>
