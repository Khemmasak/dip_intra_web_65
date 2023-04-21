<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

function chkMenuSub($s_mid)
{ 
global $db ;  
		$_sql 	= $db->query("SELECT * 
				   FROM menu_properties 
				   WHERE m_id = '{$s_mid}'  
				   ");		
		$a_row	=  $db->db_num_rows($_sql);
		if($a_row)
		{
			return true;	
			}
			else
			{
				return false;	
			}
	}
$ptype = "menu";
$ppms = "w";
if($_SESSION["EWT_SMTYPE"] != "Y"){
	$ExecSel1 = $db->query("SELECT s_name FROM ".$EWT_DB_USER.".permission where p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."'
	AND s_type = '".$ptype."' AND s_permission = '".$ppms."' and s_name > 0");
	$rows1 = $db->db_num_rows($ExecSel1);
	if($rows1>0){
		$wh = "WHERE m_id IN (SELECT s_name FROM ".$EWT_DB_USER.".permission where p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."'
		AND (s_type = '".$ptype."' AND s_permission = '".$ppms."'))"; 
	}
}

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT m_id,m_name FROM menu_list WHERE m_show = 'Y' OR m_show = 'N' {$wh} ORDER BY m_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(m_id) AS b
			  FROM menu_list 
			  WHERE m_show = 'Y' OR m_show = 'N' 
			  {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
?>


<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo $txt_menu_menu_main;?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?php echo $txt_menu_menu_main;?></li>
  
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_menu.php');"   target="_self">
<button type="button" class="btn btn-info  btn-ml"  title="<?php echo $txt_menu_add;;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_menu_add;?>
</button>
</a>
<!--<a  target="_self" onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" >
<button type="button" class="btn btn-info  btn-ml "  title="<?php echo $txt_menu_search;?>"  >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?>
</button>
</a>-->
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
            <li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_menu');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_menu_add;;?></a></li>
          	<li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->


<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<!--<div class="card ">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">

</div>
</div>
<div class="card-body">-->

<div class="panel-group" id="accordion">
<?php
$i = 0;
if($a_rows > 0){
while($a_data = $db->db_fetch_array($_sql)){	
?>
        <div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
                    
					<img src="<?php echo $IMG_PATH ;?>images/grabme.svg"> 
					<div class="blockico"><i class="fas fa-bars"></i></div> 
					<?php echo $a_data['m_name'];?>
					<span class="pull-right">
<button onclick="boxPopup('<?php echo linkboxPopup();?>pop_menu_view.php?m_id=<?php echo $a_data['m_id'];?>');"  type="button" class="btn btn-info btn-circle  " data-toggle="tooltip" data-placement="top" title="<?php echo 'View';?>" >
<i class="fas fa-search"></i>
</button>
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_menu.php?m_id=<?php echo $a_data['m_id'];?>')" > 
<button type="button" class="btn btn-warning  btn-circle  "  data-toggle="tooltip" data-placement="top" title="<?php echo 'แก้ไขเมนู';?>" >
<i class="fas fa-edit" aria-hidden="true"></i>
</button>
</a>
<?php
if(!chkMenuSub($a_data['m_id'])){
?>	
<a onClick="JQDel_Menu('<?php echo $a_data['m_id'];?>');" >
<button type="button" class="btn btn-danger  btn-circle  "  data-toggle="tooltip" data-placement="top" title="<?php echo 'ลบเมนู';?>" >
<i class="fas fa-trash-alt " aria-hidden="true"></i>&nbsp;&nbsp;
</button>
</a>
<?php }else{ ?>
	
<button type="button" class="btn btn-danger  btn-circle  "  disabled data-toggle="tooltip" data-placement="top" title="<?php echo 'ลบเมนู';?>" >
&nbsp;<i class="fas fa-trash-alt " aria-hidden="true"></i>
</button>

<?php } ?>
<a href="menu_builder.php?m_id=<?php echo $a_data['m_id'];?>" >
<button type="button" class="btn btn-primary  btn-circle  "  data-toggle="tooltip" data-placement="top" title="<?php echo 'ตั้งค่าเมนู';?>" >
<i class="fas fa-cogs" aria-hidden="true"></i>
</button>
</a>

<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_save_as_menu.php?m_id=<?php echo $a_data['m_id'];?>')" data-toggle="tooltip" data-placement="top" title="<?php echo 'Save as';?>">		
<button type="button" class="btn btn-success  btn-circle  btn-sm "  >
<i class="far fa-copy" aria-hidden="true"></i>
</button>
</a> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					</a>		</span> 			
                </h4>
            </div>
		
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	
                </div>
				<div class="panel-footer ewt-bg-white text-right">
				<!--<a onClick="boxPopup('<?//=linkboxPopup();?>pop_edit_faq_group.php?fa_id=<?php echo $a_data['fa_id'];?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $text_genbanner_altedit;?>">
				<i class="far fa-edit" aria-hidden="true"></i>
				</a>
				<a href="" onClick="" data-toggle="tooltip" data-placement="right" title="">
				<i class="far fa-trash-alt" aria-hidden="true"></i>
				</a>-->
				
				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
					<!--<a href="#set-1" class="ewt-icon ewt-icon-del text-dark"></a>
					<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_poll.php?c_id=<?php echo $a_data['c_id'];?>');" class="ewt-icon ewt-icon-edit text-dark"></a>
					<a href="#set-1" class="ewt-icon ewt-icon-view text-dark"></a>
					<a href="#set-1" class=""><i class="fas fa-cogs"></i></a>
					
					<a onClick="JQSet_Lang_Poll('<?php echo $a_data['c_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?php echo "สร้างภาษาอื่นๆ";?>">
<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $a_data['c_id'];?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>-->


<!--<a onClick="JQDel_Menu('<?php echo $a_data['m_id'];?>')" data-toggle="tooltip" data-placement="right" title="<?php echo $txt_menu_delete;?>">		
<button type="button" class="btn btn-default  btn-circle  btn-sm "  >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a> 
 
<a href="menu_builder.php?m_id=<?php echo $a_data['m_id'];?>" data-toggle="tooltip" data-placement="right" title="<?php echo $txt_menu_edit;?>">					
<button type="button" class="btn btn-default btn-circle btn-sm "  > 
</button>
</a>-->
					
<!--<a onClick="JQSet_Lang_Poll('<?php echo $a_data['c_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?php echo $txt_ewt_create_multilang;?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?php echo $a_data['m_id'];?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>-->

				</div>
				</div>
            </div>
        </div>
<?php $i++;} }else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>		
		
</div>
<?php echo pagination_ewt($statement,$perpage,$page,$url='?');?>				
</div>
</div>

</div>
<!--END card-body -->
</div>
<!--END card -->
</div>
</div>
</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>

<style>

.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}

</style>

 
<script>
function JQDel_Menu(m_id){

	$.confirm({
		title: 'ลบเมนู',
		content: 'คุณต้องการลบเมนูหรือไม่?',
		boxWidth: '30%',
		icon: 'fas fa-exclamation-circle',
		theme: 'modern',
		buttons: {
			confirm: {
				text: 'ยืนยันการลบ',
				btnClass: 'btn-warning',
				action: function () {
					$.ajax({
						type: 'POST',
						url: "func_del_menu.php",					
						data: {m_id:m_id,proc:"DelMenu"},
						success: function (data) {

							$.alert({
								title: '',
								theme: 'modern',
								content: 'ลบเมนูเรียบร้อย',
								boxWidth: '30%',
								onAction: function () {
									location.reload(true);			
									$('#box_popup').fadeOut();
								}
							});
																
							$('#box_popup').fadeOut();
						}
					});																										
				}								
			
			},
			cancel: {
				text: 'ยกเลิก'
													
			}
		},                          
		animation: 'scale',
		type: 'orange'
						
	});
}

</script>