<?php

$block_id = 'comparison-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'comparison';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$pretitle = get_field('pretitle');
$title = get_field('title');
$description = get_field('description');

$left_column_title = get_field('left_column_title');
$right_column_title = get_field('right_column_title');

$left_items = get_field('left_items');
$right_items = get_field('right_items');

?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">

  <div class="comparison__container">
    <?php if ($pretitle || $title || $description) : ?>
      <div class="comparison__header">
        <?php if ($pretitle) : ?>
          <p class="block-precontent__descr mb10"><?php echo esc_html($pretitle); ?></p>
        <?php endif; ?>

        <?php if ($title) : ?>
          <h2 class="h2 block-precontent__title mb30"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <div class="about-company__divider mb30" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="8">
            <path fill="#fd6b1c" d="M34 0h30v2H34zm0 6h15v2H34zM0 0h30v2H0zm15 6h15v2H15z" />
          </svg>
        </div>


      </div>
    <?php endif; ?>
  </div>

  <div class="comparison__layout">

    <div class="comparison__left">
      <div class="comparison__container">
        <div class="comparison__body comparison__body--left">
          <div class="comparison__content comparison__content--left">

            <?php if ($left_column_title) : ?>
              <h3 class="comparison__column-title">
                <?php echo esc_html($left_column_title); ?>
              </h3>
            <?php endif; ?>

            <?php if (!empty($left_items) && is_array($left_items)) : ?>
              <?php foreach ($left_items as $index => $item) :
                $text = $item['text'] ?? '';
                if (!$text) {
                  continue;
                }
              ?>
                <div class="comparison__item comparison__item--left" style="--i: <?php echo esc_attr($index); ?>;">
                  <div class="comparison__icon comparison__icon--yes" aria-hidden="true">✓</div>
                  <div class="comparison__text">
                    <?php echo esc_html($text); ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>

    <div class="comparison__right">
      <div class="comparison__container">
        <div class="comparison__body comparison__body--right">
          <div class="comparison__content comparison__content--right">

            <?php if ($right_column_title) : ?>
              <h3 class="comparison__column-title">
                <?php echo esc_html($right_column_title); ?>
              </h3>
            <?php endif; ?>

            <?php if (!empty($right_items) && is_array($right_items)) : ?>
              <?php foreach ($right_items as $index => $item) :
                $text = $item['text'] ?? '';
                if (!$text) {
                  continue;
                }
              ?>
                <div class="comparison__item comparison__item--right" style="--i: <?php echo esc_attr($index); ?>;">
                  <div class="comparison__icon comparison__icon--no" aria-hidden="true">✕</div>
                  <div class="comparison__text">
                    <?php echo esc_html($text); ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>

  </div>

</section>