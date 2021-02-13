<?php
/*
Plugin Name: dataFrontpage
Plugin URI: http://buhodigital.net
Description: Datos para incluir en la página de aterrizaje.
Version: 1.0
Author: Búho Digital
Author URI: http://buhodigital.net
License: GPL2
*/

function my_admin_theme_style() {
    wp_enqueue_style('my-admin-theme', plugins_url('wp-admin.css', __FILE__));
    wp_enqueue_script('my-admin-theme',plugins_url('code.js', __FILE__));

}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');

function my_admin_dataFront() {
	/*******Check if database exist*/	
	global $wpdb;
	$table_name = $wpdb->base_prefix.'data_front';
	$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
		
		if ( ! $wpdb->get_var( $query ) == $table_name ) {
			$jal_db_version = '1.0';
			/*Crear la base de datos (si no existe)*/
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
			  kFront INT(11) NOT NULL AUTO_INCREMENT , sTitulo VARCHAR(255) NOT NULL , sContenido LONGTEXT NOT NULL , sTipo VARCHAR(255) NOT NULL , bDisponible TINYINT(1) NOT NULL , PRIMARY KEY (kFront)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			/*Termina Crear la base de datos*/
		}
	/******* ends Check if database exist*/

	/*Panel de captura de información*/
	include('admin_page.php');
}

add_action('admin_footer', 'my_admin_dataFront');

/*Obtener todos datos registrados*/
function get_full_data(){
	global $wpdb;
	$result = $wpdb->get_results ( "SELECT * FROM  wp_data_front WHERE bDisponible = 1 $busqueda" );
	return $result;
}

/*Obtener datos particulares*/
function get_data($sTitulo){
	global $wpdb;
	$result = $wpdb->get_results ( "SELECT * FROM  wp_data_front WHERE bDisponible = 1 AND sTitulo='".$sTitulo."'" );
	echo $result[0]->sContenido;
}


/*guardar nuevo campo*/
function save_new_field($sTitulo,$sContenido,$sTipo){
	global $wpdb;
	$table_name = $wpdb->base_prefix.'data_front';
	$data = array('sTitulo' => $sTitulo, 'sContenido' => $sContenido, 'sTipo'=>$sTipo, 'bDisponible'=>1);
	$format = array('%s','%s','%s','%d');
	//Revisar si existe el titulo
	$title=$wpdb->get_results ( "SELECT * FROM  wp_data_front WHERE bDisponible = 1 AND sTitulo='".$sTitulo."'" );
	if(empty($title)){
	$wpdb->insert($table_name,$data,$format);
	$my_id = $wpdb->insert_id;
	echo "<script>location.reload();</script>";
	}else{
	echo "<script>alert('El título seleccionado ya está registrado');</script>";
	}
}

function delete_data_front($kFront){
	global $wpdb;
	$table_name = $wpdb->base_prefix.'data_front';
	$wpdb->delete( $table_name, array( 'kFront' => $kFront ) );
	
	echo "<script>window.location.replace('index.php') </script>";
}

function update_data_front($kFront,$sContenido){
	global $wpdb;
	$table_name = $wpdb->base_prefix.'data_front';
		$wpdb->update( 
		$table_name, 
		array( 
			'sContenido' => $sContenido,	// string
		), 
		array( 'kFront' => $kFront, ), 
		array( 
			'%s',	// value1
		), 
		array( '%d' ) 
		);
	echo "<script>location.reload();</script>";
}




?>