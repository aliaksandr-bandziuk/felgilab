<?php

/**
 * Block Name: Price Calculator Block
 */

$block_id = 'price-calculator-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'price-calculator-block';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$title                      = get_field('title') ?: 'Kalkulator kosztów';
$calculate_button_text      = get_field('calculate_button_text') ?: 'Wycenić';
$summary_title              = get_field('summary_title') ?: 'Podsumowanie';
$appointment_button_text    = get_field('appointment_button_text') ?: 'Umów się na wizytę do serwisu';
$appointment_button_type    = get_field('appointment_button_type') ?: 'popup';
$appointment_popup_selector = get_field('appointment_popup_selector') ?: '#popup-order';
$appointment_button_url     = get_field('appointment_button_url') ?: '';
$vat_rate                   = (float) (get_field('vat_rate') ?: 23);
$wheels_count               = (int) (get_field('wheels_count') ?: 4);
$currency                   = get_field('currency') ?: 'PLN';
$price_rows                 = get_field('price_rows');

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$i18n = [
  'rim_type_label' => [
    'pl' => 'Rodzaj felg',
    'en' => 'Rim type',
    'ru' => 'Тип дисков',
    'uk' => 'Тип дисків',
  ],
  'rim_type_value' => [
    'pl' => 'aluminiowe',
    'en' => 'alloy',
    'ru' => 'литые',
    'uk' => 'литі',
  ],
  'size_label' => [
    'pl' => 'Rozmiar felg',
    'en' => 'Rim size',
    'ru' => 'Размер дисков',
    'uk' => 'Розмір дисків',
  ],
  'method_label' => [
    'pl' => 'Metoda malowania',
    'en' => 'Painting method',
    'ru' => 'Метод покраски',
    'uk' => 'Метод фарбування',
  ],
  'method_system_label' => [
    'pl' => 'systemowa',
    'en' => 'standard',
    'ru' => 'стандартная',
    'uk' => 'стандартна',
  ],
  'method_powder_label' => [
    'pl' => 'proszkowa',
    'en' => 'powder coating',
    'ru' => 'порошковая',
    'uk' => 'порошкове фарбування',
  ],
  'cnc_label' => [
    'pl' => 'Toczenie CNC',
    'en' => 'CNC machining',
    'ru' => 'Проточka CNC',
    'uk' => 'Проточування CNC',
  ],
  'vulcan_label' => [
    'pl' => 'Wulkanizacja (z zostawieniem auta u nas)',
    'en' => 'Tire service (with the car left at our workshop)',
    'ru' => 'Шиномонтаж (если оставить авто у нас)',
    'uk' => 'Шиномонтаж (якщо залишити авто у нас)',
  ],
  'yes_label' => [
    'pl' => 'tak',
    'en' => 'yes',
    'ru' => 'да',
    'uk' => 'так',
  ],
  'no_label' => [
    'pl' => 'nie',
    'en' => 'no',
    'ru' => 'нет',
    'uk' => 'ні',
  ],
  'netto_label' => [
    'pl' => 'Netto',
    'en' => 'Net',
    'ru' => 'Нетто',
    'uk' => 'Нетто',
  ],
  'brutto_label' => [
    'pl' => 'Brutto',
    'en' => 'Gross',
    'ru' => 'Брутто',
    'uk' => 'Брутто',
  ],
  'per_wheel_label' => [
    'pl' => 'Koszt 1 felgi brutto (dot. malowania kompletu)',
    'en' => 'Gross cost per rim (for a full set painting)',
    'ru' => 'Стоимость 1 диска брутто (при покраске комплекта)',
    'uk' => 'Вартість 1 диска брутто (при фарбуванні комплекту)',
  ],
];

$rim_type_label      = $i18n['rim_type_label'][$lang] ?? '';
$rim_type_value      = $i18n['rim_type_value'][$lang] ?? '';
$size_label          = $i18n['size_label'][$lang] ?? '';
$method_label        = $i18n['method_label'][$lang] ?? '';
$method_system_label = $i18n['method_system_label'][$lang] ?? '';
$method_powder_label = $i18n['method_powder_label'][$lang] ?? '';
$cnc_label           = $i18n['cnc_label'][$lang] ?? '';
$vulcan_label        = $i18n['vulcan_label'][$lang] ?? '';
$yes_label           = $i18n['yes_label'][$lang] ?? '';
$no_label            = $i18n['no_label'][$lang] ?? '';
$netto_label         = $i18n['netto_label'][$lang] ?? '';
$brutto_label        = $i18n['brutto_label'][$lang] ?? '';
$per_wheel_label     = $i18n['per_wheel_label'][$lang] ?? '';

$prices_map = [];
$size_options = [];

