<?php

/**
 * Block Name: Brands Marquee Block
 */

$block_id = 'brands-marquee-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'brands-marquee';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$pretitle = get_field('pretitle');
$title = get_field('title');
$logos = get_field('logos');

if (empty($logos) || !is_array($logos)) {
  return;
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <div class="brands-marquee__container">

    <?php if ($pretitle || $title) : ?>
      <div class="block-precontent mb30">

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
  </div>
  <div
    class="brands-marquee__track"
    data-fls-marquee
    data-fls-marquee-pause
    data-fls-marquee-speed="120"
    data-fls-marquee-space="36">

    <?php foreach ($logos as $item) :

      $image = $item['logo_image'] ?? null;
      $link  = $item['logo_link'] ?? null;

      if (!$image) {
        continue;
      }

      $image_url = $image['url'] ?? '';
      $image_alt = $image['alt'] ?? '';

      if (!$image_url) {
        continue;
      }

      $has_link = !empty($link['url']);
    ?>

      <?php if ($has_link) : ?>

        <a
          href="<?php echo esc_url($link['url']); ?>"
          class="brands-marquee__item"
          width="120"
          height="60"
          aria-label="<?php echo esc_attr($image_alt); ?>"
          <?php if (!empty($link['target'])) : ?>
          target="<?php echo esc_attr($link['target']); ?>"
          <?php endif; ?>>

          <img
            src="<?php echo esc_url($image_url); ?>"
            alt="<?php echo esc_attr($image_alt); ?>"
            loading="lazy">

        </a>

      <?php else : ?>

        <div class="brands-marquee__item" width="120" height="60">

          <img
            src="<?php echo esc_url($image_url); ?>"
            alt="<?php echo esc_attr($image_alt); ?>"
            loading="lazy">

        </div>

      <?php endif; ?>

    <?php endforeach; ?>

  </div>
</section>