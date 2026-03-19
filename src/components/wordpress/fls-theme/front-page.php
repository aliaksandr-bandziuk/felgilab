<? /* Template Name: index page template */ ?>
<? get_header() ?>
<main class="page">
  <div data-fls-index class="index">

    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>

    <section class="short-form">
      <div class="short-form__container">
        <div class="short-form__wrapper">
          <p class="title-lite text-center mb20">
            Chcesz taki efekt? Skontaktuj się z nami
          </p>
          <p class="text-center mb30">
            Skontaktujemy się z Tobą odraz po otrzymaniu wiadomości.
          </p>
          <form action="#" autocomplete="off" class="small-form">
            <div class="input-container">
              <input type="tel" name="phone" class="input-contact" />
              <label for="">привет</label>
              <span>привет</span>
            </div>
            <button type="submit" class="button-primary btn" aria-label="Wyślij">
              Otdzwonić
            </button>
          </form>
        </div>
      </div>
    </section>

  </div>
</main>
<? get_footer() ?>