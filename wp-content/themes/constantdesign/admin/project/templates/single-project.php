<?php
get_header(); the_post();
$excerpt = get_the_excerpt( $post->ID );
// get the post meta for project details
$project_client = get_post_meta( $post->ID, 'project_client', true );
$project_date = get_post_meta( $post->ID, 'project_date', true );
$project_url = get_post_meta( $post->ID, 'project_url', true );
$project_socials = get_post_meta( $post->ID, 'project_socials', true );
$project_banner = get_post_meta( $post->ID, 'project_banner', true );
// get the post meta for project gallery
$project_gallery = get_post_meta( $post->ID, 'project_gallery', true );
?>
<section class="project-header header">
	<?php
	$thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    if ( $project_banner ) {
		echo '<div id="section-background-image" style="background-image: url(' . esc_url( $project_banner ) . ');"></div>';
	}
	elseif ( $thumbnail ) {
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

<section class="description">
	<div class="container">
        <div class="content">
            <div class="row gx-5">
                <div class="col col-12 col-md-6 col-lg-8">
                    <div class="project-description"><?php the_content(); ?></div>
                </div>
                <div class="col col-12 col-md-6 col-lg-4">
                    <div class="project-details">
                        <ul>
                        <?php if ( $project_client ) : ?>
                            <li><strong>Client:</strong> <?php echo esc_html( $project_client ); ?></li>
                        <?php endif; ?>
                        <?php if ( $project_date ) : ?>
                            <li><strong>Date:</strong> 
                            <?php
                            /* readable date */ 
                            $readable_date = date( 'F j, Y', strtotime( $project_date ) );
                            echo esc_html( $readable_date );
                            ?></li>
                        <?php endif; ?>
                        <?php if ( $project_url ) : ?>
                            <li><strong>URL:</strong> <a href="<?php echo esc_url( $project_url ); ?>" target="_blank"><?php echo esc_html( $project_url ); ?></a></li>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</div>
</section>

<section class="gallery">
	<div class="container">
        <div class="content">
            <?php
            
            if ( ! empty( $project_gallery ) && is_array( $project_gallery ) ) {
                echo '<div class="row gx-5">';
                foreach ( $project_gallery as $image_id ) {
                    // original image size
                    $fullimage = wp_get_attachment_image_url( $image_id, 'full' );
                    $image = wp_get_attachment_image_url( $image_id, 'full' );
                    if ( $image ) {
                        echo '<div class="col col-12 visible">';
                        echo '<figure><img src="'.$image.'"></figure>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            }

            ?>
        </div>
    </div>
</section>

<section class="back">
	<div class="container">
        <div class="content">
	        <a href="/projects" class="button">Back to Projects</a>
        </div>
	</div>
</section>

<?php get_footer(); ?>