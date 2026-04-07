<?php

/**
 * Block Name: Content Tabs Block
 */

$block_id = 'content-tabs-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'content-tabs-block';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$pretitle = get_field('pretitle') ?: '';
$title    = get_field('title') ?: '';
$tabs     = get_field('tabs');

if (empty($tabs) || !is_array($tabs)) {
  return;
}

if (!function_exists('render_content_tabs_wysiwyg')) {
  function render_content_tabs_wysiwyg($content = '')
  {
    if (empty($content)) {
      return;
    }

    echo '<div class="content-tabs-editor">';
    echo wp_kses_post($content);
    echo '</div>';
  }
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <div class="content-tabs-block__container">
    <div class="content-tabs-block__wrapper">

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

      <div data-fls-tabs="980,max" data-fls-tabs-animate="300" class="content-tabs tabs">
        <nav data-fls-tabs-titles class="content-tabs__navigation tabs__navigation gallery-tabs__navigation">
          <?php foreach ($tabs as $tab_index => $tab) : ?>
            <?php
            $tab_title = $tab['tab_title'] ?? '';
            $tab_icon  = $tab['tab_icon'] ?? null;
            ?>
            <button
              type="button"
              class="content-tabs__title gallery-tabs__title tabs__title <?php echo $tab_index === 0 ? '--tab-active' : ''; ?>">

              <?php if (!empty($tab_icon['url'])) : ?>
                <img
                  src="<?php echo esc_url($tab_icon['url']); ?>"
                  alt="<?php echo esc_attr($tab_icon['alt'] ?? $tab_title); ?>"
                  class="content-tabs__icon"
                  loading="lazy">
              <?php endif; ?>

              <span><?php echo esc_html($tab_title); ?></span>
            </button>
          <?php endforeach; ?>
        </nav>

        <div data-fls-tabs-body class="content-tabs__content tabs__content">
          <?php foreach ($tabs as $tab) : ?>
            <?php
            $has_subtabs = !empty($tab['has_subtabs']);
            $subtabs     = $tab['subtabs'] ?? [];
            $content     = $tab['content'] ?? '';
            ?>
            <div class="content-tabs__body tabs__body">

              <?php if ($has_subtabs && !empty($subtabs) && is_array($subtabs)) : ?>
                <div data-fls-tabs="980,max" data-fls-tabs-animate="300" class="content-subtabs tabs">
                  <nav data-fls-tabs-titles class="content-subtabs__navigation tabs__navigation">
                    <?php foreach ($subtabs as $subtab_index => $subtab) : ?>
                      <button
                        type="button"
                        class="content-subtabs__title gallery-tabs__title tabs__title <?php echo $subtab_index === 0 ? '--tab-active' : ''; ?>">
                        <?php echo esc_html($subtab['subtab_title'] ?? ''); ?>
                      </button>
                    <?php endforeach; ?>
                  </nav>

                  <div data-fls-tabs-body class="content-subtabs__content tabs__content">
                    <?php foreach ($subtabs as $subtab) : ?>
                      <div class="content-subtabs__body tabs__body">
                        <?php render_content_tabs_wysiwyg($subtab['content'] ?? ''); ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php else : ?>
                <?php render_content_tabs_wysiwyg($content); ?>
              <?php endif; ?>

            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</section>