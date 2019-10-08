<?php
/**
 * Template Name: Front Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() ) : ?>
  <?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<?php

    //Fields
    $bannerImg = wp_get_attachment_url( get_field('banner_image') );
    $srcset = wp_get_attachment_image_srcset( get_field('banner_image') );
    $bannerContent = get_field('banner_content');
    $bannerPrimary = get_field('banner_primary_button');
    $bannerSecondary = get_field('banner_secondary_button');
    $introLeft = get_field('intro_content');
    $introRight = get_field('intro_video');
    $introBG = get_field('intro_bg');
    $introButton = get_field('intro_button');
    $point = get_field('point');
    $industyTitle = get_field('industry_title');
    $industryBG = get_field('industry_background_image');
    //$industry = get_field('select_industries');
    $contractorTitle = get_field('contractor_title');
    $contractorContent = get_field('contractor_content');
    $contractorBtn = get_field('contractor_button');
    $projectTitle = get_field('project_title');
    $featuredProjects = get_field('select_projects_to_feature');
    $projectButton = get_field('project_button');
    $careerTitle = get_field('career_title');
    $careerContent = get_field('career_content');
    $careerSlideshow = get_field('career_slideshow');
    $careerBG = get_field('career_background_image') ? 'style="background-image:url(' . get_field('career_background_image') . ');"' : '';
    $careerButton = get_field('career_button');

    if ( $introBG ) {
        $introBG = 'style="background-image:url(' . get_field('intro_bg') . ')";';
    } else {
        $introBG = '';
    }

    if ( $industryBG ) {
        $industryBG = 'style="background-image:url(' . get_field('industry_background_image') . ')";';
    } else {
        $industryBG = '';
    }

?>
<div class="wrapper" id="full-width-page-wrapper">

    <!-- Banner -->
    <div class="container-fluid banner home-banner px-0">
        <img src="<?php wp_get_attachment_url( get_field('banner_image') ); ?>" srcset="<?php echo esc_attr( $srcset ); ?>" alt="">
        <div class="banner-content">
            <?php echo $bannerContent; ?>
            <ul class="banner-buttons">
                <li><a href="<?php echo $bannerSecondary['url']; ?>" class="btn btn-secondary"><?php echo $bannerSecondary['title']; ?></a></li>
                <li><a href="<?php echo $bannerPrimary['url']; ?>" class="btn btn-primary"><?php echo $bannerPrimary['title']; ?></a></li>
            </ul>
        </div>
    </div>

    <!-- Intro -->
    <div class="container-fluid home-intro py-4" <?php echo $introBG; ?>>
        <div class="row">
            <div class="col-md-6 home-intro-left">
                <?php echo $introLeft; ?>
                <a class="learn-more" href="<?php echo $introButton['url']; ?>"><?php echo $introButton['title']; ?></a>
            </div>
            <div class="col-md-6 home-intro-right embed-responsive embed-responsive-16by9">
                <?php echo $introRight; ?>
            </div>
        </div>
    </div>

    <!-- Major Points -->
    <div class="container home-major-points pt-4">
        <div class="row d-flex justify-content-around">
            <?php if( have_rows('point') ): ?>
            	<?php while( have_rows('point') ): the_row();
            		// vars
            		$icon = get_sub_field('point_icon');
            		$title = get_sub_field('point_title');
            		$content = get_sub_field('point_content');
            	?>
                <div class="col-md-5 point">
                    <?php echo $icon; ?>
                    <h4><?php echo $title; ?></h4>
                    <?php echo $content; ?>
                </div>
            	<?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Industries -->
    <div class="container-fluid home-industries" <?php echo $industryBG; ?>>
        <div class="row">
            <h2 class="title"><?php echo $industyTitle; ?></h2>
        	<ul class="industry-list">
                <?php
                // the query
                    $industry = new WP_Query( array(
                        'post_type' => 'industry',
                        'posts_per_page' => -1,
                        'order' => 'DESC',
                        'orderby' => 'date'
                    ));
                ?>
                <?php if ( $industry->have_posts() ) : ?>
                <?php while ( $industry->have_posts() ) : $industry->the_post(); ?>
                    <li><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                <?php endif; ?>
        	</ul>
        </div>
    </div>

    <!-- Contractor -->
    <div class="container home-contractor">
        <div class="row contractor-cta d-flex align-items-center">
            <div class="col-md-9">
                <h2><?php echo $contractorTitle; ?></h2>
                <p><?php echo $contractorContent; ?></p>
            </div>
            <div class="col-md-3">
                <a href="<?php echo $contractorBtn['url']; ?>" class="btn btn-primary"><?php echo $contractorBtn['title']; ?></a>
            </div>
        </div>

            <?php
        		$query = new WP_Query(array(
        		    'post_type' => 'dt_ext_connection',
        		    'post_status' => 'publish',
        			'posts_per_page' => -1,
                    'orderby'   => 'title',
                    'order'    => 'ASC'
        		));
        	?>
            <?php $counter = 0; ?>
                <div class="row folding-menu">
                <?php while ($query->have_posts()) : ?>
                    <?php $query->the_post(); ?>
                    <?php
                        // if ($counter % 4 == 0) :
                        //     echo $counter > 0 ? '</div></div>' : ''; // close div if it's not the first
                        //     echo '<div class="home-contractor-row container"><div class="row">';
                        // endif; ?>
                		<?php
                        $remove = array("/wp-json", "http://");
                        $url = get_post_meta(get_the_ID(), 'dt_external_connection_url', true);
                        $cleanUrl = str_replace($remove,'', $url);
                        $siteURL = str_replace('/wp-json', '', $url);
                        $title = get_the_title(get_the_ID());
                        $services = $url . "/wp/v2/service/";
                        $locations = $url . "/wp/v2/location/";
                        $logo = $url . "/acf/v3/options/options/header_logo";
                    ?>
                    <div class="menu-item col-md-3 single-sub">
                      <a href="#">
                        <img class="sub-title" data-url="<?php echo $cleanUrl;?>" src="<?php echo get_logo_rest($logo); ?>"/>
                      </a>
                      <div class="folding-content single-sub-info container-fluid">
                          <div class="row">
                              <div class="col-md-6">
                                  <h2><?php echo $title; ?></h2>
                                  website: www.<?php echo $cleanUrl; ?>
                                  <p class="description">description goes here</p>
                                  <a href="<?php echo $siteURL; ?>" class="btn btn-primary">Visit Site</a>
                              </div>
                              <div class="col-md-3">
                                  <h4>Services</h4>
                                  <?php echo get_services_rest($services); ?>
                              </div>
                              <div class="col-md-3">
                                  <h4>Locations</h4>
                                  <?php echo get_locations_rest($locations, $title); ?>
                              </div>
                          </div>
                      </div>
                  </div>
            <?php $counter++; endwhile; ?>
        </div>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>

    <!-- Featured Projects -->
    <div class="container home-featured-projects">
        <div class="row">
            <h2 class="title">Featured Projects</h2>
        </div>
        <?php if( $featuredProjects ): ?>
        <div class="row">
            <?php foreach( $featuredProjects as $post): // variable must be called $post (IMPORTANT) ?>
                <?php setup_postdata($post); ?>
                <div class="col-md-6 single-featured-project d-flex align-items-center">
                    <div class="sfp-left">
                        <h5><?php the_title(); ?></h5>
                        <p><?php echo excerpt(20, $post->ID); ?></p>
                    </div>
                    <div class="sfp-right d-flex align-items-center">
                        <?php if ( has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('featured-project'); ?>
                        <?php else : ?>
                            <img src="https://via.placeholder.com/300">
                        <?php endif; ?>
                        <span><a class="read-more btn btn-sm" href="<?php the_permalink(); ?>">Read More</a></span>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="fp-btn text-center">
                <a href="<?php echo $projectButton['url']; ?>" class="view-all btn btn-primary"><?php echo $projectButton['title']; ?></a>
            </div>
        </div>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
    <?php endif; ?>
        </div>
    </div>

    <!-- Career -->
    <div class="container-fluid home-career" <?php echo $careerBG; ?>>
        <div class="row d-flex align-items-center">
            <h2 class="title"><?php echo $careerTitle; ?></h2>
            <div class="col-md-6 hc-left">
                <?php echo $careerContent; ?>
                <a href="<?php echo $careerButton['url']; ?>" class="btn btn-primary"><?php echo $careerButton['title']; ?></a>
            </div>
            <div class="col-md-6 hc-right">
                <?php if( have_rows('career_slideshow') ): ?>
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                	<?php while( have_rows('career_slideshow') ): the_row();
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
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</div><!-- #full-width-page-wrapper -->

<?php get_footer(); ?>
