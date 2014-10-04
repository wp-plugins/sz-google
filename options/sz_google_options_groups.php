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
	'groups_widget'      => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'groups_shortcode'   => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'groups_language'    => array('N'=>'1','Y'=>'0','Z'=>'0','value' => '99'),
	'groups_name'        => array('N'=>'1','Y'=>'0','Z'=>'0','value' => 'adsense-api'),
	'groups_showsearch'  => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'groups_showtabs'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'groups_hidetitle'   => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'groups_hidesubject' => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '0'),
	'groups_width'       => array('N'=>'1','Y'=>'0','Z'=>'1','value' => 'auto'),
	'groups_height'      => array('N'=>'1','Y'=>'0','Z'=>'1','value' => 'auto'),
);