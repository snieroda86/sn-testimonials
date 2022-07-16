<?php 

$args_testimonials = array(  
    'post_type' => 'sn-testimonials',
    'post_status' => 'publish',
    'posts_per_page' => $number
);

$testimonials = new WP_Query( $args_testimonials ); 

if($testimonials->have_posts()):   
	while ( $testimonials->have_posts() ) : $testimonials->the_post(); 
		$url_meta = get_post_meta( get_the_ID() , 'sn_testimonials_user_url' , true );
		$occupation_meta = get_post_meta( get_the_ID() , 'sn_testimonials_occupation' , true );
		$company_meta = get_post_meta( get_the_ID() , 'sn_testimonials_company' , true );
		
		?>
	   <div class="sn-testimonial-item">
	 	<div class="sn-testimonial-title">
	 		<h3><?php the_title(); ?></h3>
	 	</div>
	 	<div class="sn-testimonial-content">
	 		<?php if($image): ?>
	 		<div class="sn-testimonial-thumb">
	 			<?php 
		 		if(has_post_thumbnail()):
		 			the_post_thumbnail( array(70 , 70 ) );
		 		endif;
		 		 ?>
	 		</div>
	 		<?php endif; ?>
	 		<div class="sn-testimonials-text">
	 			<?php the_content(); ?>
	 		</div>
	 	</div>
	 	<div class="sn-testimonial-meta">
	 		<?php if($occupation): ?>
	 			<div class="meta-occupation">
	 				<span><?php echo esc_html($occupation_meta); ?></span>
	 			</div>
	 		<?php endif; ?>
	 		<?php if($company): ?>
	 			<div class="meta-company">
	 				<span><a href="<?php echo esc_attr($url_meta); ?>"><?php echo esc_html($company_meta); ?></a></span>
	 			</div>
	 		<?php endif; ?>
	 		
	 	</div>
	 </div>
	<?php endwhile;
endif;

wp_reset_postdata();

?>

<a href="<?php echo get_post_type_archive_link( 'sn-testimonials' )?>"><?php _e('Show more testimonials' , 'sn-testimonials') ?></a>

 