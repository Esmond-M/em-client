<?php
/**
 * Custom Nav Walker for em-client theme
 * Adds submenu icon to menu items with children
 */
class EMClient_Mobile_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        // Add submenu with accessible roles and ARIA attributes
        $submenu_id = 'submenu-' . uniqid();
        $output .= "\n$indent<ul class=\"sub-menu\" id=\"$submenu_id\" role=\"menu\" aria-hidden=\"true\">\n";
        $output .= "$indent<li><button class=\"submenu-back-btn\" aria-label=\"Back\">&larr; Back</button></li>\n";
        $output .= "$indent<li class=\"submenu-close-btn\"><button aria-label=\"Close submenu\">
            <svg width=\"32\" height=\"32\" viewBox=\"0 0 32 32\" fill=\"white\" xmlns=\"http://www.w3.org/2000/svg\">
                <line x1=\"8\" y1=\"8\" x2=\"24\" y2=\"24\" stroke=\"white\" stroke-width=\"3\" stroke-linecap=\"round\"/>
                <line x1=\"24\" y1=\"8\" x2=\"8\" y2=\"24\" stroke=\"white\" stroke-width=\"3\" stroke-linecap=\"round\"/>
            </svg>
            </button>
            </li>\n";
    }

    /**
     * Starts the element output.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        // Add toplevel-item to all top-level li
        if ( $depth === 0 ) {
            $classes[] = 'toplevel-item';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $output .= $indent . '<li' . $class_names . ' role="none">';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        // Add submenu icon if item has children
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            // Generate unique submenu id for aria-controls
            $submenu_id = 'submenu-' . uniqid();
            $title .= '<button class="submenu-toggle" aria-label="Expand submenu" aria-expanded="false" aria-controls="' . $submenu_id . '" tabindex="0"><span class="submenu-icon" aria-hidden="true">&#9662;</span></button>';
        }
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . ' role="menuitem">';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}
