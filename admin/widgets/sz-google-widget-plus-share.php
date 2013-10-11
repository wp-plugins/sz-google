<?php
/* ************************************************************************** */
/* Controllo se definita la costante del plugin                               */
/* ************************************************************************** */
if (!defined('SZ_PLUGIN_GOOGLE_MODULE') or !SZ_PLUGIN_GOOGLE_MODULE) die();

// Definizione dei nome per le varibili per CSS id

$ID_title         = $this->get_field_id('title');
$ID_urltype       = $this->get_field_id('urltype');
$ID_url           = $this->get_field_id('url');
$ID_badge         = $this->get_field_id('badge');
$ID_text          = $this->get_field_id('text');
$ID_img           = $this->get_field_id('img');
$ID_position      = $this->get_field_id('position');
$ID_align         = $this->get_field_id('align');
$ID_size          = $this->get_field_id('size');
$ID_annotation    = $this->get_field_id('annotation');

// Definizione dei nome per le varibili per CSS name

$NAME_title       = $this->get_field_name('title');
$NAME_urltype     = $this->get_field_name('urltype');
$NAME_url         = $this->get_field_name('url');
$NAME_badge       = $this->get_field_name('badge');
$NAME_text        = $this->get_field_name('text');
$NAME_img         = $this->get_field_name('img');
$NAME_position    = $this->get_field_name('position');
$NAME_align       = $this->get_field_name('align');
$NAME_size        = $this->get_field_name('size');
$NAME_annotation  = $this->get_field_name('annotation');

// Definizione dei nome per le varibili contenuto

$VALUE_title      = esc_attr($title);
$VALUE_urltype    = esc_attr($urltype);
$VALUE_url        = esc_attr($url);
$VALUE_badge      = esc_attr($badge);
$VALUE_text       = esc_attr($text);
$VALUE_img        = esc_attr($img);
$VALUE_position   = esc_attr($position);
$VALUE_align      = esc_attr($align);
$VALUE_size       = esc_attr($size);
$VALUE_annotation = esc_attr($annotation);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->

<table style="width:100%">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->

<tr><td colspan="2">
	<label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label>
	<input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>"/>
</td></tr>

<!-- WIDGETS (Campo per inserimento tipo di URL) -->

<tr><td colspan="2">
	<select class="sz-google-switch-hidden widefat" id="<?php echo $ID_urltype ?>" name="<?php echo $NAME_urltype ?>" onchange="szgoogle_switch_hidden(this);" data-close="0" data-switch="sz-google-switch-url">
		<option value="0" <?php echo selected("0",$VALUE_urltype) ?>><?php echo __('current post address','szgoogleadmin') ?></option>
		<option value="1" <?php echo selected("1",$VALUE_urltype) ?>><?php echo __('specific url address','szgoogleadmin') ?></option>
	</select>
</td></tr>

<!-- WIDGETS (Campo per inserimento URL specifico) -->

<tr class="sz-google-switch-url"><td colspan="2">
	<input class="sz-upload-image-url widefat" id="<?php echo $ID_url ?>" name="<?php echo $NAME_url ?>" type="text" value="<?php echo $VALUE_url ?>" placeholder="<?php echo __('insert source URL','szgoogleadmin') ?>"/>
</td></tr>

<!-- WIDGETS (Campo per inserimento tipologia di badge) -->

<tr><td colspan="2">
	<select class="sz-google-switch-hidden widefat" id="<?php echo $ID_badge ?>" name="<?php echo $NAME_badge ?>" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-display" data-close="0">
		<option value="0" <?php echo selected("0",$VALUE_badge) ?>><?php echo __('button without badge','szgoogleadin') ?></option>
		<option value="1" <?php echo selected("1",$VALUE_badge) ?>><?php echo __('button with badge','szgoogleadmin') ?></option>
	</select>
</td></tr>

<!-- WIDGETS (Campo per inserimento del testo da usare come badge) -->

<tr class="sz-google-switch-display"><td colspan="2">
	<textarea class="widefat" rows="3" cols="20" id="<?php echo $ID_text ?>" name="<?php echo $NAME_text ?>" placeholder="<?php echo __('insert text for badge','szgoogleadmin') ?>"><?php echo $VALUE_text ?></textarea>
</td></tr>

