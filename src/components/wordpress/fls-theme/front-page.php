<? /* Template Name: index page template */ ?>
<? get_header() ?>
<main class="page">
  <div data-fls-index class="index">

    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>

  </div>
</main>
<? get_footer() ?>