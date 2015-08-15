<?php

/**
 * HTML code of this widget in the administration section
 * This code is on a separate file to exclude it from the frontend
 *
 * @package SZGoogle
 * @subpackage Admin
 * @author Massimo Della Rovere
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

?>
<!-- WIDGETS (Table for the FORM widget) -->
<table id="SZGoogleWidgetHangoutStart" class="sz-google-table-widget">

<!-- WIDGETS (Field with inclusion of the title widget) -->
<tr class="only-widgets">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Field for input type hangouts) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_type ?>"><?php echo ucfirst(__('hangout','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_type ?>" name="<?php echo $NAME_type ?>">
			<option value="normal"    <?php echo selected("normal"    ,$VALUE_type) ?>><?php echo __('normal'   ,'szgoogleadmin') ?></option>
			<option value="onair"     <?php echo selected("onair"     ,$VALUE_type) ?>><?php echo __('onair'    ,'szgoogleadmin') ?></option>
			<option value="party"     <?php echo selected("party"     ,$VALUE_type) ?>><?php echo __('party'    ,'szgoogleadmin') ?></option>
			<option value="moderated" <?php echo selected("moderated" ,$VALUE_type) ?>><?php echo __('moderated','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Field for entering topic) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_topic ?>"><?php echo ucfirst(__('topic','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_topic ?>" name="<?php echo $NAME_topic ?>" type="text" value="<?php echo $VALUE_topic ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field to specify the size) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width ?>" class="sz-google-checks-width widefat" name="<?php echo $NAME_width ?>" type="text" size="5" placeholder="auto" value="<?php echo $VALUE_width ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden_onchange(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto,true,false) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field for insertion type of badge) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_badge ?>"><?php echo ucfirst(__('type','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="sz-google-switch-hidden widefat" id="<?php echo $ID_badge ?>" name="<?php echo $NAME_badge ?>" onchange="szgoogle_switch_hidden_onchange(this);" data-switch="sz-google-switch-display" data-close="0">
			<option value="0" <?php echo selected("0",$VALUE_badge) ?>><?php echo __('button without badge','szgoogleadmin') ?></option>
			<option value="1" <?php echo selected("1",$VALUE_badge) ?>><?php echo __('button with badge','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Field for entering text to use as a badge) -->
<tr class="sz-google-switch-display sz-google-hidden">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_text ?>"><?php echo ucfirst(__('text','szgoogleadmin')) ?>:</label></td>
	<td colspan="2"><textarea class="widefat" rows="3" cols="20" id="<?php echo $ID_text ?>" name="<?php echo $NAME_text ?>" placeholder="<?php echo __('insert text for badge','szgoogleadmin') ?>"><?php echo $VALUE_text ?></textarea></td>
</tr>

<!-- WIDGETS (CField for entering image to use as a badge) -->
<tr class="sz-google-switch-display sz-google-hidden">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_img ?>"><?php echo ucfirst(__('image','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input class="sz-upload-image-url-2 widefat" id="<?php echo $ID_img ?>" name="<?php echo $NAME_img ?>" type="text" value="<?php echo $VALUE_img ?>" placeholder="<?php echo __('choose image for badge','szgoogleadmin') ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input class="sz-upload-image-button button" type="button" value="<?php echo ucfirst(__('file','szgoogleadmin')) ?>" data-field-url="sz-upload-image-url-2" data-title="<?php echo ucfirst(__('select or upload a file','szgoogleadmin')) ?>" data-button-text="<?php echo ucfirst(__('confirm selection','szgoogleadmin')) ?>"/></td>
</tr>

<!-- WIDGETS (Field for entering the position) -->
<tr class="sz-google-switch-display sz-google-hidden">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_position ?>"><?php echo ucfirst(__('position','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_position ?>" name="<?php echo $NAME_position ?>">
			<option value="outside" <?php echo selected("outside",$VALUE_position) ?>><?php echo __('position outside','szgoogleadmin') ?></option>
			<option value="top"     <?php echo selected("top"    ,$VALUE_position) ?>><?php echo __('position top'    ,'szgoogleadmin') ?></option>
			<option value="center"  <?php echo selected("center" ,$VALUE_position) ?>><?php echo __('position center' ,'szgoogleadmin') ?></option>
			<option value="bottom"  <?php echo selected("bottom" ,$VALUE_position) ?>><?php echo __('position bottom' ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Field for entering alignment) -->
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

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field for display control with user logged) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('logged','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_logged ?>" value="y" <?php if ($VALUE_logged == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_logged ?>" value="n" <?php if ($VALUE_logged != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Field for display control with user guest) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('guest','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_guest ?>" value="y" <?php if ($VALUE_guest == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_guest ?>" value="n" <?php if ($VALUE_guest != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field for invite profile) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_profile ?>"><?php echo ucfirst(__('invite profile','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_profile ?>" name="<?php echo $NAME_profile ?>" type="text" value="<?php echo $VALUE_profile ?>" placeholder="<?php echo __('insert profiles with comma','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Field for invite email) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_email ?>"><?php echo ucfirst(__('invite email','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_email ?>" name="<?php echo $NAME_email ?>" type="text" value="<?php echo $VALUE_email ?>" placeholder="<?php echo __('insert emails with comma','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Closing the main table form widget) -->
</table>

<!-- WIDGETS (Javascript code for UI functions) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		if (typeof(szgoogle_checks_hidden_onload) == 'function') { szgoogle_checks_hidden_onload('SZGoogleWidgetHangoutStart'); }
		if (typeof(szgoogle_switch_hidden_onload) == 'function') { szgoogle_switch_hidden_onload('SZGoogleWidgetHangoutStart'); }
		if (typeof(szgoogle_upload_select_media)  == 'function') { szgoogle_upload_select_media(); }
	});
</script>