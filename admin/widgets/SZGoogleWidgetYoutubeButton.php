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
<table id="SZGoogleWidgetYoutubeButton" class="sz-google-table-widget">

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

<!-- WIDGETS (Campo per inserimento layout) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_layout ?>"><?php echo ucfirst(__('layout','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_layout ?>" name="<?php echo $NAME_layout ?>">
			<option value="standard" <?php echo selected("standard" ,$VALUE_layout) ?>><?php echo __('standard','szgoogleadmin') ?></option>
			<option value="full"     <?php echo selected("full"     ,$VALUE_layout) ?>><?php echo __('full'    ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento theme) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_theme ?>"><?php echo ucfirst(__('theme','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_theme ?>" name="<?php echo $NAME_theme ?>">
			<option value="standard" <?php echo selected("standard" ,$VALUE_theme) ?>><?php echo __('standard','szgoogleadmin') ?></option>
			<option value="dark"     <?php echo selected("dark"     ,$VALUE_theme) ?>><?php echo __('dark'    ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per inserimento subscriber) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('subscriber','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_subscriber ?>" value="y" <?php if ($VALUE_subscriber == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_subscriber ?>" value="n" <?php if ($VALUE_subscriber != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per inserimento allineamento) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_align ?>"><?php echo ucfirst(__('alignment','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_align ?>" name="<?php echo $NAME_align ?>">
			<option value="none"   <?php echo selected("none"  ,$VALUE_align) ?>><?php echo __('alignment none'  ,'szgoogleadmin') ?></option>
			<option value="left"   <?php echo selected("left"  ,$VALUE_align) ?>><?php echo __('alignment left'  ,'szgoogleadmin') ?></option>
			<option value="center" <?php echo selected("center",$VALUE_align) ?>><?php echo __('alignment center','szgoogleadmin') ?></option>
			<option value="right"  <?php echo selected("right" ,$VALUE_align) ?>><?php echo __('alignment right' ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->
</table>

<!-- WIDGETS (Codice javascript per funzioni UI) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		if (typeof(szgoogle_checks_hidden_onload) == 'function') { szgoogle_checks_hidden_onload('SZGoogleWidgetYoutubeButton'); }
		if (typeof(szgoogle_switch_hidden_onload) == 'function') { szgoogle_switch_hidden_onload('SZGoogleWidgetYoutubeButton'); }
	});
</script>