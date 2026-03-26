<?php

/**
 * Team Block
 */

$block_id = 'team-block-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'team-block';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$team_members = get_field('team_members');
?>

<?php if (!empty($team_members)) : ?>
  <section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
    <div class="team-block__container">
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
      <div class="team-members">
        <?php foreach ($team_members as $member) :
          $photo    = $member['photo'] ?? null;
          $name     = $member['name'] ?? '';
          $position = $member['position'] ?? '';

          $photo_url = $photo['url'] ?? '';
          $photo_alt = $photo['alt'] ?? $name;
        ?>
          <div class="team-member">
            <?php if ($photo_url) : ?>
              <div class="team-member__photo">
                <img
                  src="<?php echo esc_url($photo_url); ?>"
                  alt="<?php echo esc_attr($photo_alt); ?>">
              </div>
            <?php endif; ?>

            <?php if ($name || $position) : ?>
              <div class="team-member__info">
                <?php if ($name) : ?>
                  <h3 class="team-member__name"><?php echo esc_html($name); ?></h3>
                <?php endif; ?>

                <?php if ($position) : ?>
                  <p class="team-member__position"><?php echo esc_html($position); ?></p>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>