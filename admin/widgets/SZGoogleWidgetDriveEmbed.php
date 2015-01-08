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
<table id="SZGoogleWidgetDriveEmbed" class="sz-google-table-widget">

<!-- WIDGETS (Field with inclusion of the title widget) -->
<tr class="only-widgets">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Field for entering document type) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_type ?>"><?php echo ucfirst(__('type','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select onchange="szgoogle_switch_select_onchange(this);" class="sz-google-row-select widefat" id="<?php echo $ID_type ?>" name="<?php echo $NAME_type ?>">
			<option data-open="1" value="document"     <?php echo selected("document"    ,$VALUE_type) ?>><?php echo __('document'    ,'szgoogleadmin') ?></option>
			<option data-open="2" value="presentation" <?php echo selected("presentation",$VALUE_type) ?>><?php echo __('presentation','szgoogleadmin') ?></option>
			<option data-open="3" value="spreadsheet"  <?php echo selected("spreadsheet" ,$VALUE_type) ?>><?php echo __('spreadsheet' ,'szgoogleadmin') ?></option>
			<option data-open="4" value="forms"        <?php echo selected("forms"       ,$VALUE_type) ?>><?php echo __('forms'       ,'szgoogleadmin') ?></option>
			<option data-open="5" value="pdf"          <?php echo selected("pdf"         ,$VALUE_type) ?>><?php echo __('pdf'         ,'szgoogleadmin') ?></option>
			<option data-open="6" value="video"        <?php echo selected("video"       ,$VALUE_type) ?>><?php echo __('video'       ,'szgoogleadmin') ?></option>
			<option data-open="7" value="folder"       <?php echo selected("folder"      ,$VALUE_type) ?>><?php echo __('folder'      ,'szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Field for entering specific ID) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_id ?>"><?php echo ucfirst(__('ID','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_id ?>" name="<?php echo $NAME_id ?>" type="text" value="<?php echo $VALUE_id ?>" placeholder="<?php echo __('insert document ID','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field to specify the size) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_width ?>" class="sz-google-checks-width widefat" name="<?php echo $NAME_width ?>" type="text" size="5" placeholder="auto" value="<?php echo $VALUE_width ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_width_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-width" onchange="szgoogle_checks_hidden_onchange(this);" name="<?php echo $NAME_width_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_width_auto,true,false) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_height ?>"><?php echo ucfirst(__('height','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_height ?>" class="sz-google-checks-height widefat" name="<?php echo $NAME_height ?>" type="text" size="5" placeholder="auto" value="<?php echo $VALUE_height ?>"/></td>
	<td colspan="1" class="sz-cell-vals"><input  id="<?php echo $ID_height_auto ?>" class="sz-google-checks-hidden checkbox" data-switch="sz-google-checks-height" onchange="szgoogle_checks_hidden_onchange(this);" name="<?php echo $NAME_height_auto ?>" type="checkbox" value="1" <?php echo checked($VALUE_height_auto,true,false) ?>>&nbsp;<?php echo ucfirst(__('auto','szgoogleadmin')) ?></td>
</tr>

<!-- WIDGETS (Field to specify the values ​​of presentation) -->
<tr class="sz-google-row-tab sz-google-row-tab-2"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-2">
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('start','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_start ?>" value="true"  <?php if ($VALUE_start == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_start ?>" value="false" <?php if ($VALUE_start != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<tr class="sz-google-row-tab sz-google-row-tab-2">
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('loop','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_loop ?>" value="true"  <?php if ($VALUE_loop == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_loop ?>" value="false" <?php if ($VALUE_loop != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<tr class="sz-google-row-tab sz-google-row-tab-2"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-2">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_delay ?>"><?php echo ucfirst(__('delay sec','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_delay ?>" name="<?php echo $NAME_delay ?>">
			<option value="1"  <?php echo selected("1" ,$VALUE_delay) ?>>01</option>
			<option value="2"  <?php echo selected("2" ,$VALUE_delay) ?>>02</option>
			<option value="3"  <?php echo selected("3" ,$VALUE_delay) ?>>03</option>
			<option value="4"  <?php echo selected("4" ,$VALUE_delay) ?>>04</option>
			<option value="5"  <?php echo selected("5" ,$VALUE_delay) ?>>05</option>
			<option value="10" <?php echo selected("10",$VALUE_delay) ?>>10</option>
			<option value="15" <?php echo selected("15",$VALUE_delay) ?>>15</option>
			<option value="30" <?php echo selected("30",$VALUE_delay) ?>>30</option>
			<option value="60" <?php echo selected("60",$VALUE_delay) ?>>60</option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Field to specify the values ​​of spreadsheet) -->
<tr class="sz-google-row-tab sz-google-row-tab-3"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-3">
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('single','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_single ?>" value="true"  <?php if ($VALUE_single == 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('enabled','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_single ?>" value="false" <?php if ($VALUE_single != 'true') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('disabled','szgoogleadmin')) ?></td>
</tr>

<tr class="sz-google-row-tab sz-google-row-tab-3"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-3">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_gid ?>"><?php echo ucfirst(__('sheet','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_gid ?>" name="<?php echo $NAME_gid ?>">
			<option value="1" <?php echo selected("1",$VALUE_gid) ?>>01</option>
			<option value="2" <?php echo selected("2",$VALUE_gid) ?>>02</option>
			<option value="3" <?php echo selected("3",$VALUE_gid) ?>>03</option>
			<option value="4" <?php echo selected("4",$VALUE_gid) ?>>04</option>
			<option value="5" <?php echo selected("5",$VALUE_gid) ?>>05</option>
			<option value="6" <?php echo selected("6",$VALUE_gid) ?>>06</option>
			<option value="7" <?php echo selected("7",$VALUE_gid) ?>>07</option>
			<option value="8" <?php echo selected("8",$VALUE_gid) ?>>08</option>
			<option value="9" <?php echo selected("9",$VALUE_gid) ?>>09</option>
		</select>
	</td>
</tr>

<tr class="sz-google-row-tab sz-google-row-tab-3">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_range ?>"><?php echo ucfirst(__('range','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_range ?>" name="<?php echo $NAME_range ?>" type="text" value="<?php echo $VALUE_range ?>" placeholder="<?php echo __('range of cells','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Field to specify the folder view) -->
<tr class="sz-google-row-tab sz-google-row-tab-7"><td colspan="3"><hr></td></tr>

<tr class="sz-google-row-tab sz-google-row-tab-7">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_folderview ?>"><?php echo ucfirst(__('folder view','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_folderview ?>" name="<?php echo $NAME_folderview ?>">
			<option value="list" <?php echo selected("list",$VALUE_folderview) ?>><?php echo __('list','szgoogleadmin') ?></option>
			<option value="grid" <?php echo selected("grid",$VALUE_folderview) ?>><?php echo __('grid','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Closing the main table form widget) -->
</table>

<!-- WIDGETS (Javascript code for UI functions) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		if (typeof(szgoogle_checks_hidden_onload) == 'function') { szgoogle_checks_hidden_onload('SZGoogleWidgetDriveEmbed'); }
		if (typeof(szgoogle_switch_hidden_onload) == 'function') { szgoogle_switch_hidden_onload('SZGoogleWidgetDriveEmbed'); }
		if (typeof(szgoogle_switch_select_onload) == 'function') { szgoogle_switch_select_onload('SZGoogleWidgetDriveEmbed'); }
	});
</script>