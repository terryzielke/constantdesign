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

<script>
/*
VANTA.FOG({
	el: "#your-element-selector",
	mouseControls: true,
	touchControls: true,
	gyroControls: false,
	minHeight: 200.00,
	minWidth: 200.00,
	highlightColor: 0x848484,
	midtoneColor: 0x141414,
	lowlightColor: 0x1f1f20,
	baseColor: 0x0,
	speed: 0.30,
	zoom: 0.50
})
*/
</script>

<?php get_footer(); ?>