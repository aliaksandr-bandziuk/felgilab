<?php
$pretitle = get_field('pretitle') ?: '';
$title    = get_field('title') ?: '';
$button   = get_field('button');
$tabs     = get_field('tabs') ?: [];

$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

$gallery_i18n = [
  'nav_label' => [
    'pl' => 'Nawigacja galerii',
    'en' => 'Gallery navigation',
    'ru' => 'Навигация галереи',
    'uk' => 'Навігація галереї',
  ],
];

$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$prepared_tabs = [];

if (!empty($tabs) && is_array($tabs)) {
  foreach ($tabs as $index => $tab) {
    $tab_title = !empty($tab['tab_title']) ? trim($tab['tab_title']) : '';

    if ($tab_title) {
      $prepared_tabs[] = [
        'title' => $tab_title,
        'index' => $index,
      ];
    }
  }
}

$default_tab_index = 0;
$post_id = get_the_ID();
$nonce = wp_create_nonce('felgilab_gallery_manual_nonce');
$block_id = !empty($block['id']) ? $block['id'] : uniqid('gallery_manual_');

set_transient(
  'felgilab_gallery_manual_' . $block_id,
  $tabs,
  HOUR_IN_SECONDS
);
?>

<?php if (!empty($prepared_tabs)) : ?>
  <section
    class="main-gallery"
    data-gallery-manual-block
    data-block-id="<?php echo esc_attr($block_id); ?>"
    data-post-id="<?php echo esc_attr($post_id); ?>"
    data-nonce="<?php echo esc_attr($nonce); ?>">

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

      <div class="tabs gallery-tabs">
        <nav
          class="tabs__navigation gallery-tabs__navigation"
          aria-label="<?php echo esc_attr($gallery_i18n['nav_label'][$lang]); ?>">

          <?php foreach ($prepared_tabs as $index => $tab) : ?>
            <button
              type="button"
              data-gallery-manual-tab
              data-tab-index="<?php echo esc_attr($tab['index']); ?>"
              aria-label="<?php echo esc_attr($tab['title']); ?>"
              class="tabs__title gallery-tabs__title <?php echo $index === $default_tab_index ? '--tab-active' : ''; ?>">
              <?php echo esc_html($tab['title']); ?>
            </button>
          <?php endforeach; ?>
        </nav>

        <div class="tabs__content">
          <?php foreach ($prepared_tabs as $index => $tab) : ?>
            <div
              class="tabs__body gallery-tabs__body"
              <?php echo $index !== $default_tab_index ? 'hidden' : ''; ?>>

              <div class="tab-gallery">
                <div
                  class="gallery-manual"
                  data-fls-gallery
                  data-gallery-manual-content
                  data-tab-index="<?php echo esc_attr($tab['index']); ?>">
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