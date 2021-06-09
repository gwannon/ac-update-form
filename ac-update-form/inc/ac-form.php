<?php if($currentstep != 6) { ?>
<section id="maintitle">
  <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../assets/boletin.png" alt="" />
  <h1><?php _e('Personaliza tus boletines', 'ac-update-forms'); ?></h1>
  <p><?php _e('Indícanos las temáticas y productos de Grupo SPRI que más interesan y empieza a recibir los boletines según tus preferencias.', 'ac-update-forms'); ?></p>
  <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../assets/arrow-grey.png" alt="" />
</section>
<form id="ac-form" method="post">
  <div class="row">
    <?php if($currentstep == 1) include(dirname(__FILE__)."/steps/ac-form-step1.php");
    else if($currentstep == 2) include(dirname(__FILE__)."/steps/ac-form-step2.php");
    else if($currentstep == 3) include(dirname(__FILE__)."/steps/ac-form-step3.php");
    else if($currentstep == 4) include(dirname(__FILE__)."/steps/ac-form-step4.php");
    else if($currentstep == 5) include(dirname(__FILE__)."/steps/ac-form-step5.php"); ?>
  </div>
</form>
<?php } else { ?>
  <?php include(dirname(__FILE__)."/steps/ac-form-step6.php"); ?>
<?php } ?>
<?php include(dirname(__FILE__)."/script.php"); ?>