<?php
/**
 * Template Name: Industries Archive
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */


get_header(); ?>

<div class="container-fluid page-header">
    <?php $img = get_field('industry_featured_image', 'options'); ?>
    <?php if ( $img ): ?>
        <img src="<?php echo $img; ?>" alt="">
    <?php else : ?>
        <img src="http://irex.local/wp-content/uploads/2013/10/Applied-LNG-Topock-Amien-Vessel-and-DeMethanizer-Vessel-2.png">
    <?php endif; ?>
    <h1 class="page-title">
        Industries
    </h1>
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
        <div class="col-md-12">
            <?php the_field('industry_content', 'options') ?>
        </div>
    </div>
    <div class="row industry-list">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="col-md-4">
                <div class="industry-card">
                    <strong class="title"><?php the_title(); ?></strong>
                    <?php if ( has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('page-banner'); ?>
                    <?php else : ?>
                        <img src="https://via.placeholder.com/370x89">
                    <?php endif; ?>
                    <p>
                        <?php echo excerpt(20, $post->ID); ?>
                    </p>
                    <ul class="d-flex align-items-center">
                        <li><a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary btn-sm">View Industry</a></li>
                        <li><?php echo $subCount; ?> Subsiduaries</li>
                    </ul>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
