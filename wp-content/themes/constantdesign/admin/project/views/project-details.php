<?php
// get the post meta for project details
$project_client = get_post_meta( $post->ID, 'project_client', true );
$project_date = get_post_meta( $post->ID, 'project_date', true );
$project_url = get_post_meta( $post->ID, 'project_url', true );
?>

<div class="fields">
    <div class="field">
        <label for="project_client"><?php esc_html_e( 'Client', 'constantdesign' ); ?></label>
        <input type="text" id="project_client" name="project_client" value="<?php echo esc_attr( $project_client ); ?>" />
    </div>
    <div class="field">
        <label for="project_date"><?php esc_html_e( 'Project Date', 'constantdesign' ); ?></label>
        <input type="date" id="project_date" name="project_date" value="<?php echo esc_attr( $project_date ); ?>" />
    </div>
    <div class="field">
        <label for="project_url"><?php esc_html_e( 'Project URL', 'constantdesign' ); ?></label>
        <input type="url" id="project_url" name="project_url" value="<?php echo esc_attr( $project_url ); ?>" />
    </div>
</div>
<style>
.fields {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.field {
    flex: 1 1 calc(33.333% - 20px);
    min-width: 250px;
}
.field label {
    display: block;
    margin-bottom: 5px;
}
.field input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}
</style>
<?php
// End of project details form
// This file is included in the project details meta box callback function in project-index.php
// It handles the display and saving of project details including client, date, URL, and social links.
// The form is designed to be flexible, allowing for multiple social links to be added or removed.
// The JavaScript at the end handles the dynamic addition and removal of social fields.
?>