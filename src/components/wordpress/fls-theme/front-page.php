<? /* Template Name: index page template */ ?>
<? get_header() ?>
<main class="page">
  <div data-fls-index class="index">

    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>

    <section class="before-after">
      <div class="before-after__container">
        <div data-fls-beforeafter class="before-after">
          <div data-fls-beforeafter-before class="before-after__item">
            <img src="/wp-content/uploads/2026/03/old-rim.jpg" alt="Felga przed renowacją">
          </div>
          <div data-fls-beforeafter-after class="before-after__item">
            <img src="/wp-content/uploads/2026/03/rewiew-9-2.jpg" alt="Felga po renowacji">
          </div>
          <div data-fls-beforeafter-arrow class="before-after__arrow"></div>
        </div>
      </div>
    </section>

  </div>
</main>
<? get_footer() ?>