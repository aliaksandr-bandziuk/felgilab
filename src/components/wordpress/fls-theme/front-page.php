<? /* Template Name: index page template */ ?>
<? get_header() ?>
<main class="page">
  <div data-fls-index class="index">

    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>

    <section class="gigits">
      <div class="gigits__container">
        <div class="gigits__items">
          <div class="gigits__wrapper">
            <div class="gigit-item">
              <div class="gigit-item__wrapper">
                <div class="gigit-item__counter">
                  <p class="counter">
                    <span class="counter__value">99</span>%
                  </p>
                </div>
                <div class="gigit-item__content">
                  <p class="gigit-item__title">Accuracy</p>
                  <p class="gigit-item__text">Laser scanning with sub-millimeter precision.</p>
                </div>
              </div>
            </div>
            <div class="gigit-item">
              <div class="gigit-item__wrapper">
                <div class="gigit-item__counter">
                  <p class="counter">
                    <span class="counter__value">48</span>
                  </p>
                </div>
                <div class="gigit-item__content">
                  <p class="gigit-item__title">Hours Turnaround</p>
                  <p class="gigit-item__text">From data capture to delivery in record time.</p>
                </div>
              </div>
            </div>
            <div class="gigit-item">
              <div class="gigit-item__wrapper">
                <div class="gigit-item__counter">
                  <p class="counter">
                    <span class="counter__value">30</span>%
                  </p>
                </div>
                <div class="gigit-item__content">
                  <p class="gigit-item__title">Cost Savings</p>
                  <p class="gigit-item__text">Reducing project expenses with efficient and innovative solutions.</p>
                </div>
              </div>
            </div>
            <div class="gigit-item">
              <div class="gigit-item__wrapper">
                <div class="gigit-item__counter">
                  <p class="counter">
                    <span class="counter__value">100</span>+
                  </p>
                </div>
                <div class="gigit-item__content">
                  <p class="gigit-item__title">Satisfied Clients</p>
                  <p class="gigit-item__text">Delivering measurable results for businesses worldwide.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</main>
<? get_footer() ?>