if (!empty($price_rows) && is_array($price_rows)) {
  foreach ($price_rows as $index => $row) {
    $wheel_size = isset($row['wheel_size']) ? trim((string) $row['wheel_size']) : '';

    if ($wheel_size === '') {
      continue;
    }

    $prices_map[$wheel_size] = [
      'system' => isset($row['system_price_brutto']) ? (float) $row['system_price_brutto'] : 0,
      'powder' => isset($row['powder_price_brutto']) ? (float) $row['powder_price_brutto'] : 0,
      'cnc'    => isset($row['cnc_price_brutto']) ? (float) $row['cnc_price_brutto'] : 0,
      'vulcan' => isset($row['vulcan_price_brutto']) ? (float) $row['vulcan_price_brutto'] : 0,
    ];

    $size_options[] = [
      'value'   => $wheel_size,
      'checked' => $index === 0,
    ];
  }
}

$prices_json = !empty($prices_map) ? wp_json_encode($prices_map) : '{}';

$wrapper_attributes = get_block_wrapper_attributes([
  'id'    => $block_id,
  'class' => $classes,
]);

$appointment_attrs = '';
$appointment_href = '';

if ($appointment_button_type === 'link' && !empty($appointment_button_url)) {
  $appointment_href = $appointment_button_url;
} else {
  $appointment_href = '#';
  $appointment_attrs = ' data-fancybox data-src="' . esc_attr($appointment_popup_selector) . '"';
}
?>

