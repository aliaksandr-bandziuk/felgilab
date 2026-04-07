<?php

/**
 * Block Name: All Contacts Block
 */

if (!defined('ABSPATH')) {
  exit;
}

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$all_contacts_i18n = [
  'working_hours_title' => [
    'pl' => 'Godziny pracy',
    'en' => 'Working hours',
    'ru' => 'Время работы',
    'uk' => 'Години роботи',
  ],
  'address_title' => [
    'pl' => 'Adres',
    'en' => 'Address',
    'ru' => 'Адрес',
    'uk' => 'Адреса',
  ],
  'phone_title' => [
    'pl' => 'Telefon',
    'en' => 'Phone',
    'ru' => 'Телефон',
    'uk' => 'Телефон',
  ],
  'email_title' => [
    'pl' => 'E-mail',
    'en' => 'E-mail',
    'ru' => 'E-mail',
    'uk' => 'E-mail',
  ],
];

if (!function_exists('felgilab_all_contacts_normalize_phone')) {
  function felgilab_all_contacts_normalize_phone($phone)
  {
    $phone = trim((string) $phone);

    if ($phone === '') {
      return '';
    }

    $phone = preg_replace('/[^\d+]/', '', $phone);

    if (substr($phone, 0, 1) !== '+') {
      $phone = '+' . ltrim($phone, '+');
    }

    return $phone;
  }
}

if (!function_exists('felgilab_all_contacts_format_phone_display')) {
  function felgilab_all_contacts_format_phone_display($phone)
  {
    $normalized = felgilab_all_contacts_normalize_phone($phone);
    $digits = preg_replace('/\D/', '', $normalized);

    if ($digits === '') {
      return '';
    }

    if (strlen($digits) === 11 && substr($digits, 0, 2) === '48') {
      $local = substr($digits, 2);
      return trim(chunk_split($local, 3, ' '));
    }

    return trim(chunk_split($digits, 3, ' '));
  }
}

$working_hours_raw = get_field('working_hours');
$address_raw       = get_field('address');
$address_url_raw   = get_field('address_url');
$phone_raw         = get_field('phone_full');
$email_raw         = get_field('email');

$working_hours = wp_kses_post($working_hours_raw);
$address       = wp_kses_post($address_raw);
$address_url   = esc_url($address_url_raw);

$phone_href    = felgilab_all_contacts_normalize_phone($phone_raw);
$phone_display = felgilab_all_contacts_format_phone_display($phone_raw);

$email         = sanitize_email($email_raw);
$email_display = antispambot($email);

$block_id = 'all-contacts-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'cta-lite all-contacts-block';

if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}

if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <div class="cta-lite__container">
    <div class="all-contacts-wrapper">

      <?php if (!empty($working_hours)) : ?>
        <div class="ctalite-contact">
          <p class="ctalite-contact__title">
            <?php echo esc_html($all_contacts_i18n['working_hours_title'][$lang]); ?>
          </p>
          <div class="all-contacts-btn">
            <?php echo wp_kses_post(nl2br($working_hours)); ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($address) && !empty($address_url)) : ?>
        <div class="ctalite-contact">
          <p class="ctalite-contact__title">
            <?php echo esc_html($all_contacts_i18n['address_title'][$lang]); ?>
          </p>
          <a
            href="<?php echo esc_url($address_url); ?>"
            class="all-contacts-btn"
            target="_blank"
            rel="noopener noreferrer">
            <?php echo wp_kses_post(nl2br($address)); ?>
          </a>
        </div>
      <?php elseif (!empty($address)) : ?>
        <div class="ctalite-contact">
          <p class="ctalite-contact__title">
            <?php echo esc_html($all_contacts_i18n['address_title'][$lang]); ?>
          </p>
          <div class="all-contacts-btn">
            <?php echo wp_kses_post(nl2br($address)); ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($phone_href) && !empty($phone_display)) : ?>
        <div class="ctalite-contact">
          <p class="ctalite-contact__title">
            <?php echo esc_html($all_contacts_i18n['phone_title'][$lang]); ?>
          </p>
          <a href="tel:<?php echo esc_attr($phone_href); ?>" class="all-contacts-btn">
            <?php echo esc_html($phone_display); ?>
          </a>
        </div>
      <?php endif; ?>

      <?php if (!empty($email)) : ?>
        <div class="ctalite-contact">
          <p class="ctalite-contact__title">
            <?php echo esc_html($all_contacts_i18n['email_title'][$lang]); ?>
          </p>
          <a href="mailto:<?php echo esc_attr($email); ?>" class="all-contacts-btn">
            <?php echo esc_html($email_display); ?>
          </a>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>