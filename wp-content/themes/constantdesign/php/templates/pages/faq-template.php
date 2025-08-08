<?php
/**
 * Template Name: FAQ Template
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

<section id="ask-a-question-section">
    <div class="container">
        <div class="content">
            <input type="text" id="faq_filter" placeholder="Search frequently asked questions">
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="button">I have more questions</a>
        </div>
    </div>
</section>

<section id="faq-section">
    <div class="container">
        <div class="content">
            <ul id="faq-questions">
            <?php
            $faqs = new WP_Query(array(
                'post_type' => 'faq',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            if ($faqs->have_posts()){
                while ($faqs->have_posts()) : $faqs->the_post();
                    $faq_question = get_the_title();
                    $faq_answer = get_the_content();

                    echo '<li class="faq">';
                    echo '<h3>' . esc_html($faq_question) . '</h3>';
                    echo '<p class="answer">' . wp_kses_post($faq_answer) . '</p>';
                    echo '</li>';
                endwhile;
                wp_reset_postdata();
            }
            ?>
            </ul>
        </div>
    </div>
</section>
<?php
get_footer();
?>