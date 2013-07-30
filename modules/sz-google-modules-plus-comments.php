<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULES') or !SZ_PLUGIN_GOOGLE_MODULES) die();

/* ************************************************************************** */
/* Abilitazione del sistema di commenti g+ con o senza quello di default      */
/* ************************************************************************** */

function sz_google_modules_comments_system_enable() 
{
	// Calcolo opzioni di configurazione generale

	$options = sz_google_modules_plus_options();

	// Se è specificata opzione dopo il contenuto applico il filtro a the_content
	// altrimenti applico il filtro alla funzione di comment_template

	if ($options['plus_comments_ac_enable']=='1') add_filter('the_content','sz_google_modules_comments_content');
		else add_filter('comments_template','sz_google_modules_comments_system');
}

add_action('init','sz_google_modules_comments_system_enable');

/* ************************************************************************** */
/* Funzione per rendering del sistema di commenti legato a google plus        */
/* ************************************************************************** */

function sz_google_modules_comments_system($include) 
{
	global $post,$comments;

	if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return; }

	// Aggiornamento delle variabili che contengono le opzioni		 
	// di eleborazione commenti e loro posizione nella pagina

	$checkdt = '00000000';
	$checkid	= get_the_date('Ymd');
	$options = sz_google_modules_plus_options();

	// Calcolo la data di confronto per la funzione dei commenti

	if ($options['plus_comments_dt_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) 
	{
		$checkdt  = sprintf('%04d',$options['plus_comments_dt_year']);
		$checkdt .= sprintf('%02d',$options['plus_comments_dt_month']);
		$checkdt .= sprintf('%02d',$options['plus_comments_dt_day']);

		// Se devo controllare la data e non rientra nel range giusto non eseguo
		// l'elaborazione del sistema commenti e rimando a quello originale

		if ($checkid <= $checkdt) {
			return $include;
		}
	}

	// Controllo se devo mantenere i commenti standard di wordpress		 
	// in caso affermativo eseguo il file prima dei commenti di google plus

	if ($options['plus_comments_wp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES and $options['plus_comments_aw_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES) {   
		if (file_exists($include)) @require($include);
		echo '<div id="sz-google-comments-margin" style="margin-bottom:1em"></div>';
	}

	// Creazione codice HTML per inserimento widget commenti		 

	echo '<div id="sz-google-comments" class="sz-google-comments-wrap">';
	echo '<script type="text/javascript">';
	echo "var w=document.getElementById('sz-google-comments').offsetWidth;";
	echo "document.write('".'<div class="g-comments" data-href="'.get_permalink().'" data-width="'."'+w+'".'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
	echo '</script>';
	echo '</div>';

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno stesso template passato alla funzione nel caso in cui
	// devo mantenere i commenti standard dopo quelli di google plus
	
	if ($options['plus_comments_wp_enable'] == SZ_PLUGIN_GOOGLE_VALUE_YES and $options['plus_comments_aw_enable'] == SZ_PLUGIN_GOOGLE_VALUE_NO) {   
		return $include;
	}

	// Ritorno template di commenti dummy con nessuna azione HTML
	
	return plugin_dir_path( __FILE__ ).'sz-google-modules-plus-comments-dummy.php';
}

/* ************************************************************************** */
/* Funzione per rendering del sistema di commenti legato a google plus        */
/* ************************************************************************** */

function sz_google_modules_comments_content($content) 
{
	global $post,$comments;

	if (!(is_singular() && (have_comments() || 'open' == $post->comment_status))) { return; }

	// Creazione codice HTML per inserimento widget commenti		 

	$codice  = '<div id="sz-google-comments" class="sz-google-comments-wrap">';
	$codice .= '<script type="text/javascript">';
	$codice .= "var w=document.getElementById('sz-google-comments').offsetWidth;";
	$codice .= "document.write('".'<div class="g-comments" data-href="'.get_permalink().'" data-width="'."'+w+'".'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
	$codice .= '</script>';
	$codice .= '</div>';

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	return $content.$codice;
}
