<?php
session_start();
$path = "../";
				include($path."lib/user_config.php");
				include("include/config.inc.php");
$file_template =$Website.$folder .'/main_auto_answer.php?wcad='.$_GET["wcad"].'&wtid='.$_GET["wtid"].'&t='.$_GET["t"].'&filename='.$_GET["filename"].'&SSMID='.$_SESSION["EWT_MID"].'&SSMAIL='.$_SESSION["EWT_MAIL"].'&SSorg='.$_SESSION["EWT_ORG"].'&EWT_TYPE_ID='.$_SESSION["EWT_TYPE_ID"];
$contents = file_get_contents($file_template);
$use_contents = trim($contents);
					//echo $htmlcode;
					//echo "<br>";
					// ================= ส่วนแก้ไข Tag เปิด-ปิด  ด้วย tidy  PHP  Class  ===============
					//exit;
					$tidy = new tidy;   //  ต้องเปิด extension   php_tidy.dll  ใน php.ini ก่อน
					
								$opts = array("clean" => true,'output-html' => TRUE, "quote-ampersand" => false, "quote-nbsp" => false, "lower-literals" => false, "css-prefix" => "mp", "literal-attributes" => true,"enclose-block-text"=>true,"alt-text"=>'not insert alt on tag images');  

					// , "wrap-jste" => true , "wrap" => 200 , "wrap-attributes" => true
					// "vertical-space" => true
					
					$tidy->parseString($use_contents,$opts,'latin1'); // "latin1"
					
					$tidy->cleanRepair();
					
					//$htmlcode =  trim($contents);
					
					$htmlcode = $tidy->html();  // จริงๆแล้ว ต้องใช้ content ที่แก้ tag เปิด-ปิดแล้ว  แต่เอาออกชั่วคราว  เพราะมันชอบแก้โค้ด javascript  ทำให้ javascript Error	 แต่ล่าสุดเรา set option แก้ปัญหานี้ได้แล้ว คือ 	"literal-attributes" => true 	
					
					//echo $htmlcode;
					// ==================================================================
						$headerw3c = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
	<HTML lang=\"th\">";
						$htmlcode = eregi_replace("/>",">",$htmlcode); // แก้ /> ไปก่อนเลย
						$htmlcode = eregi_replace("iso-8859-1","UTF-8",$htmlcode); // แก้ so-8859-1 ไปก่อนเลย
						$htmlcode = eregi_replace("<html lang=\"th\">",$headerw3c,$htmlcode); // แก้ so-8859-1 ไปก่อนเลย
						//แก้ไข link ไปก่อน ทำไปก่อน พี่ม่อนยังไม่คิดทางออกให้ดีกว่านี้
						$htmlcode = eregi_replace("\"images/","\"../images/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"images","src=\"../images",$htmlcode); 
						$htmlcode = eregi_replace("\"download/","\"../download/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"download","src=\"../download",$htmlcode); 
						$htmlcode = eregi_replace("\"mainpic/","\"../mainpic/",$htmlcode); 
						$htmlcode = eregi_replace("src=\"mainpic","src=\"../mainpic",$htmlcode); 
						$htmlcode = eregi_replace("\"icon/","\"../icon/",$htmlcode); 
						echo $htmlcode = eregi_replace("src=\"icon","src=\"../icon",$htmlcode); 
?>