<div class="stepcontent step<?php echo $currentstep; ?>">
  <img src="<?php echo $plugin_dir_url; ?>assets/step3.png" alt="" />
  <h2><?php _e('¿Alguna prioridad respecto a la <span>temática</span>?', 'ac-update-forms'); ?></h2>
  <input type="hidden" name="currentstep" value="3" />
  <input type="hidden" name="update" value="3" />
  <div class="columns">
    <?php foreach ($tags as $tag ) { if($tag['position'] == 'intereses') { ?>
      <label><input type="checkbox" class="checkbox-tag-intereses" id="checkbox-tag-<?php echo $tag['id']; ?>" name="ac[tags][<?php echo $tag['id']; ?>][status]" value="add" <?php echo ($tag['has_tag'] == true ? "checked" : "") ?> /> <?php echo $tag['text']; ?></label>
      <input type="hidden" id="hidden-tag-<?php echo $tag['id']; ?>" name="ac[tags][<?php echo $tag['id']; ?>][tag]" value="<?php echo $tag['my_tag']; ?>" />
    <?php } } ?>
    <label style="width: calc(50% - 14px);"><input type="checkbox" id="select-all-intereses" /> <?php _e('Me interesan los contenidos de todas estas temáticas.', 'ac-update-forms'); ?></label>
  </div>
  <nav>
    <div>
      <a href="#"><img src="<?php echo $plugin_dir_url; ?>assets/back.png" alt="" /></a>
    </div>
    <div>
      <button type="submit"><?php _e('Continúa avanzando', 'ac-update-forms'); ?></button>
      <p><em><?php _e('➤  Solo te queda 1 paso', 'ac-update-forms'); ?></em></p>
    </div>
  </nav>
</div>
