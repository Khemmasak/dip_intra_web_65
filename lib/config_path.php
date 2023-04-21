<?php
$IMG_PATH = '../EWT_ADMIN/';
$EWT_PATH = '../';
$MAIN_PATH = '../EWT_ADMIN/';

DEFINE('PATH', '../');

function __autoload($classname)
{
  $a_path = array(
    PATH.'class'
  );
  foreach($a_path as $_path)
  {
    $myDirectory = opendir($_path);
    while($entryName = readdir($myDirectory))
    {
      $a_dir[] = $entryName;
    }
    closedir($myDirectory);
    if($a_dir)
    {
      foreach($a_dir as $_item)
      { 
	  $filename = $_path."/".$_item."/". $classname .".class.php";
	//$filename = $_path."/". $classname .".class.php";   
        if(is_file($filename))
        {
          include_once($filename);
          break;
        }
      }
    }
  }
 
}

function getIP()
{
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
      $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

function cal_contact($gen_user){
	global $db,$EWT_DB_NAME,$EWT_DB_USER;

	$db->query("USE ".$EWT_DB_USER);
	$s_gen_user = $db->query("SELECT * FROM gen_user WHERE gen_user_id = '{$gen_user}' ");
	$a_row = $db->db_num_rows($s_gen_user);
	if($a_row){
	$a_user = $db->db_fetch_array($s_gen_user);

	$txt = $a_user['name_thai']." ".$a_user['surname_thai'];

	return $txt;
	}
$db->query("USE ".$EWT_DB_NAME);
	}

function link_view(){
	global $db,$EWT_FOLDER_USER;
	$PHPSELF = explode('/',$_SERVER["PHP_SELF"]);
	$paths = $PHPSELF[1]."/ewt/".$EWT_FOLDER_USER."/";


	return "http://".$_SERVER['HTTP_HOST']."/".$paths;	
}	

function linkboxPopup(){

	$_scheme = $_SERVER['REQUEST_SCHEME'];
	$_host = $_SERVER['HTTP_HOST'];	
	$_name = $_SERVER['SCRIPT_NAME'];
	$_url = $_SERVER['REQUEST_URI'];	
    //$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';
    $_protocal = "https";
    $_ip = $_SERVER['REMOTE_ADDR'];
    $_port = (isset($_SERVER['SERVER_PORT']))?$_SERVER['SERVER_PORT']:'80';
	$_directory = getEwt($_url);
	
	return $_protocal."://".$_host.$_directory;
		
}

//echo getEwt($_SERVER['REQUEST_URI']);

function getEwt($_url){
	
   $s_method = strtok($_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/".$a_method[2]."/";
		
		return  $chk_site;
	}
}

//echo linkboxPopup();

function file_size($file){
	
$size = filesize($file); // หาขนาดของไฟล์ได้มาเป็น Bytes
if ($size >= 1073741824) {
	$size = round($size / 1073741824, 2) . " GB"; //เอาทศนิยม 2 ตำแหน่ง
	} elseif ($size >= 1048576) {
		$size = round($size / 1048576, 2) . " MB";
		} elseif ($size >= 1024) {
			$size = round($size / 1024, 2) . " KB";
			}	
			
	return $size;
}

function sizeMB2byte($size){
	
	$bytesize = $size * (1024.0 * 1024);
 
	return $bytesize;
}

function EwtMaxfile($s_type){
	global $db,$EWT_DB_NAME,$EWT_DB_USER;

	$s_sql = $db->query("SELECT * FROM site_info");
	$a_data = $db->db_fetch_array($s_sql);
	
	if($s_type=='file')
	{		
		return $a_data['site_info_max_file'];		
	}else if($s_type=='img'){		
		return $a_data['site_info_max_img'];		
	}else if($s_type=='vdo'){
		return $a_data['site_info_max_vdo'];	
	}else{
		return '';
	}
	
}

function EwtTypefile($s_type){
	global $db,$EWT_DB_NAME,$EWT_DB_USER;

	$s_sql = $db->query("SELECT * FROM site_info");
	$a_data = $db->db_fetch_array($s_sql);
	
	if($s_type=='file')
	{		
		return $a_data['site_type_file'];		
	}else if($s_type=='img'){		
		return $a_data['site_type_img_file'];		
	}else if($s_type=='vdo'){
		return $a_data['site_type_vdo_file'];	
	}else{
		return '';
	}
	
}

function ValidfileType($s_type)
{
  if($s_type)
  {
	  return str_replace(",","|",EwtTypefile($s_type));
  } 	
}


function getLocation($s_mod, $s_value=false)
{
  if(is_array($s_value)) $a_value = $s_value;
  else parse_str($s_value, $a_value);

  $s_value_query = ($s_value)?'?'.urldecode(http_build_query($a_value)):'';
  $s_url = linkboxPopup().$s_mod.$s_value_query.".php";
  return $s_url;
}

function get($s_name, $s_defalut=null)
{
  return url_decode(($_GET[$s_name])?$_GET[$s_name]:$s_defalut);
}

function url_encode($a_string){
   return urlencode(utf8_encode(base64_encode($a_string)));
}
   
function url_decode($a_string){
   return base64_decode(utf8_decode(urldecode($a_string)));
}

function print_pre($a_data)
{
  if(is_array($a_data) || is_object($a_data))
  {
    echo '<pre class="debug">'.PHP_EOL;
    print_r($a_data);
    echo '</pre>'.PHP_EOL;
  }
  else echo $a_data;
}
function showWord($s_text, $s_limit=0, $s_type=false)
{
  if($s_limit)
  {
    $i_lenstr = mb_strlen($s_text);
    if($s_limit > 0 && $i_lenstr > $s_limit)
    {
      $s_str = mb_substr(nl2br(showText($s_text, $s_type)), 0, $s_limit);
      return $s_str.'&hellip;';
    }
    else return nl2br(showText($s_text, $s_type));
  }
  else
  {
    if($s_type) return showText($s_text, $s_type);
    else return nl2br(showText($s_text, $s_type));
  }
}

function showText($s_text, $s_type=false)
{
  if($s_type) return $s_text;
  return htmlspecialchars($s_text, ENT_QUOTES);
}

function showNumber($s_data)
{
  if(is_numeric($s_data)) return number_format($s_data, 0, '.', ',');
  else return 0;
}

function showZero($s_text, $s_len=4)
{
  $s_count = mb_strlen($s_text);
  if($_i = $s_count <= $s_len)
  {
    $s_zero = str_repeat('0', ($s_len-$s_count));
  }
  return $s_zero.$s_text;
}

function showFloat($s_data, $s_decimal=2)
{
  if(is_numeric($s_data)) return number_format($s_data, $s_decimal, '.', ',');
  else return number_format(0, $s_decimal, '.', ',');
}

function getExtensionFile($s_fullname, $s_name)
{
  $idx = explode( '.', $s_fullname );
  $count_explode = count($idx);
  if($count_explode == 1)
  {
    $name = $s_name;
  }
  else
  {
    $idx = strtolower($idx[$count_explode-1]);
    $name = $s_name.'.'.$idx;
  }
  return $name;
}

function getExtension($s_fullname)
{
  $idx = explode( '.', $s_fullname );
  $count_explode = count($idx);
  if($count_explode == 1)
  {
    return '';
  }
  else
  {
    $idx = strtolower($idx[$count_explode-1]);
    return $idx;
  }
}
				
function pagination($query,$per_page=10,$page=1,$url='?'){   
    global $db; 
	
    $s_sql = "SELECT COUNT(*) as `num` FROM {$query}";
	$r_result  = $db->query($s_sql);
	$a_rows = $db->db_fetch_array($r_result);
    $total = $a_rows['num'];
    $adjacents = "2"; 
     
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
	$lastlabel = "Last &rsaquo;&rsaquo;";
    $firstlabel = "&lsaquo;&lsaquo; First";
	
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
     
    $prev = $page - 1;                          
    $next = $page + 1;
     
    $lastpage = ceil($total/$per_page);
     
    $lpm1 = $lastpage - 1; // //last page minus 1
    
if($lastpage >= $page){	
	 
    $pagination = "";
	$pagination .= "<div class='col-md-12 col-sm-12 col-xs-12' >";
	$pagination .= "<div class='row'>";
	$pagination .= "<div class='col-xs-4'><span class='pagination'>Page {$page} of {$lastpage}</span></div>";
	$pagination .= "<div class='col-xs-8'>";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination hidden-xs pull-right'>";
             
        if ($page > 1){ 
			$pagination.= "<li><a href='{$url}page=1#table-view'>{$firstlabel}</a></li>";
			$pagination.= "<li><a href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
		}    
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
            }
         
        } elseif($lastpage > 5 + ($adjacents * 2)){
             
            if($page < 1 + ($adjacents * 2)) {
                 
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='disabled'><a>...</a></li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";  
                     
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                 
                $pagination.= "<li><a href='{$url}page=1#table-view'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2#table-view'>2</a></li>";
                $pagination.= "<li class='disabled'><a>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='disabled'><a>...</a></li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";      
                 
            } else {
                 
                $pagination.= "<li><a href='{$url}page=1#table-view'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2#table-view'>2</a></li>";
                $pagination.= "<li class='disabled'><a>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
            }
        }
         
            if ($page < $counter - 1) {
				$pagination.= "<li><a href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
				$pagination.= "<li><a href='{$url}page=$lastpage#table-view'>{$lastlabel}</a></li>";
			}
         
        $pagination.= "</ul>";   

		$pagination.= "<ul class='pagination visible-xs pull-right'>";
		if ($page > 1){
        $pagination.= "<li><a href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
		}else{
			$pagination.= "<li class='disabled'><a>{$prevlabel}</a></li>";
		}

		if($lastpage == $page){
		$pagination.= "<li class='disabled' ><a>{$nextlabel}</a></li>";	
		}else{		
			$pagination.= "<li><a href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
		}
		
        $pagination.= "</ul>";
    }
   $pagination.= "</div>"; 
   $pagination.= "</div>";
   $pagination.= "</div>";
}  
    return $pagination;
}

