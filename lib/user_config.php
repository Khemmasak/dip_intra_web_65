<?php
error_reporting (E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
//error_reporting (E_ALL);
date_default_timezone_set ('Asia/Bangkok');
ini_set('mbstring.internal_encoding', 'UTF-8');

//$EWT_ROOT_HOST = "202.44.230.181";
$EWT_ROOT_HOST = "localhost";
$EWT_ROOT_USER = "biz";
$EWT_ROOT_PASSWORD = 'B!zw#b2022';
$EWT_FOLDER_USER = $_SESSION["EWT_SUSER"];
$EWT_DB_NAME = "db_1_bizpotential_web";
$EWT_DB_USER ="ewt_user_bizpotential_web";// database ewt_user
$EWT_DB_TYPE = "MYSQLi";

$mailmaster = "<webmaster@192.168.1.31>";

DEFINE("E_EMAIL", 'noreply@bizpotential.com');	 
DEFINE('SEND_METHOD','smtp');
DEFINE('SMTP_HOST','mail.bizpotential.com');
DEFINE('SMTP_PORT','25');
DEFINE('SMTP_USERNAME','noreply@bizpotential.com');
DEFINE('SMTP_PASSWORD','P@ssw0rd!@#$noreply'); 

DEFINE("E_ROOT_HOST", "localhost"); 
//DEFINE("EWT_ROOT_HOST", "202.44.230.181") ;
DEFINE("EWT_ROOT_USER", "biz") ;
DEFINE("EWT_ROOT_PASSWORD", 'B!zw#b2022') ;

DEFINE("EWT_FOLDER_USER", $_SESSION["EWT_SUSER"]) ;
DEFINE("EWT_DB_NAME", "db_1_bizpotential_web") ;

DEFINE("EWT_DB_USER", "ewt_user_bizpotential_web") ;
DEFINE("EWT_DB_TYPE", "MYSQLi") ;

#ldap config
DEFINE("LDAP_HOST", "110.78.5.6");
DEFINE("LDAP_PORT", 389);
DEFINE("LDAP_BASEDN", "ou=60_0410_ศส.,dc=diprom,dc=go,dc=th");
//DEFINE("LDAP_AUTHEN", "ou=vender,dc=diprom,dc=go,dc=th");
DEFINE("LDAP_AUTHEN", "dc=diprom,dc=go,dc=th");
DEFINE("LDAP_USER", "biz_admin"); 
DEFINE("LDAP_PASS", 'P@$$w0rds$#@!');
DEFINE("LDAP_DOMAIN", "diprom");

DEFINE('BASE_URL',(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
DEFINE('HOST_PATH', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/ewtadmin");
DEFINE('HTTP_HOST', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") ."://$_SERVER[HTTP_HOST]/");
DEFINE('HOST_CAPTCHA', HTTP_HOST."/Login/ewt_picmain.php");
DEFINE('HOST_SSO', HTTP_HOST.'DIP_SSO/');

DEFINE('SSO_PATH',"https://portal.diprom.go.th/DIP_SSO/");
//DEFINE('SSO_PATH',"http://203.151.166.133/DIP_SSO/");

DEFINE("SSO_ROOT_HOST", "202.44.230.180");
DEFINE("SSO_ROOT_USER", "SSO");
DEFINE("SSO_ROOT_PASSWORD", "D!pSS0@2023");
DEFINE("SSO_DB_NAME", "DIP_INTRA_SSO");
DEFINE("SSO_DB_TYPE", "MSSQL");
DEFINE("SSO_CHAR_SET", "utf8");

$Globals_Dir = HTTP_HOST; //"../ewt/" . $_SESSION["EWT_SUSER"] . "/";
/* BIZPOTEN */
$EWT_GDCC = "N";
$EWT_LDAP_USE        = "N";
$EWT_COOKIE_SECURE   = false; //true or false (Site is not SECURE)
$EWT_COOKIE_HTTPONLY = false; //true or false (Site is not SECURE)
$EWT_COOKIE_SAMESITE = "Strict"; //Strict, Lax, None 
$EWT_COOKIE_DOMAIN   = "";

/* DEMO
$EWT_GDCC = "N";
$EWT_LDAP_USE        = "N";
$EWT_COOKIE_SECURE   = true; //true or false
$EWT_COOKIE_HTTPONLY = true; //true or false
$EWT_COOKIE_SAMESITE = "Lax"; //Strict, Lax, None 
$EWT_COOKIE_DOMAIN   = "";
*/

/* GDCC
$EWT_GDCC = "Y";
$EWT_LDAP_USE        = "Y";
$EWT_COOKIE_SECURE   = true; //true or false
$EWT_COOKIE_HTTPONLY = true; //true or false
$EWT_COOKIE_SAMESITE = "Strict"; //Strict, Lax, None 
$EWT_COOKIE_DOMAIN   = "";
*/
##==================================================================##
$EWT_USER_TOKEN_BACKEND     = "usertoken_backend";
$EWT_USER_LOGINTYPE_BACKEND = "login_type";
$EWT_LDAP_ADDRESS = "@ad-gistda.or.th";

?>