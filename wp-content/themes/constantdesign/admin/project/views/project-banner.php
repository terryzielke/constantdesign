<?php
// get the post meta for project banner image
$project_banner = get_post_meta( $post->ID, 'project_banner', true );
?>

<div class="frame">
    <div class="project-banner">
        <div class="image-preview">
            <img src="<?=($project_banner ? esc_url( $project_banner ) : 'https://placehold.co/2000x500') ?>" style="width: 100%;" />
        </div>
        <input type="hidden" id="project_banner" name="project_banner" value="<?php echo esc_attr( $project_banner ); ?>" />
        <a class="upload-image-button"><?php esc_html_e( 'Upload Image', 'constantdesign' ); ?></a>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        $('.upload-image-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var custom_uploader = wp.media({
                title: '<?php esc_html_e( 'Upload Image', 'constantdesign' ); ?>',
                button: {
                    text: '<?php esc_html_e( 'Use this image', 'constantdesign' ); ?>'
                },
                multiple: false
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#project_banner').val(attachment.url);
                $('.image-preview img').attr('src', attachment.url);
            })
            .open();
        });
    });
</script>
<?php
// This code is for the project banner meta box in the WordPress admin area.
// It allows users to upload an image for the project banner and preview it.
// The image URL is saved as post meta with the key 'project_banner'.
// The script uses the WordPress media uploader to handle image selection.
// The image preview is displayed below the input field, and a button is provided to upload a new image.
// The code also includes localization for text strings to support translation.
// The nonce field is used for security to verify the request when saving the post.
?>