<?php 

class SN_Testimonials_Widget extends WP_Widget{
	 /**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'sn-testimonials-widget',
			'description' => __('Beautiful testimonials' , 'sn-testimonials'),
		);
		parent::__construct( 'sn-testimonials', 'SN Testimonials', $widget_ops );

		add_action( 'widgets_init', function(){
		     register_widget( 'SN_Testimonials_Widget' );
		});

		add_action('wp_enqueue_scripts' , array($this , 'enqueue'));
	}

	// enqueue
	public function enqueue(){
		wp_enqueue_style(
			'sn-testimonials-widget-css' ,
			SN_TESTIMONIALS_URL.'assets/css/frontend.css'
		);

	}

	// Form 
	public function form($instance){
		$title = isset($instance['title']) ? $instance['title'] : ''; 
		$number = isset($instance['number']) ? (int) $instance['number'] : 3; 
		$image = isset($instance['image']) ? (bool) $instance['image'] : false; 
		$occupation = isset($instance['occupation']) ? (bool) $instance['occupation'] : false;
		$company = isset($instance['company']) ? (bool) $instance['company'] : false;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of testimonials:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" size="3" min="1" step="1"  value="<?php echo $number; ?>" />
		</p>

		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="checkbox" <?php checked($image); ?>  />
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Display image' ); ?></label>
			
		</p>

		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'occupation' ); ?>" name="<?php echo $this->get_field_name( 'occupation' ); ?>" type="checkbox" <?php checked($occupation); ?> />
			<label for="<?php echo $this->get_field_id( 'occupation' ); ?>"><?php _e( 'Display occupation' ); ?></label>
			
		</p>

		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'company' ); ?>" name="<?php echo $this->get_field_name( 'company' ); ?>" type="checkbox" <?php checked($company); ?> />
			<label for="<?php echo $this->get_field_id( 'company' ); ?>"><?php _e( 'Display company' ); ?></label>
			
		</p>

		<?php
	}

	// Widget 
	public function widget($args, $instance){
		$default_title = "What our clients say?";
		$title = !empty($instance['title']) ? $instance['title'] : $default_title;
		$number = !empty($instance['number']) ? $instance['number'] : 4;
		$image = isset($instance['image']) ? $instance['image'] : false;
		$occupation = isset($instance['occupation']) ? $instance['occupation'] : false;
		$company = isset($instance['company']) ? $instance['company'] : false; 

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		require(SN_TESTIMONIALS_PATH.'views/sn-testimonials_widget.php');
		
		echo $args['after_widget'];
	}

	// Form 
	public function update($new_instance, $old_instance){
		$instance = $old_instance ;
		$instance['title'] = sanitize_text_field( $new_instance['title'] ) ;
		$instance['number'] = (int) $new_instance['number'];
		$instance['image'] = !empty($new_instance['image']) ? 1 : 0  ;
		$instance['occupation'] = !empty($new_instance['occupation']) ? 1 : 0  ;
		$instance['company'] = !empty($new_instance['company']) ? 1 : 0  ;
		return $instance;
	}
}