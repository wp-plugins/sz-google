<?php
/* ************************************************************************** */
/* Disinstallazione plugin e rimozione opzioni                                */
/* ************************************************************************** */
if(!defined('WP_UNINSTALL_PLUGIN')) die();

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
	delete_option('sz_google_options_drive');
	delete_option('sz_google_options_groups');
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






