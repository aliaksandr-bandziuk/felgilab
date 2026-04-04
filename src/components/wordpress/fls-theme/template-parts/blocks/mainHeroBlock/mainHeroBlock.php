<?php
$background_image = get_field('background_image');
$video_id         = get_field('video_id');
$pretitle         = get_field('pretitle');
$title            = get_field('title');
$show_decor       = get_field('show_decor');
$whatsapp_text    = get_field('whatsapp_text');
$whatsapp_url     = get_field('whatsapp_url');
$popup_text       = get_field('popup_text');
$popup_link       = get_field('popup_link');

$image_id  = !empty($background_image['ID']) ? (int) $background_image['ID'] : 0;
$image_alt = !empty($background_image['alt'])
  ? $background_image['alt']
  : (!empty($title) ? wp_strip_all_tags($title) : 'Hero image');

$section_classes = 'main-hero';

if (empty($video_id)) {
  $section_classes .= ' is-no-video';
}
?>

<?php $player_id = 'hero-youtube-player-' . $block['id']; ?>

<section
  class="<?php echo esc_attr($section_classes); ?>"
  data-hero-youtube
  <?php if (!empty($video_id)) : ?>
  data-video-id="<?php echo esc_attr($video_id); ?>"
  <?php endif; ?>>

  <div class="main-hero__media">
    <?php if ($image_id) : ?>
      <div class="main-hero__image">
        <?php
        echo wp_get_attachment_image(
          $image_id,
          'hero-main',
          false,
          [
            'class'         => 'main-hero__img',
            'alt'           => esc_attr($image_alt),
            'loading'       => 'eager',
            'fetchpriority' => 'high',
            'decoding'      => 'async',
            'sizes'         => '100vw',
          ]
        );
        ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($video_id)) : ?>
      <div class="main-hero__video-wrap" aria-hidden="true">
        <div id="<?php echo esc_attr($player_id); ?>" class="main-hero__video"></div>
      </div>
    <?php endif; ?>
  </div>

  <div class="main-hero__body">
    <div class="main-hero__container">
      <div class="main-hero__content">
        <?php if (!empty($pretitle)) : ?>
          <p class="main-hero__pretitle">
            <?php echo esc_html($pretitle); ?>
          </p>
        <?php endif; ?>

        <?php if (!empty($title)) : ?>
          <h1 class="main-hero__title">
            <?php echo nl2br(esc_html($title)); ?>
          </h1>
        <?php endif; ?>

        <?php if ($show_decor) : ?>
          <span class="--icon-decor-double-line-white main-hero__decor" aria-hidden="true"></span>
        <?php endif; ?>

        <div class="main-hero__buttons">
          <?php if (!empty($whatsapp_url) && !empty($whatsapp_text)) : ?>
            <a href="<?php echo esc_url($whatsapp_url); ?>" class="whatsapp-main main-btn">
              <div class="whatsapp-main__wrapper">
                <span class="whatsapp-main__text"><?php echo esc_html($whatsapp_text); ?></span>
                <span class="whatsapp-main__icon --icon-ico-triangle" aria-hidden="true"></span>
              </div>
            </a>
          <?php endif; ?>

          <?php if (!empty($popup_text) && !empty($popup_link)) : ?>
            <button data-fls-popup-link="<?php echo esc_attr($popup_link); ?>" class="button-main main-btn" type="button">
              <div class="button-main__wrapper">
                <span class="button-main__text"><?php echo esc_html($popup_text); ?></span>
                <span class="button-main__icon --icon-ico-triangle" aria-hidden="true"></span>
              </div>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>