<?php
/***
Plugin Name: Client Role
Plugin URI: - 
Description: Create Custom User level Client
Author: Junaid Ahmed
Author URI: http://www.simpleux.co.uk
Version: 1.0.0.0
License: GPLv3 or later
***/

function add_roles_on_plugin_activation() {
	   remove_role( 'client' );
	   $role = get_role('administrator')->capabilities;
       add_role( 'client', 'Client', $role );
   }
   register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );
?>