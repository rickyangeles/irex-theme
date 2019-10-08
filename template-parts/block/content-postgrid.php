<?php
/**
 * Block Name: Post Grid
 *
 * This is the template that displays the Post Grid block.
 */

     $heading  = get_field('heading');
     $latestPost = get_field('show_latest_4_posts');
     $pickPost = get_field('select_posts');
     $primaryBtn = get_field('primary_button');
     $secondaryBtn = get_field('secondary_button');
?>

<div class="container-fluid post-grid">
    <h2 class="post-grid-title"><?php echo $heading; ?></h2>
    <div class="row d-flex align-items-top">
        <?php if ($latestPost) : ?>
            <?php
            // the query
                $lastest_posts = new WP_Query( array(
                    'post_type' => 'post',
                    'posts_per_page' => 4,
                ));
            ?>

            <?php if ( $lastest_posts->have_posts() ) : ?>
            <?php while ( $lastest_posts->have_posts() ) : $lastest_posts->the_post(); ?>
                <div class="col-md-3 recent-post-single">
                    <a href="<?php echo get_the_permalink(); ?>">
                    <?php if ( has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('page-banner'); ?>
                    <?php else : ?>
                        <img src="https://via.placeholder.com/370x206">
                    <?php endif; ?>
                    <div class="post-content">
                        <h5><?php the_title(); ?></h5>
                        <p><?php echo excerpt(20); ?></p>
                    </div>
                    </a>
                </div>
            <?php endwhile; ?>
            <?php endif; ?>
        <?php elseif ( $pickPost ) : ?>
            <?php if ( $pickPost ) : ?>
                <?php foreach( $pickPost as $post): // variable must be called $post (IMPORTANT) ?>
                    <?php setup_postdata($post); ?>
                    <?php $pID = $post->ID; ?>
                    <div class="col-md-3 recent-post-single">
                        <a href="<?php echo get_the_permalink(); ?>">
                        <?php if ( has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('page-banner'); ?>
                        <?php else : ?>
                            <img src="https://via.placeholder.com/370x206">
                        <?php endif; ?>
                        <div class="post-content">
                            <h5><?php echo get_the_title($pID); ?></h5>
                            <p><?php echo excerpt(20, $pID); ?></p>
                        </div>
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
            <?php endif; ?>
        <?php endif;?>
    </div>
</div>
