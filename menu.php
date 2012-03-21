<?php

/**
 * Custom Walker function for nav menus
 *
 * This function generates a top level menu with descriptions enabled
 *
 * @param type $varname1 Description
 * @param type $varname2 Description
 * @return type Description
*/
class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {

           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0)
           {
                     $description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}

function gsrm_display_menu(){

    if ( has_nav_menu( 'primary' ) ) {

        //display primary nav only top level items

        echo '<div class="menu-wrap"><h2><a href="#">menu</a></h2>';
        wp_nav_menu( array(
            'container_class' => '',
            'menu_class' => 'gsrm-menu',
            'menu_id' => 'gsrm-top-menu',
            'echo' => true,
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'depth' => 1,
            'walker' => new description_walker())
            );
            echo '</div>';

        // display custom subnav menu based on sublevels of current top level menu item
        wp_nav_menu(array('theme_location' => 'primary','menu' => '', 'menu_class' => 'gsrm-menu','menu_id' => 'gsrm-sub-menu'));
    }
}