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
	'maps_language'   => array('N'=>'1','Y'=>'0','Z'=>'0','value' => '99'),
	'maps_key'        => array('N'=>'0','Y'=>'0','Z'=>'0','value' => '' ),
	'maps_sensor'     => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'maps_javascript' => array('N'=>'0','Y'=>'0','Z'=>'0','value' => 'F'),
	'maps_s_enable'   => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '1'),
	'maps_s_width'    => array('N'=>'1','Y'=>'0','Z'=>'1','value' => 'auto'),
	'maps_s_height'   => array('N'=>'1','Y'=>'0','Z'=>'1','value' => 'auto'),
	'maps_s_zoom'     => array('N'=>'1','Y'=>'0','Z'=>'1','value' => '5'),
	'maps_s_view'     => array('N'=>'0','Y'=>'0','Z'=>'0','value' => 'ROADMAP'),
	'maps_w_enable'   => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '1'),
	'maps_w_width'    => array('N'=>'1','Y'=>'0','Z'=>'1','value' => 'auto'),
	'maps_w_height'   => array('N'=>'1','Y'=>'0','Z'=>'1','value' => 'auto'),
	'maps_w_zoom'     => array('N'=>'1','Y'=>'0','Z'=>'1','value' => '5'),
	'maps_w_view'     => array('N'=>'0','Y'=>'0','Z'=>'0','value' => 'ROADMAP'),
);
