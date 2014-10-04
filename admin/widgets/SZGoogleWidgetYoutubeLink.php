<?php
/**
 * Codice HTML per il form di impostazione collegato 
 * al widget presente nella parte di amministrazione, questo
 * codice è su file separato per escluderlo dal frontend
 *
 * @package SZGoogle
 * @subpackage SZGoogleWidgets
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();
?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->
<table id="SZGoogleWidgetYoutubeLink" class="sz-google-table-widget">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->
<tr class="only-widgets">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento tipo di URL) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_method ?>"><?php echo ucfirst(__('URL','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="sz-google-switch-hidden widefat" id="<?php echo $ID_method ?>" name="<?php echo $NAME_method ?>" onchange="szgoogle_switch_hidden_onchange(this);" data-close="1" data-switch="sz-google-switch-url">
			<option value="1" <?php echo selected("1",$VALUE_method) ?>><?php echo __('configuration','szgoogleadmin') ?></option>
			<option value="2" <?php echo selected("2",$VALUE_method) ?>><?php echo __('specific channel','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento URL specifico) -->
<tr class="sz-google-switch-url sz-google-hidden">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_channel ?>"><?php echo ucfirst(__('channel','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="sz-upload-image-url widefat" id="<?php echo $ID_channel ?>" name="<?php echo $NAME_channel ?>" type="text" value="<?php echo $VALUE_channel ?>" placeholder="<?php echo __('insert channel','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo con inserimento dei valori SHOW) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('subscription','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<input type="radio" name="<?php echo $NAME_subscription ?>" value="y" <?php if ($VALUE_subscription == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?>&nbsp;&nbsp;
		<input type="radio" name="<?php echo $NAME_subscription ?>" value="n" <?php if ($VALUE_subscription != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?>
	</td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('new tab','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<input type="radio" name="<?php echo $NAME_newtab ?>" value="y" <?php if ($VALUE_newtab == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?>&nbsp;&nbsp;
		<input type="radio" name="<?php echo $NAME_newtab ?>" value="n" <?php if ($VALUE_newtab != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?>
	</td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per inserimento del testo da usare come badge) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_text ?>"><?php echo ucfirst(__('text','szgoogleadmin')) ?>:</label></td>
	<td colspan="2"><textarea class="widefat" rows="3" cols="20" id="<?php echo $ID_text ?>" name="<?php echo $NAME_text ?>" placeholder="<?php echo __('insert text of link','szgoogleadmin') ?>"><?php echo $VALUE_text ?></textarea></td>
</tr>

<!-- WIDGETS (Campo per inserimento immagine da usare come badge) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_image ?>"><?php echo ucfirst(__('image','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input class="sz-upload-image-url-2 widefat" id="<?php echo $ID_image ?>" name="<?php echo $NAME_image ?>" type="text" value="<?php echo $VALUE_image ?>" placeholder="<?php echo __('choose image for badge','szgoogleadmin') ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input class="sz-upload-image-button button" type="button" value="<?php echo ucfirst(__('file','szgoogleadmin')) ?>" data-field-url="sz-upload-image-url-2" data-title="<?php echo ucfirst(__('select or upload a file','szgoogleadmin')) ?>" data-button-text="<?php echo ucfirst(__('confirm selection','szgoogleadmin')) ?>"/></td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->
</table>

<!-- WIDGETS (Codice javascript per funzioni UI) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		if (typeof(szgoogle_checks_hidden_onload) == 'function') { szgoogle_checks_hidden_onload('SZGoogleWidgetYoutubeLink'); }
		if (typeof(szgoogle_switch_hidden_onload) == 'function') { szgoogle_switch_hidden_onload('SZGoogleWidgetYoutubeLink'); }
		if (typeof(szgoogle_upload_select_media)  == 'function') { szgoogle_upload_select_media(); }
	});
</script>