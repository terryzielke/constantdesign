<?php get_header(); the_post(); ?>

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
		<h1><?php the_title(); ?></h1>
	</div>
</section>

<section class="page">
	<div class="container">
		<?php the_content(); ?>
	</div>
</section>

<?php get_footer(); ?>