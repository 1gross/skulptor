<?php get_header(); ?>
    <main>
        <div class="wrapper">
            <div class="simple-page">
                <h1><?php the_title(); ?></h1>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </main>
<?php get_footer(); ?>