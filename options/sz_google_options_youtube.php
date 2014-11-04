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
	'youtube_channel'            => array('N'=>'1','Y'=>'0','Z'=>'0','value' => 'wpitalyplus'),
	'youtube_widget'             => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_widget_badge'       => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_widget_button'      => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_widget_link'        => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_widget_playlist'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_shortcode'          => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_shortcode_badge'    => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_shortcode_button'   => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_shortcode_link'     => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_shortcode_playlist' => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_responsive'         => array('N'=>'0','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_width'              => array('N'=>'1','Y'=>'0','Z'=>'0','value' => '600'),
	'youtube_height'             => array('N'=>'1','Y'=>'0','Z'=>'0','value' => '400'),
	'youtube_margin_top'         => array('N'=>'1','Y'=>'0','Z'=>'0','value' => ''),
	'youtube_margin_right'       => array('N'=>'1','Y'=>'0','Z'=>'0','value' => ''),
	'youtube_margin_bottom'      => array('N'=>'1','Y'=>'0','Z'=>'0','value' => '1'),
	'youtube_margin_left'        => array('N'=>'1','Y'=>'0','Z'=>'0','value' => ''),
	'youtube_margin_unit'        => array('N'=>'1','Y'=>'0','Z'=>'0','value' => 'em'),
	'youtube_force_ssl'          => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube_autoplay'           => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube_loop'               => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube_fullscreen'         => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '1'),
	'youtube_disablekeyboard'    => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube_theme'              => array('N'=>'1','Y'=>'0','Z'=>'0','value' => 'dark'),
	'youtube_cover'              => array('N'=>'1','Y'=>'0','Z'=>'0','value' => 'local'),
	'youtube_disableiframe'      => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube_analytics'          => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube_delayed'            => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube_schemaorg'          => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
	'youtube_disablerelated'     => array('N'=>'1','Y'=>'1','Z'=>'0','value' => '0'),
);