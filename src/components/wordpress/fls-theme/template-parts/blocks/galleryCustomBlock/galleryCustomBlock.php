<?php
$pretitle = get_field('pretitle') ?: '';
$title    = get_field('title') ?: '';
$button   = get_field('button');

$display_by = get_field('display_by') ?: 'brand';
$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

$gallery_i18n = [
  'zoom' => [
    'pl' => 'Zoom',
    'en' => 'Zoom',
    'ru' => 'Увеличить',
    'uk' => 'Збільшити',
  ],
  'nav_label' => [
    'pl' => 'Nawigacja galerii',
    'en' => 'Gallery navigation',
    'ru' => 'Навигация галереи',
    'uk' => 'Навігація галереї',
  ],
];

$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';
$items_per_tab = 6;
$taxonomy = $display_by === 'color' ? 'rim_color' : 'car_brand';

if (!function_exists('felgilab_get_gallery_item_display_title')) {
  function felgilab_get_gallery_item_display_title($post_id, $display_by = 'brand', $lang = 'pl')
  {
    if ($display_by === 'color') {
      $brand_name = '';
      $color_name = '';

      $brand_terms = get_the_terms($post_id, 'car_brand');
      if (!empty($brand_terms) && !is_wp_error($brand_terms)) {
        $brand_term = reset($brand_terms);

        if ($brand_term && !empty($brand_term->name)) {
          $brand_name = $brand_term->name;
        }
      }

      $rim_terms = get_the_terms($post_id, 'rim_color');
      if (!empty($rim_terms) && !is_wp_error($rim_terms)) {
        $rim_term = reset($rim_terms);

        if ($rim_term) {
          $term_id = (int) $rim_term->term_id;

          if (function_exists('felgilab_translate_term_id')) {
            $term_id = felgilab_translate_term_id($term_id, 'rim_color', $lang);
          }

          $translated_term = get_term($term_id, 'rim_color');

          if ($translated_term && !is_wp_error($translated_term) && !empty($translated_term->name)) {
            $color_name = $translated_term->name;
          }
        }
      }

      $combined_title = trim($brand_name . ' ' . $color_name);

      if ($combined_title !== '') {
        return $combined_title;
      }
    }

    return get_the_title($post_id);
  }
}

if (!function_exists('felgilab_gallery_item_is_preferred_for_display')) {
  function felgilab_gallery_item_is_preferred_for_display($post_id, $display_by = 'brand')
  {
    $excerpt = trim((string) get_post_field('post_excerpt', $post_id));
    $has_excerpt = $excerpt !== '';

    if ($display_by === 'color') {
      return $has_excerpt;
    }

    return !$has_excerpt;
  }
}

if (!function_exists('felgilab_render_gallery_block_item')) {
  function felgilab_render_gallery_block_item($post_id, $zoom_text, $display_by = 'brand', $lang = 'pl')
  {
    $thumbnail_id = get_post_thumbnail_id($post_id);

    if (!$thumbnail_id) {
      return;
    }

    $image_full = wp_get_attachment_image_url($thumbnail_id, 'full');
    $item_title = felgilab_get_gallery_item_display_title($post_id, $display_by, $lang);
    $image_alt  = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

    if (!$image_alt) {
      $image_alt = $item_title ?: get_the_title($post_id);
    }

    if (!$image_full) {
      return;
    }
?>
    <a href="<?php echo esc_url($image_full); ?>" class="gallery__item">
      <p class="gallery__item--title">
        <?php echo esc_html($item_title); ?>
      </p>

      <span class="button-main main-btn gallery-zoom-btn" aria-hidden="true">
        <span class="whatsapp-main__wrapper">
          <span class="whatsapp-main__text">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 16 16" fill="#fff" class="bi bi-zoom-in">
              <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
              <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z" />
              <path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5z" />
            </svg>
          </span>
        </span>
      </span>

      <?php
      echo wp_get_attachment_image(
        $thumbnail_id,
        'gallery-grid-home',
        false,
        [
          'alt'      => esc_attr($image_alt),
          'loading'  => 'lazy',
          'decoding' => 'async',
          'sizes'    => '(max-width: 767px) calc(100vw - 30px), (max-width: 1200px) calc(50vw - 24px), 360px',
        ]
      );
      ?>
    </a>
<?php
  }
}

