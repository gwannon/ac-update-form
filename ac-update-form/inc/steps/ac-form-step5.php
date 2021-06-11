<div class="stepcontent step<?php echo $currentstep; ?> flex">

  <div>
    <h2 style="margin-bottom: 10px !important;"><?php _e('Guarda tu <span>perfil</span>', 'ac-update-forms'); ?></h2><br/>
    <p style="margin-bottom: 50px;"><?php _e('Cuanta más información completes mejor te informaremos.', 'ac-update-forms'); ?></p>
  </div>
  <input type="hidden" name="currentstep" value="5" />
  <input type="hidden" name="update" value="5" />
  <div class="columns">
    <label><b><?php _e('Email', 'ac-update-forms'); ?></b><br/><?php echo $contact->email; ?></label>

    <?php foreach ($formFields as $id => $field ) { if($field['position'] == 'pre') { ?>
      <label><b><?php echo $field['label']; ?><?php echo ($field['required'] ? "*" : ""); ?></b>
        <?php if(isset($field['select'])) { ?>
          <select name="ac[field][<?php echo $field['id']."-".$field['field']; ?>]" oninvalid="onError();" <?php echo ($field['required'] ? " required" : ""); ?>>
            <option value=""><?php printf(__('Elige tu %s', 'ac-update-forms'), mb_strtolower($field['label'])); ?></option>
            <?php foreach($field['select'] as $select) { ?>
              <option value="<?php echo $select['label']; ?>"<?php echo ($field['value'] == $select['label'] ? " selected='selected'" : ""); ?>><?php echo $select['text']; ?></option>
            <?php } ?>
          </select>
        <?php } else { ?>
          <input type="<?php echo ($field['type'] != '' ? $field['type'] : "text"); ?>" name="ac[field][<?php echo $field['id']."-".$field['field']; ?>]" value="<?php echo $field['value']; ?>" placeholder="<?php echo $field['label']; ?>" oninvalid="onError();" <?php echo ($field['required'] ? " required" : ""); ?><?php echo ($field['pattern'] ? " pattern='".$field['pattern']."'" : ""); ?> />
        <?php } } ?>
      </label>
    <?php } ?>


    <?php foreach ($formData as $label => $input ) { ?>
      <label><b><?php echo $input['name']; ?><?php echo ($input['required'] ? "*" : ""); ?></b>
        <input type="<?php echo ($input['type'] != '' ? $input['type'] : "text"); ?>" name="ac[data][<?php echo $label; ?>]" value="<?php echo $contact->{$label}; ?>" placeholder="<?php echo $input['name']; ?>" oninvalid="onError();"<?php echo ($input['required'] ? " required" : ""); ?> <?php echo ($input['pattern'] ? " pattern='".$input['pattern']."'" : ""); ?> />
      </label>
    <?php } ?>


    <?php foreach ($formFields as $id => $field ) { if($field['position'] == 'post') { ?>
      <label><b><?php echo $field['label']; ?><?php echo ($field['required'] ? "*" : ""); ?></b>
        <?php if(isset($field['select'])) { ?>
          <select name="ac[field][<?php echo $field['id']."-".$field['field']; ?>]" oninvalid="onError();" <?php echo ($field['required'] ? " required" : ""); ?>>
            <option value=""><?php printf(__('Elige tu %s', 'ac-update-forms'), mb_strtolower($field['label'])); ?></option>
            <?php foreach($field['select'] as $select) { ?>
              <option value="<?php echo $select['label']; ?>"<?php echo ($field['value'] == $select['label'] ? " selected='selected'" : ""); ?>><?php echo $select['text']; ?></option>
            <?php } ?>
          </select>
        <?php } else { ?>
          <input type="<?php echo ($field['type'] != '' ? $field['type'] : "text"); ?>" name="ac[field][<?php echo $field['id']."-".$field['field']; ?>]" value="<?php echo $field['value']; ?>" placeholder="<?php echo $field['label']; ?>" oninvalid="onError();" <?php echo ($field['required'] ? " required" : ""); ?><?php echo ($field['pattern'] ? " pattern='".$field['pattern']."'" : ""); ?> />
        <?php } } ?>
      </label>
    <?php } ?>

    <label><b><?php _e('Protección de datos*', 'ac-update-forms'); ?></b>
      <p style="font-size: 13px; line-height: 20px;"><input type="checkbox" required id="avisolegal" /> <?php _e('Sí, he LEÍDO y ACEPTO en todos sus términos la Información legal incluida en la <a href="https://www.spri.eus/es/politica-de-privacidad/">política de privacidad</a>', 'ac-update-forms'); ?></p>
      <p class="minilegal"><?php _e('SPRI-Agencia Vasca de Desarrollo Empresarial (www.spri.eus), como responsable del tratamiento y con quien puede contactar mediante el mail lopd@spri.eus recoge sus datos personales con la finalidad de prestarle el adecuado servicio de atención en relación a nuestros servicios y programas de ayudas. Para conocer en detalle los derechos que le asisten y disponer de información ampliada respecto a las finalidades y legitimación del tratamiento puede dirigirse a esta página.', 'ac-update-forms'); ?></p>
    </label>
  </div>
  <button type="submit" disabled="disabled"><?php _e('Guarda tu perfil', 'ac-update-forms'); ?></button>
</div>
