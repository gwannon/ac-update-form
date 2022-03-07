<?php

/*

CREATE TABLE `$acCacheTable` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `action` varchar(500) NOT NULL,
      `param1` varchar(500) NOT NULL,
      `param2` varchar(500) DEFAULT NULL,
      `param3` varchar(500) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

*/

class acCache {
	private $id;
	private $action;
	private $param1;
	private $param2;
	private $param3;
  private $param4;

	function __construct ($id) {
    global $table_prefix, $wpdb;
    $acCacheTable = $table_prefix . 'ac_cache';
		$res = $wpdb->get_results("SELECT * FROM `$acCacheTable` WHERE `id` = '{$id}';");
		$data = $res[0];
		$this->id = $data->id;
		$this->action = $data->action;
		$this->param1 = $data->param1;
		$this->param2 = $data->param2;
		$this->param3 = $data->param3;
		$this->param4 = $data->param4;
	  return;
	}

	// GETs -------------------------------
	function getId() { return $this->id; }
	function getAction() { return $this->action; }
	function getParam1() { return $this->param1; }
	function getParam2() { return $this->param2; }
  function getParam3() { return $this->param3; }
  function getParam4() { return $this->param4; }

	// SETs -------------------------------
	function setAction($value) { 
		global $table_prefix, $wpdb;
    $acCacheTable = $table_prefix . AC_CACHE_TABLE;
		$this->title = $value; 
		$wpdb->query("UPDATE `$acCacheTable` SET action = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setParam1($value) { 
    global $table_prefix, $wpdb;
    $acCacheTable = $table_prefix . AC_CACHE_TABLE;
		$this->title_original = $value; 
		$db->query("UPDATE `$acCacheTable` SET param1 = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setParam2($value) { 
    global $table_prefix, $wpdb;
    $acCacheTable = $table_prefix . AC_CACHE_TABLE;
		$this->duration = $value; 
		$wpdb->query("UPDATE `$acCacheTable` SET param2 = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setParam3($value) { 
		global $table_prefix, $wpdb;
    $acCacheTable = $table_prefix . AC_CACHE_TABLE;
		$this->resolution = $value; 
		$wpdb->query("UPDATE `$acCacheTable` SET param3 = '{$value}' WHERE id = '".$this->id."';"); 
	}
  function setParam4($value) { 
		global $table_prefix, $wpdb;
    $acCacheTable = $table_prefix . AC_CACHE_TABLE;
		$this->resolution = $value; 
		$wpdb->query("UPDATE `$acCacheTable` SET param4 = '{$value}' WHERE id = '".$this->id."';"); 
	}

  public static function createAcCache ($action, $param1, $param2 = '', $param3 = '', $param4 = '') {
    global $table_prefix, $wpdb;
    $acCacheTable = $table_prefix . AC_CACHE_TABLE;
    $res = $wpdb->query("INSERT INTO `$acCacheTable` (`action`, `param1`, `param2`, `param3`, `param4`) VALUES ('{$action}', '{$param1}', '{$param2}', '{$param3}', '{$param4}');");
    return new acCache($wpdb->insert_id);
  }
  
  public static function deleteAcCache ($id) {
    global $table_prefix, $wpdb;
    $acCacheTable = $table_prefix . AC_CACHE_TABLE;
    $res = $wpdb->query("DELETE FROM `$acCacheTable` WHERE `id` = '{$id}'");
    return true;
  }
}

function getCaches($offset = 0, $maxitems = 0, $orderby = 'id', $order = 'ASC') {
  global $table_prefix, $wpdb;
  $acCacheTable = $table_prefix . AC_CACHE_TABLE;
	if($maxitems > 0) $limit = " LIMIT {$offset}, {$maxitems}";
	else $limit = "";
	$sql = "SELECT id FROM `$acCacheTable` ORDER BY `{$orderby}` {$order}".$limit.";";
  echo $sql;
	$res = $wpdb->get_results($sql);
	$ids = array();
	foreach($res as $data) {
		$ids[] = $data->id;
	}
	return $ids;
}