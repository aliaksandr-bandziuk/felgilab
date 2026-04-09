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
    'pl' => 'Możesz dodać maksymalnie 10 zdjęć (JPG, PNG, WebP), do 5 MB każde.',
    'en' => 'You can add up to 10 photos (JPG, PNG, WebP), 5 MB each maximum.',
    'ru' => 'Можно добавить до 10 фото (JPG, PNG, WebP), максимум 5 МБ каждое.',
    'uk' => 'Можна додати до 10 фото (JPG, PNG, WebP), максимум 5 МБ кожне.',
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

        <form
          action="<?php echo esc_url(get_template_directory_uri() . '/sendmail/index.php'); ?>"
          method="post"
          autocomplete="off"
          class="small-form form-sending"
          enctype="multipart/form-data"
          data-fls-form="ajax"
          data-fls-form-popup="popup-thanks">

          <input type="hidden" name="page_url" value="">
          <input type="hidden" name="form_name" value="Final Contact Block">

          <div style="position:absolute; left:-9999px; opacity:0; pointer-events:none;" aria-hidden="true">
            <label for="website_<?php echo esc_attr($block['id']); ?>">Website</label>
            <input
              type="text"
              name="website"
              id="website_<?php echo esc_attr($block['id']); ?>"
              tabindex="-1"
              autocomplete="off">
          </div>

          <div class="input-container">
            <input
              type="text"
              name="name"
              id="name_<?php echo esc_attr($block['id']); ?>"
              class="input-contact"
              required
              data-fls-form-errtext="<?php echo esc_attr(
                                        $lang === 'pl' ? 'Wpisz imię' : ($lang === 'ru' ? 'Введите имя' : ($lang === 'uk' ? 'Введіть ім’я' : 'Enter your name'))
                                      ); ?>" />
            <label for="name_<?php echo esc_attr($block['id']); ?>"><?php echo esc_html($i18n['name'][$lang]); ?></label>
            <span><?php echo esc_html($i18n['name'][$lang]); ?></span>
          </div>

          <div class="input-container">
            <input
              type="tel"
              name="phone"
              id="phone_<?php echo esc_attr($block['id']); ?>"
              class="input-contact"
              required
              inputmode="tel"
              autocomplete="tel"
              placeholder="+48 123 456 789"
              data-phone-input
              data-fls-form-errtext="<?php echo esc_attr(
                                        $lang === 'pl' ? 'Wpisz numer telefonu' : ($lang === 'ru' ? 'Введите номер телефона' : ($lang === 'uk' ? 'Введіть номер телефону' : 'Enter your phone number'))
                                      ); ?>"
              data-phone-error="<?php echo esc_attr(
                                  $lang === 'pl' ? 'Wpisz poprawny numer telefonu w formacie międzynarodowym, np. +48 123 456 789.' : ($lang === 'ru' ? 'Введите корректный номер телефона в международном формате, например: +48 123 456 789.' : ($lang === 'uk' ? 'Введіть коректний номер телефону в міжнародному форматі, наприклад: +48 123 456 789.' :
                                    'Enter a valid phone number in international format, e.g. +48 123 456 789.'))
                                ); ?>" />
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
              accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
              multiple
              data-max-files="10"
              data-max-file-size="<?php echo esc_attr(5 * 1024 * 1024); ?>"
              data-error-too-many="<?php echo esc_attr($lang === 'pl' ? 'Możesz dodać maksymalnie 10 zdjęć.' : ($lang === 'ru' ? 'Можно добавить максимум 10 фото.' : ($lang === 'uk' ? 'Можна додати максимум 10 фото.' : 'You can upload up to 10 photos.'))); ?>"
              data-error-too-large="<?php echo esc_attr($lang === 'pl' ? 'Plik jest za duży. Maksymalny rozmiar jednego zdjęcia to 5 MB.' : ($lang === 'ru' ? 'Файл слишком большой. Максимальный размер одного фото — 5 МБ.' : ($lang === 'uk' ? 'Файл занадто великий. Максимальний розмір одного фото — 5 МБ.' : 'File is too large. Maximum size per photo is 5 MB.'))); ?>"
              data-error-invalid-type="<?php echo esc_attr($lang === 'pl' ? 'Nieprawidłowy format pliku. Dozwolone: JPG, PNG, WebP.' : ($lang === 'ru' ? 'Недопустимый формат файла. Разрешены: JPG, PNG, WebP.' : ($lang === 'uk' ? 'Неприпустимий формат файлу. Дозволені: JPG, PNG, WebP.' : 'Invalid file type. Allowed: JPG, PNG, WebP.'))); ?>"
              data-remove-label="<?php echo esc_attr($lang === 'pl' ? 'Usuń' : ($lang === 'ru' ? 'Удалить' : ($lang === 'uk' ? 'Видалити' : 'Remove'))); ?>" />

            <label for="wheel_photos_<?php echo esc_attr($block['id']); ?>" class="file-label">
              <?php echo esc_html($i18n['upload'][$lang]); ?>
            </label>

            <div class="file-note">
              <?php echo esc_html($i18n['upload_note'][$lang]); ?>
            </div>

            <div class="file-list" id="fileList_<?php echo esc_attr($block['id']); ?>"></div>
          </div>

          <div class="form-message" aria-live="polite"></div>

          <button type="submit" class="button-primary btn w_btn2" aria-label="<?php echo esc_attr($button_text); ?>">
            <?php echo esc_html($button_text); ?>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>