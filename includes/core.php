<?
#### Custom Post Types
global $ibge_setup, $ficha_setup;
$ibge_setup = array(
	'A187' => 'Possui plano?',
	'A171' => 'Sistema Municipal de Ensino',
	'A219' => 'Fundo Municipal de Educação',
	'A211' => 'Conselho Municipal de Educação'
	);


$ficha_setup = array(
    'Q1' => '1. Seu município possui plano de educação em vigência?',
    'Q2' => '2. Quando o plano de educação foi aprovado?',
    'Q3' => '3. O plano de educação já foi revisado nos últimos quatro anos?',
    'Q4' => '4. Seu município está elaborando um plano de educação? [Somente para quem respondeu Não na pergunta 01]',
    'Q5' => '5. Seu município pretende elaborar um plano de educação nesta gestão (2013-2016)? [Somente para quem respondeu Sim na pergunta 04]',
    'Q6' => '6. Seu município pretende revisar o plano de educação nesta gestão (2013-2016)? [Somente para quem já tem plano]',
    'Q7' => '7. Em qual momento da elaboração se encontra? (Somente para os munícipios que estão em processo de elaboração do Plano de Educação)',
    'Q8' => '8. O município contratou ou pretende contratar algum tipo de consultoria externa para elaboração do plano de educação? [Para todos]',
    'Q9' => '9. Quais dos órgãos/instâncias abaixo participam ou participaram da elaboração do plano de educação?',
    'Q10' => '10. Quais das organizações/movimentos abaixo participam ou participaram da elaboração do plano de educação?',
    'Q11' => '11. Dos segmentos da comunidade escolar descritos abaixo, quais participaram ou estão participando da elaboração do plano de educação de seu município.',
    'Q12' => '12. Quais foram ou estão sendo os dados utilizados para a elaboração do diagnóstico do município a ser utilizado no plano de educação? [Se necessário, assinale mais de uma alternativa]',
    'Q13' => '13. Quais foram ou estão sendo as principais metodologias utilizadas para a elaboração do plano de educação de seu município?',
    'Q14' => '14. O processo de elaboração do plano de educação mobilizou ou vem mobilizando',
    'Q15' => '15. Houve ou há um investimento na comunicação sobre o processo de construção/revisão do Plano?',
    'Q16' => '16. Caso positivo, a comunicação do processo se deu:',
    'Q17' => '17. Seu município está preparado para cumprir a lei de acesso à informação pública (lei 12.527/2011) com relação à área de educação?',
    'Q18' => '18. Além da gestão municipal, participam ou participaram do processo de construção/revisão dos Planos',
    'Q19' => '19. A construção do plano envolveu/envolve as seguintes etapas/modalidades e níveis da educação?',
    'Q20' => '20. Houve ou há um investimento na participação de crianças e adolescentes na construção do Plano de Educação?',
    'Q21' => '21.  Se sim, de que forma?'
);


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
	 add_meta_box('post-municipio-ibge', 'Munic IBGE', 'municipio_post_ibge_metabox', 'municipio', 'normal', 'default');
	 add_meta_box('post-municipio-ficha', 'Ficha do Munícipio', 'municipio_post_ficha_metabox', 'municipio', 'normal', 'default');
	 remove_meta_box( 'slugdiv', 'municipio', 'normal' );
	 remove_meta_box( 'submitdiv', 'municipio', 'normal' );
}

/* Display the post IBGE meta box. */
function municipio_post_ibge_metabox( $object, $box ) {
    global $post, $ibge_setup;
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="ibgemeta_noncename" id="ibgemeta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
    // Get the location data if its already been entered
	$ibge_results = array();
	
	foreach ($ibge_setup as $key => $value) {
	    $ibge_results[$key] = get_post_meta($post->ID, $key, true);
	}
	
	
    // Echo cria o field
    echo '<p>Possui plano?</p>';
    echo '<input type="text" name="A187" value="' . $ibge_results['A187']  . '" class="widefat" />';
    echo '<p>Instâncias de Gestão Democrática</p>';
    echo '<p>Sistema Municipal de Ensino</p>';
    echo '<input type="text" name="A171" value="' . $ibge_results['A171']  . '" class="widefat" />';
    echo '<p>Fundo Municipal de Educação</p>';
    echo '<input type="text" name="A219" value="' . $ibge_results['A219']  . '" class="widefat" />';
    echo '<p>Conselho Municipal de Educação</p>';
    echo '<input type="text" name="A211" value="' . $ibge_results['A211']  . '" class="widefat" />';
}

// Save the Metabox Data
function municipio_post_save_ibge_meta($post_id, $post) {
    global $ibge_setup;
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['ibgemeta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
    
    //Possivel combinar as funcoes??
    $ibge_meta = array();
    foreach ($ibge_setup as $key => $value) {
	    $ibge_meta[$key] = $_POST[$key];
	}
    
    // Add values of $events_meta as custom fields
    foreach ($ibge_meta as $key => $value) { // Cycle through the $events_meta array!
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



/* Display the post ficha meta box. */
function municipio_post_ficha_metabox( $object, $box ) {
    global $post, $ficha_setup;
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="fichameta_noncename" id="fichameta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
    // Get the location data if its already been entered
	$ficha_results = array();
	
	foreach ($ficha_setup as $key => $value) {
	    $ficha_results[$key] = get_post_meta($post->ID, $key, true);
	}
	
	
    // Echo cria o field 
    //echo '<p>Ficha</p>';
    //echo '<input type="text" name="A187" value="' . $ficha_results['A187']  . '" class="widefat" />';

    //Looping cria field
    foreach ($ficha_setup as $key => $value) {
	  echo "<p>" . $value . "</p>";
	  echo "<input type='text' name='" . $key . "' value='" . $ficha_results[$key] . "' class='widefat' />";
	}
}

// Save the Metabox Data
function municipio_post_save_ficha_meta($post_id, $post) {
    global $ficha_setup;
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
    
    //Possivel combinar as funcoes??
    $ficha_meta = array();
    foreach ($ficha_setup as $key => $value) {
	    $ficha_meta[$key] = $_POST[$key];
	}
    
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

add_action('save_post', 'municipio_post_save_ibge_meta', 1, 2); // save the custom fields
add_action('save_post', 'municipio_post_save_ficha_meta', 1, 2); // save the custom fields

?>
