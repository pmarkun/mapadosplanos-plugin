<?
/*
Plugin Name: Mapa dos Planos - Plugin
Description: Plugin que adicione o tipo de post 'Municipio'
Version: 0.1
Author: Esfera - Hacks Políticos
Author URI: http://blog.esfera.mobi/
Plugin URI: http://blog.esfera.mobi/ae-munic
*/

define('AE_MUNIC_DIR', plugin_dir_path(__FILE__));
define('AE_MUNIC_URL', plugin_dir_url(__FILE__));

function ae_munic_load(){
    if(is_admin()) //load admin files only in admin
        require_once(AE_MUNIC_DIR.'includes/admin.php');
        
    require_once(AE_MUNIC_DIR.'includes/core.php');
}

ae_munic_load();

/**
 * Activation, Deactivation and Uninstall Functions
 * 
 **/
register_activation_hook(__FILE__, 'ae_munic_activation');
register_deactivation_hook(__FILE__, 'ae_munic_deactivation');


function ae_munic_activation() {
    
	//actions to perform once on plugin activation go here    
    
	
    //register uninstaller
    register_uninstall_hook(__FILE__, 'ae_munic_uninstall');
}

function ae_munic_deactivation() {
    
	// actions to perform once on plugin deactivation go here
	    
}

function ae_munic_uninstall(){
    
    //actions to perform once on plugin uninstall go here
	    
}

?>
