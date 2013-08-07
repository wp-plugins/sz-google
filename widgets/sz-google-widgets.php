<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/* ************************************************************************** */
/* Definizione costanti che devo essere comuni a tutti i file widgets         */
/* ************************************************************************** */

define('SZ_PLUGIN_GOOGLE_WIDGETS',true);
define('SZ_PLUGIN_GOOGLE_WIDGETS_BASENAME',basename(__FILE__));

/* ************************************************************************** */
/* Controllo opzioni generale per sapere quali moduli caricare                */
/* ************************************************************************** */

$widgets_options = sz_google_modules_options();

if ($widgets_options['plus']=='1') {
	@require_once(dirname(__FILE__).'/sz-google-widgets-plus.php');
}