function pagination_folder($query,$per_page=10,$page=1,$url='?'){   
    global $db; 
	

    $total = $query;
    $adjacents = "2"; 
     
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
	$lastlabel = "Last &rsaquo;&rsaquo;";
    $firstlabel = "&lsaquo;&lsaquo; First";
	
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
     
    $prev = $page - 1;                          
    $next = $page + 1;
     
    $lastpage = ceil($total/$per_page);
     
    $lpm1 = $lastpage - 1; // //last page minus 1
    
if($lastpage >= $page){	
	 
    $pagination = "";
	$pagination .= "<div class='col-md-12 col-sm-12 col-xs-12' >";
	$pagination .= "<div class='row'>";
	$pagination .= "<div class='col-xs-4'><span class='pagination'>Page {$page} of {$lastpage}</span></div>";
	$pagination .= "<div class='col-xs-8'>";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination hidden-xs pull-right'>";
             
        if ($page > 1){ 
			$pagination.= "<li><a href='{$url}page=1#table-view'>{$firstlabel}</a></li>";
			$pagination.= "<li><a href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
		}    
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
            }
         
        } elseif($lastpage > 5 + ($adjacents * 2)){
             
            if($page < 1 + ($adjacents * 2)) {
                 
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='disabled'><a>...</a></li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";  
                     
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                 
                $pagination.= "<li><a href='{$url}page=1#table-view'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2#table-view'>2</a></li>";
                $pagination.= "<li class='disabled'><a>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='disabled'><a>...</a></li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";      
                 
            } else {
                 
                $pagination.= "<li><a href='{$url}page=1#table-view'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2#table-view'>2</a></li>";
                $pagination.= "<li class='disabled'><a>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
            }
        }
         
            if ($page < $counter - 1) {
				$pagination.= "<li><a href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
				$pagination.= "<li><a href='{$url}page=$lastpage#table-view'>{$lastlabel}</a></li>";
			}
         
        $pagination.= "</ul>";   

		$pagination.= "<ul class='pagination visible-xs pull-right'>";
		if ($page > 1){
        $pagination.= "<li><a href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
		}else{
			$pagination.= "<li class='disabled'><a>{$prevlabel}</a></li>";
		}

		if($lastpage == $page){
		$pagination.= "<li class='disabled' ><a>{$nextlabel}</a></li>";	
		}else{		
			$pagination.= "<li><a href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
		}
		
        $pagination.= "</ul>";
    }
   $pagination.= "</div>"; 
   $pagination.= "</div>";
   $pagination.= "</div>";
}  
    return $pagination;
}

