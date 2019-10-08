<?php
/**
 * Block Name: Full-Width
 *
 * This is the template that displays the Full-Width block.
 */

     $width = get_field('width');
     $theme = get_field('color_theme');
     $align = get_field('text_align');
     $heading  = get_field('header');
     $content = get_field('content');
     $primaryBtn = get_field('primary_button');
     $secondaryBtn = get_field('secondary_button');
?>

<div class="container-fluid full-width <?php echo $width; ?> <?php echo $theme; ?> <?php echo $align; ?>">
    <div class="row">
        <div class="col-md-12">
            <h2><?php echo $heading; ?></h2>
            <?php echo $content; ?>
            <div class="button-wrap">
                <?php if ( $primaryBtn['url'] ) : ?>
                    <a href="<?php echo $primaryBtn['url'] ?>" class="btn primary-btn"><?php echo $primaryBtn['title']; ?></a>
                <?php endif; ?>
                <?php if ( $secondaryBtn['url'] ) : ?>
                    <a href="<?php echo $secondaryBtn['url'] ?>" class="btn secondary-btn"><?php echo $secondaryBtn['title']; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
