<? /* Template Name: index page template */ ?>
<? get_header() ?>
<main class="page">
  <div data-fls-index class="index">

    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>

    <section class="cta-lite">
      <div class="cta-lite__container"></div>
    </section>

    <div class="section-book-appointment">
      <div class="uk-grid uk-grid-divider uk-flex-center uk-flex-middle" data-uk-grid="">
        <div class="uk-first-column">
          <div class="section-title"> <img src="assets/img/logo-icon.svg" alt="logo-icon">
            <h3 class="uk-h2">Schedule Our Expert <br> Visit Or Get A Quote</h3>
          </div>
        </div>
        <div>
          <div class="block-with-icon"><a class="block-with-icon__link" href="tel:8109204660">
              <div class="block-with-icon__icon"><img src="assets/img/ico-phone.png" alt="ico-phone"></div>
              <div class="block-with-icon__desc">
                <div class="block-with-icon__label">Schedule a Visit</div>
                <div class="block-with-icon__value">(810) 920-4660</div>
              </div>
            </a></div>
        </div>
        <div>
          <div class="block-with-icon"><a class="block-with-icon__link" href="mailto:repair@cardan.com">
              <div class="block-with-icon__icon"><img src="assets/img/ico-comments.png" alt="ico-comments"></div>
              <div class="block-with-icon__desc">
                <div class="block-with-icon__label">Need Help? Send us Email</div>
                <div class="block-with-icon__value">repair@cardan.com</div>
              </div>
            </a></div>
        </div>
      </div>
    </div>

  </div>
</main>
<? get_footer() ?>