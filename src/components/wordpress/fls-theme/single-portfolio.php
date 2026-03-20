<?php

get_header();

// Получаем текущий язык через Polylang
$current_lang = pll_current_language();
?>


<main class="page">
  <section
    class="standard-hero">
    <div class="main-hero__media">
      <div class="main-hero__image">
        <!-- featured image -->
        <?php
        if (has_post_thumbnail()) {
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
          $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
        } else {
          $image_url = '';
          $image_alt = '';
        }
        ?>
        <img
          src="<?php echo esc_url($image_url); ?>"
          alt="<?php echo esc_attr($image_alt); ?>"
          class="main-hero__img">
      </div>
    </div>

    <div class="main-hero__body">
      <div class="main-hero__container">
        <div class="main-hero__content">

          <div class="breadcrumbs" aria-label="Breadcrumb">
            <?php custom_breadcrumbs(); ?>
          </div>

          <h1 class="main-hero__title">
            <?php the_title(); ?>
          </h1>
          <span class="--icon-decor-double-line-white main-hero__decor" aria-hidden="true"></span>
        </div>
      </div>
    </div>
  </section>

  <section class="portfolio-data">
    <div class="portfolio-data__container">
      <?php
      $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';

      // Переводы меток
      switch ($current_lang) {
        case 'en':
          $car_label          = 'Car';
          $diameter_label     = 'Wheel diameter';
          $color_label        = 'Color';
          $service_label      = 'Service';
          $similar_title      = 'Similar topics';
          $read_more_text     = 'Read more';
          $no_image_alt       = 'Preview image';
          $effekt_label       = 'Effect';
          break;

        case 'ru':
          $car_label          = 'Автомобиль';
          $diameter_label     = 'Диаметр диска';
          $color_label        = 'Цвет';
          $service_label      = 'Услуга';
          $similar_title      = 'Похожие материалы';
          $read_more_text     = 'Читать далее';
          $no_image_alt       = 'Изображение превью';
          $effekt_label       = 'Эффект';
          break;

        case 'uk':
          $car_label          = 'Автомобіль';
          $diameter_label     = 'Діаметр диска';
          $color_label        = 'Колір';
          $service_label      = 'Послуга';
          $similar_title      = 'Схожі матеріали';
          $read_more_text     = 'Читати далі';
          $no_image_alt       = 'Зображення прев’ю';
          $effekt_label       = 'Ефект';
          break;

        case 'pl':
        default:
          $car_label          = 'Samochód';
          $diameter_label     = 'Średnica felgi';
          $color_label        = 'Kolor';
          $service_label      = 'Usługa';
          $similar_title      = 'Podobne tematy';
          $read_more_text     = 'Czytaj więcej';
          $no_image_alt       = 'Miniatura';
          $effekt_label       = 'Efekt';
          break;
      }

      // Получаем новые метаполя
      $car_name     = trim(get_post_meta(get_the_ID(), '_portfolio_car_name', true));
      $rim_diameter = trim(get_post_meta(get_the_ID(), '_portfolio_rim_diameter', true));
      $rim_color    = trim(get_post_meta(get_the_ID(), '_portfolio_rim_color', true));
      $service_name = trim(get_post_meta(get_the_ID(), '_portfolio_service_name', true));

      if ($car_name || $rim_diameter || $rim_color || $service_name) :
      ?>


        <div class="portfolio-data__wrapper mb60">
          <?php if ($car_name) : ?>
            <div class="portfolio-bullet">
              <div class="portfolio-bullet__top">
                <p><?php echo esc_html($car_label); ?></p>
              </div>
              <div class="portfolio-bullet__bottom">
                <p><?php echo esc_html($car_name); ?></p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($rim_diameter) : ?>
            <div class="portfolio-bullet">
              <div class="portfolio-bullet__top">
                <p><?php echo esc_html($diameter_label); ?></p>
              </div>
              <div class="portfolio-bullet__bottom">
                <p><?php echo esc_html($rim_diameter); ?></p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($rim_color) : ?>
            <div class="portfolio-bullet">
              <div class="portfolio-bullet__top">
                <p><?php echo esc_html($color_label); ?></p>
              </div>
              <div class="portfolio-bullet__bottom">
                <p><?php echo esc_html($rim_color); ?></p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($service_name) : ?>
            <div class="portfolio-bullet">
              <div class="portfolio-bullet__top">
                <p><?php echo esc_html($service_label); ?></p>
              </div>
              <div class="portfolio-bullet__bottom">
                <p><?php echo esc_html($service_name); ?></p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (has_excerpt()) : ?>
        <div class="wide-excerpt mb60">
          <p><b><?php echo esc_html($effekt_label); ?>:</b> <?php echo get_the_excerpt(); ?></p>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <?php while (have_posts()) : the_post(); ?>
    <div class="entry-content mb60">
      <?php the_content(); ?>
    </div>
  <?php endwhile; ?>

</main>

<?php get_footer(); ?>