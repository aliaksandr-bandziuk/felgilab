<?php

/**
 * Digits Block
 */

$pretitle = get_field('pretitle') ?: '';
$title = get_field('title') ?: '';
$digit_items = get_field('digit_items');

$classes = 'digits';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}

$wrapper_attributes = get_block_wrapper_attributes([
  'class' => $classes,
]);
?>

<?php if (!empty($digit_items)) : ?>
  <section <?php echo $wrapper_attributes; ?>>
    <div class="digits__container">

      <?php if ($pretitle || $title) : ?>
        <div class="block-precontent mb50">

          <?php if ($pretitle) : ?>
            <p class="block-precontent__descr mb10">
              <?php echo esc_html($pretitle); ?>
            </p>
          <?php endif; ?>

          <?php if ($title) : ?>
            <h2 class="h2 block-precontent__title mb30">
              <?php echo esc_html($title); ?>
            </h2>
          <?php endif; ?>

          <div class="about-company__divider mb30" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="8">
              <path fill="#fd6b1c" d="M34 0h30v2H34zm0 6h15v2H34zM0 0h30v2H0zm15 6h15v2H15z" />
            </svg>
          </div>

        </div>
      <?php endif; ?>

      <div class="digits__items">
        <div class="digits__wrapper">

          <?php foreach ($digit_items as $item) :
            $counter_value  = $item['counter_value'] ?? '';
            $counter_symbol = $item['counter_symbol'] ?? '';
            $digit_title    = $item['digit_title'] ?? '';
            $digit_text     = $item['digit_text'] ?? '';
          ?>
            <div class="digit-item">
              <div class="digit-item__wrapper">

                <div class="digit-item__counter">
                  <p class="counter">
                    <span class="counter__value"><?php echo esc_html($counter_value); ?></span>
                    <?php if (!empty($counter_symbol)) : ?>
                      <?php echo esc_html($counter_symbol); ?>
                    <?php endif; ?>
                  </p>
                </div>

                <?php if ($digit_title || $digit_text) : ?>
                  <div class="digit-item__content">
                    <?php if ($digit_title) : ?>
                      <p class="digit-item__title">
                        <?php echo esc_html($digit_title); ?>
                      </p>
                    <?php endif; ?>

                    <?php if ($digit_text) : ?>
                      <p class="digit-item__text">
                        <?php echo esc_html($digit_text); ?>
                      </p>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

              </div>
            </div>
          <?php endforeach; ?>

        </div>
      </div>

    </div>
  </section>
<?php endif; ?>