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
<p><table id="SZGoogleWidgetPlusComments" class="sz-google-table-widget">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento tipo di URL) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_method ?>"><?php echo ucfirst(__('URL','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="sz-google-switch-hidden widefat" id="<?php echo $ID_method ?>" name="<?php echo $NAME_method ?>" onchange="szgoogle_switch_hidden_onchange(this);" data-close="1" data-switch="sz-google-switch-url">
			<option value="1" <?php echo selected("1",$VALUE_method) ?>><?php echo __('current post address','szgoogleadmin') ?></option>
			<option value="2" <?php echo selected("2",$VALUE_method) ?>><?php echo __('specific url address','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Campo per inserimento URL specifico) -->
<tr class="sz-google-switch-url sz-google-hidden">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_url ?>"><?php echo ucfirst(__('URL','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="sz-upload-image-url widefat" id="<?php echo $ID_url ?>" name="<?php echo $NAME_url ?>" type="text" value="<?php echo $VALUE_url ?>" placeholder="<?php echo __('insert source URL','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare la dimensione) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width ?>" class="sz-google-checks-width widefat" name="<?php echo $NAME_width ?>" type="text" size="5" placeholder="auto" value="<?php echo $VALUE_width ?>" placeholder="auto"/></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden_onchange(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro align -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_align ?>"><?php echo ucfirst(__('align','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_align ?>" name="<?php echo $NAME_align ?>">
			<option value="none"   <?php echo selected("none"  ,$VALUE_align) ?>><?php echo __('none'  ,'szgoogleadmin') ?></option>
			<option value="left"   <?php echo selected("left"  ,$VALUE_align) ?>><?php echo __('left'  ,'szgoogleadmin') ?></option>
			<option value="center" <?php echo selected("center",$VALUE_align) ?>><?php echo __('center','szgoogleadmin') ?></option>
			<option value="right"  <?php echo selected("right" ,$VALUE_align) ?>><?php echo __('right' ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->
</table></p>

<!-- WIDGETS (Codice javascript per funzioni UI) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		if (typeof(szgoogle_checks_hidden_onload) == 'function') { szgoogle_checks_hidden_onload('SZGoogleWidgetPlusComments'); }
		if (typeof(szgoogle_switch_hidden_onload) == 'function') { szgoogle_switch_hidden_onload('SZGoogleWidgetPlusComments'); }
	});
</script>