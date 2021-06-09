<div class="stepcontent step<?php echo $currentstep; ?>">
  <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../../assets/step2.png" alt="" />
  <h2><?php _e('¿Con cuál de nuestros <span>perfiles de empresa</span> te identificas?', 'ac-update-forms'); ?></h2>


  <input type="hidden" name="currentstep" value="2" />
  <input type="hidden" name="update" value="2" />
  <div class="columns">
    <?php foreach ($tags as $tag ) { if($tag['position'] == 'empresa') { ?>
      <label><input type="checkbox" class="checkbox-tag-empresa" id="checkbox-tag-<?php echo $tag['id']; ?>" name="ac[tags][<?php echo $tag['id']; ?>][status]" value="add" <?php echo ($tag['has_tag'] == true ? "checked" : "") ?> /> <?php echo $tag['text']; ?></label>
      <input type="hidden" id="hidden-tag-<?php echo $tag['id']; ?>" name="ac[tags][<?php echo $tag['id']; ?>][tag]" value="<?php echo $tag['my_tag']; ?>" />
    <?php } } ?>
    <label><input type="checkbox" id="select-all-empresa" /> <?php _e('Me interesa recibir la información para cualquiera de estos perfiles.', 'ac-update-forms'); ?></label>
  </div>
  <nav>
    <div>
      <a href="#"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>../../assets/back.png" alt="" /></a>
    </div>
    <div>
      <button type="submit"><?php _e('Continúa avanzando', 'ac-update-forms'); ?></button>
      <p><em><?php _e('➤  Solo te quedan 2 pasos', 'ac-update-forms'); ?></em></p>
    </div>
  </nav>
</div>
