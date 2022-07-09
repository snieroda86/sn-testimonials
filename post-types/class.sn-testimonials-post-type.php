<?php 

if( !class_exists('SN_Testimonials_Post_Type')){
	class SN_Testimonials_Post_Type{

		public function __construct(){
			add_action('init' , array($this , 'createPostType') );
			add_action( 'add_meta_boxes', array($this , 'sn_add_custom_box') );
			add_action( 'save_post', array($this , 'save_post' ) );
		}


		public function createPostType(){
			register_post_type( 'sn-testimonials',
		    // CPT Options
		        array(
		            'labels' => array(
		                'name' => __( 'SN Testimonials' ),
		                'singular_name' => __( 'Testimonial' )
		            ),
		            'supports' => array( 'title', 'editor', 'thumbnail'),
		            'hierarchical'        => false,
			        'public'              => true,
			        'show_ui'             => true,
			        'show_in_menu'        => true,
			        'show_in_nav_menus'   => true,
			        'show_in_admin_bar'   => true,
			        'menu_position'       => 5,
			        'can_export'          => true,
			        'has_archive'         => true,
			        'exclude_from_search' => false,
			        'publicly_queryable'  => true,
			        'capability_type'     => 'post',
			        'show_in_rest' 		  => false,
			        'menu_icon' 		  => 'dashicons-testimonial'
			  
		  
		        )
		    );
		}

		// Add metaboxes
		public function sn_add_custom_box(){
			add_meta_box(
	            'sn_testimonials_metabox',                 // Unique ID
	            esc_html__( 'Testimonial options', 'sn-testimonials' ),      // Box title
	            array( $this , 'sn_testimonials_box_html'),  
	            'sn-testimonials'  , 
	            'normal' ,
	            'high'                           // Post type
	        );
		}

		// Metaox render html
		public function sn_testimonials_box_html( $post ){
			require_once(SN_TESTIMONIALS_PATH.'views/sn-testimonials_meta_box.php');
		}

		// Save post with metadata 
		public function save_post( $post_id ){
			// Verify nonce 
			if(isset($_POST['sn_testimonials_nonce'])){
				if(! wp_verify_nonce( $_POST['sn_testimonials_nonce'] , 'sn_testimonials_nonce' )){
					return;
				}
			}

			// Check doing autosave
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
				return;
			}

			// Check post type
			if(isset($_POST['post_type']) && $_POST['post_type']==='sn-testimonials'){
				if( ! current_user_can( 'edit_post' , $post_id )){
					return;
				}elseif(! current_user_can( 'edit_page' , $post_id )){
					return;
				}
			}

			if (isset($_POST['action']) && $_POST['action'] == 'editpost') {

			    $old_occupation = get_post_meta( $post_id, 'sn_testimonials_occupation', true ); 
			    $new_occupation = $_POST['sn_testimonials_occupation'];
			    $old_company    = get_post_meta( $post_id, 'sn_testimonials_company', true ); 
			    $new_company    = $_POST['sn_testimonials_company'];
			    $old_user_url   = get_post_meta( $post_id, 'sn_testimonials_user_url', true ); 
			    $new_user_url   = $_POST['sn_testimonials_user_url']; 

			    update_post_meta( $post_id, 'sn_testimonials_occupation', sanitize_text_field( $new_occupation ), $old_occupation );
			    update_post_meta( $post_id, 'sn_testimonials_company', sanitize_text_field( $new_company ), $old_company );
			    update_post_meta( $post_id, 'sn_testimonials_user_url', esc_url_raw( $new_user_url ), $old_user_url );
			}
		}
	}
}

 ?>