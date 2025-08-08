<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// get the post ID
$post = get_post();
$title = get_the_title( $post->ID );
$thumbnail = get_the_post_thumbnail( $post->ID, 'full' );
$excerpt = get_the_excerpt( $post->ID );
// get the post meta for service
$service_icon = get_post_meta( $post->ID, 'service_icon', true );
$service_include = get_post_meta( $post->ID, 'service_include', true );
$service_tagline = get_post_meta( $post->ID, 'service_tagline', true );

get_header();
?>

<section class="header">
	<div id="service-background"><?php echo $service_icon; ?></div>
	<div class="container">
        <div class="content">
		    <h1><?php the_title(); ?></h1>
        </div>
	</div>
</section>

<section id="service-description-section">
    <div class="container">
        <div class="content">
            <div class="description"><?php the_content(); ?></div>
        </div>
    </div>
</section>

<section id="services-included-section">
    <div class="container">
        <div class="content">
            <h3>Our <?php echo $title; ?> Services Include:</h3>
            <ul class="services-included">
                <?php foreach ($service_include as $index => $include) : ?>
                    <li><?php echo esc_attr($include['desc']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<section id="service-tagline-section">
    <div class="container">
        <div class="content">
            <h3><?php echo $service_tagline; ?></h3>
        </div>
    </div>
</section>

<section class="split-links-section">
	<table>
		<tr>
			<td>
				<a href="/projects">See Our Work_</a>
			</td>
			<td>
				<a href="/contact/quote">Get A Quote_</a>
			</td>
		</tr>
	</table>
</section>

<?php
get_footer();
?>