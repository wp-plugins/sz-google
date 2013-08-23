<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_SHORTCODES') or !SZ_PLUGIN_GOOGLE_SHORTCODES) die();

/* ************************************************************************** */ 
/* Controllo le opzioni per sapere quali widgets risultano attivati           */ 
/* ************************************************************************** */ 

$options = sz_google_modules_plus_options();

if ($options['plus_shortcode_pr_enable']   =='1') {
	add_shortcode('sz-gplus-profile','sz_google_shortcodes_plus_profile');
}

if ($options['plus_shortcode_pa_enable']   =='1') {
	add_shortcode('sz-gplus-page','sz_google_shortcodes_plus_page');
}

if ($options['plus_shortcode_co_enable']   =='1') {
	add_shortcode('sz-gplus-community','sz_google_shortcodes_plus_community');
}

if ($options['plus_button_enable_plusone'] =='1') {
	add_shortcode('sz-gplus-one','sz_google_shortcodes_plus_plusone');
}

if ($options['plus_button_enable_sharing'] =='1') {
	add_shortcode('sz-gplus-share','sz_google_shortcodes_plus_sharing');
}

if ($options['plus_button_enable_follow']  =='1') {
	add_shortcode('sz-gplus-follow','sz_google_shortcodes_plus_follow');
}

