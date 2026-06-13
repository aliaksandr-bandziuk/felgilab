<?php
/*
Template Name: Gallery Page
Template Post Type: page
*/
get_header();

$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

$gallery_i18n = [
  'all' => [
    'pl' => 'Wszystkie',
    'en' => 'All',
    'ru' => 'Все',
    'uk' => 'Всі',
  ],
  'empty_all' => [
    'pl' => 'Brak zdjęć do wyświetlenia.',
    'en' => 'No images to display.',
    'ru' => 'Нет изображений для отображения.',
    'uk' => 'Немає зображень для відображення.',
  ],
  'empty_brand' => [
    'pl' => 'Brak zdjęć dla marki',
    'en' => 'No images for brand',
    'ru' => 'Нет изображений для марки',
    'uk' => 'Немає зображень для марки',
  ],
  'zoom' => [
    'pl' => 'Zoom',
    'en' => 'Zoom',
    'ru' => 'Увеличить',
    'uk' => 'Збільшити',
  ],
  'load_more' => [
    'pl' => 'Załaduj więcej',
    'en' => 'Load more',
    'ru' => 'Загрузить ещё',
    'uk' => 'Завантажити ще',
  ],
];

$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$brands = get_terms([
  'taxonomy'   => 'car_brand',
  'hide_empty' => true,
]);

$items_per_page = 20;

/**
 * Рендер карточек галереи
 */
function felgilab_render_gallery_items($query, $zoom_text, $items_per_page = 20)
{
  $index = 0;

  while ($query->have_posts()) :
    $query->the_post();

    $image_full  = get_the_post_thumbnail_url(get_the_ID(), 'gallery-grid');
    $image_large = get_the_post_thumbnail_url(get_the_ID(), 'gallery-grid');
    $image_alt   = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

    if (!$image_alt) {
      $image_alt = get_the_title();
    }

    if (!$image_full || !$image_large) {
      continue;
    }

    $hidden_class = $index >= $items_per_page ? ' gallery__item--hidden' : '';
?>
    <a href="<?php echo esc_url($image_full); ?>" class="gallery__item">
      <span class="button-main main-btn gallery-zoom-btn" aria-hidden="true">
        <span class="whatsapp-main__wrapper">
          <span class="whatsapp-main__text gallery-zoom-btn__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 16 16" fill="#fff" class="bi bi-zoom-in">
              <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
              <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z" />
              <path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5z" />
            </svg>
          </span>
        </span>
      </span>
      <img src="<?php echo esc_url($image_large); ?>" alt="<?php echo esc_attr($image_alt); ?>">
    </a>
<?php
    $index++;
  endwhile;

  return $index;
}
?>

<main class="page">
  <div data-fls-index class="index">
    <section
      class="main-gallery page-gallery"
      data-gallery-manual-block
      data-block-id="page-gallery-<?php echo esc_attr(get_the_ID()); ?>"
      data-post-id="<?php echo esc_attr(get_the_ID()); ?>"
      data-nonce="<?php echo esc_attr(wp_create_nonce('felgilab_gallery_manual_nonce')); ?>"
      data-gallery-mode="page_gallery">
      <div class="main-gallery__container">
        <div class="block-precontent mb50">
          <?php $pretitle = get_post_meta(get_the_ID(), '_felgilab_pretitle', true); ?>
          <?php if ($pretitle) : ?>
            <p class="block-precontent__descr mb20">
              <?php echo esc_html($pretitle); ?>
            </p>
          <?php endif; ?>

          <h1 class="h2 block-precontent__title">
            <?php the_title(); ?>
          </h1>
        </div>

        <?php if (!empty($brands) && !is_wp_error($brands)) : ?>
          <div data-fls-tabs data-fls-tabs-animate="500" class="tabs gallery-tabs">
            <nav data-fls-tabs-titles class="tabs__navigation gallery-tabs__navigation" aria-label="Gallery Tabs Navigation">
              <button
                aria-label="<?php echo esc_attr($gallery_i18n['all'][$lang]); ?>"
                type="button"
                class="tabs__title gallery-tabs__title --tab-active"
                data-gallery-manual-tab
                data-tab-index="0"
                data-brand-id="all">
                <?php echo esc_html($gallery_i18n['all'][$lang]); ?>
              </button>

              <?php foreach ($brands as $brand_index => $brand) : ?>
                <button
                  aria-label="<?php echo esc_attr($brand->name); ?>"
                  type="button"
                  class="tabs__title gallery-tabs__title"
                  data-gallery-manual-tab
                  data-tab-index="<?php echo esc_attr($brand_index + 1); ?>"
                  data-brand-id="<?php echo esc_attr($brand->term_id); ?>">
                  <?php echo esc_html($brand->name); ?>
                </button>
              <?php endforeach; ?>
            </nav>

            <div data-fls-tabs-body class="tabs__content">
              <div class="tabs__body gallery-tabs__body">
                <div class="tab-gallery">
                  <div
                    class="gallery"
                    data-fls-gallery
                    data-gallery-manual-content
                    data-tab-index="0"
                    data-brand-id="all">
                  </div>
                </div>
              </div>

              <?php foreach ($brands as $brand_index => $brand) : ?>
                <div class="tabs__body gallery-tabs__body" hidden>
                  <div class="tab-gallery">
                    <div
                      class="gallery"
                      data-fls-gallery
                      data-gallery-manual-content
                      data-tab-index="<?php echo esc_attr($brand_index + 1); ?>"
                      data-brand-id="<?php echo esc_attr($brand->term_id); ?>">
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php else : ?>
          <p><?php echo esc_html($gallery_i18n['empty_all'][$lang]); ?></p>
        <?php endif; ?>
      </div>
    </section>

    <?php while (have_posts()) : the_post(); ?>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    <?php endwhile; ?>

  </div>
</main>

<?php get_footer(); ?>