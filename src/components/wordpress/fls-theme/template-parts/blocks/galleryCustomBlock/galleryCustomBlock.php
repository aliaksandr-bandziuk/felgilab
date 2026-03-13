<?php
$pretitle = get_field('pretitle') ?: '';
$title    = get_field('title') ?: '';
$button   = get_field('button');

$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

$gallery_i18n = [
  'zoom' => [
    'pl' => 'Zoom',
    'en' => 'Zoom',
    'ru' => 'Увеличить',
    'uk' => 'Збільшити',
  ],
];

$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$items_per_tab = 6;

/**
 * Render one gallery item
 */
if (!function_exists('felgilab_render_gallery_block_item')) {
  function felgilab_render_gallery_block_item($post_id, $zoom_text)
  {
    $thumbnail_id = get_post_thumbnail_id($post_id);

    if (!$thumbnail_id) {
      return;
    }

    $image_full  = wp_get_attachment_image_url($thumbnail_id, 'full');
    $image_large = wp_get_attachment_image_url($thumbnail_id, 'large');
    $image_alt   = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

    if (!$image_alt) {
      $image_alt = get_the_title($post_id);
    }

    if (!$image_full || !$image_large) {
      return;
    }
?>
    <a href="<?php echo esc_url($image_full); ?>" class="gallery__item">
      <span class="button-main main-btn gallery-zoom-btn" aria-hidden="true">
        <span class="whatsapp-main__wrapper">
          <span class="whatsapp-main__text">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" id="Search" height="24" width="24">
              <path stroke="#ffffff" d="M18.425 18.425 23.5 23.5m-12.5 -2C5.201 21.5 0.5 16.799 0.5 11S5.201 0.5 11 0.5 21.5 5.201 21.5 11 16.799 21.5 11 21.5Z" stroke-width="1"></path>
            </svg>
          </span>
        </span>
      </span>
      <img
        src="<?php echo esc_url($image_large); ?>"
        alt="<?php echo esc_attr($image_alt); ?>"
        loading="lazy"
        decoding="async">
    </a>
<?php
  }
}

$brands = get_terms([
  'taxonomy'   => 'car_brand',
  'hide_empty' => true,
  'orderby'    => 'name',
  'order'      => 'ASC',
]);

$tabs_data = [];

if (!empty($brands) && !is_wp_error($brands)) {
  $all_gallery_items = get_posts([
    'post_type'              => 'gallery_item',
    'post_status'            => 'publish',
    'numberposts'            => -1,
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'suppress_filters'       => false,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'fields'                 => 'ids',
  ]);

  if (!empty($all_gallery_items)) {
    $brands_map = [];
    foreach ($brands as $brand) {
      $brands_map[$brand->term_id] = [
        'term'  => $brand,
        'items' => [],
      ];
    }

    foreach ($all_gallery_items as $post_id) {
      if (!has_post_thumbnail($post_id)) {
        continue;
      }

      $post_terms = get_the_terms($post_id, 'car_brand');
      if (empty($post_terms) || is_wp_error($post_terms)) {
        continue;
      }

      foreach ($post_terms as $term) {
        if (!isset($brands_map[$term->term_id])) {
          continue;
        }

        if (count($brands_map[$term->term_id]['items']) >= $items_per_tab) {
          continue;
        }

        $brands_map[$term->term_id]['items'][] = $post_id;
      }
    }

    foreach ($brands_map as $brand_data) {
      if (!empty($brand_data['items'])) {
        $tabs_data[] = $brand_data;
      }
    }
  }
}
?>

<?php if (!empty($tabs_data)) : ?>
  <section class="main-gallery">
    <div class="main-gallery__container">
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

      <div data-fls-tabs data-fls-tabs-animate="500" class="tabs gallery-tabs">
        <nav data-fls-tabs-titles class="tabs__navigation gallery-tabs__navigation" aria-label="Gallery Tabs Navigation">
          <?php foreach ($tabs_data as $index => $tab) : ?>
            <button
              type="button"
              aria-label="<?php echo esc_attr($tab['term']->name); ?>"
              class="tabs__title gallery-tabs__title <?php echo $index === 0 ? '--tab-active' : ''; ?>">
              <?php echo esc_html($tab['term']->name); ?>
            </button>
          <?php endforeach; ?>
        </nav>

        <div data-fls-tabs-body class="tabs__content">
          <?php foreach ($tabs_data as $tab) : ?>
            <div class="tabs__body gallery-tabs__body">
              <div class="tab-gallery">
                <div class="gallery" data-fls-gallery>
                  <?php foreach ($tab['items'] as $post_id) : ?>
                    <?php felgilab_render_gallery_block_item($post_id, $gallery_i18n['zoom'][$lang]); ?>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <?php if (!empty($button['url']) && !empty($button['title'])) : ?>
        <div class="service__button mt50">
          <a
            href="<?php echo esc_url($button['url']); ?>"
            target="<?php echo esc_attr(!empty($button['target']) ? $button['target'] : '_self'); ?>"
            class="button-main main-btn">
            <span class="whatsapp-main__wrapper">
              <span class="whatsapp-main__text"><?php echo esc_html($button['title']); ?></span>
              <span class="whatsapp-main__icon --icon-ico-triangle" aria-hidden="true"></span>
            </span>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>