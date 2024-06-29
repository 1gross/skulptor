<?php get_header(); ?>
<main id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part('entry.php'); ?>
<?php comments_template(); ?>
<?php endwhile; endif; ?>
<?php get_template_part( 'nav-below.php', 'below' ); ?>
</main>
<?php get_footer(); ?>