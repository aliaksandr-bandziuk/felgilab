<?php

/**
 * CTA Lite Block template
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Get current language
 */
$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

/**
 * Static translations
 */
$cta_lite_i18n = [
  'content_title' => [
    'pl' => 'Umów się na wizytę lub uzyskaj wycenę',
    'en' => 'Book a visit or get a quote',
    'ru' => 'Запишитесь на визит или получите оценку',
    'uk' => 'Запишіться на візит або отримайте оцінку',
  ],
  'phone_title' => [
    'pl' => 'Zaplanuj wizytę',
    'en' => 'Book a visit',
    'ru' => 'Запланируйте визит',
    'uk' => 'Заплануйте візит',
  ],
  'email_title' => [
    'pl' => 'Skontaktuj się z nami',
    'en' => 'Contact us',
    'ru' => 'Свяжитесь с нами',
    'uk' => 'Зв’яжіться з нами',
  ],
  'logo_alt' => [
    'pl' => 'Kontakt Felgilab',
    'en' => 'Felgilab contact',
    'ru' => 'Контакты Felgilab',
    'uk' => 'Контакти Felgilab',
  ],
];

/**
 * Helpers
 */
if (!function_exists('felgilab_cta_lite_normalize_phone')) {
  function felgilab_cta_lite_normalize_phone($phone)
  {
    $phone = trim((string) $phone);

    if ($phone === '') {
      return '';
    }

    // Allow only digits and one leading +
    $phone = preg_replace('/[^\d+]/', '', $phone);

    if (substr($phone, 0, 1) !== '+') {
      $phone = '+' . ltrim($phone, '+');
    }

    return $phone;
  }
}

if (!function_exists('felgilab_cta_lite_format_phone_display')) {
  function felgilab_cta_lite_format_phone_display($phone)
  {
    $normalized = felgilab_cta_lite_normalize_phone($phone);
    $digits = preg_replace('/\D/', '', $normalized);

    if ($digits === '') {
      return '';
    }

    /**
     * For Polish numbers entered as +48XXXXXXXXX
     * visible output: 739 103 744
     */
    if (strlen($digits) === 11 && substr($digits, 0, 2) === '48') {
      $local = substr($digits, 2);

      return trim(chunk_split($local, 3, ' '));
    }

    /**
     * Fallback:
     * remove plus and show grouped digits with spaces
     */
    return trim(chunk_split($digits, 3, ' '));
  }
}

/**
 * Block fields
 */
$phone_raw = get_field('phone_full');
$email_raw = get_field('email');

/**
 * Sanitized values
 */
$phone_href = felgilab_cta_lite_normalize_phone($phone_raw);
$phone_display = felgilab_cta_lite_format_phone_display($phone_raw);

$email = sanitize_email($email_raw);
$email_display = antispambot($email);

/**
 * Block classes
 */
$block_id = 'cta-lite-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$class_name = 'cta-lite';

if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}

if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
  <div class="cta-lite__container">
    <div class="cta-lite__wrapper">
      <div class="ctalite-content">
        <img
          src="/wp-content/uploads/2026/03/cropped-felgilab-logo.png"
          alt="<?php echo esc_attr($cta_lite_i18n['logo_alt'][$lang]); ?>"
          class="ctalite-content__image">
        <p class="ctalite-content__title">
          <?php echo esc_html($cta_lite_i18n['content_title'][$lang]); ?>
        </p>
      </div>

      <?php if (!empty($phone_href) && !empty($phone_display)) : ?>
        <div class="ctalite-contact">
          <p class="ctalite-contact__title">
            <?php echo esc_html($cta_lite_i18n['phone_title'][$lang]); ?>
          </p>
          <a href="tel:<?php echo esc_attr($phone_href); ?>" class="ctalite-contact__btn">
            <?php echo esc_html($phone_display); ?>
          </a>
        </div>
      <?php endif; ?>

      <?php if (!empty($email)) : ?>
        <div class="ctalite-contact">
          <p class="ctalite-contact__title">
            <?php echo esc_html($cta_lite_i18n['email_title'][$lang]); ?>
          </p>
          <a href="mailto:<?php echo esc_attr($email); ?>" class="ctalite-contact__btn">
            <?php echo esc_html($email_display); ?>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>