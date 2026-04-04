<?php

/**
 * Block Name: Final Contact Block
 */

$block_id = 'final-contact-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'final-contact';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$title       = get_field('title') ?: 'Skontaktuj się z nami';
$description = get_field('description') ?: 'Masz pytanie lub chcesz otrzymać wycenę? Wypełnij formularz, a odpowiemy tak szybko, jak to możliwe.';
$button_text = get_field('button_text') ?: 'Wyślij formularz';
$map_iframe = get_field('map_iframe');

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$i18n = [
  'name' => [
    'pl' => 'Imię',
    'en' => 'Name',
    'ru' => 'Имя',
    'uk' => 'Ім’я',
  ],
  'phone' => [
    'pl' => 'Telefon',
    'en' => 'Phone',
    'ru' => 'Телефон',
    'uk' => 'Телефон',
  ],
  'message' => [
    'pl' => 'Opisz problem z felgami (nieobowiązkowo)',
    'en' => 'Describe the problem with the wheels (optional)',
    'ru' => 'Опишите проблему с дисками (необязательно)',
    'uk' => 'Опишіть проблему з дисками (необов’язково)',
  ],
  'message_placeholder' => [
    'pl' => 'np. rysa na rancie, skrzywienie, odpryski lakieru',
    'en' => 'e.g. curb rash, bent wheel, paint damage',
    'ru' => 'например: царапина на ободе, искривление, повреждение краски',
    'uk' => 'наприклад: подряпина на ободі, викривлення, пошкодження фарби',
  ],
  'upload' => [
    'pl' => 'Dodaj zdjęcia uszkodzonych felg',
    'en' => 'Add photos of damaged wheels',
    'ru' => 'Добавьте фото повреждённых дисков',
    'uk' => 'Додайте фото пошкоджених дисків',
  ],
  'upload_note' => [
    'pl' => 'Możesz dodać kilka zdjęć (JPG, PNG, WebP).',
    'en' => 'You can add several photos (JPG, PNG, WebP).',
    'ru' => 'Можно добавить несколько фото (JPG, PNG, WebP).',
    'uk' => 'Можна додати кілька фото (JPG, PNG, WebP).',
  ],
  'map_title' => [
    'pl' => 'Mapa lokalizacji FelgiLab w Warszawie',
    'en' => 'Map showing FelgiLab location in Warsaw',
    'ru' => 'Карта расположения FelgiLab в Варшаве',
    'uk' => 'Карта розташування FelgiLab у Варшаві',
  ],
];


if (!$map_iframe) {
  $map_iframe = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2449.117693444661!2d20.921476976993176!3d52.13218056486965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471933fb7fe71edb%3A0xa3139f1d9ffeb62a!2sRenowacja%20Felg%20FelgiLab!5e0!3m2!1sen!2spl!4v1773328917158!5m2!1sen!2spl" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="' . esc_attr($i18n['map_title'][$lang]) . '"></iframe>';
}

if ($map_iframe && strpos($map_iframe, 'title=') === false) {
  $map_iframe = str_replace(
    '<iframe',
    '<iframe title="' . esc_attr($i18n['map_title'][$lang]) . '"',
    $map_iframe
  );
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <div class="final-contact__container">
    <div class="final-contact__wrapper">
      <div class="final-contact__map">
        <?php echo wp_kses(
          $map_iframe,
          [
            'iframe' => [
              'src' => true,
              'width' => true,
              'height' => true,
              'style' => true,
              'allowfullscreen' => true,
              'loading' => true,
              'referrerpolicy' => true,
              'title' => true,
            ],
          ]
        ); ?>
      </div>

      <div class="final-contact__inner">
        <h2 class="h2-white mb20">
          <?php echo esc_html($title); ?>
        </h2>

        <div class="about-company__divider mb30">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="8" aria-hidden="true">
            <path fill="#fd6b1c" d="M34 0h30v2H34zm0 6h15v2H34zM0 0h30v2H0zm15 6h15v2H15z" />
          </svg>
        </div>

        <p class="final-contact__description mb20">
          <?php echo esc_html($description); ?>
        </p>

        <form action="#" autocomplete="off" class="small-form">
          <div class="input-container">
            <input type="text" name="name" id="name_<?php echo esc_attr($block['id']); ?>" class="input-contact" />
            <label for="name_<?php echo esc_attr($block['id']); ?>"><?php echo esc_html($i18n['name'][$lang]); ?></label>
            <span><?php echo esc_html($i18n['name'][$lang]); ?></span>
          </div>

          <div class="input-container">
            <input type="tel" name="phone" id="phone_<?php echo esc_attr($block['id']); ?>" class="input-contact" />
            <label for="phone_<?php echo esc_attr($block['id']); ?>"><?php echo esc_html($i18n['phone'][$lang]); ?></label>
            <span><?php echo esc_html($i18n['phone'][$lang]); ?></span>
          </div>

          <div class="input-container textarea">
            <textarea
              name="message"
              id="message_<?php echo esc_attr($block['id']); ?>"
              class="input-contact"
              placeholder="<?php echo esc_attr($i18n['message_placeholder'][$lang]); ?>"></textarea>
            <label for="message_<?php echo esc_attr($block['id']); ?>">
              <?php echo esc_html($i18n['message'][$lang]); ?>
            </label>
            <span><?php echo esc_html($i18n['message'][$lang]); ?></span>
          </div>

          <div class="file-upload">
            <input
              type="file"
              name="wheel_photos[]"
              id="wheel_photos_<?php echo esc_attr($block['id']); ?>"
              class="input-file"
              accept="image/*"
              multiple />

            <label for="wheel_photos_<?php echo esc_attr($block['id']); ?>" class="file-label">
              <?php echo esc_html($i18n['upload'][$lang]); ?>
            </label>

            <div class="file-note">
              <?php echo esc_html($i18n['upload_note'][$lang]); ?>
            </div>

            <div class="file-list" id="fileList_<?php echo esc_attr($block['id']); ?>"></div>
          </div>

          <button type="submit" class="button-primary btn w_btn2" aria-label="<?php echo esc_attr($button_text); ?>">
            <?php echo esc_html($button_text); ?>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>