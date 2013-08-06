<?php
/**
 * Widget for displaying navigation menus.
 */
/**
 * Adds Fup_Menu_Widget widget.
 */
class Fup_Menu_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'fup_menu_widget', // Base ID
			'Fuplate Menu Widget', // Name
			array( 'description' => __( 'Renders Navigation Menus', 'Fup' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		foreach ( $instance as $key => $value ):

			$$key = $value;

		endforeach;

		if ( empty( $navbar ) ) $navbar = 'none';

		switch ( $args['id'] ):
			case 'sidebar-1':
			case 'sidebar-2':
			case 'sidevar-3':
				$location = 'sidebar';
				break;
			case 'masthead-1':
				$location = 'masthead';
				break;
			case 'footer-1':
				$location = 'footer';
				break;
			case 'lower-left':
				$location = 'left-column';
				break;
			case 'lower-middle':
				$location = 'center-column';
				break;
			case 'lower-right':
				$location = 'right-column';
				break;
			default:
				$location = FALSE;
		endswitch;

		$walker = ( !empty( $walker ) ) ? new  $walker() : NULL;
		if ( !isset( $depth ) ) $depth = 0;

		$options = array(
						  'theme_location'  => $location,
						  'container'       => FALSE,
						  'menu_class'      => $menu_class,
						  'menu_id'         => $menu_id,
						  'fallback_cb'     => FALSE,
						  'before'          => $before,
						  'after'           => $after,
						  'link_before'     => $link_before,
						  'link_after'      => $link_after,
						  'depth'           => $depth,
						  'echo'            => FALSE,
						  'walker'          => $walker,
						  );

		if ( 'none' == $navbar ):

			$title = apply_filters( 'widget_title', $instance['title'] );



				$menu = wp_nav_menu( $options );

			if ( !empty( $menu ) ):
				echo $args['before_widget'];
				if ( !empty( $title ) )
					echo $args['before_title'] . $title
					   . $args['after_title'];
				echo '<nav>';
				echo $menu;
				echo '</nav>';
				echo $args['after_widget'];
			endif;
		else:
			if ( 1 > $depth && 3 < $depth ) $depth = 3;

			$options['walker'] = new wp_bootstrap_navwalker();
			$options['menu_class'] = $class . ' nav navbar-nav';

			$class = 'navbar';
			$class = ( 'fixed-to-top' == $navbar )
				? $class . ' navbar-fixed-top' : $class;
			$class = ( 'fixed-to-bottom' == $navbar )
				? $class . ' navbar-fixed-bottom' : $class;
			$class = ( 'static-top' == $navbar )
				? $class . ' navbar-static-top' : $class;
			$class = ( 'yes' == $inverted )
				? $class . ' navbar-inverse' : $class;

			if ( $menu = wp_nav_menu( $options ) ):
				echo '<div id="nav-' . $location . '" class="' . $class . '">'
				   . '<nav class="container">';
				if ( 'yes' == $responsive ):
					echo '<button type="button" class="navbar-toggle" '
					   . 'data-toggle="collapse" data-target=".'
					   . $location . '-nav"><span class="icon-bar"></span>'
					   . '<span class="icon-bar"></span><span '
					   . 'class="icon-bar"></span></button>';
            	endif;

            	if ( !empty( $title ) ):
            		echo '<p class="navbar-text">' . $title
            		   . '</p>';
            	endif;
            	if ( 'yes' == $responsive ):
            		echo '<div class="nav-collapse collapse '
            		   . 'navbar-responsive-collapse ' . $location . '-nav">';
            	endif;

                echo $menu;
    			if ( 'yes' == $responsive ):
    				echo '</div>';
    			endif;

                echo '</nav></div>';

			endif;
		endif;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ( isset( $instance['title'] ) )
			? $instance[ 'title' ] : NULL;
		$walker = ( isset( $instance['walker'] ) )
			? $instance['walker'] : NULL;
		$menu_class = ( isset( $instance['menu_class'] ) )
			? $instance['menu_class'] : NULL;
		$menu_id = ( isset( $instance['menu_id'] ) )
			? $instance['menu_id'] : NULL;
		$before = ( isset( $instance['before'] ) )
			? $instance['before'] : NULL;
		$after = ( isset( $instance['after'] ) )
			? $instance['after'] : NULL;
		$link_before = ( isset( $instance['link_before'] ) )
			? $instance['link_before'] : NULL;
		$link_after = ( isset( $instance['link_after'] ) )
			? $instance['link_after'] : NULL;
		$depth = ( isset( $instance['depth'] ) )
			? $instance['depth'] : NULL;
		$navbar = ( isset( $instance['navbar'] ) )
			? $instance['navbar'] : 'none';
		$navbar = ( isset( $instance['navbar'] ) )
			? $instance['navbar'] : 'none';
		$responsive = ( isset( $instance['responsive'] ) )
			? $instance['responsive'] : 'no';
		$responsive = ( isset( $instance['inverted'] ) )
			? $instance['inverted'] : 'no';

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php
			_e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php
			echo $this->get_field_id( 'title' ); ?>" name="<?php
			echo $this->get_field_name( 'title' ); ?>" type="text"
			value="<?php echo esc_attr( $title ); ?>"
			placeholder="<?php echo esc_attr_e( 'Menu Title', 'fup' ); ?>">
		</p>
		<fieldset>
			<legend>Navigation bar options:</legend>
			<p>
				<label for="<?php echo $this->get_field_id( 'navbar' );
				?>"><?php _e( 'Make navigation bar?', 'fup' ); ?></label>
				<select id="<?php
					echo $this->get_field_id( 'navbar' );
					?>" name="<?php echo $this->get_field_name( 'navbar' );
					?>">
					<option <?php if ( 'none' === $navbar )
						echo 'selected="selected" '; ?> value="none"><?php
						echo _e( 'No', 'fup'); ?></option>
					<option <?php if ( 'static' === $navbar )
						echo 'selected="selected" '; ?> value="static"><?php
						echo _e( 'Static', 'fup'); ?></option>
					<option <?php if ( 'fixed-to-top' === $navbar )
						echo 'selected="selected" ';
						?> value="fixed-to-top"><?php
						echo _e( 'Fixed to top', 'fup'); ?></option>
					<option <?php if ( 'fixed-to-bottom' === $navbar )
						echo 'selected="selected" ';
						?> value="fixed-to-bottom"><?php
						echo _e( 'Fixed to bottom', 'fup'); ?></option>
					<option <?php if ( 'static-top' === $navbar )
						echo 'selected="selected" ';
						?> value="static-top"><?php
						echo _e( 'Static top navbar', 'fup'); ?></option>

				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'responsive' );
					?>"><?php _e( 'Make responsively collapsing?', 'fup' );
					?></label>
				<select id="<?php
					echo $this->get_field_id( 'responsive' );
					?>" name="<?php echo $this->get_field_name( 'responsive' );
					?>">
					<option <?php if ( 'no' === $responsive )
						echo 'selected="selected" '; ?> value="no"><?php
						echo _e( 'No', 'fup'); ?></option>
					<option <?php if ( 'yes' === $responsive )
						echo 'selected="selected" '; ?> value="yes"><?php
						echo _e( 'Yes', 'fup'); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'inverted' );
				?>"><?php _e( 'Invert colors?', 'fup' ); ?></label>
				<select id="<?php
					echo $this->get_field_id( 'inverted' );
					?>" name="<?php echo $this->get_field_name( 'inverted' );
					?>">
					<option <?php if ( 'no' === $responsive )
						echo 'selected="selected" '; ?> value="no"><?php
						echo _e( 'No', 'fup'); ?></option>
					<option <?php if ( 'yes' === $responsive )
						echo 'selected="selected" '; ?> value="yes"><?php
						echo _e( 'Yes', 'fup'); ?></option>
				</select>
			</p>

		</fieldset>
		<p>&nbsp;</p>
		<fieldset>
			<legend>See the <a
				href="http://codex.wordpress.org/Function_Reference/wp_nav_menu"
				title="Visit Codex for further explanation."> Codex</a> for
				further explanation.
			</legend>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'container_class' );
					?>"><?php _e( 'Container Class:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'container_class' ); ?>"
					name="<?php
					echo $this->get_field_name( 'container_class' );
					?>" type="text" value="<?php
					echo esc_attr( $container_class ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: menu-{menu slug}-container', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'container_id' );
					?>"><?php _e( 'Container ID:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'container_id' ); ?>"
					name="<?php
					echo $this->get_field_name( 'container_id' );
					?>" type="text" value="<?php
					echo esc_attr( $container_id ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: None', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'menu_class' );
					?>"><?php _e( 'Menu Class:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'menu_class' ); ?>"
					name="<?php
					echo $this->get_field_name( 'menu_class' );
					?>" type="text" value="<?php
					echo esc_attr( $menu_class ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: menu', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'menu_id' );
					?>"><?php _e( 'Menu ID:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'menu_id' ); ?>"
					name="<?php
					echo $this->get_field_name( 'menu_id' );
					?>" type="text" value="<?php
					echo esc_attr( $menu_id ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: menu-{menu slug}', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'before' );
					?>"><?php _e( 'Output before &lt;a&gt;:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'before' ); ?>"
					name="<?php
					echo $this->get_field_name( 'before' );
					?>" type="text" value="<?php
					echo esc_attr( $before ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: none', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'after' );
					?>"><?php _e( 'Output after &lt;a&gt;:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'after' ); ?>"
					name="<?php
					echo $this->get_field_name( 'after' );
					?>" type="text" value="<?php
					echo esc_attr( $after ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: none', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'link_before' );
					?>"><?php _e( 'Output text before &lt;a&gt;:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'link_before' ); ?>"
					name="<?php
					echo $this->get_field_name( 'link_before' );
					?>" type="text" value="<?php
					echo esc_attr( $link_before ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: none', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'link_after' );
					?>"><?php _e( 'Output text after &lt;a&gt;:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'link_after' ); ?>"
					name="<?php
					echo $this->get_field_name( 'link_after' );
					?>" type="text" value="<?php
					echo esc_attr( $link_after ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: none', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'depth' );
					?>"><?php _e( 'Menu depth:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'depth' ); ?>"
					name="<?php
					echo $this->get_field_name( 'depth' );
					?>" type="text" value="<?php
					echo esc_attr( $depth ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: 0', 'fup' );
					?>">
			</p>
			<p>
				<label for="<?php
					echo $this->get_field_id( 'walker' );
					?>"><?php _e( 'Use walker:' ); ?></label>
				<input class="widefat" id="<?php
					echo $this->get_field_id( 'walker' ); ?>"
					name="<?php
					echo $this->get_field_name( 'walker' );
					?>" type="text" value="<?php
					echo esc_attr( $walker ); ?>" placeholder="<?php
					echo esc_attr_e( 'Default: Walker_Nav_Menu ', 'fup' );
					?>">
			</p>
		</fieldset>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) )
			? strip_tags( $new_instance['title'] ) : '';
		$instance['menu_class'] = ( ! empty( $new_instance['menu_class'] ) )
			? strip_tags( $new_instance['menu_class'] ) : '';
		$instance['menu_id'] = ( ! empty( $new_instance['menu_id'] ) )
			? strip_tags( $new_instance['menu_id'] ) : '';
		$instance['before'] = ( ! empty( $new_instance['before'] ) )
			? strip_tags( $new_instance['before'] ) : '';
		$instance['after'] = ( ! empty( $new_instance['after'] ) )
			? strip_tags( $new_instance['after'] ) : '';
		$instance['link_before'] = ( ! empty( $new_instance['link_before'] ) )
			? strip_tags( $new_instance['link_before'] ) : '';
		$instance['link_after'] = ( ! empty( $new_instance['link_after'] ) )
			? strip_tags( $new_instance['link_after'] ) : '';
		$instance['depth'] = ( ! empty( $new_instance['depth'] ) )
			? strip_tags( $new_instance['title'] ) : '';
		$instance['walker'] = ( ! empty( $new_instance['walker'] ) )
			? strip_tags( $new_instance['walker'] ) : '';
		$instance['navbar'] = (
								in_array( $new_instance['navbar'],
										  array(
												 'static',
												 'fixed-to-top',
												 'fixed-to-bottom',
												 'static-top',
												 ) ) )
			? $new_instance['navbar'] : none;
		$instance['navbar'] = (
								in_array( $new_instance['navbar'],
										  array(
												 'static',
												 'fixed-to-top',
												 'fixed-to-bottom',
												 'static-top',
												 ) ) )
			? $new_instance['navbar'] : none;

		$instance['responsive'] = ( 'yes' == $new_instance['responsive'] )
			? 'yes' : 'no';
		$instance['inverted'] = ( 'yes' == $new_instance['inverted'] )
			? 'yes' : 'no';


		return $instance;
	}

}


// register Fup_Menu_Widget
function register_fup_menu_widget() {
    register_widget( 'Fup_Menu_Widget' );
}
add_action( 'widgets_init', 'register_fup_menu_widget' );


