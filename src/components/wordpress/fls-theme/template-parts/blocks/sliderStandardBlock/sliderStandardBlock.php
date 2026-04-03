<?php

/**
 * Slider Standard Block
 */

$pretitle    = get_field('pretitle');
$title       = get_field('title');
$slides      = get_field('slides');
$button_text = get_field('button_text');
$button_url  = get_field('button_url');

$block_id = 'slider-standard-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'services';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <div class="services__container">
    <?php if ($pretitle || $title) : ?>
      <div class="block-precontent mb50">
        <?php if ($pretitle) : ?>
          <p class="block-precontent__descr mb10">
            <?php echo esc_html($pretitle); ?>
          </p>
        <?php endif; ?>

        <?php if ($title) : ?>
          <h2 class="h2 block-precontent__title">
            <?php echo esc_html($title); ?>
          </h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($slides) && is_array($slides)) : ?>
      <div class="slider-block services-slider" data-fls-slider data-slider-type="services">
        <div class="slider-block__slider swiper">
          <div class="slider-block__wrapper swiper-wrapper">
            <?php foreach ($slides as $slide) : ?>
              <?php
              $service_id    = is_object($slide) ? $slide->ID : $slide;
              $service_title = get_the_title($service_id);
              $service_url   = get_permalink($service_id);
              $image_html = get_the_post_thumbnail(
                $service_id,
                'service-card',
                array(
                  'class'    => 'service-item__img',
                  'alt'      => esc_attr($service_title),
                  'loading'  => 'lazy',
                  'decoding' => 'async',
                  'sizes'    => '(max-width: 767px) 100vw, (max-width: 1200px) 50vw, 33vw',
                )
              );

              $excerpt = get_the_excerpt($service_id);

              if (empty($excerpt)) {
                $content = get_post_field('post_content', $service_id);
                $excerpt = wp_strip_all_tags(strip_shortcodes($content));
              }

              $excerpt = trim(preg_replace('/\s+/u', ' ', $excerpt));
              $excerpt = mb_strimwidth($excerpt, 0, 120, '...');
              ?>
              <a href="<?php echo esc_url($service_url); ?>" class="service-item swiper-slide">
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
            <?php endforeach; ?>
          </div>
        </div>

        <div class="slider-block__controls mt10">
          <button class="slider-block__button slider-block__button--prev" type="button" aria-label="<?php esc_attr_e('Poprzedni slajd', 'fls'); ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <polyline fill="none" stroke="#000" points="10 14 5 9.5 10 5"></polyline>
              <line fill="none" stroke="#000" x1="16" y1="9.5" x2="5" y2="9.52"></line>
            </svg>
          </button>

          <button class="slider-block__button slider-block__button--next" type="button" aria-label="<?php esc_attr_e('Następny slajd', 'fls'); ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <polyline fill="none" stroke="#000" points="10 5 15 9.5 10 14"></polyline>
              <line fill="none" stroke="#000" x1="4" y1="9.5" x2="15" y2="9.5"></line>
            </svg>
          </button>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($button_text && $button_url) : ?>
      <div class="service__button mt50">
        <a href="<?php echo esc_url($button_url); ?>" class="button-main main-btn">
          <div class="whatsapp-main__wrapper">
            <span class="whatsapp-main__text"><?php echo esc_html($button_text); ?></span>
            <span class="whatsapp-main__icon --icon-ico-triangle" aria-hidden="true"></span>
          </div>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>