if ($options['plus_comments_sh_enable']    =='1') {
	add_shortcode('sz-gplus-comments','sz_google_shortcodes_plus_comments');
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ COMMENTS                             */
/* ************************************************************************** */

function sz_google_shortcodes_plus_comments($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'    => '',
		'width'  => '',
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url    = trim($url);
	$width  = strtolower(trim($width));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($url == '') $url = get_permalink();

	// Creazione codice univoco per l'inserimento del box commenti		 

	$uniqueID = 'sz-google-comments-'.md5(uniqid(),false);

	// Creazione codice HTML per inserimento widget commenti		 
	
	if (!is_numeric($width) or $width == '') 
	{ 
		$HTML  = '<div id="'.$uniqueID.'" class="sz-google-comments-wrap">';
		$HTML .= '<script type="text/javascript">';
		$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
		$HTML .= "document.write('".'<div class="g-comments" data-href="'.$url.'" data-width="'."'+w+'".'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
		$HTML .= '</script>';
		$HTML .= '</div>';

	} else {

		$HTML  = '<div id="'.$uniqueID.'" class="sz-google-comments-wrap">';
		$HTML .= '<script type="text/javascript">';
		$HTML .= "var w=document.getElementById('".$uniqueID."').offsetWidth;";
		$HTML .= "document.write('".'<div class="g-comments" data-href="'.$url.'" data-width="'.$width.'" data-height="50" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>'."');";
		$HTML .= '</script>';
		$HTML .= '</div>';
	}

	// Aggiunta del codice javascript per il rendering dei widget		 
	// Questo codice viene aggiungo anche dalla sidebar però viene inserito una sola volta

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su COMMUNITY                   */
/* ************************************************************************** */

function sz_google_shortcodes_plus_community($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'id'     => SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY,
		'width'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'layout' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'photo'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO,
		'owner'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id     = trim($id);
	$width  = strtolower(trim($width));
	$layout = strtolower(trim($layout));
	$theme  = strtolower(trim($theme));
	$photo  = strtolower(trim($photo));
	$owner  = strtolower(trim($owner));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == '') { 
		$id = SZ_PLUGIN_GOOGLE_PLUS_ID_COMMUNITY; 
	}

	if ($layout <> 'portrait' and $layout <> 'landscape') { 
		$layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
	} 

	if ($theme <> 'light' and $theme <> 'dark') { 
		$theme = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
	} 

	if ($photo <> 'true' and $photo <> 'false') { $photo = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PHOTO; } 
	if ($owner <> 'true' and $owner <> 'false') { $owner = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_OWNER; } 

	// Controllo il valore per dimensione widget

	if (!is_numeric($width) or $width == '') { 
		if ($layout == 'portrait') $width = $options['plus_shortcode_size_portrait'];
			else $width = $options['plus_shortcode_size_landscape']; 
	}

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-community"';
	$HTML .= ' data-href="https://plus.google.com/communities/'.$id.'"';
	$HTML .= ' data-width="'     .$width  .'"';
	$HTML .= ' data-layout="'    .$layout.'"';
	$HTML .= ' data-theme="'     .$theme .'"';
	$HTML .= ' data-showphoto="' .$photo .'"';
	$HTML .= ' data-showowners="'.$owner .'"';
	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BUTTON FOLLOW                        */
/* ************************************************************************** */

function sz_google_shortcodes_plus_follow($atts,$content=null) 
{
	$DEFAULT_URL        = '';
	$DEFAULT_WIDTH      = ''; 
	$DEFAULT_RELATION   = '';
	$DEFAULT_SIZE       = 'medium';
	$DEFAULT_ANNOTATION = 'bubble';

	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'        => $DEFAULT_URL,
		'size'       => $DEFAULT_SIZE,
		'width'      => $DEFAULT_WIDTH,
		'annotation' => $DEFAULT_ANNOTATION,
		'rel'        => $DEFAULT_RELATION,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url        = trim($url);
	$width      = strtolower(trim($width));
	$size       = strtolower(trim($size));
	$annotation = strtolower(trim($annotation));
	$rel        = strtolower(trim($rel));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($width == '' or !is_numeric($width)) { 
		$width = $DEFAULT_WIDTH; 
	} 

	if (!in_array($size,array('small','medium','large',))) { 
		$size = $DEFAULT_SIZE; 
	} 

	if (!in_array($annotation,array('bubble','vertical-bubble','none'))) { 
		$annotation = $DEFAULT_ANNOTATION; 
	} 

	if (!in_array($rel,array('author','publishe'))) { 
		$rel = $DEFAULT_RELATION; 
	} 

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == '') $url = get_permalink();

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-follow"';
	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';

	if ($size  == 'small')  $HTML .= ' data-height="15"';
	if ($size  == 'medium') $HTML .= ' data-height="20"';
	if ($size  == 'large')  $HTML .= ' data-height="24"';
	if ($width <> '')       $HTML .= ' data-width="'.$width.'"';
	if ($rel   <> '')       $HTML .= ' data-rel="'.$rel.'"';

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}
/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su PAGE                        */
/* ************************************************************************** */

function sz_google_shortcodes_plus_page($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'id'        => SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE,
		'width'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'layout'    => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'cover'     => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
		'tagline'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
		'publisher' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id        = trim($id);
	$width     = strtolower(trim($width));
	$layout    = strtolower(trim($layout));
	$theme     = strtolower(trim($theme));
	$cover     = strtolower(trim($cover));
	$tagline   = strtolower(trim($tagline));
	$publisher = strtolower(trim($publisher));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == '') { 
		$id = SZ_PLUGIN_GOOGLE_PLUS_ID_PAGE; $publisher = 'false'; 
	}

	if ($layout <> 'portrait' and $layout <> 'landscape') { 
		$layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
	} 

	if ($theme <> 'light' and $theme <> 'dark') { 
		$theme = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
	} 

	if ($cover     <> 'true' and $cover     <> 'false') { $cover     = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; } 
	if ($tagline   <> 'true' and $tagline   <> 'false') { $tagline   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; } 
	if ($publisher <> 'true' and $publisher <> 'false') { $publisher = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_PUBLISHER; } 

	// Controllo il valore per dimensione widget

	if (!is_numeric($width) or $width == '') { 
		if ($layout == 'portrait') $width = $options['plus_shortcode_size_portrait'];
			else $width = $options['plus_shortcode_size_landscape']; 
	}

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-page"';
	$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
	$HTML .= ' data-width="'         .$width  .'"';
	$HTML .= ' data-layout="'        .$layout .'"';
	$HTML .= ' data-theme="'         .$theme  .'"';
	$HTML .= ' data-showcoverphoto="'.$cover  .'"';
	$HTML .= ' data-showtagline="'   .$tagline.'"';

	if ($publisher == 'true') {		
		$HTML .= ' data-rel="publisher"';
	}

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BOTTON PLUS ONE                      */
/* ************************************************************************** */

function sz_google_shortcodes_plus_plusone($atts,$content=null) 
{
	$DEFAULT_URL        = '';
	$DEFAULT_SIZE       = 'standard';
	$DEFAULT_WIDTH      = '300'; 
	$DEFAULT_ANNOTATION = 'inline';

	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'        => $DEFAULT_URL,
		'size'       => $DEFAULT_SIZE,
		'width'      => $DEFAULT_WIDTH,
		'annotation' => $DEFAULT_ANNOTATION,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url        = trim($url);
	$width      = strtolower(trim($width));
	$size       = strtolower(trim($size));
	$annotation = strtolower(trim($annotation));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($width == '' or !is_numeric($width)) { 
		$width = $DEFAULT_WIDTH; 
	} 

	if (!in_array($size,array('small','medium','standard','tail'))) { 
		$size = $DEFAULT_SIZE; 
	} 

	if (!in_array($annotation,array('inline','bubble','none'))) { 
		$annotation = $DEFAULT_ANNOTATION; 
	} 

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == '') $url = get_permalink();

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-plusone"';
	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-size="'      .$size      .'"';
	$HTML .= ' data-width="'     .$width     .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';
	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;	
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BADGE su PROFILO                     */
/* ************************************************************************** */

function sz_google_shortcodes_plus_profile($atts,$content=null) 
{
	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'id'      => SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE,
		'width'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_WIDTH,
		'layout'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT,
		'theme'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME,
		'cover'   => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER,
		'tagline' => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE,
		'author'  => SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$id      = trim($id);
	$width   = strtolower(trim($width));
	$layout  = strtolower(trim($layout));
	$theme   = strtolower(trim($theme));
	$cover   = strtolower(trim($cover));
	$tagline = strtolower(trim($tagline));
	$author  = strtolower(trim($author));

	// Lettura opzioni generali per impostazione dei dati di default

	$options = sz_google_modules_plus_options();

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($id == '') { 
		$id = SZ_PLUGIN_GOOGLE_PLUS_ID_PROFILE; $author = 'false'; 
	}

	if ($layout <> 'portrait' and $layout <> 'landscape') { 
		$layout = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_LAYOUT; 
	} 

	if ($theme <> 'light' and $theme <> 'dark') { 
		$theme = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_THEME; 
	} 

	if ($cover   <> 'true' and $cover   <> 'false') { $cover   = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_COVER; } 
	if ($tagline <> 'true' and $tagline <> 'false') { $tagline = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_TAGLINE; } 
	if ($author  <> 'true' and $author  <> 'false') { $author  = SZ_PLUGIN_GOOGLE_PLUS_SHORTCODE_AUTHOR; } 

	// Controllo il valore per dimensione widget

	if (!is_numeric($width) or $width == '') { 
		if ($layout == 'portrait') $width = $options['plus_shortcode_size_portrait'];
			else $width = $options['plus_shortcode_size_landscape']; 
	}

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-person"';
	$HTML .= ' data-href="https://plus.google.com/'.$id.'"';
	$HTML .= ' data-width="'         .$width  .'"';
	$HTML .= ' data-layout="'        .$layout .'"';
	$HTML .= ' data-theme="'         .$theme  .'"';
	$HTML .= ' data-showcoverphoto="'.$cover  .'"';
	$HTML .= ' data-showtagline="'   .$tagline.'"';

	if ($author == 'true') {		
		$HTML .= ' data-rel="author"';
	}

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}

/* ************************************************************************** */
/* Funzione shortcode per inserimento G+ BUTTON SHARING                       */
/* ************************************************************************** */

function sz_google_shortcodes_plus_sharing($atts,$content=null) 
{
	$DEFAULT_URL        = '';
	$DEFAULT_SIZE       = 'medium';
	$DEFAULT_WIDTH      = ''; 
	$DEFAULT_ANNOTATION = 'inline';

	/* Estrazione del valore URL dal codice shortcode */

	extract(shortcode_atts(array(
		'url'        => $DEFAULT_URL,
		'size'       => $DEFAULT_SIZE,
		'width'      => $DEFAULT_WIDTH,
		'annotation' => $DEFAULT_ANNOTATION,
	),$atts));

	// Esecuzione trim su valori specificati su shortcode

	$url        = trim($url);
	$width      = strtolower(trim($width));
	$size       = strtolower(trim($size));
	$annotation = strtolower(trim($annotation));

	// Imposto i valori di default nel caso siano specificati dei valori
	// che non appartengono al range dei valori accettati

	if ($width == '' or !is_numeric($width)) { 
		$width = $DEFAULT_WIDTH; 
	} 

	if (!in_array($size,array('small','medium','large',))) { 
		$size = $DEFAULT_SIZE; 
	} 

	if (!in_array($annotation,array('inline','bubble','vertical-bubble','none'))) { 
		$annotation = $DEFAULT_ANNOTATION; 
	} 

	// Se non specifico un URL fisso imposto il permalink attuale

	if ($url == '') $url = get_permalink();

	// Preparazione codice HTML per il badge di google plus

	$HTML  = '<div class="g-plus"';
	$HTML .= ' data-action="share"';	
	$HTML .= ' data-href="'      .$url       .'"';
	$HTML .= ' data-annotation="'.$annotation.'"';

	if ($size  == 'small')  $HTML .= ' data-height="15"';
	if ($size  == 'medium') $HTML .= ' data-height="20"';
	if ($size  == 'large')  $HTML .= ' data-height="24"';
	if ($width <> '')       $HTML .= ' data-width="'.$width.'"';

	$HTML .= '></div>';

	// Aggiunta del codice javascript per il rendering dei widget		 

	add_action('wp_footer','sz_google_modules_plus_add_script_footer');

	// Ritorno il codice HTML generato dalla funzione		 

	return $HTML;
}