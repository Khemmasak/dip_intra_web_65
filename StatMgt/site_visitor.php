<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$con = stripslashes(urldecode($_GET["con"]));
?>
<html>
<head>
<title>Stat</title>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<h5>New Visitor</h5><hr size="1">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#FFFFFF"> 
          <td> 
            <?php
	$sql = $db->query("SELECT sv_ip FROM stat_visitor WHERE sv_url = 'page' AND  sv_new = 'Y' ".$con."");
	while($R = mysql_fetch_row($sql)){
echo "<li>".$R[0]."</li>";
	}
	?>
          </td>
        </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
