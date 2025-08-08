<?php
/**
 * Template file for displaying Z-Sections content on the frontend.
 */
if ( ! isset( $z_sections_data ) || ! is_array( $z_sections_data ) ) {
    global $post;
    if ( $post ) {
        $z_sections_editor = get_post_meta( $post->ID, 'z_sections_editor', true );
        $z_sections_data = json_decode( $z_sections_editor, true );
        if ( ! is_array( $z_sections_data ) ) {
            $z_sections_data = []; // Ensure it's an array even if empty or invalid JSON
        }
    } else {
        $z_sections_data = [];
    }
}

if ( empty( $z_sections_data ) ) {
    return; // Don't output anything if no sections are found.
}
?>
<?php get_header(); ?>

<div class="z-sections">

    <?php
    foreach ( $z_sections_data as $section ) :
        // Sanitize and set default values for section attributes
        $type = isset( $section['type'] ) ? sanitize_html_class( $section['type'] ) : 'full-width';
        $bg = isset( $section['bg'] ) ? esc_url( $section['bg'] ) : '';
        $id = isset( $section['id'] ) && ! empty( $section['id'] ) ? 'id="' . sanitize_title( $section['id'] ) . '"' : '';
        $class_attribute = isset( $section['class'] ) && ! empty( $section['class'] ) ? sanitize_html_class( $section['class'] ) : '';
        $full_width_class = ( isset( $section['fullWidth'] ) && $section['fullWidth'] ) ? ' full-viewer-width' : '';
        $collapse_class = ( isset( $section['collapse'] ) && $section['collapse'] ) ? ' collapse-spacing' : '';
        $reverse_class = ( isset( $section['reverse'] ) && $section['reverse'] ) ? ' section-reverse' : '';

        // Generate inline style for background image if set
        $bg_style = ! empty( $bg ) ? ' style="background-image: url(' . $bg . ');"' : '';

        // Combine all classes
        $section_classes = "z-section {$type}-section {$class_attribute} {$full_width_class} {$collapse_class} {$reverse_class}";
        $section_classes = trim( $section_classes ); // Clean up extra spaces

        // --- Content Block Helper Function (to avoid repetition) ---
        // This function will render the common content elements for a column/section
        $render_content_block = function( $content_data ) {
            $thumbnail_html = '';
            if ( ! empty( $content_data['smallImgLink'] ) ) {
                $thumbnail_html = '<div class="z-thumbnail"><img src="' . esc_url( $content_data['smallImgLink'] ) . '" alt="Thumbnail" /></div>';
            }

            $content_html = '';
            if ( ! empty( $content_data['wysiwygContent'] ) ) {
                $content_html = '<div class="z-content">' . wp_kses_post( $content_data['wysiwygContent'] ) . '</div>';
            }

            $cta_html = '';
            if ( ! empty( $content_data['btnText'] ) && ! empty( $content_data['btnLink'] ) ) {
                $target = ( isset( $content_data['btnTarget'] ) && $content_data['btnTarget'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
                $cta_html = '<div class="z-cta"><a href="' . esc_url( $content_data['btnLink'] ) . '"' . $target . '>' . esc_html( $content_data['btnText'] ) . '</a></div>';
            }
            return $thumbnail_html . $content_html . $cta_html;
        };
    ?>

    <section class="<?php echo esc_attr( $section_classes ); ?>" <?php echo $id; ?> <?php echo $bg_style; ?>>
            <div class="row">

                <?php if ( $type === 'full-width' ) : ?>
                    <div class="col col-12 col-md-12">
                        <?php
                            $content_data = [
                                'smallImgLink'   => isset( $section['smallImgLink'] ) ? $section['smallImgLink'] : '',
                                'wysiwygContent' => isset( $section['wysiwygContent'] ) ? $section['wysiwygContent'] : '',
                                'btnText'        => isset( $section['btnText'] ) ? $section['btnText'] : '',
                                'btnLink'        => isset( $section['btnLink'] ) ? $section['btnLink'] : '',
                                'btnTarget'      => isset( $section['btnTarget'] ) ? $section['btnTarget'] : false,
                            ];
                            echo $render_content_block( $content_data );
                        ?>
                    </div>

                <?php elseif ( $type === 'columns' ) : ?>
                    <?php
                    $columns = isset( $section['columns'] ) && is_array( $section['columns'] ) ? $section['columns'] : [];
                    // responsive column classes based on the number of columns
                    $col_class = 'col col-12 col-md-6';
                    if ( count( $columns ) === 6 ) {
                         $col_class = 'col col-12 col-md-4 col-lg-2';
                    } elseif ( count( $columns ) === 5 ) {
                         $col_class = 'col col-12 col-md-6 col-lg-2';
                    } elseif ( count( $columns ) === 4 ) {
                         $col_class = 'col col-12 col-md-6 col-lg-3';
                    } elseif ( count( $columns ) === 3 ) {
                         $col_class = 'col col-12 col-md-4';
                    } elseif ( count( $columns ) === 2 ) {
                         $col_class = 'col col-12 col-md-6';
                    } elseif ( count( $columns ) === 1 ) {
                         $col_class = 'col col-12 col-md-12';
                    }
                    ?>
                    <?php if ( ! empty( $columns ) ) : ?>
                        <?php foreach ( $columns as $column ) : ?>
                            <div class="<?php echo esc_attr( $col_class ); ?> column-item">
                                <?php
                                    $col_content_data = [
                                        'smallImgLink'   => isset( $column['smallImgLink'] ) ? $column['smallImgLink'] : '',
                                        'wysiwygContent' => isset( $column['wysiwygContent'] ) ? $column['wysiwygContent'] : '',
                                        'btnText'        => isset( $column['btnText'] ) ? $column['btnText'] : '',
                                        'btnLink'        => isset( $column['btnLink'] ) ? $column['btnLink'] : '',
                                        'btnTarget'      => isset( $column['btnTarget'] ) ? $column['btnTarget'] : false,
                                    ];
                                    echo $render_content_block( $col_content_data );
                                ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php elseif ( $type === 'text-image' ) : ?>
                    <div class="col col-12 col-md-6 text-column">
                        <?php
                            $content_data = [
                                'smallImgLink'   => isset( $section['smallImgLink'] ) ? $section['smallImgLink'] : '',
                                'wysiwygContent' => isset( $section['wysiwygContent'] ) ? $section['wysiwygContent'] : '',
                                'btnText'        => isset( $section['btnText'] ) ? $section['btnText'] : '',
                                'btnLink'        => isset( $section['btnLink'] ) ? $section['btnLink'] : '',
                                'btnTarget'      => isset( $section['btnTarget'] ) ? $section['btnTarget'] : false,
                            ];
                            echo $render_content_block( $content_data );
                        ?>
                    </div>
                    <div class="col col-12 col-md-6 image-column">
                        <?php if ( ! empty( $section['largeImgLink'] ) ) : ?>
                            <div class="main-image">
                                <img src="<?php echo esc_url( $section['largeImgLink'] ); ?>" alt="Main Image" />
                            </div>
                        <?php endif; ?>
                    </div>

                <?php elseif ( $type === 'image-text' ) : ?>
                    <div class="col col-12 col-md-6 image-column">
                        <?php if ( ! empty( $section['largeImgLink'] ) ) : ?>
                            <div class="main-image">
                                <img src="<?php echo esc_url( $section['largeImgLink'] ); ?>" alt="Main Image" />
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col col-12 col-md-6 text-column">
                        <?php
                            $content_data = [
                                'smallImgLink'   => isset( $section['smallImgLink'] ) ? $section['smallImgLink'] : '',
                                'wysiwygContent' => isset( $section['wysiwygContent'] ) ? $section['wysiwygContent'] : '',
                                'btnText'        => isset( $section['btnText'] ) ? $section['btnText'] : '',
                                'btnLink'        => isset( $section['btnLink'] ) ? $section['btnLink'] : '',
                                'btnTarget'      => isset( $section['btnTarget'] ) ? $section['btnTarget'] : false,
                            ];
                            echo $render_content_block( $content_data );
                        ?>
                    </div>

                <?php elseif ( $type === 'shortcode' ) : ?>
                    <div class="col col-12 col-md-12">
                        <?php
                        if ( ! empty( $section['shortcode'] ) ) {
                            echo do_shortcode( wp_kses_post( $section['shortcode'] ) );
                        }
                        ?>
                    </div>

                <?php else : ?>
                    <div class="col col-12 col-md-12">
                        <p>Unknown section type: <?php echo esc_html( $section['type'] ); ?></p>
                    </div>
                <?php endif; ?>

            </div></section><?php endforeach; ?>

</div>
<?php get_footer(); ?>
