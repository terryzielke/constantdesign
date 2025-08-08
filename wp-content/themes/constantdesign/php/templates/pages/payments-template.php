<?php
/**
 * Template Name: Payments Template
 */
get_header();
?>

<section id="payments-header" class="header">
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

<section id="payment-message-section">
    <div class="container">
        <div class="content">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<section id="payments-section">
    <div class="container">
        <div class="content">
	        	<?php echo do_shortcode('[forminator_form id="238"]'); ?>
	        	<!--
                <script async src="https://js.stripe.com/v3/buy-button.js"></script>
                <stripe-buy-button buy-button-id="buy_btn_1Rst06FwgCLRHU9CzHTwM0t5" publishable-key="pk_live_zYDizJQLQQG9b1KlGGI0wdUV00sRkj2YkQ" ></stripe-buy-button>
                -->
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
?>