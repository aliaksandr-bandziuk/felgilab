<?php

/**
 * Block Name: Price List Block
 */

$block_id = 'price-list-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'price-list';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$i18n = [
  'rim_types' => [
    'aluminium' => [
      'pl' => 'Felgi aluminiowe',
      'en' => 'Alloy wheels',
      'ru' => 'Алюминиевые диски',
      'uk' => 'Алюмінієві диски',
    ],
    'steel' => [
      'pl' => 'Felgi stalowe',
      'en' => 'Steel wheels',
      'ru' => 'Стальные диски',
      'uk' => 'Сталеві диски',
    ],
  ],
  'fallback' => [
    'col_1' => [
      'pl' => 'Rozmiar',
      'en' => 'Size',
      'ru' => 'Размер',
      'uk' => 'Розмір',
    ],
    'col_2' => [
      'pl' => 'Cena od',
      'en' => 'Price from',
      'ru' => 'Цена от',
      'uk' => 'Ціна від',
    ],
  ],
];

$pretitle = get_field('pretitle') ?: '';
$title = get_field('title') ?: '';

$aluminium_services = get_field('aluminium_services');
$steel_services = get_field('steel_services');

$aluminium_label = $i18n['rim_types']['aluminium'][$lang];
$steel_label = $i18n['rim_types']['steel'][$lang];

$fallback_col_1 = $i18n['fallback']['col_1'][$lang];
$fallback_col_2 = $i18n['fallback']['col_2'][$lang];

$has_aluminium_services = !empty($aluminium_services) && is_array($aluminium_services);
$has_steel_services = !empty($steel_services) && is_array($steel_services);

if (!$has_aluminium_services && !$has_steel_services) {
  return;
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <div class="price-list__container">
    <div class="price-list__wrapper">

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

      <div data-fls-tabs="980,max" data-fls-tabs-animate="300" class="price-list-tabs tabs">
        <nav data-fls-tabs-titles class="price-list-tabs__navigation tabs__navigation">

          <?php if ($has_aluminium_services) : ?>
            <button type="button" class="price-list-tabs__title tabs__title --tab-active">
              <img
                src="/wp-content/uploads/2026/03/rim-alum.png"
                alt="<?php echo esc_attr($aluminium_label); ?>"
                class="price-list-tabs__img">
              <span><?php echo esc_html($aluminium_label); ?></span>
            </button>
          <?php endif; ?>

          <?php if ($has_steel_services) : ?>
            <button type="button" class="price-list-tabs__title tabs__title <?php echo !$has_aluminium_services ? '--tab-active' : ''; ?>">
              <img
                src="/wp-content/uploads/2026/03/rim-steel.png"
                alt="<?php echo esc_attr($steel_label); ?>"
                class="price-list-tabs__img">
              <span><?php echo esc_html($steel_label); ?></span>
            </button>
          <?php endif; ?>

        </nav>

        <div data-fls-tabs-body class="price-list-tabs__content tabs__content">

          <?php if ($has_aluminium_services) : ?>
            <div class="price-list-tabs__body tabs__body">
              <div data-fls-tabs="980,max" data-fls-tabs-animate="300" class="price-subtabs tabs">
                <nav data-fls-tabs-titles class="price-subtabs__navigation tabs__navigation">
                  <?php foreach ($aluminium_services as $service_index => $service) : ?>
                    <button type="button" class="price-subtabs__title tabs__title <?php echo $service_index === 0 ? '--tab-active' : ''; ?>">
                      <?php echo esc_html($service['service_title'] ?? ''); ?>
                    </button>
                  <?php endforeach; ?>
                </nav>

                <div data-fls-tabs-body class="price-subtabs__content tabs__content">
                  <?php foreach ($aluminium_services as $service) : ?>
                    <?php
                    $col_1_title = !empty($service['col_1_title']) ? $service['col_1_title'] : $fallback_col_1;
                    $col_2_title = !empty($service['col_2_title']) ? $service['col_2_title'] : $fallback_col_2;
                    $rows = !empty($service['rows']) && is_array($service['rows']) ? $service['rows'] : [];
                    ?>
                    <div class="price-subtabs__body tabs__body">
                      <div class="price-table">
                        <div class="price-table__head">
                          <div class="price-table__col"><?php echo esc_html($col_1_title); ?></div>
                          <div class="price-table__col"><?php echo esc_html($col_2_title); ?></div>
                        </div>

                        <?php foreach ($rows as $row) : ?>
                          <?php
                          $row_type = $row['row_type'] ?? 'text';
                          $row_label = '';

                          if ($row_type === 'size' && isset($row['size']) && $row['size'] !== '') {
                            $row_label = trim($row['size']) . '"';
                          } else {
                            $row_label = $row['label'] ?? '';
                          }

                          $row_price = trim((string)($row['price'] ?? ''));
                          $row_price_output = $row_price !== '' ? $row_price . ' zł' : '';
                          ?>
                          <div class="price-table__row">
                            <div class="price-table__col">
                              <?php echo esc_html($row_label); ?>
                            </div>
                            <div class="price-table__col">
                              <?php echo esc_html($row_price_output); ?>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($has_steel_services) : ?>
            <div class="price-list-tabs__body tabs__body">
              <div data-fls-tabs="980,max" data-fls-tabs-animate="300" class="price-subtabs tabs">
                <nav data-fls-tabs-titles class="price-subtabs__navigation tabs__navigation">
                  <?php foreach ($steel_services as $service_index => $service) : ?>
                    <button type="button" class="price-subtabs__title tabs__title <?php echo (!$has_aluminium_services && $service_index === 0) ? '--tab-active' : ($has_aluminium_services ? ($service_index === 0 ? '--tab-active' : '') : ''); ?>">
                      <?php echo esc_html($service['service_title'] ?? ''); ?>
                    </button>
                  <?php endforeach; ?>
                </nav>

                <div data-fls-tabs-body class="price-subtabs__content tabs__content">
                  <?php foreach ($steel_services as $service) : ?>
                    <?php
                    $col_1_title = !empty($service['col_1_title']) ? $service['col_1_title'] : $fallback_col_1;
                    $col_2_title = !empty($service['col_2_title']) ? $service['col_2_title'] : $fallback_col_2;
                    $rows = !empty($service['rows']) && is_array($service['rows']) ? $service['rows'] : [];
                    ?>
                    <div class="price-subtabs__body tabs__body">
                      <div class="price-table">
                        <div class="price-table__head">
                          <div class="price-table__col"><?php echo esc_html($col_1_title); ?></div>
                          <div class="price-table__col"><?php echo esc_html($col_2_title); ?></div>
                        </div>

                        <?php foreach ($rows as $row) : ?>
                          <?php
                          $row_type = $row['row_type'] ?? 'text';
                          $row_label = '';

                          if ($row_type === 'size' && isset($row['size']) && $row['size'] !== '') {
                            $row_label = trim($row['size']) . '"';
                          } else {
                            $row_label = $row['label'] ?? '';
                          }

                          $row_price = trim((string)($row['price'] ?? ''));
                          $row_price_output = $row_price !== '' ? $row_price . ' zł' : '';
                          ?>
                          <div class="price-table__row">
                            <div class="price-table__col">
                              <?php echo esc_html($row_label); ?>
                            </div>
                            <div class="price-table__col">
                              <?php echo esc_html($row_price_output); ?>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</section>