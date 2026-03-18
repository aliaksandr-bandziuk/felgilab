<?php get_header(); ?>

<main class="portfolio-single">
  <div class="portfolio-single__container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="portfolio-entry">
          <h1><?php the_title(); ?></h1>

          <?php if (has_post_thumbnail()) : ?>
            <div class="portfolio-entry__image">
              <?php the_post_thumbnail('full'); ?>
            </div>
          <?php endif; ?>

          <div class="portfolio-entry__content">
            <?php the_content(); ?>
          </div>
        </article>
    <?php endwhile;
    endif; ?>
  </div>
</main>

<?php get_footer(); ?>