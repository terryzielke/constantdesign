<?php
// get the post meta for project gallery
$project_gallery = get_post_meta( $post->ID, 'project_gallery', true );
?>

<div class="frame">
    <div class="gallery">
        <?php
        // Check if the project gallery is not empty
        if ( ! empty( $project_gallery ) && is_array( $project_gallery ) ) {
            foreach ( $project_gallery as $image_id ) {
                $image_url = wp_get_attachment_image_src( $image_id, 'full' );
                if ( $image_url ) {
                    echo '<div class="gallery-item">';
                    echo '<img src="' . esc_url( $image_url[0] ) . '" alt="" />';
                    echo '<input type="hidden" name="project_gallery[]" value="' . esc_attr( $image_id ) . '" />';
                    echo '<button type="button" class="remove-image">' . esc_html__( 'Remove', 'constantdesign' ) . '</button>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
    <button type="button" id="add-image"><?php esc_html_e( 'Add Image', 'constantdesign' ); ?></button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add new image field
    document.getElementById('add-image').addEventListener('click', function() {
        const gallery = document.querySelector('.gallery');
        const newItem = document.createElement('div');
        newItem.classList.add('gallery-item');
        newItem.innerHTML = `
            <input type="hidden" name="project_gallery[]" value="" />
            <img src="" alt="" />
            <button type="button" class="remove-image"><?php echo esc_html__( 'Remove', 'constantdesign' ); ?></button>
        `;
        gallery.appendChild(newItem);
        // Add event listener for the remove button
        newItem.querySelector('.remove-image').addEventListener('click', function() {
            gallery.removeChild(newItem);
        });
    });
    // Remove image functionality
    document.querySelectorAll('.remove-image').forEach(button => {
        button.addEventListener('click', function() {
            const galleryItem = this.parentElement;
            galleryItem.parentElement.removeChild(galleryItem);
        });
    });
});

// jQuery to handle media selection
jQuery(document).ready(function($) {
    // Open media library to select an image
    $(document).on('click', '.gallery-item img', function() {
        const image = $(this);
        const input = image.siblings('input[type="hidden"]');
        const frame = wp.media({
            title: '<?php echo esc_js( __( 'Select Image', 'constantdesign' ) ); ?>',
            button: {
                text: '<?php echo esc_js( __( 'Use this image', 'constantdesign' ) ); ?>'
            },
            multiple: false
        });
        frame.on('select', function() {
            const attachment = frame.state().get('selection').first().toJSON();
            image.attr('src', attachment.url);
            input.val(attachment.id);
        });
        frame.open();
    });
    // Drag and drop functionality for gallery items
    $('.gallery').sortable({
        items: '.gallery-item',
        cursor: 'move',
        placeholder: 'gallery-item-placeholder',
        update: function(event, ui) {
            // Update the order of images in the hidden input fields
            const order = [];
            $('.gallery-item input[type="hidden"]').each(function() {
                order.push($(this).val());
            });
            // Update the order input field
            $('input[name="project_gallery_order"]').val(order.join(','));
        }
    });
});

</script>
<style>
.gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.gallery-item {
    position: relative;
    width: 150px;
    height: 150px;
    overflow: hidden;
}
.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.gallery-item .remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(255, 255, 255, 0.8);
    border: none;
    border-radius: 4px;
    cursor: pointer;
    padding: 5px;
}
#add-image {
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #9946FF;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
#add-image:hover {
    background-color:rgb(115, 40, 206);
}
</style>
<?php
// End of file wp-content/themes/constantdesign/admin/project/views/project-gallery.php
// This file is part of the Constant Design theme for WordPress.
// It handles the project gallery functionality, allowing users to add and remove images from a project.
// The gallery is displayed with existing images, and users can add new images or remove existing ones.
// The script includes functionality to dynamically add and remove images from the gallery using JavaScript.
// The styles ensure the gallery is displayed in a grid format with appropriate spacing and styling for the images and buttons.
?>