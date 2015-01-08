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
<table id="SZGoogleWidgetMaps" class="sz-google-table-widget">

<!-- WIDGETS (Field with inclusion of the title widget) -->
<tr class="only-widgets">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('widget title','szgoogleadmin') ?>"/></td>
</tr>

<tr class="only-widgets"><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field to specify lat and lng) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_lat ?>"><?php echo ucfirst(__('latitude','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_lat ?>" name="<?php echo $NAME_lat ?>" type="text" value="<?php echo $VALUE_lat ?>" placeholder="<?php echo __('enter map latitude','szgoogleadmin') ?>"/></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_lng ?>"><?php echo ucfirst(__('longitude','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_lng ?>" name="<?php echo $NAME_lng ?>" type="text" value="<?php echo $VALUE_lng ?>" placeholder="<?php echo __('enter map longitude','szgoogleadmin') ?>"/></td>
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

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field to specify zoom) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_zoom ?>"><?php echo ucfirst(__('zoom','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_zoom ?>" name="<?php echo $NAME_zoom ?>">
			<option value=""   <?php echo selected(""  ,$VALUE_zoom) ?>><?php echo SZGOOGLE_UPPER(__('default','szgoogleadmin')) ?></option>
			<option value="01" <?php echo selected("01",$VALUE_zoom) ?>>1</option>
			<option value="02" <?php echo selected("02",$VALUE_zoom) ?>>2</option>
			<option value="03" <?php echo selected("03",$VALUE_zoom) ?>>3</option>
			<option value="04" <?php echo selected("04",$VALUE_zoom) ?>>4</option>
			<option value="05" <?php echo selected("05",$VALUE_zoom) ?>>5</option>
			<option value="06" <?php echo selected("06",$VALUE_zoom) ?>>6</option>
			<option value="07" <?php echo selected("07",$VALUE_zoom) ?>>7</option>
			<option value="08" <?php echo selected("08",$VALUE_zoom) ?>>8</option>
			<option value="09" <?php echo selected("09",$VALUE_zoom) ?>>9</option>
			<option value="10" <?php echo selected("10",$VALUE_zoom) ?>>10</option>
			<option value="11" <?php echo selected("11",$VALUE_zoom) ?>>11</option>
			<option value="12" <?php echo selected("12",$VALUE_zoom) ?>>12</option>
			<option value="13" <?php echo selected("13",$VALUE_zoom) ?>>13</option>
			<option value="14" <?php echo selected("14",$VALUE_zoom) ?>>14</option>
			<option value="15" <?php echo selected("15",$VALUE_zoom) ?>>15</option>
			<option value="16" <?php echo selected("16",$VALUE_zoom) ?>>16</option>
			<option value="17" <?php echo selected("17",$VALUE_zoom) ?>>17</option>
			<option value="18" <?php echo selected("18",$VALUE_zoom) ?>>18</option>
			<option value="19" <?php echo selected("19",$VALUE_zoom) ?>>19</option>
			<option value="20" <?php echo selected("20",$VALUE_zoom) ?>>20</option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Field to specify view) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_view ?>"><?php echo ucfirst(__('view','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_view ?>" name="<?php echo $NAME_view ?>">
			<option value=""          <?php echo selected(""         ,$VALUE_view) ?>><?php echo SZGOOGLE_UPPER(__('default'  ,'szgoogleadmin')) ?></option>
			<option value="ROADMAP"   <?php echo selected("ROADMAP"  ,$VALUE_view) ?>><?php echo SZGOOGLE_UPPER(__('roadmap'  ,'szgoogleadmin')) ?></option>
			<option value="SATELLITE" <?php echo selected("SATELLITE",$VALUE_view) ?>><?php echo SZGOOGLE_UPPER(__('satellite','szgoogleadmin')) ?></option>
			<option value="HYBRID"    <?php echo selected("HYBRID"   ,$VALUE_view) ?>><?php echo SZGOOGLE_UPPER(__('hybrid'   ,'szgoogleadmin')) ?></option>
			<option value="TERRAIN"   <?php echo selected("TERRAIN"  ,$VALUE_view) ?>><?php echo SZGOOGLE_UPPER(__('terrain'  ,'szgoogleadmin')) ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Field to specify layer) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_layer ?>"><?php echo ucfirst(__('layer','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_layer ?>" name="<?php echo $NAME_layer ?>">
			<option value=""        <?php echo selected(""       ,$VALUE_layer) ?>><?php echo SZGOOGLE_UPPER(__('default','szgoogleadmin')) ?></option>
			<option value="NOTHING" <?php echo selected("NOTHING",$VALUE_layer) ?>><?php echo SZGOOGLE_UPPER(__('nothing','szgoogleadmin')) ?></option>
			<option value="TRAFFIC" <?php echo selected("TRAFFIC",$VALUE_layer) ?>><?php echo SZGOOGLE_UPPER(__('traffic','szgoogleadmin')) ?></option>
			<option value="TRANSIT" <?php echo selected("TRANSIT",$VALUE_layer) ?>><?php echo SZGOOGLE_UPPER(__('transit','szgoogleadmin')) ?></option>
			<option value="BICYCLE" <?php echo selected("BICYCLE",$VALUE_layer) ?>><?php echo SZGOOGLE_UPPER(__('bicycle','szgoogleadmin')) ?></option>
		</select>
	</td>
</tr>

<!-- WIDGETS (Closing the main table form widget) -->
</table>

<!-- WIDGETS (Javascript code for UI functions) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		if (typeof(szgoogle_checks_hidden_onload) == 'function') { szgoogle_checks_hidden_onload('SZGoogleWidgetMaps'); }
	});
</script>