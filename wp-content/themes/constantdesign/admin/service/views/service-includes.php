<?php
// get the post meta for service include
$service_include = get_post_meta( $post->ID, 'service_include', true );

// output service include repeatable field: desc
$service_include = !empty($service_include) ? $service_include : array(array('desc' => ''));
?>
<div class="service-includes">
    <div class="service-includes-fields">
        <?php foreach ($service_include as $index => $include) : ?>
            <div class="service-include-field">
                <label for="service_include_<?php echo $index; ?>_desc"><?php esc_html_e( 'Description', 'constantdesign' ); ?></label>
                <input type="text" id="service_include_<?php echo $index; ?>_desc" name="service_include[<?php echo $index; ?>][desc]" value="<?php echo esc_attr($include['desc']); ?>" />
                <button type="button" class="remove-include"><?php esc_html_e( 'Remove', 'constantdesign' ); ?></button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-include"><?php esc_html_e( 'Add Service', 'constantdesign' ); ?></button>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add new include field
    document.getElementById('add-include').addEventListener('click', function() {
        const index = document.querySelectorAll('.service-include-field').length;
        const newField = document.createElement('div');
        newField.classList.add('service-include-field');
        newField.innerHTML = `
            <label for="service_include_${index}_desc"><?php esc_html_e( 'Description', 'constantdesign' ); ?></label>
            <input type="text" id="service_include_${index}_desc" name="service_include[${index}][desc]" value="" />
            <button type="button" class="remove-include"><?php esc_html_e( 'Remove', 'constantdesign' ); ?></button>
        `;
        document.querySelector('.service-includes-fields').appendChild(newField);   
    });
    // Remove include field
    document.querySelector('.service-includes-fields').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-include')) {
            e.target.parentElement.remove();
        }
    });
});
</script>
<style>
.service-includes {
    margin-bottom: 20px;
}
.service-includes-fields {
    display: flex;
    flex-direction: column;
}
.service-include-field {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
.service-include-field label {
    margin-right: 10px;
}
.service-include-field input {
    width: calc(50% - 10px);
    padding: 2px;
    box-sizing: border-box;
    margin-right: 10px;
}
.service-include-field button {
    padding: 8px 12px;
    background-color: #FF4D6D;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.service-include-field button:hover {
    background-color:rgb(210, 48, 78);
}
#add-include {
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #9946FF;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
#add-include:hover {
    background-color:rgb(115, 40, 206);
}
</style>
<?php
// This file is used to display the service includes meta box in the admin area.
// It allows users to add, edit, and remove service includes for a service post type.
// The includes are stored as a repeatable field in the post meta.
// The script handles adding and removing include fields dynamically.
// The styles ensure the fields are displayed in a user-friendly manner.
// The service includes are saved when the post is saved, using the `constantdesign_save_service_includes` function defined in the service index file.
?>