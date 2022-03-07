<div id="logincontent">
  <?php if (isset($_REQUEST['email']) && is_email($_REQUEST['email'])) { 

    $result =  acSearchUserByEmail(strip_tags($_REQUEST['email']));

    if(count($result) > 0) {
      $contact = $result[0];

      //Borramos los cacheos que pduieran haber quedado de otras veces.
      acDeleteCache ($contact->id);

      //Preparamos la cache para cuando vuelva del email
      /*$url = admin_url('admin-ajax.php')."?action=ac_cache_user&contact_id=".$contact->id;
      //echo $url;
      require_once( 'wp-load.php' );
      wp_remote_get( $url, array("blocking" => false));*/
    
      //Quitamos todos los filtros para que no afecten al mensaje.     
      remove_all_filters('wp_mail', 10);

      //Preparamos el email
      $headers = array(
        "From: info@spri.eus",
        "Reply-To: info@spri.eus",
        "X-Mailer: PHP/".phpversion(),
        "Content-type: text/html; charset=utf-8"
      );
      $message = str_replace("[LINK]", get_the_permalink()."?hash=".$contact->hash."&contact_id=".$contact->id, file_get_contents(dirname(__FILE__)."/../templates/email_".ICL_LANGUAGE_CODE.".html"));
      wp_mail ($_REQUEST['email'], __("Aquí puedes actualizar tus preferencias de suscripción a Grupo SPRI", 'ac-update-forms'), $message, $headers);
      wp_mail ("jorge@enutt.net", __("Aquí puedes actualizar tus preferencias de suscripción a Grupo SPRI", 'ac-update-forms'), $message, $headers);
      ?><p class="ok"><?php _e('Para actualizar tus preferencias de suscripción, comprueba tu correo electrónico porque te hemos enviado un mensaje con los pasos para poder hacerlo.', 'ac-update-forms'); ?></p>
      <script>
        jQuery.get( "<?php echo admin_url('admin-ajax.php')."?action=ac_cache_user&contact_id=".$contact->id; ?>", function( data ) {
          console.log( data );
        });
      </script>
      <?php 
    } else { ?>
      <p class="error"><?php _e('Email incorrecto. El email suministrado no está en nuestra base de datos.', 'ac-update-forms'); ?></p>
    <?php }
  } else if (isset($_REQUEST['email'])) { ?>
    <p class="error"><?php _e('Email incorrecto. El email suministrado no tiene el formato adecuado.', 'ac-update-forms'); ?></p>
  <?php } else if($error_access) { ?>
    <p class="error"><?php _e('Datos de acceso incorrectos.', 'ac-update-forms'); ?></p>
  <?php } ?>
  <form id="ac-form-login" method="post">
    <img src="<?php echo $plugin_dir_url; ?>assets/boletin.png" alt="" />
    <h1><?php _e('Personaliza tus boletines', 'ac-update-forms'); ?></h1>
    <p><?php _e('Empieza a recibir los boletines según tus preferencias.', 'ac-update-forms'); ?><br/><?php _e('Indícanos tu <b>email</b> para verificar que realmente eres tú.', 'ac-update-forms'); ?></p>
    <div>
      <input type="email" name="email" value="" placeholder="<?php _e('Email', 'ac-update-forms'); ?>" required />
      <button type="submit" name="send"><?php _e('Enviar', 'ac-update-forms'); ?></button>
    </div>
  </form>
</div>
