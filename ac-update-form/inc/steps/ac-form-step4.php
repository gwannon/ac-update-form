<div class="stepcontent step<?php echo $currentstep; ?>">
  <img src="<?php echo $plugin_dir_url; ?>assets/step4.png" alt="" />
  <h2><?php _e('¿En qué <span>idioma</span> quieres recibirnos?', 'ac-update-forms'); ?></h2>


  <input type="hidden" name="currentstep" value="4" />
  <input type="hidden" name="update" value="4" />
  <div class="columns">
    <?php $disabled = true; foreach ($langs as $lang) { if($lang['has_tag'] == true) $disabled = false; ?>
      <label><input type="checkbox" class="checkbox-lang" id="checkbox-lang-<?php echo $lang['id']; ?>" name="ac[langs][<?php echo $lang['id']; ?>][status]" value="add" <?php echo ($lang['has_tag'] == true ? "checked" : "") ?> /> <?php echo $lang['text']; ?></label>
      <input type="hidden" id="hidden-lang-<?php echo $lang['id']; ?>" name="ac[langs][<?php echo $lang['id']; ?>][tag]" value="<?php echo $lang['my_tag']; ?>" />
    <?php } ?>
    <label><input type="checkbox" id="select-all-lang" /> <?php _e('Seleccionar ambos', 'ac-update-forms'); ?></label>
  </div>

  
  <nav>
    <div>
      <a href="#"><img src="<?php echo $plugin_dir_url; ?>assets/back.png" alt="" /></a>
    </div>
    <div>
      <button type="submit"<?php echo ($disabled ? " disabled='disabled'" : "") ?>><?php _e('Para terminar, confírmanos tus datos', 'ac-update-forms'); ?></button>
    </div>
  </nav>
</div>
