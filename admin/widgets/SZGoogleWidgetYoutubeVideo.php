<?php
/**
 * Codice HTML per il form di impostazione collegato 
 * al widget presente nella parte di amministrazione, questo
 * codice è su file separato per escluderlo dal frontend
 *
 * @package SZGoogle
 */
if (!defined('SZ_PLUGIN_GOOGLE') or !SZ_PLUGIN_GOOGLE) die();

/**
 * Definizione variabili che sono legata alla istanza del 
 * widget richiamato com memorizzazione delle opzioni.
 */
$title           = trim(strip_tags($instance['title']));
$url             = trim(strip_tags($instance['url']));
$responsive      = trim(strip_tags($instance['responsive']));
$width           = trim(strip_tags($instance['width']));
$height          = trim(strip_tags($instance['height']));
$delayed         = trim(strip_tags($instance['delayed']));
$autoplay        = trim(strip_tags($instance['autoplay']));
$loop            = trim(strip_tags($instance['loop']));
$fullscreen      = trim(strip_tags($instance['fullscreen']));
$schemaorg       = trim(strip_tags($instance['schemaorg']));
$disableiframe   = trim(strip_tags($instance['disableiframe']));
$disablekeyboard = trim(strip_tags($instance['disablekeyboard']));
$disablerelated  = trim(strip_tags($instance['disablerelated']));
$start           = trim(strip_tags($instance['start']));
$end             = trim(strip_tags($instance['end']));
$theme           = trim(strip_tags($instance['theme']));
$cover           = trim(strip_tags($instance['cover']));

/**
 * Creazione HTML CSS (id) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$ID_title              = $this->get_field_id('title');
$ID_url                = $this->get_field_id('url');
$ID_responsive         = $this->get_field_id('responsive');
$ID_width              = $this->get_field_id('width');
$ID_height             = $this->get_field_id('height');
$ID_delayed            = $this->get_field_id('delayed');
$ID_autoplay           = $this->get_field_id('autoplay');
$ID_loop               = $this->get_field_id('loop');
$ID_fullscreen         = $this->get_field_id('fullscreen');  
$ID_schemaorg          = $this->get_field_id('schemaorg'); 
$ID_disableiframe      = $this->get_field_id('disableiframe');
$ID_disablekeyboard    = $this->get_field_id('disablekeyboard');
$ID_disablerelated     = $this->get_field_id('disablerelated');
$ID_start              = $this->get_field_id('start');
$ID_end                = $this->get_field_id('end');
$ID_theme              = $this->get_field_id('theme');
$ID_cover              = $this->get_field_id('cover');

/**
 * Creazione HTML CSS (name) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$NAME_title            = $this->get_field_name('title');
$NAME_url              = $this->get_field_name('url');
$NAME_responsive       = $this->get_field_name('responsive');
$NAME_width            = $this->get_field_name('width');
$NAME_height           = $this->get_field_name('height');
$NAME_delayed          = $this->get_field_name('delayed');
$NAME_autoplay         = $this->get_field_name('autoplay');
$NAME_loop             = $this->get_field_name('loop');
$NAME_fullscreen       = $this->get_field_name('fullscreen');  
$NAME_schemaorg        = $this->get_field_name('schemaorg'); 
$NAME_disableiframe    = $this->get_field_name('disableiframe');
$NAME_disablekeyboard  = $this->get_field_name('disablekeyboard');
$NAME_disablerelated   = $this->get_field_name('disablerelated');
$NAME_start            = $this->get_field_name('start');
$NAME_end              = $this->get_field_name('end');
$NAME_theme            = $this->get_field_name('theme');
$NAME_cover            = $this->get_field_name('cover');

/**
 * Creazione HTML CSS (value) per tutte le variabili 
 * elencate sopra e presenti nelle opzioni del widget.
 */
$VALUE_title           = esc_attr($title);
$VALUE_url             = esc_attr($url);
$VALUE_responsive      = esc_attr($responsive);
$VALUE_width           = esc_attr($width);
$VALUE_height          = esc_attr($height);
$VALUE_delayed         = esc_attr($delayed);
$VALUE_autoplay        = esc_attr($autoplay);
$VALUE_loop            = esc_attr($loop);
$VALUE_fullscreen      = esc_attr($fullscreen);  
$VALUE_schemaorg       = esc_attr($schemaorg); 
$VALUE_disableiframe   = esc_attr($disableiframe);
$VALUE_disablekeyboard = esc_attr($disablekeyboard);
$VALUE_disablerelated  = esc_attr($disablerelated);
$VALUE_start           = esc_attr($start);
$VALUE_end             = esc_attr($end);
$VALUE_theme           = esc_attr($theme);
$VALUE_cover           = esc_attr($cover);

?>
<!-- WIDGETS (Tabella per contenere il FORM del widget) -->
<p><table class="sz-google-table-widget">