<!-- WIDGETS (Campo per inserimento immagine da usare come badge) -->

<tr class="sz-google-switch-display">
	<td><input class="sz-upload-image-url-2 widefat" id="<?php echo $ID_img ?>" name="<?php echo $NAME_img ?>" type="text" value="<?php echo $VALUE_img ?>" placeholder="<?php echo __('choose image for badge','szgoogleadmin') ?>"/></td>
	<td><input class="sz-upload-image-button button" type="button" value="<?php echo ucfirst(__('select file','szgoogleadmin')) ?>" data-field-url="sz-upload-image-url-2" data-title="<?php echo ucfirst(__('select or upload a file','szgoogleadmin')) ?>" data-button-text="<?php echo ucfirst(__('confirm selection','szgoogleadmin')) ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento della posizione) -->

<tr class="sz-google-switch-display"><td colspan="2">
	<select class="widefat" id="<?php echo $ID_position ?>" name="<?php echo $NAME_position ?>">
		<option value="outside" <?php echo selected("outside",$VALUE_position) ?>><?php echo __('position outside','szgoogleadmin') ?></option>
		<option value="top"     <?php echo selected("top"    ,$VALUE_position) ?>><?php echo __('position top'    ,'szgoogleadmin') ?></option>
		<option value="center"  <?php echo selected("center" ,$VALUE_position) ?>><?php echo __('position center' ,'szgoogleadmin') ?></option>
		<option value="bottom"  <?php echo selected("bottom" ,$VALUE_position) ?>><?php echo __('position bottom' ,'szgoogleadmin') ?></option>
	</select>
</td></tr>

<!-- WIDGETS (Campo per inserimento allineamento) -->

<tr><td colspan="2">
	<select class="widefat" id="<?php echo $ID_align ?>" name="<?php echo $NAME_align ?>">
		<option value="none"   <?php echo selected("none"  ,$VALUE_align) ?>><?php echo __('alignment none'  ,'szgoogleadmin') ?></option>
		<option value="left"   <?php echo selected("left"  ,$VALUE_align) ?>><?php echo __('alignment left'  ,'szgoogleadmin') ?></option>
		<option value="center" <?php echo selected("center",$VALUE_align) ?>><?php echo __('alignment center','szgoogleadmin') ?></option>
		<option value="right"  <?php echo selected("right" ,$VALUE_align) ?>><?php echo __('alignment right' ,'szgoogleadmin') ?></option>
	</select>
</td></tr>

<!-- WIDGETS (Campo per inserimento button size) -->

<tr><td colspan="2">
	<select class="widefat" id="<?php echo $ID_size ?>" name="<?php echo $NAME_size ?>">
		<option value="standard" <?php echo selected("standard",$VALUE_size) ?>><?php echo __('size standard','szgoogleadmin') ?></option>
		<option value="small"    <?php echo selected("small"   ,$VALUE_size) ?>><?php echo __('size small'   ,'szgoogleadmin') ?></option>
		<option value="medium"   <?php echo selected("medium"  ,$VALUE_size) ?>><?php echo __('size medium'  ,'szgoogleadmin') ?></option>
		<option value="tail"     <?php echo selected("tail"    ,$VALUE_size) ?>><?php echo __('size tail'    ,'szgoogleadmin') ?></option>
	</select>
</td></tr>

<!-- WIDGETS (Campo per inserimento button annotation) -->

<tr><td colspan="2">
	<select class="widefat" id="<?php echo $ID_annotation ?>" name="<?php echo $NAME_annotation ?>">
		<option value="none"   <?php echo selected("none"  ,$VALUE_annotation) ?>><?php echo __('annotation none'  ,'szgoogleadmin') ?></option>
		<option value="inline" <?php echo selected("inline",$VALUE_annotation) ?>><?php echo __('annotation inline','szgoogleadmin') ?></option>
		<option value="bubble" <?php echo selected("bubble",$VALUE_annotation) ?>><?php echo __('annotation bubble','szgoogleadmin') ?></option>
	</select>
</td></tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->

</table>

<!-- WIDGETS (Codice javascript per funzioni UI) -->

<script type="text/javascript">
	jQuery(document).ready(function(){
		szgoogle_switch_hidden_ready();
		szgoogle_media_uploader();
	});
</script>