function pagination_ewt($statement,$per_page=10,$page=1,$url='?'){
    global $db;

    $s_sql = "{$statement}";
	$r_result  = $db->query($s_sql);
	$a_rows = $db->db_fetch_row($r_result);
    $total = $a_rows[0];
    $adjacents = "2";

      $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
	$lastlabel = "Last &rsaquo;&rsaquo;";
    $firstlabel = "&lsaquo;&lsaquo; First";
	
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
     
    $prev = $page - 1;                          
    $next = $page + 1;
     
    $lastpage = ceil($total/$per_page);
     
    $lpm1 = $lastpage - 1; // //last page minus 1
    
if($lastpage >= $page){	
	 
    $pagination = "";
	$pagination .= "<div class='col-md-12 col-sm-12 col-xs-12' >";
	$pagination .= "<div class='row'>";
	$pagination .= "<div class='col-xs-4'><span class='pagination'>Page {$page} of {$lastpage}</span></div>";
	$pagination .= "<div class='col-xs-8'>";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination hidden-xs pull-right'>";
             
        if ($page > 1){ 
			$pagination.= "<li><a href='{$url}page=1#table-view'>{$firstlabel}</a></li>";
			$pagination.= "<li><a href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
		}    
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
            }
         
        } elseif($lastpage > 5 + ($adjacents * 2)){
             
            if($page < 1 + ($adjacents * 2)) {
                 
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='disabled'><a>...</a></li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";  
                     
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                 
                $pagination.= "<li><a href='{$url}page=1#table-view'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2#table-view'>2</a></li>";
                $pagination.= "<li class='disabled'><a>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='disabled'><a>...</a></li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";      
                 
            } else {
                 
                $pagination.= "<li><a href='{$url}page=1#table-view'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2#table-view'>2</a></li>";
                $pagination.= "<li class='disabled'><a>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
            }
        }
         
            if ($page < $counter - 1) {
				$pagination.= "<li><a href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
				$pagination.= "<li><a href='{$url}page=$lastpage#table-view'>{$lastlabel}</a></li>";
			}
         
        $pagination.= "</ul>";   

		$pagination.= "<ul class='pagination visible-xs pull-right'>";
		if ($page > 1){
        $pagination.= "<li><a href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
		}else{
			$pagination.= "<li class='disabled'><a>{$prevlabel}</a></li>";
		}

		if($lastpage == $page){
		$pagination.= "<li class='disabled' ><a>{$nextlabel}</a></li>";	
		}else{		
			$pagination.= "<li><a href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
		}
		
        $pagination.= "</ul>";
    }
   $pagination.= "</div>"; 
   $pagination.= "</div>";
   $pagination.= "</div>";
}  
    return $pagination;
}

