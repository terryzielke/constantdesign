<?php
/**
 * Template Name: Landing Page - Referrals Template
 */
get_header();
?>
<section id="referral-introduction-section">
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
			<div class="row gx-5">
				<div class="col col-12">
					<center class="introduction">
						<h1>Constant Design Referral Discount Program</h1>
						<h3 class="yellow">Rewarding you for helping us create something new.</h3>
					</center>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="referral-description-section">
	<div class="container">
		<div class="content">
			<div class="row gx-5">
				<div class="col col-12 col-md-6">
					<span class="big-number">15%</span>
				</div>
				<div class="col col-12 col-md-6">
	                <?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="split-links-section yellow darken">
	<table>
		<tr>
			<td>
				<a href="#contact-section">Request A Quote_</a>
			</td>
		</tr>
	</table>
</section>

<section id="referral-how-it-works">
	<div class="container">
		<center class="content">
			<h2>How It Works</h2>
		</center>
	</div>
	<div class="row gx-0">
		<div class="col col-12 col-md-4">
			<div class="service visible">
				<h2>1</h2>
				<h3>Tell Your Network</h3>
				<p>Share your positive experience with Constant Design — whether it’s our stunning branding, sleek websites, or strategic marketing solutions.</p>
			</div>
		</div>
		<div class="col col-12 col-md-4">
			<div class="service visible">
				<h2>2</h2>
				<h3>Send Them Our Way</h3>
				<p>Have your referral include your name and email when they submit a quote request, or mention you in a direct email to us.</p>
			</div>
		</div>
		<div class="col col-12 col-md-4">
			<div class="service visible">
				<h2>3</h2>
				<h3>They Save Money</h3>
				<p>Once a new client signs their first contract, they’ll receive a discount of up to 15%, based on the project scope.</p>
			</div>
		</div>
	</div>
</section>

<section id="why-refer-constant-design-section">
	<div class="container">
		<div class="content">
			<div class="row gx-5">
				<div class="col col-12 col-md-6">
					<h2>Why Refer Constant Design?</h2>
				</div>
				<div class="col col-12 col-md-6">
					<ul>
						<li>Support small business growth in Calgary and beyond.</li>
						<li>Help other businesses access professional branding, web design, and graphics.</li>
						<li>Feel great about helping your friends save money!</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="build-something-great-section">
	<div id="build-something-great-background">
		<div 
			id="gl" 
			data-imageOriginal="<?php echo get_template_directory_uri(); ?>/assets/img/parrot-with-a-megaphone.jpg" 
			data-imageDepth="<?php echo get_template_directory_uri(); ?>/assets/img/parrot-with-a-megaphone-map.jpg" 
			data-horizontalThreshold="35" 
			data-verticalThreshold="15">
		</div>
	</div>
	<div class="container">
		<div class="content">
			<div class="text visible">
				<h2>Start Referring Today</h2>
				<h3>Your network already knows you have great taste —  now share it and save them 15%.</h3>
			</div>
		</div>
	</div>
</section>

<section class="split-links-section yellow">
	<table>
		<tr>
			<td>
				<a href="#contact-section">Get A Quote_</a>
			</td>
			<td>
				<a href="/projects">See Our Work_</a>
			</td>
		</tr>
	</table>
</section>

<?php include (get_template_directory() . '/php/templates/components/contact-form.php'); ?>

<section id="referral-program-rules-section">
	<div class="container">
		<div class="content">
			<h3>Referral Discount Program – Terms & Conditions</h3>
			
			<h5>Eligibility</h5>
			<ul>
				<li>The referral discount applies only to new Constant Design clients who have not previously worked with us.</li>
				<li>To receive the discount, the referred client must provide the full name, and email of the person who referred them at the time of their initial inquiry or quote request.</li>
			</ul>
			
			<h5>Discount Details</h5>
			<ul>
				<li>Referred clients will receive <strong>5% off</strong> the total cost of their first signed project, if the project <strong>over $1,500.00</strong>.</li>
				<li>Referred clients will receive <strong>10% off</strong> the total cost of their first signed project, if the project <strong>over $5,000.00</strong>.</li>
				<li>Referred clients will receive <strong>15% off</strong> the total cost of their first signed project, if the project <strong>over $10,000.00</strong>.</li>
				<li>The discount applies only to the first project the referred client signs a contract for, not any subsequent projects.</li>
			</ul>
			
			<h5>Referral Name Submission</h5>
			<ul>
				<li>The referral name must be provided before or at the time of signing the project contract.</li>
				<li>Failure to provide the referral name at this stage will result in the discount not being applied.</li>
			</ul>
			
			<h5>Limitations</h5>
			<ul>
				<li>The discount cannot be combined with any other promotions, discounts, or offers.</li>
				<li>The discount is non-transferable and has no cash value.</li>
				<li>Constant Design reserves the right to verify the referrer’s identity before applying the discount.</li>
			</ul>
			
			<h5>Program Changes</h5>
			<ul>
				<li>Constant Design may modify or discontinue this program at any time without prior notice.</li>
				<li>Any changes will not affect discounts already approved prior to the modification date.</li>
			</ul>
		</div>
	</div>
</section>

<?php
get_footer();
?>