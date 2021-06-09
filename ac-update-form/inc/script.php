<script>
  jQuery('.checkbox-boletines').click(function() {
    if(jQuery(this).is(":checked")) {
      jQuery("#"+jQuery(this).attr("id").replace("checkbox", "hidden")).val("Sí");
    } else {
      jQuery("#"+jQuery(this).attr("id").replace("checkbox", "hidden")).val("No");
    }
  });
  jQuery("#select-all-empresa").change(function() {
    jQuery(".checkbox-tag-empresa").prop('checked', jQuery(this).is(':checked'));
  });

  jQuery("#select-all-intereses").change(function() {
    jQuery(".checkbox-tag-intereses").prop('checked', jQuery(this).is(':checked'));
  });

  jQuery("#select-all-preferencias").change(function() {
    jQuery(".checkbox-tag-preferencias").prop('checked', jQuery(this).is(':checked'));
  });

  jQuery("#select-all-lang").change(function() {
    jQuery(".checkbox-lang").prop('checked', jQuery(this).is(':checked'));
    var disabled = true;
    jQuery(".checkbox-lang").each(function() {
      if(jQuery(this).prop('checked')) disabled = false;
    });
    jQuery(".step4 button").prop('disabled', disabled);
  });

  jQuery("#avisolegal").change(function() {
    jQuery(".step5 button").prop('disabled', !jQuery(this).is(':checked'));
  });

  jQuery(".step4 button").click(function(e) {
    e.preventDefault();
    var send = false;
    jQuery(".checkbox-lang").each(function() {
      if(jQuery(this).prop('checked')) send = true;
    });
    if(send) jQuery("#ac-form").submit();
  });

  jQuery(".checkbox-lang, #select-all-lang").click(function(e) {
    console.log("click");
    var disabled = true;
    jQuery(".checkbox-lang").each(function() {
      if(jQuery(this).prop('checked')) disabled = false;
    });
    jQuery(".step4 button").prop('disabled', disabled);
  });

  jQuery("#ac-form .stepcontent nav div:nth-child(1) a").click(function() {
    event.preventDefault();
    history.back(1);
  });
</script>