<?php
// get the post meta for service icon
$service_icon = get_post_meta( $post->ID, 'service_icon', true );
?>

<textarea name="service_icon" id="service_icon" rows="5" class="widefat"><?php echo $service_icon; ?></textarea>
<style>
    #service_icon{
        margin-top: 10px;
        background-color: black;
        color: lime;
        font-family: monospace;
        font-size: 8px;
        min-height: 400px;
    }
</style>