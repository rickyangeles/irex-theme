<?php
/**
 * Template Name: Single Service
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */


get_header(); ?>

<?php
    $serviceSlideshow = get_field('service_gallery');
    $serviceCTAcontent = get_field('service_cta_content', 'options');
    $serviceCTAbtn     = get_field('service_cta_button', 'options');
    $pID                = get_the_ID();
?>
<!-- Page Header -->
<div class="container-fluid page-header">
    <?php if (has_post_thumbnail()) :?>
        <?php the_post_thumbnail('page-banner'); ?>
    <?php else: ?>
        <img src="<?php echo the_field('service_featured_image', 'options')?>">
    <?php endif; ?>
    <div class="row">
        <h1 class="page-title">
            <?php the_title(); ?>
        </h1>
    </div>
</div>
<div class="container breadcrumb">
    <div class="row">
        <div class="col-md-12">
            <?php bcn_display(); ?>
        </div>
    </div>
</div>
<div class="container main-content">
    <div class="row">
        <?php if ( $serviceSlideshow ): ?>
            <div class="col-md-6 service-content">
        <?php else : ?>
            <div class="col-md-12 service-content">
        <?php endif; ?>
            <?php the_content(); ?>
            </div>
        <?php
            $images = get_field('gallery');
            $size = 'service-slideshow'; // (thumbnail, medium, large, full or custom size)

            if( $serviceSlideshow ): ?>
                <div class="col-md-6 slideshow">
                    <div class="swiper-container service-slide slide-<?php echo get_the_ID(); ?>" id="<?php echo get_the_ID(); ?>">
                    <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <?php foreach( $serviceSlideshow as $image ): ?>
                                <div class="swiper-slide">
                                    <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                                    <div class="slide-caption"><?php echo $image['caption']; ?></div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                        <div class="nav-wrap">
                            <div class="swiper-pagination"></div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!-- If we need pagination -->
        </div>

    <div class="row">
        <?php
            $subpages = new WP_Query( array(
                'post_type' => 'service',
                'post_parent' => $pID,
                'posts_per_page' => -1,
                'orderby' => 'title'
            ));
         ?>
        <?php if( $subpages->have_posts() ) : ?>
            <div class="col-md-6 service-sub-pages">
                <h4>Services:</h4>
                <ul class="service-list">
                <?php while( $subpages->have_posts() ) : $subpages->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <?php if( $subpages->have_posts() ) : ?>
            <div class="col-md-6 service-cta-wrap">
        <?php else : ?>
            <div class="col-md-8 service-cta-wrap offset-md-2">
        <?php endif; ?>
            <div class="row service-cta d-flex align-items-center">
                <div class="col-md-8 service-cta-content">
                    <?php echo $serviceCTAcontent; ?>
                </div>
                <div class="col-md-4 service-cta-btn">
                    <a href="<?php echo $serviceCTAbtn['url']; ?>" class="btn btn-secondary"><?php echo $serviceCTAbtn['title']; ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contractor -->
<div class="container page-contractor">
    <h3 class="service-title"><?php the_title(); ?> Providers</h3>
        <?php
            $meta = get_post_meta($post->ID, 'dt_connection_map', false);
            $items = array();
            foreach($meta as $k => $v) {
                foreach ($v as $kk => $vv ) {
                    if ($kk == 'external') {
                        foreach($vv as $kkk => $vvv) {
                            $items[] = $kkk;
                        }
                    }
                }
            }
            $query = new WP_Query(array(
                'post_type' => 'dt_ext_connection',
                'post__in' => $items,
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
<?php get_footer(); ?>