<?php if (!empty($size_options)) : ?>
  <section <?= $wrapper_attributes; ?>>
    <div class="calculator__container">
      <div
        class="calculator"
        data-vat-rate="<?= esc_attr($vat_rate); ?>"
        data-wheels-count="<?= esc_attr($wheels_count > 0 ? $wheels_count : 4); ?>"
        data-currency="<?= esc_attr($currency); ?>"
        data-prices="<?= esc_attr($prices_json); ?>">

        <?php if ($title) : ?>
          <div class="block-precontent mb50">

            <?php if ($title) : ?>
              <h2 class="h2 block-precontent__title mb30">
                <?php echo esc_html($title); ?>
              </h2>
            <?php endif; ?>

          </div>
        <?php endif; ?>

        <div class="calculator-grid">
          <div class="calculator-select">
            <p class="calculator-select__title"><?= esc_html($rim_type_label); ?>:</p>
            <div class="calculator-select__wrap">
              <div class="calculator-select__el">
                <input
                  type="radio"
                  id="<?= esc_attr($block_id); ?>-type-aluminum"
                  name="<?= esc_attr($block_id); ?>-type"
                  checked
                  class="calcInput">
                <label for="<?= esc_attr($block_id); ?>-type-aluminum">
                  <div class="calculator-select__el-box" aria-hidden="true">
                    <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1 4.04716L4.04716 7.09432L10.1415 1" stroke="currentColor" stroke-width="1.52358" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <span><?= esc_html($rim_type_value); ?></span>
                </label>
              </div>
            </div>
          </div>

          <div class="calculator-select">
            <p class="calculator-select__title"><?= esc_html($size_label); ?>:</p>
            <div class="calculator-select__wrap size-columns">
              <?php foreach ($size_options as $size_option) : ?>
                <?php
                $size_value = $size_option['value'];
                $size_id = sanitize_title($size_value);
                ?>
                <div class="calculator-select__el">
                  <input
                    type="radio"
                    id="<?= esc_attr($block_id . '-size-' . $size_id); ?>"
                    name="<?= esc_attr($block_id); ?>-size"
                    value="<?= esc_attr($size_value); ?>"
                    class="calcInput js-calc-size"
                    <?= checked($size_option['checked'], true, false); ?>>
                  <label for="<?= esc_attr($block_id . '-size-' . $size_id); ?>">
                    <div class="calculator-select__el-box" aria-hidden="true">
                      <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 4.04716L4.04716 7.09432L10.1415 1" stroke="currentColor" stroke-width="1.52358" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </div>
                    <span><?= esc_html($size_value); ?></span>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="calculator-select">
            <p class="calculator-select__title"><?= esc_html($method_label); ?>:</p>
            <div class="calculator-select__wrap">
              <div class="calculator-select__el">
                <input
                  type="radio"
                  id="<?= esc_attr($block_id); ?>-method-system"
                  name="<?= esc_attr($block_id); ?>-method"
                  value="system"
                  checked
                  class="calcInput js-calc-method">
                <label for="<?= esc_attr($block_id); ?>-method-system">
                  <div class="calculator-select__el-box" aria-hidden="true">
                    <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1 4.04716L4.04716 7.09432L10.1415 1" stroke="currentColor" stroke-width="1.52358" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <span><?= esc_html($method_system_label); ?></span>
                </label>
              </div>

              <div class="calculator-select__el">
                <input
                  type="radio"
                  id="<?= esc_attr($block_id); ?>-method-powder"
                  name="<?= esc_attr($block_id); ?>-method"
                  value="powder"
                  class="calcInput js-calc-method">
                <label for="<?= esc_attr($block_id); ?>-method-powder">
                  <div class="calculator-select__el-box" aria-hidden="true">
                    <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1 4.04716L4.04716 7.09432L10.1415 1" stroke="currentColor" stroke-width="1.52358" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <span><?= esc_html($method_powder_label); ?></span>
                </label>
              </div>
            </div>
          </div>

          <div class="calculator-select">
            <p class="calculator-select__title"><?= esc_html($cnc_label); ?>:</p>
            <div class="calculator-select__wrap">
              <div class="calculator-select__el">
                <input
                  type="radio"
                  id="<?= esc_attr($block_id); ?>-cnc-yes"
                  name="<?= esc_attr($block_id); ?>-cnc"
                  value="yes"
                  class="calcInput js-calc-cnc">
                <label for="<?= esc_attr($block_id); ?>-cnc-yes">
                  <div class="calculator-select__el-box" aria-hidden="true">
                    <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1 4.04716L4.04716 7.09432L10.1415 1" stroke="currentColor" stroke-width="1.52358" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <span><?= esc_html($yes_label); ?></span>
                </label>
              </div>

              <div class="calculator-select__el">
                <input
                  type="radio"
                  id="<?= esc_attr($block_id); ?>-cnc-no"
                  name="<?= esc_attr($block_id); ?>-cnc"
                  value="no"
                  checked
                  class="calcInput js-calc-cnc">
                <label for="<?= esc_attr($block_id); ?>-cnc-no">
                  <div class="calculator-select__el-box" aria-hidden="true">
                    <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1 4.04716L4.04716 7.09432L10.1415 1" stroke="currentColor" stroke-width="1.52358" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <span><?= esc_html($no_label); ?></span>
                </label>
              </div>
            </div>
          </div>

          <div class="calculator-select">
            <p class="calculator-select__title"><?= esc_html($vulcan_label); ?>:</p>
            <div class="calculator-select__wrap">
              <div class="calculator-select__el">
                <input
                  type="radio"
                  id="<?= esc_attr($block_id); ?>-vulcan-yes"
                  name="<?= esc_attr($block_id); ?>-vulcan"
                  value="yes"
                  class="calcInput js-calc-vulcan">
                <label for="<?= esc_attr($block_id); ?>-vulcan-yes">
                  <div class="calculator-select__el-box" aria-hidden="true">
                    <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1 4.04716L4.04716 7.09432L10.1415 1" stroke="currentColor" stroke-width="1.52358" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <span><?= esc_html($yes_label); ?></span>
                </label>
              </div>

              <div class="calculator-select__el">
                <input
                  type="radio"
                  id="<?= esc_attr($block_id); ?>-vulcan-no"
                  name="<?= esc_attr($block_id); ?>-vulcan"
                  value="no"
                  checked
                  class="calcInput js-calc-vulcan">
                <label for="<?= esc_attr($block_id); ?>-vulcan-no">
                  <div class="calculator-select__el-box" aria-hidden="true">
                    <svg viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1 4.04716L4.04716 7.09432L10.1415 1" stroke="currentColor" stroke-width="1.52358" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <span><?= esc_html($no_label); ?></span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <button type="button" class="calculator__btn js-calc-submit">
          <?= esc_html($calculate_button_text); ?>
        </button>

        <div class="calculator__res d-none js-calc-result">
          <p class="calculator__res-title"><?= esc_html($summary_title); ?></p>

          <div class="calculator__res-wrap">
            <div class="calculator__res-el">
              <p class="calculator__res-name"><?= esc_html($netto_label); ?></p>
              <p class="calculator__res-prise js-calc-netto"></p>
            </div>

            <div class="calculator__res-el">
              <p class="calculator__res-name"><?= esc_html($brutto_label); ?></p>
              <p class="calculator__res-prise js-calc-brutto"></p>
            </div>

            <div class="calculator__res-el">
              <p class="calculator__res-name"><?= esc_html($per_wheel_label); ?></p>
              <p class="calculator__res-prise js-calc-per-wheel"></p>
            </div>
          </div>
        </div>

        <?php if (!empty($appointment_button_text)) : ?>
          <a
            class="calculator__btn-blue d-none js-calc-appointment"
            href="<?= esc_url($appointment_href); ?>"
            <?= $appointment_attrs; ?>>
            <?= esc_html($appointment_button_text); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>