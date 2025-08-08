<?php
// get the post meta for service tagline
$service_tagline = get_post_meta( $post->ID, 'service_tagline', true );
?>
<input type="text" name="service_tagline" id="service_tagline" value="<?php echo esc_attr( $service_tagline ); ?>" class="widefat" />