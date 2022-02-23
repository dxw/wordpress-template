<?php
  if (get_field('header_logo_alt_text', 'option')) {
    $header_logo_alt_text = get_field('header_logo_alt_text', 'option');
  } else {
    $header_logo_alt_text = get_bloginfo('name');
  }
?>

<header class="global-header" role="banner">
    <div class="row">
        <div class="logo">
            <a href="<?php echo site_url() ?>">
              <h1><?php echo $header_logo_alt_text; ?></h1>
              <!-- <img src="<?php echo $theme_uri . '/static/img/logo.png'; ?>" alt="<?php echo $header_logo_alt_text; ?>"> -->
            </a>
        </div>
    </div>
    <div class="row">
        <?php get_template_part('partials/navigation'); ?>
    </div>
</header>
