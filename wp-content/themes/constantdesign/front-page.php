<?php get_header(); the_post(); ?>

<script>document.documentElement.className="js";var supportsCssVars=function(){var e,t=document.createElement("style");return t.innerHTML="root: { --tmp-var: bold; }",document.head.appendChild(t),e=!!(window.CSS&&window.CSS.supports&&window.CSS.supports("font-weight","var(--tmp-var)")),t.parentNode.removeChild(t),e};supportsCssVars()||alert("Please view this demo in a modern browser that supports CSS Variables.");</script>
<section id="constant-introduction-section">
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
					<div class="introduction">
						<h1><span>Creative.</span><span>Custom.</span><span>Consistent.</span></h1>
						<?php
							/*At Constant Design, we specialize in helping businesses stand out with exceptional graphic design, custom website solutions, and ongoing website management. Whether you’re building a brand from scratch or need a digital refresh, we deliver powerful, design-driven results that elevate your online presence.*/
							the_content();
							?>
					</div>
					<div class="buttons">
						<a href="/contact" class="button large">Start your next project</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="constant-services-section">
	<div class="row gx-0">
		<div class="col col-12 col-md-4">
			<div class="service visible">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-graphic-design.svg" alt="Graphic Design Icon">
				<h3>Graphic Design for Every Application</h3>
				<p>From logos and business cards to product packaging and digital ads, our graphic design services cover everything you need to build a consistent and impactful brand. We combine creativity with strategy to create visuals that resonate with your audience and support your business goals.</p>
			</div>
		</div>
		<div class="col col-12 col-md-4">
			<div class="service visible">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-web-development.svg" alt="Web Development Icon">
				<h3>Custom Website Solutions</h3>
				<p>No templates here. We design and develop custom websites that are tailored to your brand, your market, and your goals. Our websites are fast, responsive, SEO-friendly, and built to convert. Whether you need an e-commerce site, a portfolio, or a corporate presence, Constant Design has you covered.</p>
			</div>
		</div>
		<div class="col col-12 col-md-4">
			<div class="service visible">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-web-management.svg" alt="Web Management Icon">
				<h3>Website Management Made Easy</h3>
				<p>Our job doesn't end at launch. We offer comprehensive website management services so your site stays secure, updated, and optimized. From content updates and performance tuning to regular backups and plugin maintenance, we keep your digital presence running smoothly.</p>
			</div>
		</div>
	</div>
</section>

<section id="your-constant-advantage-section">
	<div class="container">
		<div class="content">
			<div class="row gx-5">
				<div class="col col-12 col-md-6">
					<h2>Your Constant Advantage.</h2>
				</div>
				<div class="col col-12 col-md-6">
					<ul>
						<li>Over a decade of industry experience</li>
						<li>Fully customized solutions—no cookie-cutters here</li>
						<li>SEO and mobile optimized from the ground up</li>
						<li>One-on-one support and transparent communication</li>
						<li>Full-service design and web management under one roof</li>
					</ul>
				</div>
			</div>
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
				<a href="/contact">Get A Quote_</a>
			</td>
		</tr>
	</table>
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
				<h2><span>Ready to Build</span> <span>Something Great?</span></h2>
				<h3>Let's create something that makes your brand impossible to ignore.</h3>
			</div>
		</div>
	</div>
</section>

<section id="referral-cta-section">
	<div class="container">
		<div class="content">
			<div class="row gx-5">
				<div class="col col-12 col-md-6">
					<h2>Referral Discount Program.</h2>
					<h3>Rewarding you for helping us create something new.</h3>
				</div>
				<div class="col col-12 col-md-6">
					<span class="big-number">15%</span>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="split-links-section">
	<table>
		<tr>
			<td>
				<a href="/referrals">Learn More_</a>
			</td>
		</tr>
	</table>
</section>

<?php get_footer(); ?>