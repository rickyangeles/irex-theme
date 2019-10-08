<?php
/**
 * Block Name: Split
 *
 * This is the template that displays the Split block.
 */
;
     $theme = get_field('color_theme');
     $mainContentSize = get_field('main_column_width');
     $mainContentSide = get_field('main_column_side');
     $mainContent = get_field('main_content');
     $primaryBtn = get_field('primary_button');
     $secondaryBtn = get_field('secondary_button');
     $secondaryContent = get_field('secondary_content');

     if ( $mainContentSize == 'col-md-4') {
         $secondaryContentSize = 'col-md-8';
     } elseif ( $mainContentSize == 'col-md-6') {
         $secondaryContentSize = 'col-md-6';
     } else {
         $secondaryContentSize = 'col-md-4';
     }

     if ( $mainContentSide == 'right') {
         $side = 'flex-row-reverse';
     }
?>

<div class="container-fluid split-column <?php echo $theme; ?>">
    <div class="row d-flex align-items-center <?php echo $side; ?>">
        <div class="<?php echo $mainContentSize; ?>">
            <?php echo $mainContent; ?>
            <div class="button-wrap">
                <?php if ( $primaryBtn['url'] ) : ?>
                    <a href="<?php echo $primaryBtn['url'] ?>" class="btn primary-btn"><?php echo $primaryBtn['title']; ?></a>
                <?php endif; ?>
                <?php if ( $secondaryBtn['url'] ) : ?>
                    <a href="<?php echo $secondaryBtn['url'] ?>" class="btn secondary-btn"><?php echo $secondaryBtn['title']; ?></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="<?php echo $secondaryContentSize; ?>">
            <?php if ( $secondaryContent == 'text') : ?>
                <?php echo get_field('text'); ?>
            <?php endif; ?>

            <?php if ( $secondaryContent == 'slideshow') : ?>
                <?php if( have_rows('slideshow') ): ?>
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                	<?php while( have_rows('slideshow') ): the_row();
                		// vars
                		$image = get_sub_field('slide_image');
                		$content = get_sub_field('slide_caption');
                		?>
                         <div class="swiper-slide">
                    		<img src="<?php echo $image; ?>" />
                            <div class="slide-caption"><?php echo $content; ?></div>
                        </div>
                	<?php endwhile; ?>
                </div>
                    <!-- If we need pagination -->
                    <div class="nav-wrap">
                        <div class="swiper-pagination"></div>
                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    </div>
                    <script type="text/javascript">
                    var mySwiper = new Swiper ('.swiper-container', {
                      // Optional parameters
                      direction: 'horizontal',
                      loop: true,

                      // If we need pagination
                      pagination: {
                        el: '.swiper-pagination',
                      },

                      // Navigation arrows
                      navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                      },
                    })
                    </script>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ( $secondaryContent == 'embed') : ?>
                <div class="embed-container">
                	<?php the_field('embed'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
