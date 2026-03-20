<?php

/**
 * Block Name: Short Contact Block
 */

$block_id = 'short-contact-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'short-form';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$title       = get_field('title') ?: 'Chcesz taki efekt? Skontaktuj się z nami';
$description = get_field('description') ?: 'Skontaktujemy się z Tobą od razu po otrzymaniu wiadomości.';
$button_text = get_field('button_text') ?: 'Oddzwonić';

$wrapper_attributes = '';

if (function_exists('get_block_wrapper_attributes')) {
  $wrapper_attributes = get_block_wrapper_attributes([
    'id'    => $block_id,
    'class' => $classes,
  ]);
} else {
  $wrapper_attributes = sprintf(
    'id="%s" class="%s"',
    esc_attr($block_id),
    esc_attr($classes)
  );
}

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$i18n = [
  'phone' => [
    'pl' => 'Telefon',
    'en' => 'Phone',
    'ru' => 'Телефон',
    'uk' => 'Телефон',
  ],
];

$phone_label = $i18n['phone'][$lang];
?>

<section <?php echo $wrapper_attributes; ?> aria-label="<?php echo esc_attr($title); ?>" class="short-form">
  <div class="short-form__container">
    <div class="short-form__wrapper">
      <p class="title-lite text-center mb20">
        <?php echo esc_html($title); ?>
      </p>

      <p class="text-center mb30 short-form__description">
        <?php echo esc_html($description); ?>
      </p>

      <form action="#" autocomplete="off" class="small-form">
        <div class="input-container">
          <input
            type="tel"
            name="phone"
            class="input-contact"
            inputmode="tel"
            autocomplete="tel" />
          <label for=""><?php echo esc_html($phone_label); ?></label>
          <span><?php echo esc_html($phone_label); ?></span>
        </div>

        <button type="submit" class="button-primary btn" aria-label="<?php echo esc_attr($button_text); ?>">
          <?php echo esc_html($button_text); ?>
        </button>
      </form>
    </div>
  </div>
</section>