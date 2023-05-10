<?php
DEFINE('path', 'assets/');
include path . 'config/config.inc.php';
include path . 'class/db/dbdpis.class.php';

// Get the department ID and parent ID from the parameters
$deptId = $_GET['dept_id'];
$parentId = $_GET['parent_id'];

// Connect to the database and retrieve the work groups for the selected department
dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);
$query = "SELECT * FROM USR_DEPARTMENT WHERE DEPT_PARENT_ID = '".$deptId."' ";
$res = dbdpis::getFetchAll($query);

// Convert the result set to a JSON object
$workGroups = array();
foreach($res as $value){
  $workGroups[$value['DEP_ID']] = $value['DEP_NAME'];
}

echo json_encode($workGroups);
?>
