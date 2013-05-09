<?
/*
Plugin Name: Mapa dos Planos - Plugin
Description: Plugin que adiciona o suporte a Questionários.
Version: 0.1
Author: Esfera - Hacks Políticos
Author URI: http://blog.esfera.mobi/
Plugin URI: http://blog.esfera.mobi/ae-munic
*/

define('MAPADOSPLANOS_DIR', plugin_dir_path(__FILE__));
define('MAPADOSPLANOS_URL', plugin_dir_url(__FILE__));

function mapadosplanos_load(){
    if(is_admin()) //load admin files only in admin
        require_once(MAPADOSPLANOS_DIR.'includes/admin.php');
        
    require_once(MAPADOSPLANOS_DIR.'includes/core.php');
}

mapadosplanos_load();

/**
 * Activation, Deactivation and Uninstall Functions
 * 
 **/
register_activation_hook(__FILE__, 'mapadosplanos_activation');
register_activation_hook( __FILE__, 'mapadosplanos_install' );
register_deactivation_hook(__FILE__, 'mapadosplanos_deactivation');


function mapadosplanos_install() {
    global $wpdb;
    global $db;
    $db = $wpdb->prefix . 'mapadosplanos_quest';
    
    $charset_collate = '';
    if (!empty ($wpdb->charset)) {
        $charset_collate = " DEFAULT CHARACTER SET {$wpdb->charset}";
    }
    else {
        $charset_collate = " DEFAULT CHARACTER SET utf8";   
    }
    if (!empty ($wpdb->collate)) {
        $charset_collate .= " COLLATE {$wpdb->collate}";
    }
    else {
        $charset_collate .= " COLLATE utf8_general_ci";   
    }
    
    // create the ECPT metabox database table
    if($wpdb->get_var("show tables like '$db'") != $db) 
    {
        $sql = "CREATE TABLE " . $db . " (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `post_id` bigint(20) NOT NULL,
        `qs_nome` text NOT NULL,
        `qs_cpf` text NOT NULL,
        `qs_relacao` text NOT NULL,
        `qs_relacao_obs` text NOT NULL,
        `qs_conselho` text NOT NULL,
        `qs_conselho_obs` text NOT NULL,
        `qs_email` text NOT NULL,
        `qs_telefone` text NOT NULL,
        `qs_01` text NOT NULL,
        `qs_01_1` text NOT NULL,
        `qs_01_obs` text NOT NULL,
        `qs_02_1` text NOT NULL,
        `qs_02_2` text NOT NULL,
        `qs_02_3` text NOT NULL,
        `qs_02_4` text NOT NULL,
        `qs_02_5` text NOT NULL,
        `qs_02_obs` text NOT NULL,
        `qs_03` text NOT NULL,
        `qs_04` text NOT NULL,
        `qs_obs` text NOT NULL,
        UNIQUE KEY id (id)
        )" . $charset_collate . ";";
 
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        add_option( "mapadosplanos_db_version", "1.0" );
    }
}

function mapadosplanos_activation() {
    
	//actions to perform once on plugin activation go here    
    
	
    //register uninstaller
    register_uninstall_hook(__FILE__, 'mapadosplanos_uninstall');
}

function mapadosplanos_deactivation() {
    
	// actions to perform once on plugin deactivation go here
	    
}

function mapadosplanos_uninstall(){
    
    //actions to perform once on plugin uninstall go here
	    
}

?>
