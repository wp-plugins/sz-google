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
<table id="SZGoogleWidgetYoutubeVideo" class="sz-google-table-widget">

<!-- WIDGETS (Field with inclusion of the title widget) -->
<tr class="only-widgets">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Field for entering specific URL) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_url ?>"><?php echo ucfirst(__('URL video','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_url ?>" name="<?php echo $NAME_url ?>" type="text" value="<?php echo $VALUE_url ?>" placeholder="<?php echo __('insert URL for youtube video','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field to specify the enable parameter) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('responsive','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_responsive ?>" value="y" onchange="szgoogle_switch_hidden_onchange(this);" data-switch="sz-google-switch-display" data-open="n" <?php if ($VALUE_responsive == 'y') echo ' checked '?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_responsive ?>" value="n" onchange="szgoogle_switch_hidden_onchange(this);" data-switch="sz-google-switch-display" data-open="n" <?php if ($VALUE_responsive != 'y') echo ' checked  class="sz-google-switch-hidden"'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('delayed','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_delayed ?>" value="y" <?php if ($VALUE_delayed == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_delayed ?>" value="n" <?php if ($VALUE_delayed != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('autoplay','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_autoplay ?>" value="y" <?php if ($VALUE_autoplay == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_autoplay ?>" value="n" <?php if ($VALUE_autoplay != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('loop','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_loop ?>" value="y" <?php if ($VALUE_loop == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_loop ?>" value="n" <?php if ($VALUE_loop != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('fullscreen','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_fullscreen ?>" value="y" <?php if ($VALUE_fullscreen == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_fullscreen ?>" value="n" <?php if ($VALUE_fullscreen != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('schemaorg','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_schemaorg ?>" value="y" <?php if ($VALUE_schemaorg == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_schemaorg ?>" value="n" <?php if ($VALUE_schemaorg != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field parameter to specify the width & height) -->
<tr class="sz-google-switch-display sz-google-hidden">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_width ?>" name="<?php echo $NAME_width ?>" class="widefat" type="text" placeholder="auto" value="<?php echo $VALUE_width ?>"/></td>
</tr>

<tr class="sz-google-switch-display sz-google-hidden">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_height ?>"><?php echo ucfirst(__('height','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_height ?>" name="<?php echo $NAME_height ?>" class="widefat" type="text" placeholder="auto" value="<?php echo $VALUE_height ?>"/></td>
</tr>

<tr class="sz-google-switch-display sz-google-hidden"><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field parameter to specify the theme & cover) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_theme ?>"><?php echo ucfirst(__('theme','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_theme ?>" name="<?php echo $NAME_theme ?>">
			<option value="dark"  <?php echo selected("dark" ,$VALUE_theme) ?>><?php echo __('theme dark' ,'szgoogleadmin') ?></option>
			<option value="light" <?php echo selected("light",$VALUE_theme) ?>><?php echo __('theme light','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_cover ?>"><?php echo ucfirst(__('cover','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals">
		<select class="widefat" id="<?php echo $ID_cover ?>" name="<?php echo $NAME_cover ?>">
			<option value="local"   <?php echo selected("local"  ,$VALUE_cover) ?>><?php echo __('cover local'  ,'szgoogleadmin') ?></option>
			<option value="youtube" <?php echo selected("youtube",$VALUE_cover) ?>><?php echo __('cover youtube','szgoogleadmin') ?></option>
		</select>
	</td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field parameter to specify the disable) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('disable iframe','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disableiframe ?>" value="y" <?php if ($VALUE_disableiframe == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disableiframe ?>" value="n" <?php if ($VALUE_disableiframe != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('disable keyboard','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disablekeyboard ?>" value="y" <?php if ($VALUE_disablekeyboard == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disablekeyboard ?>" value="n" <?php if ($VALUE_disablekeyboard != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label><?php echo ucfirst(__('disable related','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disablerelated ?>" value="y" <?php if ($VALUE_disablerelated == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disablerelated ?>" value="n" <?php if ($VALUE_disablerelated != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Field parameter to specify the start & end) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_start ?>"><?php echo ucfirst(__('start (secs)','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_start ?>" name="<?php echo $NAME_start ?>" type="number" step="1" min="0" value="<?php echo $VALUE_start ?>" placeholder="<?php echo __('insert value in seconds','szgoogleadmin') ?>"/></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_end ?>"><?php echo ucfirst(__('end (secs)','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_end ?>" name="<?php echo $NAME_end ?>" type="number" step="1" min="0" value="<?php echo $VALUE_end ?>" placeholder="<?php echo __('insert value in seconds','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Closing the main table form widget) -->
</table>

<!-- WIDGETS (Javascript code for UI functions) -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		if (typeof(szgoogle_switch_hidden_onload) == 'function') { szgoogle_switch_hidden_onload('SZGoogleWidgetYoutubeVideo'); }
	});
</script>