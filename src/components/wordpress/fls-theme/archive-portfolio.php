<?php get_header(); ?>

<main class="portfolio-archive">
  <div class="portfolio-archive__container">
    <?php if (have_posts()) : ?>
      <div class="portfolio-archive__grid">
        <?php while (have_posts()) : the_post(); ?>
          <article class="portfolio-card">
            <a href="<?php the_permalink(); ?>" class="portfolio-card__link">
              <?php if (has_post_thumbnail()) : ?>
                <div class="portfolio-card__image">
                  <?php the_post_thumbnail('large'); ?>
                </div>
              <?php endif; ?>

              <h2 class="portfolio-card__title"><?php the_title(); ?></h2>

              <?php if (has_excerpt()) : ?>
                <div class="portfolio-card__excerpt">
                  <?php the_excerpt(); ?>
                </div>
              <?php endif; ?>
            </a>
          </article>
        <?php endwhile; ?>
      </div>

      <?php the_posts_pagination(); ?>
    <?php else : ?>
      <p>No portfolio items found.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>