<!-- WIDGETS (Campo con inserimento del titolo widget) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_title ?>"><?php echo ucfirst(__('title','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_title ?>" name="<?php echo $NAME_title ?>" type="text" value="<?php echo $VALUE_title ?>" placeholder="<?php echo __('insert title for widget','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Campo per inserimento URL specifico) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_url ?>"><?php echo ucfirst(__('URL video','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_url ?>" name="<?php echo $NAME_url ?>" type="text" value="<?php echo $VALUE_url ?>" placeholder="<?php echo __('insert URL for youtube video','szgoogleadmin') ?>"/></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro enable) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_responsive ?>"><?php echo ucfirst(__('responsive','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_responsive ?>" value="y" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-display" data-close="y" <?php if ($VALUE_responsive == 'y') echo ' checked class="sz-google-switch-hidden"'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_responsive ?>" value="n" onchange="szgoogle_switch_hidden(this);" data-switch="sz-google-switch-display" data-close="y" <?php if ($VALUE_responsive != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_delayed ?>"><?php echo ucfirst(__('delayed','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_delayed ?>" value="y" <?php if ($VALUE_delayed == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_delayed ?>" value="n" <?php if ($VALUE_delayed != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_autoplay ?>"><?php echo ucfirst(__('autoplay','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_autoplay ?>" value="y" <?php if ($VALUE_autoplay == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_autoplay ?>" value="n" <?php if ($VALUE_autoplay != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_loop ?>"><?php echo ucfirst(__('loop','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_loop ?>" value="y" <?php if ($VALUE_loop == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_loop ?>" value="n" <?php if ($VALUE_loop != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_fullscreen ?>"><?php echo ucfirst(__('fullscreen','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_fullscreen ?>" value="y" <?php if ($VALUE_fullscreen == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_fullscreen ?>" value="n" <?php if ($VALUE_fullscreen != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_schemaorg ?>"><?php echo ucfirst(__('schemaorg','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_schemaorg ?>" value="y" <?php if ($VALUE_schemaorg == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_schemaorg ?>" value="n" <?php if ($VALUE_schemaorg != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro width & height) -->
<tr class="sz-google-switch-display">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_width ?>"><?php echo ucfirst(__('width','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_width ?>" name="<?php echo $NAME_width ?>" type="number" step="1" min="0" value="<?php echo $VALUE_width ?>"/></td>
</tr>

<tr class="sz-google-switch-display">
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_height ?>"><?php echo ucfirst(__('height','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_height ?>" name="<?php echo $NAME_height ?>" type="number" step="1" min="0" value="<?php echo $VALUE_height ?>"/></td>
</tr>

<tr class="sz-google-switch-display"><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro theme & cover) -->
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

<!-- WIDGETS (Campo per specificare il parametro disable) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_disableiframe ?>"><?php echo ucfirst(__('disable iframe','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disableiframe ?>" value="y" <?php if ($VALUE_disableiframe == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disableiframe ?>" value="n" <?php if ($VALUE_disableiframe != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_disablekeyboard ?>"><?php echo ucfirst(__('disable keyboard','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disablekeyboard ?>" value="y" <?php if ($VALUE_disablekeyboard == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disablekeyboard ?>" value="n" <?php if ($VALUE_disablekeyboard != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_disablerelated ?>"><?php echo ucfirst(__('disable related','szgoogleadmin')) ?>:</label></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disablerelated ?>" value="y" <?php if ($VALUE_disablerelated == 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('yes','szgoogleadmin')) ?></td>
	<td colspan="1" class="sz-cell-vals"><input type="radio" name="<?php echo $NAME_disablerelated ?>" value="n" <?php if ($VALUE_disablerelated != 'y') echo ' checked'?>>&nbsp;<?php echo ucfirst(__('no' ,'szgoogleadmin')) ?></td>
</tr>

<tr><td colspan="3"><hr></td></tr>

<!-- WIDGETS (Campo per specificare il parametro start & end) -->
<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_start ?>"><?php echo ucfirst(__('start (secs)','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_start ?>" name="<?php echo $NAME_start ?>" type="number" step="1" min="0" value="<?php echo $VALUE_start ?>" placeholder="<?php echo __('insert value in seconds','szgoogleadmin') ?>"/></td>
</tr>

<tr>
	<td colspan="1" class="sz-cell-keys"><label for="<?php echo $ID_end ?>"><?php echo ucfirst(__('end (secs)','szgoogleadmin')) ?>:</label></td>
	<td colspan="2" class="sz-cell-vals"><input class="widefat" id="<?php echo $ID_end ?>" name="<?php echo $NAME_end ?>" type="number" step="1" min="0" value="<?php echo $VALUE_end ?>" placeholder="<?php echo __('insert value in seconds','szgoogleadmin') ?>"/></td>
</tr>

<!-- WIDGETS (Chiusura tabella principale widget form) -->
</table></p>

<!-- WIDGETS (Codice javascript per funzioni UI) -->

<script type="text/javascript">
	jQuery(document).ready(function(){
		szgoogle_switch_hidden_ready();
	});
</script>