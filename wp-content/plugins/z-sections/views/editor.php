<?php
    // Set nonce
    wp_nonce_field('z_sections_meta_nonce', 'z_sections_meta_nonce');
    // Get data
    $z_sections_editor = get_post_meta( $post->ID, 'z_sections_editor', true );
?>
<input type="hidden" name="z_sections_editor" id="z_sections_editor" value='<?php echo esc_attr($z_sections_editor); ?>' />

<?php
// decode the JSON data
$z_sections_editor_data = json_decode($z_sections_editor, true);
?>

<div id="z_sections_editor_sections">
<?php

if($z_sections_editor_data === null) {
    // If the data is null, initialize it with an empty array
    $z_sections_editor_data = [];
}

// Output HTML
foreach ($z_sections_editor_data as $section) {

    // components variables for section content
    $HTML_START = '';
    // $HTML_START_COL and $HTML_END_COL are specific to single-column layouts like image-text/text-image.
    // For columns section, we'll handle column wrapping differently within the loop.
    $HTML_IMAGE = ''; // This will be per-column if needed
    $HTML_CONTENT = ''; // This will be per-column if needed
    $HTML_SHORTCODE = ''; // This will be per-column if needed (unlikely for columns)
    $COMPILED_HTML = '';

    // validate section data
    $type = isset($section['type']) ? htmlspecialchars($section['type']) : 'full-width';
    $bg = isset($section['bg']) ? htmlspecialchars($section['bg']) : '';
    $id = isset($section['id']) ? htmlspecialchars($section['id']) : '';
    $class = isset($section['class']) ? htmlspecialchars($section['class']) : '';
    $fullWidth = isset($section['fullWidth']) ? $section['fullWidth'] : false;
    $collapse = isset($section['collapse']) ? $section['collapse'] : false;
    $reverse = isset($section['reverse']) ? $section['reverse'] : false;
    // These are typically for single image sections, not directly for columns unless each column has one
    // $largeImgLink = isset($section['largeImgLink']) ? htmlspecialchars($section['largeImgLink']) : '';
    // $smallImgLink = isset($section['smallImgLink']) ? htmlspecialchars($section['smallImgLink']) : '';
    // $wysiwygContent = isset($section['wysiwygContent']) ? $section['wysiwygContent'] : '';
    // $shortcode = isset($section['shortcode']) ? htmlspecialchars($section['shortcode']) : '';
    // $btnText = isset($section['btnText']) ? htmlspecialchars($section['btnText']) : '';
    // $btnLink = isset($section['btnLink']) ? htmlspecialchars($section['btnLink']) : '';
    // $btnTarget = isset($section['btnTarget']) ? $section['btnTarget'] : false;

    // start section HTML
    $HTML_START .=      '<section class="' . $type . ($bg ? ' background' : '') . '" '.($bg ? ' style="background-image: url(' . $bg . ');"' : '').'>
                            <div class="section-header handle">
                                <h2>' .($type == 'image-text' ? 'Image and Text' : ($type == 'text-image' ? 'Text and Image' : ucwords( str_replace('-', ' ', $type)))) . '</h2>
                                <a class="toggle-settings"><span class="dashicons dashicons-admin-generic"></span></a>
                                <a class="section-delete"><span class="dashicons dashicons-no"></span></a>
                            </div>
                            <div class="section-settings">
                                <input type="hidden" class="section-type" value="' . $type . '">
                                <input type="hidden" class="section-bg" value="' . $bg . '">
                                <div class="input"><label>ID</label><input type="text" class="section-id" value="' . $id . '"></div>
                                <div class="input"><label>Classes</label><input type="text" class="section-class" value="' . $class . '"></div>
                                <div class="input"><label for="section-full-width">Viewer Width</label><input type="checkbox" class="section-full-width" ' . ($fullWidth ? ' checked' : '') . '></div>';
                                if($type === 'columns' || $type === 'image-text' || $type === 'text-image') { // Added text-image for consistency
                                    $HTML_START .= '<div class="input"><label for="section-collapse">Collapse Spacing</label><input type="checkbox" class="section-collapse" ' . ($collapse ? ' checked' : '') . '></div>';
                                    $HTML_START .= '<div class="input"><label for="section-reverse">Reverse</label><input type="checkbox" class="section-reverse" ' . ($reverse ? ' checked' : '') . '></div>';
                                }
                                $HTML_START .= '<div class="input"><label>Background Image</label><a class="select-bg-image">Select</a><a class="remove-bg-image">Remove</a></div>
                            </div>
                            <div class="section-content">'; // This div will contain the columns

    // Individual content blocks for reusability (moved inside the section loop for clarity, or can be a function)
    $single_image_block = function($largeImgLink) {
        return          '<div class="section-column-image">
                            <figure class="large-img-figure '.($largeImgLink ? ' has-image' : '').'">
                                <img class="large-img-preview" src="' . esc_attr($largeImgLink) . '">
                                <a class="large-img-remove"><span class="dashicons dashicons-no"></span></a>
                                <input type="hidden" class="large-img-link" value="' . esc_attr($largeImgLink) . '">
                            </figure>
                        </div>';
    };

    $single_content_block = function($smallImgLink, $wysiwygContent, $btnText, $btnLink, $btnTarget) {
        return          '<div class="section-column-content">
                            <figure class="small-img-figure '.($smallImgLink ? ' has-image' : '').'">
                                <img class="small-img-preview" src="' . esc_attr($smallImgLink) . '">
                                <a class="small-img-select">Add Thumbnail</a>
                                <a class="small-img-remove"><span class="dashicons dashicons-no"></span></a>
                                <input type="hidden" class="small-img-link" value="' . esc_attr($smallImgLink) . '">
                            </figure>
                            <textarea class="wysiwyg" placeholder="enter your content here">' . esc_textarea($wysiwygContent) . '</textarea>
                            <div class="cta-button '.($btnText ? ' has-button' : '').'">
                                <a class="add-cta-button">Add CTA Button</a>
                                <div class="input"><label>Button Text</label><input type="text" class="btn-text" value="' . esc_attr($btnText) . '"></div>
                                <div class="input"><label>Button Link</label><input type="text" class="btn-link" value="' . esc_attr($btnLink) . '"></div>
                                <div class="input"><label for="btn-target">Open In New Tab</label><input type="checkbox" class="btn-target" ' . ($btnTarget ? ' checked' : '') . '></div>
                            </div>
                        </div>';
    };

    $single_shortcode_block = function($shortcode) {
        return          '<div class="section-column-shortcode">
                            <div class="input"><label>Shortcode</label><input type="text" class="shortcode" value="' . esc_attr($shortcode) . '"></div>
                        </div>';
    };

    $HTML_END =            '</div>
                        </section>';

    // compile section HTML for each section type
    if($type === 'full-width') {
        $wysiwygContent = isset($section['wysiwygContent']) ? $section['wysiwygContent'] : '';
        $smallImgLink = isset($section['smallImgLink']) ? htmlspecialchars($section['smallImgLink']) : '';
        $btnText = isset($section['btnText']) ? htmlspecialchars($section['btnText']) : '';
        $btnLink = isset($section['btnLink']) ? htmlspecialchars($section['btnLink']) : '';
        $btnTarget = isset($section['btnTarget']) ? $section['btnTarget'] : false;

        $COMPILED_HTML = $HTML_START . '<table class="single-column-layout"><tr><td>' . $single_content_block($smallImgLink, $wysiwygContent, $btnText, $btnLink, $btnTarget) . '</td></tr></table>' . $HTML_END;

    } elseif($type === 'columns') {
        // This is where the magic for columns happens!
        $columns_data = isset($section['columns']) && is_array($section['columns']) ? $section['columns'] : [];

        $columns_html = '<div class="columns-container">';
        if (empty($columns_data)) {
            // Render an empty column if no columns exist, so user can add content
            $columns_html .= '<div class="section-column default-column">
                                <a class="column-delete"><span class="dashicons dashicons-no"></span></a>' . // Add delete button for empty column too
                                $single_content_block('', '', '', '', false) . // Empty content
                             '</div>';
        } else {
            foreach ($columns_data as $col_index => $column) {
                // Get column specific data
                $col_smallImgLink = isset($column['smallImgLink']) ? htmlspecialchars($column['smallImgLink']) : '';
                $col_wysiwygContent = isset($column['wysiwygContent']) ? $column['wysiwygContent'] : '';
                $col_btnText = isset($column['btnText']) ? htmlspecialchars($column['btnText']) : '';
                $col_btnLink = isset($column['btnLink']) ? htmlspecialchars($column['btnLink']) : '';
                $col_btnTarget = isset($column['btnTarget']) ? $column['btnTarget'] : false;

                $columns_html .= '<div class="section-column">
                                    <a class="column-delete"><span class="dashicons dashicons-no"></span></a>' .
                                    $single_content_block($col_smallImgLink, $col_wysiwygContent, $col_btnText, $col_btnLink, $col_btnTarget) .
                                 '</div>';
            }
        }
        $columns_html .= '</div>'; // close .columns-container
        $columns_html .= '<div class="column-actions"><a class="button button-secondary add-column">Add Column</a></div>'; // Add column button

        $COMPILED_HTML = $HTML_START . $columns_html . $HTML_END;

    } elseif($type === 'text-image') {
        $largeImgLink = isset($section['largeImgLink']) ? htmlspecialchars($section['largeImgLink']) : '';
        $smallImgLink = isset($section['smallImgLink']) ? htmlspecialchars($section['smallImgLink']) : '';
        $wysiwygContent = isset($section['wysiwygContent']) ? $section['wysiwygContent'] : '';
        $btnText = isset($section['btnText']) ? htmlspecialchars($section['btnText']) : '';
        $btnLink = isset($section['btnLink']) ? htmlspecialchars($section['btnLink']) : '';
        $btnTarget = isset($section['btnTarget']) ? $section['btnTarget'] : false;

        $COMPILED_HTML = $HTML_START . '<table class="single-column-layout"><tr><td>' . $single_content_block($smallImgLink, $wysiwygContent, $btnText, $btnLink, $btnTarget) . '</td><td>' . $single_image_block($largeImgLink) . '</td></tr></table>' . $HTML_END;

    } elseif($type === 'image-text') {
        $largeImgLink = isset($section['largeImgLink']) ? htmlspecialchars($section['largeImgLink']) : '';
        $smallImgLink = isset($section['smallImgLink']) ? htmlspecialchars($section['smallImgLink']) : '';
        $wysiwygContent = isset($section['wysiwygContent']) ? $section['wysiwygContent'] : '';
        $btnText = isset($section['btnText']) ? htmlspecialchars($section['btnText']) : '';
        $btnLink = isset($section['btnLink']) ? htmlspecialchars($section['btnLink']) : '';
        $btnTarget = isset($section['btnTarget']) ? $section['btnTarget'] : false;

        $COMPILED_HTML = $HTML_START . '<table class="single-column-layout"><tr><td>' . $single_image_block($largeImgLink) . '</td><td>' . $single_content_block($smallImgLink, $wysiwygContent, $btnText, $btnLink, $btnTarget) . '</td></tr></table>' . $HTML_END;

    } elseif($type === 'shortcode') {
        $shortcode = isset($section['shortcode']) ? htmlspecialchars($section['shortcode']) : '';
        $COMPILED_HTML = $HTML_START . '<table class="single-column-layout"><tr><td>' . $single_shortcode_block($shortcode) . '</td></tr></table>' . $HTML_END;

    } else {
        // default case for unknown section type
        $COMPILED_HTML = '<p>Unknown section type: ' . htmlspecialchars($type) . '</p>';
    }

    // output compiled HTML
    echo $COMPILED_HTML;
}