$terms_args = [
  'taxonomy'   => $taxonomy,
  'hide_empty' => false,
  'orderby'    => 'name',
  'order'      => 'ASC',
];

if ($taxonomy === 'rim_color' && function_exists('pll_current_language')) {
  $terms_args['lang'] = $lang;
}

$terms = get_terms($terms_args);
$tabs_data = [];

if (!empty($terms) && !is_wp_error($terms)) {
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
    $terms_map = [];

    foreach ($terms as $term) {
      $terms_map[$term->term_id] = [
        'term'             => $term,
        'preferred_items'  => [],
        'fallback_items'   => [],
        'items'            => [],
      ];
    }

    foreach ($all_gallery_items as $post_id) {
      if (!has_post_thumbnail($post_id)) {
        continue;
      }

      $post_terms = get_the_terms($post_id, $taxonomy);

      if (empty($post_terms) || is_wp_error($post_terms)) {
        continue;
      }

      $is_preferred = felgilab_gallery_item_is_preferred_for_display($post_id, $display_by);

      foreach ($post_terms as $term) {
        $term_id = (int) $term->term_id;

        if ($taxonomy === 'rim_color' && function_exists('felgilab_translate_term_id')) {
          $term_id = felgilab_translate_term_id($term_id, $taxonomy, $lang);
        }

        if (!isset($terms_map[$term_id])) {
          continue;
        }

        if ($is_preferred) {
          if (
            count($terms_map[$term_id]['preferred_items']) >= $items_per_tab ||
            in_array($post_id, $terms_map[$term_id]['preferred_items'], true)
          ) {
            continue;
          }

          $terms_map[$term_id]['preferred_items'][] = $post_id;
        } else {
          if (
            count($terms_map[$term_id]['fallback_items']) >= $items_per_tab ||
            in_array($post_id, $terms_map[$term_id]['fallback_items'], true)
          ) {
            continue;
          }

          $terms_map[$term_id]['fallback_items'][] = $post_id;
        }
      }
    }

    foreach ($terms_map as $term_id => $term_data) {
      $items = $term_data['preferred_items'];

      if (count($items) < $items_per_tab && !empty($term_data['fallback_items'])) {
        foreach ($term_data['fallback_items'] as $fallback_post_id) {
          if (count($items) >= $items_per_tab) {
            break;
          }

          if (in_array($fallback_post_id, $items, true)) {
            continue;
          }

          $items[] = $fallback_post_id;
        }
      }

      if (!empty($items)) {
        $term_data['items'] = $items;
        $tabs_data[] = $term_data;
      }
    }
  }
}

$default_tab_index = 2;
if ($default_tab_index >= count($tabs_data)) {
  $default_tab_index = 0;
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
        <nav
          data-fls-tabs-titles
          class="tabs__navigation gallery-tabs__navigation"
          aria-label="<?php echo esc_attr($gallery_i18n['nav_label'][$lang]); ?>">
          <?php foreach ($tabs_data as $index => $tab) : ?>
            <button
              type="button"
              aria-label="<?php echo esc_attr($tab['term']->name); ?>"
              class="tabs__title gallery-tabs__title <?php echo $index === $default_tab_index ? '--tab-active' : ''; ?>">
              <?php echo esc_html($tab['term']->name); ?>
            </button>
          <?php endforeach; ?>
        </nav>

        <div data-fls-tabs-body class="tabs__content">
          <?php foreach ($tabs_data as $index => $tab) : ?>
            <div class="tabs__body gallery-tabs__body">
              <div class="tab-gallery">
                <div class="gallery" data-fls-gallery data-gallery-loaded="<?php echo $index === $default_tab_index ? 'true' : 'false'; ?>">
                  <?php if ($index === $default_tab_index) : ?>
                    <?php foreach ($tab['items'] as $post_id) : ?>
                      <?php felgilab_render_gallery_block_item($post_id, $gallery_i18n['zoom'][$lang], $display_by, $lang); ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>

                <?php if ($index !== $default_tab_index) : ?>
                  <template class="gallery-tab-template">
                    <?php foreach ($tab['items'] as $post_id) : ?>
                      <?php felgilab_render_gallery_block_item($post_id, $gallery_i18n['zoom'][$lang], $display_by, $lang); ?>
                    <?php endforeach; ?>
                  </template>
                <?php endif; ?>
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