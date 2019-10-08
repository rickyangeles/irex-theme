<?php
/**
 * Block Name: CTA
 *
 * This is the template that displays the CTA block.
 */

     $width = get_field('width');
     $theme = get_field('color_theme');
     $heading  = get_field('cta_title');
     $content = get_field('cta_text');
     $primaryBtn = get_field('cta_button');
?>

<div class="container-fluid cta <?php echo $width; ?> <?php echo $theme; ?> <?php echo $align; ?>">
    <div class="row d-flex align-items-center">
        <?php if ($primaryBtn) : ?>
            <div class="col-md-9">
        <?php else : ?>
            <div class="col-md-12">
        <?php endif; ?>
            <h3><?php echo $heading; ?></h3>
            <p><?php echo $content; ?></p>
        </div>
        <?php if ( $primaryBtn ) : ?>
            <div class="col-md-3">
                <?php if ( $primaryBtn['url'] ) : ?>
                    <a href="<?php echo $primaryBtn['url'] ?>" class="btn primary-btn"><?php echo $primaryBtn['title']; ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
