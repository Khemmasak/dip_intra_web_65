<?php
//session_start();
require_once dirname(__FILE__) . '/../../../lib/user_config.php';
$EWT_DB_NAME = "db_1_bizpotential_web";
$EWT_FOLDER_USER = "dip_intranet";
//$EWT_DB_USER ="ewt_user_86";// database ewt_user
$EWT_DB_TYPE = "MYSQLi"; 

DEFINE('BASE_URL',(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
DEFINE('HOST', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/dip_intranet/");
DEFINE('HTTP_HOST', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") ."://$_SERVER[HTTP_HOST]/");
DEFINE('HOST_PATH', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") ."://$_SERVER[HTTP_HOST]/dip_intranet/ewtadmin/");
DEFINE('HOST_CAPTCHA', HTTP_HOST."Login/ewt_picmain.php");

#ldap config
DEFINE("LDAP_HOST", "110.78.5.6");
DEFINE("LDAP_PORT", 389);
DEFINE("LDAP_BASEDN", "ou=60_0410_ศส.,dc=diprom,dc=go,dc=th");
DEFINE("LDAP_AUTHEN", "ou=vender,dc=diprom,dc=go,dc=th");
//DEFINE("LDAP_AUTHEN", "dc=diprom,dc=go,dc=th");
DEFINE("LDAP_USER", "biz_admin"); 
DEFINE("LDAP_PASS", 'P@$$w0rds$#@!');
DEFINE("LDAP_DOMAIN", "diprom");

DEFINE("E_EMAIL", 'noreply@bizpotential.com');	
DEFINE('SEND_METHOD','smtp');
DEFINE('SMTP_HOST','mail.bizpotential.com');
DEFINE('SMTP_PORT','25');
DEFINE('SMTP_USERNAME','noreply@bizpotential.com');
DEFINE('SMTP_PASSWORD','P@ssw0rd!@#$noreply'); 

/* BIZPOTEN */
$EWT_WEB_SHORTPATH = "/";
$EWT_WEB_FULLPATH = "/dip_intranet/";
$EWT_WEB_DOMAIN = HOST;
$EWT_WEB_SCRIPTALL_PATH = "../../";
$EWT_COOKIE_SECURE = false; //true or false (Site is not SECURE)
$EWT_COOKIE_HTTPONLY = false; //true or false (Site is not SECURE)
$EWT_FACEBOOK_USE = "N";
$EWT_COOKIE_SAMESITE = "Strict"; //Strict, Lax, None 
$EWT_LDAP_USE = "N";
$EWT_COOKIE_DOMAIN = "";

/* DEMO
$EWT_WEB_SHORTPATH = "/";
$EWT_WEB_FULLPATH  = "/ewtadmin/ewt/gistda_web/";
$EWT_WEB_DOMAIN    = "https://demo.gistda.or.th/";
$EWT_WEB_SCRIPTALL_PATH    = "/ewtadmin/";
$EWT_COOKIE_SECURE   = true; //true or false
$EWT_COOKIE_HTTPONLY = true; //true or false
$EWT_FACEBOOK_USE  = "Y";
$EWT_COOKIE_SAMESITE = "Lax"; //Strict, Lax, None 
$EWT_LDAP_USE     = "N";
$EWT_COOKIE_DOMAIN   = "";
*/

/* GDCC
$EWT_WEB_SHORTPATH = "/";
$EWT_WEB_FULLPATH  = "/ewtadmin/ewt/gistda_web/";
$EWT_WEB_DOMAIN    = "https://164.115.24.91/";
$EWT_WEB_SCRIPTALL_PATH    = "/ewtadmin/";
$EWT_COOKIE_SECURE   = true; //true or false
$EWT_COOKIE_HTTPONLY = true; //true or false
$EWT_FACEBOOK_USE  = "N";
$EWT_COOKIE_SAMESITE = "Strict"; //Strict, Lax, None 
$EWT_LDAP_USE     = "Y";
$EWT_COOKIE_DOMAIN   = "";
*/

##==================================================================##
$EWT_USER_TOKEN_BACKEND     = "usertoken_backend";
$EWT_USER_LOGINTYPE_BACKEND = "login_type";
$EWT_LDAP_ADDRESS = "@ad-gistda.or.th";
$EWT_PAGINATION_LIMIT = "Y";
?>