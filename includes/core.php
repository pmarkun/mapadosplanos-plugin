<?

#### Custom Post Types

add_action('init', 'municipio_register');
 
function municipio_register() {
	$args = array(
	'label' => __('Municípios'),
	'singular_label' => __('Município'),
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'rewrite' => false,
	'query_var' => false,
	'supports' => array('title'),
	 'register_meta_box_cb' => 'add_municipio_metaboxes'
   );
 
	register_post_type( 'municipio' , $args );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function add_municipio_metaboxes() {
	 add_meta_box('post-municipio-ficha', 'Ficha do Munícipio', 'municipio_post_ficha_metabox', 'municipio', 'normal', 'default');
	 remove_meta_box( 'slugdiv', 'municipio', 'normal' );
	 remove_meta_box( 'submitdiv', 'municipio', 'normal' );
}

/* Display the post meta box. */
function municipio_post_ficha_metabox( $object, $box ) {
        global $post;
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="fichameta_noncename" id="fichameta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Get the location data if its already been entered
        $ficha_A187 = get_post_meta($post->ID, 'A187', true);
	$ficha_A171 = get_post_meta($post->ID, 'A171', true);
	$ficha_A219 = get_post_meta($post->ID, 'A219', true);
	$ficha_A211 = get_post_meta($post->ID, 'A211', true);
	
    // Echo out the field
    echo '<p>Possui plano?</p>';
    echo '<input type="text" name="A187" value="' . $ficha_A187  . '" class="widefat" />';
    echo '<p>Instâncias de Gestão Democrática</p>';
    echo '<p>Sistema Municipal de Ensino</p>';
    echo '<input type="text" name="A171" value="' . $ficha_A171  . '" class="widefat" />';
    echo '<p>Fundo Municipal de Educação</p>';
    echo '<input type="text" name="A219" value="' . $ficha_A219  . '" class="widefat" />';
    echo '<p>Conselho Municipal de Educação</p>';
    echo '<input type="text" name="A211" value="' . $ficha_A211  . '" class="widefat" />';
}

// Save the Metabox Data
function municipio_post_save_ficha_meta($post_id, $post) {
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['fichameta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
    $ficha_meta['A187'] = $_POST['A187'];
    $ficha_meta['_ficha_vigencia'] = $_POST['_ficha_vigencia'];
    
    
    // Add values of $events_meta as custom fields
    foreach ($ficha_meta as $key => $value) { // Cycle through the $events_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
}
add_action('save_post', 'municipio_post_save_ficha_meta', 1, 2); // save the custom fields

?>
