<?php
/**
 * File richiamato in fase di disinstallazione plugin: In questa
 * fase bisogna eseguire la pulizia delle opzioni memorizzate sul
 * database wordpress e controllare se ambiente multisite. 
 *
 * @package SZGoogle
 */
if(!defined('WP_UNINSTALL_PLUGIN')) die();

// CONVERTIRE QUESTO FILE IN OGGETTO

/* ************************************************************************** */
/* Disinstallazione plugin e rimozione opzioni                                */
/* ************************************************************************** */

if (is_multisite()) sz_unistall_google_delete_options_multisite();  
	else sz_unistall_google_delete_options();
	
/* ************************************************************************** */
/* Funzione per cancellazione di tutte le opzioni dei vari blog               */
/* ************************************************************************** */

function sz_unistall_google_delete_options() 
{
	delete_option('sz_google_options_base');
	delete_option('sz_google_options_plus');
	delete_option('sz_google_options_ga');
	delete_option('sz_google_options_authenticator');
	delete_option('sz_google_options_calendar');
	delete_option('sz_google_options_drive');
	delete_option('sz_google_options_fonts');
	delete_option('sz_google_options_groups');
	delete_option('sz_google_options_hangouts');
	delete_option('sz_google_options_panoramio');
	delete_option('sz_google_options_translate');
	delete_option('sz_google_options_youtube');
}

/* ************************************************************************** */
/* Funzione per cancellazione di tutte le opzioni dei vari blog               */
/* ************************************************************************** */

function sz_unistall_google_delete_options_multisite() 
{
	global $wpdb;
	$blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);

	if ($blogs) 
	{
		foreach($blogs as $blog) {
			switch_to_blog($blog['blog_id']);
			sz_unistall_google_delete_options();
		}
		restore_current_blog();
	}
}
