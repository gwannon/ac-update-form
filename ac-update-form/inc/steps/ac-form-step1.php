<div class="stepcontent step<?php echo $currentstep; ?>">
  <img src="<?php echo $plugin_dir_url; ?>assets/step1.png" alt="" />
  <h2><?php _e('¿Te gustaría recibir <span>todos los boletines</span>?', 'ac-update-forms'); ?></h2>
  <input type="hidden" name="currentstep" value="1" />
  <input type="hidden" name="update" value="1" />
  <div class="boxes">
    <?php foreach ($formNewslettersFields as $id => $field ) { ?>
      <div class="box">
        <input class="checkbox-boletines" type="checkbox" id="checkbox-<?php echo $id."-".$field['field']; ?>" name="checkbox-<?php echo $id."-".$field['field']; ?>" value="1" <?php echo ($field['value'] == 'Sí' ? "checked" : "") ?> />
        <h3><?php echo $field['label']; ?></h3>
        <p><?php echo $field['description']; ?></p>
        <input type="hidden" id="hidden-<?php echo $id."-".$field['field']; ?>" name="ac[newsletter][<?php echo $field['id']."-".$field['field']; ?>]" value="<?php echo $field['value']; ?>" />
      </div>
    <?php } ?>
  </div>
  <button type="submit"><?php _e('Continúa avanzando', 'ac-update-forms'); ?></button>
  <p><em><?php _e('➤  Solo te quedan 3 pasos', 'ac-update-forms'); ?></em></p>
</div>