function pagination_sso($statement,$per_page=10,$page=1,$url='?'){
    $sso = new sso();

    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
     
    $prev = $page - 1;                          
    $next = $page + 1;

    $s_sql = "{$statement}";
    $a_rows = $sso->getFetch($s_sql);
	$total = $a_rows['b'];
    $adjacents = "2";

    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
	$lastlabel = "Last &rsaquo;&rsaquo;";
    $firstlabel = "&lsaquo;&lsaquo; First";
     
    $lastpage = ceil($total/$per_page);
     
    $lpm1 = $lastpage - 1; // //last page minus 1
    
    if($lastpage >= $page){	
        
        $pagination = "";
        $pagination .= "<div class='col-md-12 col-sm-12 col-xs-12' >";
        $pagination .= "<div class='row'>";
        $pagination .= "<div class='col-xs-4'><span class='pagination'>Page {$page} of {$lastpage}</span></div>";
        $pagination .= "<div class='col-xs-8'>";
        if($lastpage > 1){   
            $pagination .= "<ul class='pagination hidden-xs pull-right'>";
                
            if ($page > 1){ 
                $pagination.= "<li><a href='{$url}page=1#table-view'>{$firstlabel}</a></li>";
                $pagination.= "<li><a href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
            }    
            if ($lastpage < 7 + ($adjacents * 2)){   
                for ($counter = 1; $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                }
            
            } elseif($lastpage > 5 + ($adjacents * 2)){
                
                if($page < 1 + ($adjacents * 2)) {
                    
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                    }
                    $pagination.= "<li class='disabled'><a>...</a></li>";
                    $pagination.= "<li><a href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                    $pagination.= "<li><a href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";  
                        
                } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    
                    $pagination.= "<li><a href='{$url}page=1#table-view'>1</a></li>";
                    $pagination.= "<li><a href='{$url}page=2#table-view'>2</a></li>";
                    $pagination.= "<li class='disabled'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                    }
                    $pagination.= "<li class='disabled'><a>...</a></li>";
                    $pagination.= "<li><a href='{$url}page={$lpm1}#table-view'>{$lpm1}</a></li>";
                    $pagination.= "<li><a href='{$url}page={$lastpage}#table-view'>{$lastpage}</a></li>";      
                    
                } else {
                    
                    $pagination.= "<li><a href='{$url}page=1#table-view'>1</a></li>";
                    $pagination.= "<li><a href='{$url}page=2#table-view'>2</a></li>";
                    $pagination.= "<li class='disabled'><a>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>{$counter}</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}page={$counter}#table-view'>{$counter}</a></li>";                    
                    }
                }
            }
            
                if ($page < $counter - 1) {
                    $pagination.= "<li><a href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
                    $pagination.= "<li><a href='{$url}page=$lastpage#table-view'>{$lastlabel}</a></li>";
                }
            
            $pagination.= "</ul>";   

            $pagination.= "<ul class='pagination visible-xs pull-right'>";
            if ($page > 1){
            $pagination.= "<li><a href='{$url}page={$prev}#table-view'>{$prevlabel}</a></li>";
            }else{
                $pagination.= "<li class='disabled'><a>{$prevlabel}</a></li>";
            }

            if($lastpage == $page){
            $pagination.= "<li class='disabled' ><a>{$nextlabel}</a></li>";	
            }else{		
                $pagination.= "<li><a href='{$url}page={$next}#table-view'>{$nextlabel}</a></li>";
            }
            
            $pagination.= "</ul>";
        }
    $pagination.= "</div>"; 
    $pagination.= "</div>";
    $pagination.= "</div>";
    }  
    return $pagination; 
}
?>