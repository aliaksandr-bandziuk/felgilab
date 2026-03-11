<?php

/**
 * Block Name: About Company Block
 */

$block_id = 'about-company-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'about-company';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$media_title = get_field('media_title');
$pretitle    = get_field('pretitle');
$title       = get_field('title');
$description = get_field('description');
$items       = get_field('items');

$static_media_image = '/wp-content/uploads/2026/03/rim-about-1.jpg';
$static_icon_image  = '/wp-content/uploads/2026/03/rim-service-icon.svg';
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <div class="about-company__container">
    <div class="about-company__wrapper">

      <div class="about-company__media">
        <div class="about-company__media-bg">
          <img src="<?php echo esc_url($static_media_image); ?>" alt="FelgiLab">
        </div>

        <div class="about-company__media-overlay"></div>

        <div class="about-company__media-content">
          <div class="about-company__icon">
            <img src="<?php echo esc_url($static_icon_image); ?>" alt="">
          </div>

          <?php if ($media_title) : ?>
            <h3 class="about-company__media-title">
              <?php echo wp_kses_post(nl2br($media_title)); ?>
            </h3>
          <?php endif; ?>
        </div>
      </div>

      <div class="about-company__content">

        <?php if ($pretitle) : ?>
          <p class="about-company__pretitle">
            <?php echo esc_html($pretitle); ?>
          </p>
        <?php endif; ?>

        <?php if ($title) : ?>
          <h2 class="about-company__title">
            <?php echo esc_html($title); ?>
          </h2>
        <?php endif; ?>

        <div class="about-company__divider mb30">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="8" aria-hidden="true">
            <path fill="#fd6b1c" d="M34 0h30v2H34zm0 6h15v2H34zM0 0h30v2H0zm15 6h15v2H15z" />
          </svg>
        </div>

        <?php if ($description) : ?>
          <p class="about-company__text">
            <?php echo esc_html($description); ?>
          </p>
        <?php endif; ?>

        <?php if ($items) : ?>
          <div class="about-company__list">
            <?php
            $number = 1;
            foreach ($items as $item) :
              $item_image = $item['image'] ?? '';
              $item_title = $item['title'] ?? '';
              $item_text  = $item['text'] ?? '';
              $image_url  = !empty($item_image['url']) ? $item_image['url'] : '';
              $image_alt  = !empty($item_image['alt']) ? $item_image['alt'] : $item_title;
            ?>
              <div class="about-company__item">
                <div class="about-company__item-icon">
                  <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                  <?php endif; ?>
                </div>

                <div class="about-company__item-content">
                  <?php if ($item_title) : ?>
                    <h3><?php echo esc_html($item_title); ?></h3>
                  <?php endif; ?>

                  <?php if ($item_text) : ?>
                    <p><?php echo esc_html($item_text); ?></p>
                  <?php endif; ?>
                </div>

                <span class="about-company__number"><?php echo esc_html($number); ?></span>
              </div>
            <?php
              $number++;
            endforeach;
            ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <div class="about-company__shape">
    <svg viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
      <path d="M0 40L500 70L1000 100L1440 40V120H0Z" fill="#f3f3f3" />
    </svg>
  </div>
</section>