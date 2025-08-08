<?php
/**
 * Template Name: Projects Template
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

<?php
if (get_the_content()):
?>
<section id="projects-overview-section">
    <div class="container">
        <div class="content">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<?php
endif;
?>

<section id="projects-list-section">
    <div class="container">
        <div class="content">
            <ul id="projects">
            <?php
            $projects = get_posts([
                'post_type' => 'project',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ]);
            if ($projects) {
                foreach ($projects as $project) {
                    setup_postdata($project);
                    $link = get_permalink($project->ID);
                    $title = get_the_title($project->ID);
                    $excerpt = get_the_excerpt($project->ID);
                    $featured_image = get_the_post_thumbnail_url($project->ID, 'full');
                    $project_socials = get_post_meta( $project->ID, 'project_socials', true );
                    // get all categories for the project
                    $terms = get_the_terms($project->ID, 'category');
                    if ($terms && !is_wp_error($terms)) {
                        $terms = wp_list_pluck($terms, 'name');
                    } else {
                        $terms = [];
                    }
                    ?>
                    <a href="<?php echo esc_url($link); ?>">
                        <li class="project visible">
                            <figure class="project-thumbnail">
                                <img src="<?php echo $featured_image; ?>" alt="<?php echo esc_attr($title); ?>" />
                            </figure>
                            <div class="project-details">
                                <h2><?php echo $title ?></h2>
                                <p class="project-excerpt"><?php echo $excerpt; ?></p>
                                <table>
                                    <tr>
                                        <td class="project-categories">
                                            <?php if ($terms) : ?>
                                                <ul>
                                                    <?php foreach ($terms as $term) : ?>
                                                        <li><?php echo esc_html($term); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </li>
                    </a>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
            </ul>
        </div>
    </div>
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