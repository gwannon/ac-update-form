<?php //LIBs -----------------------------------------------------------------------
/* function print_pre($string) {
  echo "<pre>";
  print_r ($string);	
  echo "</pre>";
} */

function acSearchUserByEmail ($email) {   //Llamada CURL para sacar un usuario a partir de su email
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts?search=".urlencode($email));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  acRegisterApi("/api/3/contacts?search=".$email." GET");
  return json_decode(curl_exec($curl))->contacts;
}

//CAMPOs-------------------------------------------------

/*function acGetFields() { //Llamada CURL para sacar todos los campos
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/fields?limit=100");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  acRegisterApi("/api/3/fields?limit=100"." GET");
  return json_decode(curl_exec($curl));
}*/

function acGetUserById ($id) {
  $file = dirname(__FILE__)."/cache/".$id.".json";
  if (file_exists($file) && time()-filemtime($file) < 240) { //Si es menos de 5 minutos usamos el cacheo
    return json_decode(file_get_contents($file));
  }
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts/".$id);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  acRegisterApi("/api/3/contacts/".$id." GET");
  $json = json_decode(curl_exec($curl))->contact;
  //Cacheamos el fichero de respuesta
  $f = fopen($file, "w+");
  fwrite($f, json_encode($json));
  fclose($f);
  return $json;
} 

function acGetFieldsByUserId($id) {
  $file = dirname(__FILE__)."/cache/fieldValues".$id.".json";
  if (file_exists($file) && time()-filemtime($file) < 240) { //Si es menos de 5 minutos segundos usamos el cacheo
    return json_decode(file_get_contents($file));
  }

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts/".$id."/fieldValues");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  acRegisterApi("/api/3/contacts/".$id."/fieldValues"." GET");
  $json = json_decode(curl_exec($curl))->fieldValues;
  //Cacheamos el fichero de respuesta
  $f = fopen($file, "w+");
  fwrite($f, json_encode($json));
  fclose($f);
  return $json;  
}

function acUpdateFieldsByUserId($id, $data) {
  $curl = curl_init();
  $json = '{
    "contact": {
      "phone": "'.($data['phone'] != '' ? $data['phone'] : $contact->phone ).'",
      "firstName": "'.($data['firstName'] != '' ? $data['firstName'] : $contact->firstName ).'",
      "lastName": "'.($data['lastName'] != '' ? $data['lastName'] : $contact->lastName ).'"
    }
  }';
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts/".$id);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
  acRegisterApi("/api/3/contacts/".$id." PUT");
  return json_decode(curl_exec($curl))->contact;
}

function acUpdateCustomFieldValueByCustomFieldId($id, $contact_id, $field_id, $value) {
  $curl = curl_init();
  $json = '{
    "fieldValue": {
        "contact": '.$contact_id.',
        "field": '.$field_id.',
        "value": "'.$value.'"
    },
    "useDefaults": true
  }';
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/fieldValues/".$id);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
  acRegisterApi("/api/3/fieldValues/".$id." PUT");
  return json_decode(curl_exec($curl));
}

function acCreateCustomFieldValueByCustomFieldId($contact_id, $field_id, $value) {
  $curl = curl_init();
  $json = '{
      "fieldValue": {
          "contact": '.$contact_id.',
          "field": '.$field_id.',
          "value": "'.$value.'"
      },
      "useDefaults": true
  }';
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/fieldValues");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
  acRegisterApi("/api/3/fieldValues"." POST");
  return json_decode(curl_exec($curl));
}

//TAGs-------------------------------------------------

/*function acGetTags() { //Llamada CURL para sacar todos los tags
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/tags?limit=100");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  acRegisterApi("/api/3/tags?limit=100"." GET");
  return json_decode(curl_exec($curl))->tags;
}*/

function acGetUserTagsById ($id) {

  $file = dirname(__FILE__)."/cache/contactTags".$id.".json";
  if (file_exists($file) && time()-filemtime($file) < 240) { //Si es menos de 5 minutos segundos usamos el cacheo
    return json_decode(file_get_contents($file));
  }

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts/".$id."/contactTags");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  acRegisterApi("/api/3/contacts/".$id."/contactTags"." GET");
  
  $json = json_decode(curl_exec($curl))->contactTags;
  //Cacheamos el fichero de respuesta
  $f = fopen($file, "w+");
  fwrite($f, json_encode($json));
  fclose($f);
  
  return $json;
} 

function acAddTagUser($contact_id, $tag_id) {
  $curl = curl_init();
  $json = '{
    "contactTag": {
      "contact": "'.$contact_id.'",
      "tag": "'.$tag_id.'"
    }
  }';
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contactTags");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
  acRegisterApi("/api/3/contactTags"." POST");
  return json_decode(curl_exec($curl))->contactTag;
}


function acDeleteTagUser($id) {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contactTags/".$id);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
  acRegisterApi("/api/3/contactTags/".$id." GET");
  return json_decode(curl_exec($curl));
}

function acRegisterApi($string) {
  /*$f = fopen(dirname(__FILE__)."/log_api.txt", "a+");
  fwrite($f, $string.PHP_EOL);
  fclose($f);*/
}

function acDeleteCache ($contact_id) {
  //Borramos los cacheos
  $file = dirname(__FILE__)."/cache/fieldValues".$contact_id.".json";
  unlink($file);
  $file = dirname(__FILE__)."/cache/contactTags".$contact_id.".json";
  unlink($file);
  $file = dirname(__FILE__)."/cache/".$contact_id.".json";
  unlink($file);
}






function acAddAutomationUser($contact_id, $automation_id) {
  $curl = curl_init();
  $json = '{
    "contactAutomation": {
      "contact": "'.$contact_id.'",
      "automation": "'.$automation_id.'"
    }
  }';
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contactAutomations");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
  acRegisterApi("/api/3/contactAutomations"." POST");
  return json_decode(curl_exec($curl))->contacts;
}


