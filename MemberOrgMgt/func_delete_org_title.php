<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_data = array_merge($_GET);
$s_data = array();	

if($a_data['proc']=='DelOrgTitle'){
	
$db->query("USE ".$EWT_DB_USER);
$s_sql = $db->query("SELECT *
					 FROM `title`
					 WHERE `title_id` = '{$a_data['id']}' ");
$a_rows		= $db->db_num_rows($s_sql);	
$a_data_org = $db->db_fetch_array($s_sql);
$name_thai 	= $a_data_org['title_thai'];
	
del('title','title_id='.$a_data['id']);

$db->query("USE ".$EWT_DB_NAME);	
$db->write_log("delete","org",$txt_org_title_delete.' '.$name_thai);							   
//print_r($s_data);	
unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;
} 
	
?>