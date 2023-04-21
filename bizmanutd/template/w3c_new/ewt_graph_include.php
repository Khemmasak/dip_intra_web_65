<?php
$EWT_PATH = "../";
//important var
// $graph_name <= array of graph name
// $graph_data <= array of graph data
// $graph_link <= array of graph link
// $graph_title <= graph title
// $graph_xname <= graph x name
// $graph_yname <= graph y name
// $graph_height <= graph height 
// $graph_width <= graph width
// $graph_rotate <= graph rotate name
if(!(empty($graph_name))){
if($graph_height == ""){
$graph_height = "500";
}
if($graph_width == ""){
$graph_width = "600";
}
if($graph_rotate == ""){
$graph_rotate = "0";
}
if($mygraphidofinclude == ""){
	$mygraphidofinclude = "1";
}else{
	$mygraphidofinclude++;
}
$array_color = array("F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE",);
$file_g_temp = date("YmdHis");
$myfile = $EWT_PATH."chart_tmp/".$file_g_temp.$mygraphidofinclude.".xml";
$txt = '<graph caption=\''.addslashes($graph_title).'\' xAxisName=\''.addslashes($graph_xname).'\' yAxisName=\''.addslashes($graph_yname).'\' decimalPrecision=\'0\' formatNumberScale=\'0\' showNames=\'1\'  baseFont=\'Tahoma\'  baseFontSize=\'11\'  outCnvBaseFontSize=\'11\' outCnvBaseFont=\'Tahoma\' rotateNames=\''.$graph_rotate.'\'  >';
	$gnum = count($graph_data);
	$dataok = 'N';
	for($g=0;$g<$gnum;$g++){
		if(trim($graph_name[$g]) != '' OR trim($graph_data[$g]) != ''){
			$graph_name[$g] = stripslashes(ereg_replace("'",'`',$graph_name[$g]));
			$txt .= '<set name=\''.trim($graph_name[$g]).'\' value=\''.trim($graph_data[$g]).'\' '; 
			if($graph_link[$g] != ''){
				$txt .= ' link= \''.urlencode($graph_link[$g]).'\' ';
			}
			$txt .= ' color=\''.$array_color[$g].'\' />';
			if($graph_data[$g] > 0){
				$dataok = 'Y';
			}
		}
	}
	$txt .= '</graph>';
	if($dataok == "Y"){
//	$fp=fopen($myfile,"w");
//	fputs($fp,$txt);
//	fclose($fp);
	if($graph_group == "Y"){
	?>
<table width="<?php echo $graph_width; ?>" border="0" align="center" cellpadding="3" cellspacing="1"  class="ewttableuse" id="mytr<?php echo $mygraphidofinclude; ?>_1">
  <tr>
    <td  class="ewttablehead"> <?php echo $text_Gengraph_list1;?>
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list2;?></a> 
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list3;?></a> 
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='';"><?php echo $text_Gengraph_list4;?></a> </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
	<?php
	}
	?>
     <OBJECT  type="application/x-shockwave-flash" data="<?php echo $EWT_PATH; ?>chart/FCF_Column3D.swf"   id="Column3D"  width="<?php echo $graph_width; ?>" height="<?php echo $graph_height; ?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"  >
         <param name="movie" value="<?php echo $EWT_PATH; ?>chart/FCF_Column3D.swf" >
         <param name="FlashVars" value="&amp;chartWidth=<?php echo $graph_width; ?>&amp;chartHeight=<?php echo $graph_height; ?>&amp;dataXML=<?php echo $txt; ?>">
         <param name="quality" value="high" >
      </object>
	  <?php
	  	if($graph_group == "Y"){
	?>
	</td>
  </tr>
</table>
	<?php
	}
	  ?>
	  <?php
		if($graph_group == "Y"){
	?>
<table  id="mytr<?php echo $mygraphidofinclude; ?>_2" width="<?php echo $graph_width; ?>" border="0" cellspacing="1" cellpadding="3" style="display:none"  class="ewttableuse">
  <tr>
    <td  class="ewttablehead"> <a href="#view"  onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list1;?></a> 
	 | <?php echo $text_Gengraph_list2;?>
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list3;?></a> 
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='';"><?php echo $text_Gengraph_list4;?></a> </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
	<?php
	}
	?>
	  	 <OBJECT type="application/x-shockwave-flash"  data="<?php echo $EWT_PATH; ?>chart/FCF_Pie2D.swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="<?php echo $graph_width; ?>" height="<?php echo $graph_height; ?>" id="Pie" >
         <param name="movie" value="<?php echo $EWT_PATH; ?>chart/FCF_Pie2D.swf" >
         <param name="FlashVars" value="&amp;dataXML=<?php echo $txt; ?>&amp;chartWidth=<?php echo $graph_width; ?>&amp;chartHeight=<?php echo $graph_height; ?>">
         <param name="quality" value="high" >

      </object>
	  	  <?php
	  	if($graph_group == "Y"){
	?>
	</td>
  </tr>
</table>
	<?php
	}
	  ?>
	  <?php
		if($graph_group == "Y"){
	?>
<table  id="mytr<?php echo $mygraphidofinclude; ?>_3" width="<?php echo $graph_width; ?>" border="0" cellspacing="1" cellpadding="3" style="display:none"  class="ewttableuse">
  <tr>
    <td  class="ewttablehead"> <a href="#view"  onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list1;?></a> 
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list2;?></a>
	 | <?php echo $text_Gengraph_list3;?>  
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='';"><?php echo $text_Gengraph_list4;?></a> </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
	<?php
	}
	?>
	         <OBJECT  type="application/x-shockwave-flash"  data="<?php echo $EWT_PATH; ?>chart/FCF_Line.swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="<?php echo $graph_width; ?>" height="<?php echo $graph_height; ?>" id="Line" >
         <param name="movie" value="<?php echo $EWT_PATH; ?>chart/FCF_Line.swf" >
         <param name="FlashVars" value="&amp;dataXML=<?php echo $txt; ?>&amp;chartWidth=<?php echo $graph_width; ?>&amp;chartHeight=<?php echo $graph_height; ?>">
         <param name="quality" value="high" >
      </object>  
	  	  <?php
	  	if($graph_group == "Y"){
	?>
	</td>
  </tr>
</table>
	<?php
	}
	  ?>
	  <?php
		if($graph_group == "Y"){
	?>
<table  id="mytr<?php echo $mygraphidofinclude; ?>_4" width="<?php echo $graph_width; ?>" border="0" cellspacing="1" cellpadding="3" style="display:none"  class="ewttableuse">
  <tr>
    <td  class="ewttablehead"> <a href="#view"  onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list1;?></a> 
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list2;?></a>
	 | <a href="#view" onClick="document.all.mytr<?php echo $mygraphidofinclude; ?>_1.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_2.style.display='none';document.all.mytr<?php echo $mygraphidofinclude; ?>_3.style.display='';document.all.mytr<?php echo $mygraphidofinclude; ?>_4.style.display='none';"><?php echo $text_Gengraph_list3;?></a>  
	 | <?php echo $text_Gengraph_list4;?> </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
	<?php
	}
	?>
	       <OBJECT type="application/x-shockwave-flash"  data="<?php echo $EWT_PATH; ?>chart/FCF_Bar2D.swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="<?php echo $graph_width; ?>" height="<?php echo $graph_height; ?>" id="Bars" >
         <param name="movie" value="<?php echo $EWT_PATH; ?>chart/FCF_Bar2D.swf" >
         <param name="FlashVars" value="&amp;dataXML=<?php echo $txt; ?>&amp;chartWidth=<?php echo $graph_width; ?>&amp;chartHeight=<?php echo $graph_height; ?>">
         <param name="quality" value="high" >
      </object>   
	<?php
	  	if($graph_group == "Y"){
	?>
	</td>
  </tr>
</table>
	<?php
	}}}else{
	?>
<table  width="<?php echo $graph_width; ?>"   height="<?php echo $graph_height; ?>" border="0" align="center" cellpadding="3" cellspacing="1"    class="ewttableuse">
	<tr>
    <td  class="ewttablehead" align="center">
	<?php echo $text_Gengraph_nodata;?>
	</td>
	</tr>
</table>
	<?php
	} ?>