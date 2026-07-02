<?php
/*
Template Name: Order Status
Template Post Type: page
*/

get_header();

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';

$texts = [
  'pl' => [
    'description' => 'Kliknij przycisk poniżej i wprowadź numer telefonu podany podczas składania zamówienia, aby sprawdzić aktualny status realizacji.',
    'note' => 'Jeśli nie pamiętasz numeru telefonu użytego w zamówieniu, skontaktuj się z nami.',
  ],
  'en' => [
    'description' => 'Click the button below and enter the phone number provided when placing your order to check its current status.',
    'note' => 'If you do not remember the phone number used for the order, please contact us.',
  ],
  'ru' => [
    'description' => 'Нажмите кнопку ниже и введите номер телефона, указанный при оформлении заказа, чтобы проверить его текущий статус.',
    'note' => 'Если вы не помните номер телефона, указанный при оформлении заказа, свяжитесь с нами.',
  ],
  'uk' => [
    'description' => 'Натисніть кнопку нижче та введіть номер телефону, вказаний під час оформлення замовлення, щоб перевірити його поточний статус.',
    'note' => 'Якщо ви не пам’ятаєте номер телефону, вказаний під час оформлення замовлення, зв’яжіться з нами.',
  ],
];

$t = $texts[$current_lang] ?? $texts['pl'];
?>

<main class="order-status-page">

  <section
    class="standard-hero">
    <div class="main-hero__media">
      <div class="main-hero__image">
        <!-- featured image -->
        <?php
        if (has_post_thumbnail()) {
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
          $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
        } else {
          $image_url = '';
          $image_alt = '';
        }
        ?>
        <img
          src="<?php echo esc_url($image_url); ?>"
          alt="<?php echo esc_attr($image_alt); ?>"
          class="main-hero__img">
      </div>
    </div>

    <div class="main-hero__body">
      <div class="main-hero__container">
        <div class="main-hero__content">

          <div class="breadcrumbs" aria-label="Breadcrumb">
            <?php custom_breadcrumbs(); ?>
          </div>

          <h1 class="main-hero__title">
            <?php the_title(); ?>
          </h1>
          <span class="--icon-decor-double-line-white main-hero__decor" aria-hidden="true"></span>
        </div>
      </div>
    </div>
  </section>

  <section class="order-status-page__hero">
    <div class="order-status-page__container">

      <p class="order-status-page__description">
        <?php echo esc_html($t['description']); ?>
      </p>

    </div>
  </section>

  <section class="order-status-page__section">
    <div class="order-status-page__container">

      <div class="order-status-page__card">
        <div class="order-status-page__widget" id="order-status-widget-place"></div>

        <p class="order-status-page__note">
          <?php echo esc_html($t['note']); ?>
        </p>
      </div>

    </div>
  </section>

  <?php while (have_posts()) : the_post(); ?>
    <div class="entry-content mt50 mb50">
      <?php the_content(); ?>
    </div>
  <?php endwhile; ?>

</main>

<script type="text/javascript">
  (function() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.async = true;
    script.src = "https://web.roapp.io/static/order-status-widget/dist/loader.js";
    script.setAttribute("data-widget-key", "677907455f70cecb4304a399c3e927ac");
    document.getElementsByTagName("head")[0].appendChild(script);
  })();
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const widgetPlace = document.getElementById('order-status-widget-place');

    const interval = setInterval(function() {
      const iframe = document.getElementById('order-status-widget-frame');

      if (iframe && widgetPlace) {
        widgetPlace.appendChild(iframe);

        iframe.style.setProperty('position', 'static', 'important');
        iframe.style.setProperty('display', 'block', 'important');
        iframe.style.setProperty('margin', '0 auto', 'important');
        iframe.style.setProperty('width', '185px', 'important');
        iframe.style.setProperty('height', '46px', 'important');
        iframe.style.setProperty('left', 'auto', 'important');
        iframe.style.setProperty('right', 'auto', 'important');
        iframe.style.setProperty('bottom', 'auto', 'important');
        iframe.style.setProperty('z-index', '1', 'important');

        clearInterval(interval);
      }
    }, 300);

    setTimeout(function() {
      clearInterval(interval);
    }, 10000);
  });
</script>

<?php get_footer(); ?>