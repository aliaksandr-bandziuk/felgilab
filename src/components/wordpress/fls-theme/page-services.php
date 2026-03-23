<?php
/*
Template Name: Page Services
Template Post Type: page
*/
get_header();

$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

// Тексты интерфейса
switch ($current_lang) {
  case 'pl':
    $empty_label = 'Nie znaleziono usług.';
    break;

  case 'ru':
    $empty_label = 'Услуги не найдены.';
    break;

  case 'uk':
    $empty_label = 'Послуги не знайдено.';
    break;

  case 'en':
  default:
    $empty_label = 'No services found.';
    break;
}
?>

<main class="page">
  <section class="standard-hero">
    <div class="main-hero__media">
      <div class="main-hero__image">
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

  <section class="services services-archive">
    <div class="services__container">
      <div class="services-grid">
        <?php
        $args = [
          'post_type'        => 'services',
          'posts_per_page'   => -1,
          'post_status'      => 'publish',
          'post_parent'      => 0, // только родительские услуги
          'orderby'          => 'date',
          'order'            => 'DESC',
          'suppress_filters' => false,
        ];

        if (!empty($current_lang)) {
          $args['lang'] = $current_lang;
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) :
          while ($query->have_posts()) :
            $query->the_post();

            $service_id    = get_the_ID();
            $service_title = get_the_title($service_id);
            $service_url   = get_permalink($service_id);

            $image_html = get_the_post_thumbnail(
              $service_id,
              'large',
              [
                'class'   => 'service-item__img',
                'alt'     => esc_attr($service_title),
                'loading' => 'lazy',
              ]
            );

            $excerpt = get_the_excerpt($service_id);

            $excerpt = get_the_excerpt($service_id);

            if (empty($excerpt)) {
              $content = get_post_field('post_content', $service_id);
              $excerpt = wp_strip_all_tags(strip_shortcodes($content));
            }

            // обрезка до 120 символов
            $excerpt = mb_strimwidth($excerpt, 0, 120, '...');
        ?>
            <a href="<?php echo esc_url($service_url); ?>" class="service-item services-grid__item">
              <?php if ($image_html) : ?>
                <div class="service-item__image">
                  <?php echo $image_html; ?>
                </div>
              <?php endif; ?>

              <div class="service-item__content">
                <?php if ($service_title) : ?>
                  <p class="service-item__title">
                    <?php echo esc_html($service_title); ?>
                  </p>
                <?php endif; ?>

                <?php if ($excerpt) : ?>
                  <p class="service-item__descr">
                    <?php echo esc_html($excerpt); ?>
                  </p>
                <?php endif; ?>
              </div>
            </a>
        <?php
          endwhile;
        else :
          echo '<p>' . esc_html($empty_label) . '</p>';
        endif;

        wp_reset_postdata();
        ?>
      </div>
    </div>
  </section>

  <?php if (get_the_content()) : ?>
    <section class="services-page-content mb60">
      <div class="services-page-content__container">
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
</main>

<?php get_footer(); ?>