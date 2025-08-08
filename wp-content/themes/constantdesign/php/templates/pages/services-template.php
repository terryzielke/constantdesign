<?php
/**
 * Template Name: Services Template
 */
get_header();
?>

<section class="header">
	<?php
	$thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	if ( $thumbnail ) {
		echo '<div id="section-background-image" style="background-image: url(' . esc_url( $thumbnail ) . ');"></div>';
	} else {
		echo '<div id="section-background"></div>';
	}
	?>
	<div class="container">
        <div class="content">
		    <h1><?php the_title(); ?></h1>
        </div>
	</div>
</section>

<section id="services-overview-section">
    <div class="container">
        <div class="content">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<section id="services-list-section">
    <ul id="services">
    <?php

    $services = get_posts([
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ]);
    if ($services) {
        foreach ($services as $service) {
            setup_postdata($service);

            $link = get_permalink($service->ID);
            $title = get_the_title($service->ID);
            $excerpt = get_the_excerpt($service->ID);
            $service_icon = get_post_meta( $service->ID, 'service_icon', true );
            $service_tagline = get_post_meta( $service->ID, 'service_tagline', true );
            ?>
            <li class="service visible">
                <figure class="service-icon">
                    <?php echo $service_icon; ?>
                </figure>
                <h3><?php echo $title ?></h3>
                <div class="service-excerpt">
                    <p><?php echo $service_tagline; ?></p>
                </div>
                <a href="<?php echo esc_url($link); ?>" class="button small">Learn More</a>
            </li>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<li>No services found.</li>';
    }

    ?>
    </ul>
</section>

<section id="ready-to-get-started-section">
	<div class="container">
        <div class="content">
            <div class="row gx-5">
                <div class="col col-12 col-md-6">
                    <h2>Ready to bring your project to life?</h2>
                </div>
                <div class="col col-12 col-md-6">
                    <h3>Connect with our team and share your vision. We'll craft a tailored strategy to help your business succeed and stand out in today's competitive market.</h3>
                    <p><a href="<?php echo esc_url(home_url('/contact')); ?>" class="button">Start Now</a></p>
                </div>
            </div>
        </div>
	</div>
</section>
<?php
get_footer();
?>