?>
</div>

<div id="z_toolbar">
    <div class="z_toolbar_item">
        <a id="z_add_section" class="button button-primary">Add Section</a>
        <ul id="z_section_list">
            <li><figure class="z_section_item" data-section-type="full-width">
                <img src="<?php echo esc_url(plugins_url('z-sections/assets/img/layout-full-width.svg')); ?>" alt="Full Width Section" />
                <figcaption>Full Width</figcaption>
            </figure></li>
            <li><figure class="z_section_item" data-section-type="columns">
                <img src="<?php echo esc_url(plugins_url('z-sections/assets/img/layout-columns.svg')); ?>" alt="Columns Section" />
                <figcaption>Columns</figcaption>
            </figure></li>
            <li><figure class="z_section_item" data-section-type="text-image">
                <img src="<?php echo esc_url(plugins_url('z-sections/assets/img/layout-text-image.svg')); ?>" alt="Text and Image Section" />
                <figcaption>Text and Image</figcaption>
            </figure></li>
            <li><figure class="z_section_item" data-section-type="image-text">
                <img src="<?php echo esc_url(plugins_url('z-sections/assets/img/layout-image-text.svg')); ?>" alt="Image and Text Section" />
                <figcaption>Image and Text</figcaption>
            </figure></li>
            <li><figure class="z_section_item" data-section-type="shortcode">
                <img src="<?php echo esc_url(plugins_url('z-sections/assets/img/layout-shortcode.svg')); ?>" alt="Shortcode Section" />
                <figcaption>Shortcode</figcaption>
            </figure></li>
        </ul>
    </div>
</div>