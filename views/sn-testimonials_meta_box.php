<?php 
$sn_testimonials_occupation = get_post_meta( $post->ID, 'sn_testimonials_occupation', true );
$sn_testimonials_company = get_post_meta( $post->ID, 'sn_testimonials_company', true );
$sn_testimonials_user_url = get_post_meta( $post->ID, 'sn_testimonials_user_url', true );

?>

<table class="form-table sn-testimonials-metabox"> 
    <input type="hidden" name="sn_testimonials_nonce" value="<?php echo wp_create_nonce( 'sn_testimonials_nonce' )?>">
    <tr>
        <th>
            <label for="sn_testimonials_occupation"><?php esc_html_e( 'User occupation', 'sn-testimonials' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="sn_testimonials_occupation" 
                id="sn_testimonials_occupation" 
                class="regular-text occupation"
                value="<?php echo (isset($sn_testimonials_occupation)) ? esc_html($sn_testimonials_occupation) : ''  ; ?>"
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="sn_testimonials_company"><?php esc_html_e( 'User company', 'sn-testimonials' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="sn_testimonials_company" 
                id="sn_testimonials_company" 
                class="regular-text company"
                value="<?php echo (isset($sn_testimonials_company)) ? esc_html($sn_testimonials_company) : ''  ; ?>"
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="sn_testimonials_user_url"><?php esc_html_e( 'User URL', 'sn-testimonials' ); ?></label>
        </th>
        <td>
            <input 
                type="url" 
                name="sn_testimonials_user_url" 
                id="sn_testimonials_user_url" 
                class="regular-text user-url"
                value="<?php echo (isset($sn_testimonials_user_url)) ? esc_html($sn_testimonials_user_url) : ''  ; ?>"
            >
        </td>
    </tr> 
</table>