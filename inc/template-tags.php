
<?php
/**
 * Custom template tags for this theme
 *
 * @package em-client
 *
 * This file defines the EmClient_Template_Tags class, which provides reusable helper functions for displaying post meta information in your theme.
 *
 * Functions included:
 * - posted_on(): Prints HTML with meta information for the current post date/time.
 * - posted_by(): Prints HTML with meta information for the current author.
 * - entry_footer(): Prints HTML for categories, tags, comments, and edit link.
 * - post_thumbnail(): Displays the post’s featured image (thumbnail).
 * - wp_body_open(): Calls the wp_body_open action for compatibility.
 *
 * These functions help keep your template files clean and make it easy to update post meta output in one place.
 */
class EmClient_Template_Tags {
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    public static function posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'em-client' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Prints HTML with meta information for the current author.
     */
    public static function posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x( 'by %s', 'post author', 'em-client' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    public static function entry_footer() {
        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() ) {
            $categories_list = get_the_category_list( esc_html__( ', ', 'em-client' ) );
            if ( $categories_list ) {
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'em-client' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'em-client' ) );
            if ( $tags_list ) {
                printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'em-client' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'em-client' ),
                        array( 'span' => array( 'class' => array(), ) )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'em-client' ),
                    array( 'span' => array( 'class' => array(), ) )
                ),
                wp_kses_post( get_the_title() )
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }

    /**
     * Displays an optional post thumbnail.
     */
    public static function post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
            <?php
        else :
            ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                    the_post_thumbnail(
                        'post-thumbnail',
                        array(
                            'alt' => the_title_attribute( array( 'echo' => false ) ),
                        )
                    );
                ?>
            </a>
            <?php
        endif;
    }

    /**
     * Shim for sites older than 5.2.
     */
    public static function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}
