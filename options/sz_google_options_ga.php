<?php

/**
 * Definizione array per le opzioni del plugin legate al modulo
 * corrispondente con cui sviluppare la funzione getOptions() e
 * le operazioni legate alla fase di attivazione del plugin.
 *
 * @package SZGoogle
 * @subpackage SZGoogleOptions
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

// Definizione array() con tutte le opzioni collegate al modulo che
// dovranno essere richiamate tramite un include(setoptions)

return array(
	'ga_type'                 => array('N'=>'1','Y'=>'0','Z'=>'0','value' => 'classic'),
	'ga_uacode'               => array('N'=>'1','Y'=>'0','Z'=>'0','value' => ''),
	'ga_position'             => array('N'=>'0','Y'=>'0','Z'=>'0','value' => 'H'),
	'ga_enable_front'         => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'ga_enable_admin'         => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'ga_enable_administrator' => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'ga_enable_logged'        => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'ga_enable_subdomain'     => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'ga_enable_multiple'      => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'ga_enable_advertiser'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'ga_enable_features'      => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
);