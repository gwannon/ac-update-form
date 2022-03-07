<?php
/**
 * Plugin Name: ActiveCampignUpdateForm
 * Plugin URI:  https://www.enutt.net/
 * Description: Formulario para actualizar los datos de los usuarios de Active Campaign de SPRI
 * Version:     2.0
 * Author:      Eñutt
 * Author URI:  https://www.enutt.net/
 * License:     GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ac-update-forms
 *
 * PHP 7.3
 * WordPress 5.5.3
 */

//ini_set("display_errors", 1);
define('AC_VER', '1.1'); 
define('AC_API_DOMAIN', 'https://xxx.api-us1.com'); 
define('AC_API_TOKEN', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
define('AC_CACHE_TABLE', 'ac_cache'); 



//Al activar plugin crear tabla para cacheo
register_activation_hook( __FILE__, "ac_activate_myplugin" );
function ac_activate_myplugin() {
	ac_create_db();
}
function ac_create_db() {
  global $table_prefix, $wpdb;
  $acCacheTable = $table_prefix . 'ac_cache';
  if( $wpdb->get_var( "show tables like '$acCacheTable'" ) != acCacheTable ) {
    $sql = "CREATE TABLE `$acCacheTable` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `action` varchar(500) NOT NULL,
      `param1` varchar(500) NOT NULL,
      `param2` varchar(500) DEFAULT NULL,
      `param3` varchar(500) DEFAULT NULL,
      `param4` varchar(500) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
  }
}


//Cargamos el multi-idioma
function ac_plugins_loaded() {
  load_plugin_textdomain('ac-update-forms', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
}
add_action('plugins_loaded', 'ac_plugins_loaded', 0 );

//Precargamos los estilos y los script
function ac_wp_enqueue_scripts() {
  wp_register_style('ac-update-forms-style', plugins_url( '/assets/style.css', __FILE__ ), array(), AC_VER, 'all' );
  wp_register_script('ac-update-forms-script',  plugins_url( '/assets/script.js', __FILE__ ), array('jquery'), AC_VER, true);
}
add_action( 'wp_enqueue_scripts', 'ac_wp_enqueue_scripts' );


//Shortocodes --------------------------------------------------------------
function ac_update_forms_shortcode($params = array(), $content = null) {
  global $post;
  $plugin_dir_url = plugin_dir_url( __FILE__ );
  ob_start(); 

  include(dirname(__FILE__)."/inc/libs.php");
  include(dirname(__FILE__)."/inc/cache.php");
  include(dirname(__FILE__)."/inc/fields.php");
  //print_pre2($_REQUEST);

  if (isset($_REQUEST['contact_id']) && $_REQUEST['contact_id'] > 0 && isset($_REQUEST['hash']) && $_REQUEST['hash'] != '') { //Sacamos le formulario de los datos ------------------
    $contact = acGetUserById ($_REQUEST['contact_id']);
   
    //Calculamos el paso
    if(isset($_REQUEST['currentstep']) && $_REQUEST['currentstep'] > 0) {
      $currentstep = $_REQUEST['currentstep'];
    } else $currentstep = 0;

    //Actualizamos los datos del usuario
    if($_REQUEST['hash'] == $contact->hash) { //El usuario es el correcto proque tiene el mismo hash

      if(isset($_REQUEST['update']) && $_REQUEST['update'] != '') { //Actualizamos el perfil del usuario
       
        //PASO 1
        //Actualizamos las newsletter ---------------------------------
        if($currentstep == 1) {
          foreach ($_REQUEST['ac']['newsletter'] as $key => $value) {
            $temp = explode("-", $key);
            if($temp[0] == 'create') {
              //$result = acCreateCustomFieldValueByCustomFieldId($contact->id, $temp[1], $value);
              acCache::createAcCache ("acCreateCustomFieldValueByCustomFieldId", $contact->id, $temp[1], $value);
            } else {
              //$result = acUpdateCustomFieldValueByCustomFieldId($temp[0], $contact->id, $temp[1], $value);
              acCache::createAcCache ("acUpdateCustomFieldValueByCustomFieldId", $temp[0], $contact->id, $temp[1], $value);
            }
          }
        }

        //PASO 2 y 3
        if($currentstep == 2 || $currentstep == 3) {
          //Actualizamos los intereses
          foreach($_REQUEST['ac']['tags'] as $tag_id => $tag) {
            if(!isset($tag['status']) && $tag['tag'] > 0) {
              //$result = acDeleteTagUser($tag['tag']);
              acCache::createAcCache ("acDeleteTagUser", $tag['tag'], $contact->id, $tag_id);
            } else if(isset($tag['status']) && !$tag['tag']) {
              //$result = acAddTagUser($contact->id, $tag_id);
              acCache::createAcCache ("acAddTagUser", $contact->id, $tag_id);
            }
          }
        }
        
        //PASO 4
        //Actualizamos los idiomas
        if($currentstep == 4) {
          foreach($_REQUEST['ac']['langs'] as $tag_id => $tag) {
            if(!isset($tag['status']) && $tag['tag'] > 0) {
              //$result = acDeleteTagUser($tag['tag']);
              acCache::createAcCache ("acDeleteTagUser", $tag['tag'], $contact->id, $tag_id);
            } else if(isset($tag['status']) && !$tag['tag']) {
              //$result = acAddTagUser($contact->id, $tag_id);
              acCache::createAcCache ("acAddTagUser", $contact->id, $tag_id);
            }
          }
        }

        //PASO 5
        if($currentstep == 5) {
          //Actualizamos los datos principales
          //$contact = acUpdateFieldsByUserId($contact->id, $_REQUEST['ac']['data']);
          acCache::createAcCache ("acUpdateFieldsByUserId", $contact->id, json_encode($_REQUEST['ac']['data'], JSON_UNESCAPED_UNICODE));

          //Actualizamos los campos extras
          $myFields = acGetFieldsByUserId($contact->id);
          foreach ($_REQUEST['ac']['field'] as $key => $value) {
            $temp = explode("-", $key);
            if($temp[0] == 'create') {
              //$result = acCreateCustomFieldValueByCustomFieldId($contact->id, $temp[1], $value);
              acCache::createAcCache ("acCreateCustomFieldValueByCustomFieldId", $contact->id, $temp[1], $value);
            } else {
              foreach ($myFields as $myField) {
                if ($myField->field == $temp[1] && $myField->value != $value) {
                  //$result = acUpdateCustomFieldValueByCustomFieldId($temp[0], $contact->id, $temp[1], $value);
                  acCache::createAcCache ("acUpdateCustomFieldValueByCustomFieldId", $temp[0], $contact->id, $temp[1], $value);
                  break;
                }
              }
            }
          }

          //Metemos la fecha de última actualización
          $control = 'create';
          foreach ($myFields as $myField) {
            if ($myField->field == 39) {
              //$result = acUpdateCustomFieldValueByCustomFieldId($myField->id, $contact->id, 39, date("Y-m-d"));
              acCache::createAcCache ("acUpdateCustomFieldValueByCustomFieldId", $myField->id, $contact->id, 39, date("Y-m-d"));
              $control = 'update';
              break;
            }
          }
          if($control == 'create') {
            //$result = acCreateCustomFieldValueByCustomFieldId($contact->id, 39, date("Y-m-d"));
            acCache::createAcCache ("acCreateCustomFieldValueByCustomFieldId", $contact->id, 39, date("Y-m-d"));
          }

          //Borramos los cacheos
          acDeleteCache ($contact->id);
        }
      } 
      
      //Preparamos el siguiente paso
      $currentstep++;

      //PASO 1
      //Preparamos los datos de newsletter
      if($currentstep == 1) {
        $myFields = acGetFieldsByUserId($contact->id);
        $formNewslettersFields = array();
        foreach ($fields_newsletter as $field) {
          $value = "No";
          $temp = array("label" => $field['text'], "value" => $value, "field" => $field['id'], "id" => 'create', "description" => $field['description']);
          foreach ($myFields as $myField) {
            if ($myField->field == $field['id']) {
              $temp['value'] = $myField->value;
              $temp['id'] = $myField->id;
              break;
            }
          }
          $formNewslettersFields[] = $temp;
        }
        //print_pre($formNewslettersFields);
      }

      //PASO 2 y 3
      //Preparamos las etiquetas
      if($currentstep == 2 || $currentstep == 3) {
        $myTags = acGetUserTagsById ($contact->id);
        foreach ($tags as $key => $tag) {
          $tags[$key]['has_tag'] = false;
          foreach ($myTags as $myTag) {
            if ($myTag->tag == $tag['id']) {
              $tags[$key]['has_tag'] = true;
              $tags[$key]['my_tag'] = $myTag->id;
              break;
            }
          }
        }
      }

      //PASO 4
      //Preparamos los idiomas
      if($currentstep == 4) {
        $myTags = acGetUserTagsById ($contact->id);
        foreach ($langs as $key => $tag) {
          $langs[$key]['has_tag'] = false;
          foreach ($myTags as $myTag) {
            if ($myTag->tag == $tag['id']) {
              $langs[$key]['has_tag'] = true;
              $langs[$key]['my_tag'] = $myTag->id;
              break;
            }
          }
        }
      }

      //PASO 5
      //Preparamos los datos extras
      if($currentstep == 5) {
        $myFields = acGetFieldsByUserId($contact->id);
        $formFields = array();
        foreach ($fields as $field) {
          $value = "";
          $temp = array("label" => $field['text'], "value" => $value, "field" => $field['id'], "id" => 'create', "position" => $field['position'], "required" => $field['required']);
          if (isset($field['select'])) $temp['select'] = $field['select'];
          if (isset($field['pattern'])) $temp['pattern'] = $field['pattern'];
          if (isset($field['type'])) $temp['type'] = $field['type'];
          foreach ($myFields as $myField) {
            if ($myField->field == $field['id']) {
              $temp['value'] = $myField->value;
              $temp['id'] = $myField->id;
              break;
            }
          }
          $formFields[] = $temp;
        }
        //print_pre($formFields);
      }
      include(dirname(__FILE__)."/inc/ac-form.php");     
    } else {
      $error_access = true;
      include(dirname(__FILE__)."/inc/ac-form-login.php");
    }
  } else { //Sacamos el miniformulario para pedir el email --------------------------------------------------
    include(dirname(__FILE__)."/inc/ac-form-login.php");
  } 
  wp_enqueue_style('ac-update-forms-style');
   
  $html = ob_get_clean(); 
  return $html;
}
add_shortcode('ac-update-forms', 'ac_update_forms_shortcode');





//ADMIN-AJAX -----------------------------------------------
function acWpAjaxCacheUser() {
  include(dirname(__FILE__)."/inc/libs.php");
  if(is_numeric($_REQUEST['contact_id'])) {
    acGetFieldsByUserId($_REQUEST['contact_id']);
    acGetUserTagsById($_REQUEST['contact_id']);
    acGetUserById($_REQUEST['contact_id']);
  }
  wp_die();
}
add_action( 'wp_ajax_nopriv_ac_cache_user', 'acWpAjaxCacheUser' );
add_action( 'wp_ajax_ac_cache_user', 'acWpAjaxCacheUser' );


function acWpProcessCache() {
  ini_set("display_errors", 1);
  include(dirname(__FILE__)."/inc/libs.php");
  include(dirname(__FILE__)."/inc/cache.php");
  include(dirname(__FILE__)."/inc/fields.php");
  if(isset($_REQUEST['max']) && is_numeric($_REQUEST['max']) && $_REQUEST['max'] > 0) $max = $_REQUEST['max'];
  else $max = 100;
  $ids = getCaches(0, $max);
  echo "<pre>";
  foreach ($ids as $id) {
    $cache = new acCache($id);
    echo $cache->getAction().PHP_EOL;
    print_r ($cache);
		acCache::deleteAcCache ($id);

    if($cache->getAction() == 'acCreateCustomFieldValueByCustomFieldId') {
      acCreateCustomFieldValueByCustomFieldId($cache->getParam1(), $cache->getParam2(), $cache->getParam3());
      //print_r($result);
      //acCache::deleteAcCache ($id);
    } else if($cache->getAction() == 'acUpdateCustomFieldValueByCustomFieldId') {
      acUpdateCustomFieldValueByCustomFieldId($cache->getParam1(), $cache->getParam2(), $cache->getParam3(), $cache->getParam4());
      //print_r($result);
      //acCache::deleteAcCache ($id);
    } else if($cache->getAction() == 'acUpdateFieldsByUserId') {
      //print_r(json_decode($cache->getParam2(), true));
      $result = acUpdateFieldsByUserId($cache->getParam1(), json_decode($cache->getParam2(), true));
      //print_r($result);
      //acCache::deleteAcCache ($id);
    } else if($cache->getAction() == 'acDeleteTagUser') {
    	$control = true;
    	foreach ($tags as $tag) {
    		if($cache->getParam3() == $tag['id'] && isset($tag['automdown'])) {
    			$result = acAddAutomationUser($cache->getParam2(), $tag['automdown']);
    			print_r($result);
    			$control = false;
    			break;
    		}
    	}
    
      if($control) $result = acDeleteTagUser($cache->getParam1());
      //print_r($result);
      //acCache::deleteAcCache ($id);
    } else if($cache->getAction() == 'acAddTagUser') {
    	$control = true;
    	foreach ($tags as $tag) {
    		if($cache->getParam2() == $tag['id'] && isset($tag['automup'])) {
    			$result = acAddAutomationUser($cache->getParam1(), $tag['automup']);
    			print_r($result);
    			$control = false;
    			break;
    		}
    	}
    
    	if($control) $result = acAddTagUser($cache->getParam1(), $cache->getParam2());
      //print_r($result);
      //acCache::deleteAcCache ($id);
    } else {
      echo $cache->getAction().PHP_EOL;     
    }

  }
  echo "<pre>";
  wp_die();
}
add_action( 'wp_ajax_nopriv_ac_process_cache', 'acWpProcessCache' );
add_action( 'wp_ajax_ac_process_cache', 'acWpProcessCache' );
