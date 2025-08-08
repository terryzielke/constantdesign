<?php
/**
 * Template Name: Support Template
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

<section id="consultation-form-section">
    <div class="container">
        <div class="content">
            <!-- Google Calendar Appointment Scheduling begin -->
            <iframe src="https://calendar.google.com/calendar/appointments/schedules/AcZssZ1ZrUGZww--NjO3aWUHqYP_Ij98hAea2ambue4bC3xZFjV-3P26PMNXLNGYXn7pe9cuyfGfAmRP?gv=true" style="border: 0" width="100%" height="600" frameborder="0"></iframe>
            <!-- end Google Calendar Appointment Scheduling -->
        </div>
    </div>
</section>

<?php
get_footer();
?>