<?php
/**
 * Template Name: Service Archive
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */


get_header(); ?>
<!-- Page Header -->
<div class="container-fluid page-header">
    <img src="<?php echo the_field('service_featured_image', 'options')?>">
    <div class="row">
        <h1 class="page-title">
            Services
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
        <div class="col-md-4 left-content">
            <?php the_content(); ?>
        </div>
        <div class="col-md-8 right-content">
            <div class="expand-btn">
                <a id="toggleAccordions-show">Expand All</a> / <a id="toggleAccordions-hide">collapse All</a>
            </div>
            <?php
                $services = array(
                    'post_type' => 'service',
                    'orderby'  => 'title',
                    'order'    => 'ASC',
                    'posts_per_page' => -1,
                    'post_parent' => 0
                );
                $servicePosts = new WP_Query($services);
            ?>
            <?php if ( $servicePosts->have_posts() ) : ?>
                <div id="accordion" class="service-accordion">
                <?php while ( $servicePosts->have_posts() ) : $servicePosts->the_post(); ?>
                    <?php $pID = get_the_ID(); ?>
                    <div class="card">
                        <div class="card-header" id="heading-<?php echo $pID; ?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-<?php echo $pID; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $pID; ?>">
                                    <?php the_title(); ?>
                                    <i class="fas fa-caret-down"></i>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse-<?php echo $pID; ?>" class="collapse" aria-labelledby="heading<?php echo $pID; ?>" data-parent="#accordion">
                            <?php if ( has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('service-archive-banner'); ?>
                            <?php else : ?>
                                <img src="http://irex.local/wp-content/uploads/2013/10/Applied-LNG-Topock-Amien-Vessel-and-DeMethanizer-Vessel-2.png">
                            <?php endif; ?>
                          <div class="card-body">
                              <div class="row">
                                  <?php
                                      $subpages = new WP_Query( array(
                                          'post_type' => 'service',
                                          'post_parent' => $pID,
                                          'posts_per_page' => -1,
                                          'orderby' => 'title'
                                      ));
                                   ?>

                                  <?php if ( $subpages->have_posts() ) : ?>
                                      <div class="col-md-8">
                                  <?php else : ?>
                                      <div class="col-md-12">
                                  <?php endif; ?>
                                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                      <!-- Counting the numbers of connections -->

                                      <ul class="service-button-list d-flex align-items-center">
                                          <li><a href="<?php echo the_permalink(); ?>" class="btn btn-primary btn-sm">View Service Page</a></li>
                                          <li><?php echo total_connections($pID); ?> Providers</li>
                                      </ul>

                                  </div>
                                  <?php
                                      $subpages = new WP_Query( array(
                                          'post_type' => 'service',
                                          'post_parent' => $pID,
                                          'posts_per_page' => -1,
                                          'orderby' => 'title'
                                      ));
                                   ?>
                                  <?php if( $subpages->have_posts() ) : ?>
                                      <div class="col-md-4">
                                          <h5>Related Services</h5>
                                          <ul class="service-list">
                                          <?php while( $subpages->have_posts() ) : $subpages->the_post(); ?>
                                              <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                          <?php endwhile; ?>
                                      </div>
                                  <?php endif; ?>
                              </div>
                          </div>
                      </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- end of the loop -->

            <!-- pagination here -->

                <?php wp_reset_postdata(); ?>
            <?php else : ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
            <?php endif; ?>

        </div>
    </div>
</div>
<div class="container page-contractor">
    <div class="row contractor-cta d-flex align-items-center">
        <div class="col-md-9">
            <?php $contractorTitle = get_field('contractor_title', '5292');
            $contractorContent = get_field('contractor_content', '5292');
            $contractorBtn = get_field('contractor_button', '5292'); ?>
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
                'posts_per_page' => 12,
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
<?php get_footer(); ?>
