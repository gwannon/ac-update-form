<?php

//LIBs -----------------------------------------------------------------------
function print_pre($string) {
  echo "<pre>";
  print_r ($string);	
  echo "</pre>";
} 

function acSearchUserByEmail ($email) {   //Llamada CURL para sacar un usuario a partir de su email
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts?search=".$email);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  return json_decode(curl_exec($curl))->contacts;
}

//CAMPOs-------------------------------------------------

function acGetFields() { //Llamada CURL para sacar todos los campos
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/fields?limit=100");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  return json_decode(curl_exec($curl));
}

function acGetUserById ($id) {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts/".$id);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  return json_decode(curl_exec($curl))->contact;
} 

function acGetFieldsByUserId($id) {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts/".$id."/fieldValues");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  return json_decode(curl_exec($curl))->fieldValues;  
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
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
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
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
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
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
  return json_decode(curl_exec($curl));
}

//TAGs-------------------------------------------------

function acGetTags() { //Llamada CURL para sacar todos los tags
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/tags?limit=100");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  return json_decode(curl_exec($curl))->tags;
}

function acGetUserTagsById ($id) {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contacts/".$id."/contactTags");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  return json_decode(curl_exec($curl))->contactTags;
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
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json)));
  return json_decode(curl_exec($curl))->contactTag;
}


function acDeleteTagUser($id) {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/contactTags/".$id);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
  return json_decode(curl_exec($curl));
}