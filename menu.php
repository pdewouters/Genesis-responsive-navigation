<?php
class sub_nav_walker extends Walker_Nav_Menu {
	var $found_parents = array();

	function start_el(&$output, $item, $depth, $args) {
                 $item_output = '';
		global $wp_query;
		
		//this only works for second level sub navigations
		$parent_item_id = 0;
		
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'.esc_attr($class_names).'"';

		#current_page_item
		// Checks if the current element is in the current selection
		if (strpos($class_names, 'current-menu-item') || strpos($class_names, 'current-menu-parent') || strpos($class_names, 'current-menu-ancestor') || (is_array($this->found_parents) && in_array($item->menu_item_parent, $this->found_parents))) {
			// Keep track of all selected parents
			$this->found_parents[] = $item->ID;
			//check if the item_parent matches the current item_parent
			if ($item->menu_item_parent != $parent_item_id) {
				$output .= $indent.'<li'.$class_names.'>';
				
				$attributes = !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
				$attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
				$attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
				$attributes .= !empty($item->url) ? ' href="'.esc_attr($item->url).'"' : '';
				
				$item_output = $args->before;
				$item_output .= '<a'.$attributes.'><span>';
				$item_output .= $args->link_before.apply_filters('the_title', $item->title, $item->ID).$args->link_after;
				$item_output .= '</span></a>';
				$item_output .= $args->after;
			}
			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}
	}

	function end_el(&$output, $item, $depth) {
		$parent_item_id = 0;
		
		$class_names = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'.esc_attr($class_names).'"';

		if (strpos($class_names, 'current-menu-item') || strpos($class_names, 'current-menu-parent') || strpos($class_names, 'current-menu-ancestor') || (is_array($this->found_parents) && in_array($item->menu_item_parent, $this->found_parents))) {
			// Closes only the opened li
			if (is_array($this->found_parents) && in_array($item->ID, $this->found_parents) && $item->menu_item_parent != $parent_item_id) {
				$output .= "</li>\n";
			}
		}
	}

	function end_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		// If the sub-menu is empty, strip the opening tag, else closes it
		if (substr($output, -22) == "<ul class=\"sub-menu\">\n") {
			$output = substr($output, 0, strlen($output) - 23);
		} else {
			$output .= "$indent</ul>\n";
		}
	}
}

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
        // disable primary and subnav
        remove_action( 'genesis_after_header', 'genesis_do_nav' );
        remove_action( 'genesis_after_header', 'genesis_do_subnav' );
        //display primary nav only top level items
        echo '<div id="menu-wrap">';
        echo '<h2  class="_toggle _expanded">Menu</h2>';
        wp_nav_menu( array(
            'container_class' => '_toggle',
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
        //wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 1, 'menu' => '','menu_id'  => 'wprm_toplevel' ) );
        // display custom subnav menu based on sublevels of current top level menu item
        wp_nav_menu(array('walker' => new sub_nav_walker(),'theme_location' => 'primary','menu' => '', 'menu_class' => 'gsrm-menu','menu_id' => 'gsrm-sub-menu'));
    }
}