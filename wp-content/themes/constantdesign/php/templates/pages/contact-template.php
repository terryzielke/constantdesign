<?php
/**
 * Template Name: Contact Template
 */
get_header();
?>
<?php
$thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'full' );
if ( $thumbnail ) {
    echo '<figure id="contact-background-image" style="background-image: url(' . esc_url( $thumbnail ) . ');"></figure>';
}
?>
<section id="contact-header" class="header">
	<?php if ( !$thumbnail ) { echo '<div id="section-background"></div>'; } ?>
	<div class="container">
        <div class="content">
		    <h1><?php the_title(); ?></h1>
        </div>
	</div>
</section>

<?php include (get_template_directory() . '/php/templates/components/contact-form.php'); ?>


<?php
get_footer();
?>