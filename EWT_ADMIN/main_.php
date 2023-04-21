<?php
session_start();
## >> Check login

	if($_SESSION["EWT_SMUSER"] == "" ){
				?>
				<script language="javascript">
				self.location.href = "../index.php";	
				</script>
				<?php
			exit();
		}
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/config_path.php");
$EWT_PATH = '../';	
$IMG_PATH = '';
$MAIN_PATH = '';



?>
<?php 
include("../header.php");
include('link.php');
?>	
</head>
<body class="ewt-bg-body">
<?php include('../ewt_module_hidden.php');?>


<?php
## >> Get site-userinfo
$siteuserinfo_data = $db->query("SELECT url FROM $EWT_DB_USER.user_info WHERE EWT_User = 'prd_intra_web'");
$siteuserinfo_info = $db->db_fetch_array($siteuserinfo_data);

## >> Get module list
$module_array = array();

$module_data = $db->query("SELECT * 
						   FROM   $EWT_DB_USER.web_module_ewt
						   WHERE  m_name NOT IN ('Dashboard') AND m_status = 'Y' AND (m_link IS NOT NULL AND m_link !='')
						   ORDER BY m_order ASC, m_name ASC");
while($module_info = $db->db_fetch_array($module_data)){
	array_push($module_array,$module_info);
}

## >> Get module list- sidemenu
$moduleside_array = array();

$moduleside_data = $db->query("SELECT * 
						       FROM   $EWT_DB_USER.web_module_ewt
						       WHERE  m_status = 'Y' AND (m_link IS NOT NULL AND m_link !='')
						       ORDER BY m_order ASC, m_name ASC");
while($moduleside_info = $db->db_fetch_array($moduleside_data)){
	array_push($moduleside_array,$moduleside_info);
}
?>

<!-- Start menu section -->
<section id="menu-area">
<nav class="navbar navbar-default main-navbar" role="navigation" >  
<!--Menu-->	
	<div class="navbar-header btn-header" id="btn-header">
    <ul>
		<li id="btn-menu" ><a href="#"><i class="fas fa-bars fa-2x i-menu" aria-hidden="true" id="i-menu" ></i></a></li>
		<!--<li><a href="#" class="icon icon-menu" id="btn-menu">Menu</a></li>-->
	</ul>                                                             
    </div>
	<div id="navbar-logo">
		<a class="navbar-brand logo animated fadeInLeft" href="<?php echo $MAIN_PATH; ?>main.php">
			<img src="<?php echo $IMG_PATH;?>../images/logo.png"  alt="logo" />
		</a> 
	</div> 	
	<div id="sideNav" class="sideNav">
	<ul>
	
		<?php
		foreach($moduleside_array AS $module){
			
			$show_module = "Y";

			## >> Allow only admin
			if($module["m_admin"]=="Y" && $_SESSION['EWT_SMTYPE'] != 'Y'){
				$show_module = "N";
			}

			## >> Check permission
			if($module["m_code"]!=""){
				if(!$db->check_permission($module["m_code"],"w","")){
					$show_module = "N";
				}
			}

			$target_rel  = "";
			
			## >> Module url
			$module_link = "../".$module["m_link"];

			if($show_module == "Y"){
		?>
		<li>
			<a href="<?php echo $module_link; ?>" <?php echo $target_rel; ?>>
			<img src="../EWT_ADMIN/<?php echo $module["m_image"]; ?>" class="img-responsive sideNavImg" />
			<span class="text-center"> <?php echo $module["m_name"]; ?></span></a>
		</li>
		<?php 
			}
		} 
		?>

	</ul>
	</div>
	<div id="navbar" class="navbar-collapse collapse">
	<div class="collapse navbar-collapse navbar-right">
	<div class="home-cms ">
	<p class="aBiz "><span class="icon-notification text-larger text-white "></span><span class="text-white"> Site  :  <?php echo $_SESSION["EWT_SUSER"]; ?></span></p>
	<!--<p class="aBiz ">
	<i class="fas fa-user-cog text-larger text-white "></i>		
	<span class="text-dark"> User : <?php echo $_SESSION["EWT_SMUSER"]; ?></span>
	</p>-->
	
	
	
	<p class="aBiz dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" >
	<a href=""><i class="fas fa-user-cog text-larger text-white "></i><span class="caret text-white"></span></a>		
	<span class="text-white"> User : <?php echo $_SESSION["EWT_SMUSER"]; ?></span>
	</p>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
    <?php if($_SESSION['EWT_SMTYPE'] == 'N'){?>
		<?php /*
		<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>ewt_logout.php">
		<i class="fas fa-sign-out-alt"></i> Profile</a></li> */?>
<?php } ?>
<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?>
	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>SystemLogMgt/"><i class="far fa-caret-square-right"></i> System Log</a></li> 
<?php } ?>

	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>VisitorStatMgt/"><i class="far fa-caret-square-right"></i> Visitor Stat</a></li>    
	<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $EWT_PATH; ?>ewt_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>    
    </ul>
	
	
	</div>

	

	
	
	</div>
	
	</div>
	
</nav> 
</section><!--End Menu-->
<?php 
//include('menu.php');
//include('navbar.php');
?>

<!-- START CONTAINER  -->
<div class="container-fluid" >

<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12"  >
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<div class="card" >
<div class="card-body" >

<img src="<?php echo $IMG_PATH ;?>images/visitor1.png" class="animated fadeInDown " style="height: 60px;width: 60px;">  
<span class="animated fadeInDown text-large "><?php echo "Dashboard";?></span>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="row ">
	<div class="col-md-12 col-sm-12 col-xs-12 " >
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
				<div class="card ">
					<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
						<div class="card-title text-left">
							<!--<div class="title" >
								<i class="fas fa-hashtag"></i> Module บนเว็บ Gistda
							</div>-->
						</div>
					</div>
					<div class="card-body " id="tab3">
						<div class="panel-group row">

							<?php
							foreach($module_array AS $module){
							
								$show_module = "Y";
					
								## >> Allow only admin
								if($module["m_admin"]=="Y" && $_SESSION['EWT_SMTYPE'] != 'Y'){
									$show_module = "N";
								}

								## >> Check permission
								if($module["m_code"]!=""){
									if(!$db->check_permission($module["m_code"],"w","")){
										$show_module = "N";
									}
								}

								$target_rel  = "";
								
								## >> Module url
								$module_link = "../".$module["m_link"];

								if($show_module == "Y"){
							?>
							<div class="col-xl-2 col-lg-2 col-sm-3 col-sm-4 col-xs-4" align="center" style="height:150px;">
								<a href="<?php echo $module_link; ?>" <?php echo $target_rel; ?>>
									<img src="../EWT_ADMIN/<?php echo $module["m_image"]; ?>" style="width:100px;height:100px" class="img-responsive sideNavImg">
									<span class="text-center"> <?php echo $module["m_name"]; ?></span>
								</a>
							</div>
							<?php 
								}
							} 
							?>

						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
<!--<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<div class="card">
<!--start card-header ->
<div class="card-header">
<h2><?php echo "Dashboard";?></h2>
<p></p>             
<ol class="breadcrumb">
<li><a href="banner_group.php"><?php echo "Dashboard";?></a></li>
<li class=""></li>       
</ol>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 " ></div>	
</div>
</div>
<!--END card-header ->

<!--start card-body ->
<div class="card-body">

</div>
<!--END card-body ->

</div>
</div>-->

<div class="col-md-12 col-sm-12 col-xs-12 " >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?php echo "ข่าวสาร/บทความใหม่รายวัน";?></div>

</div>
</div>
<div class="card-body" id="tab1">

<ul class="list-group">
<?php
$date = new DateTime();
$Y = $date->format('Y')+543; 
$MD = $date->format('-m-d');

$s_art_new = $db->query("SELECT n_id,n_topic,n_owner 
FROM article_list WHERE n_id != '' AND  n_approve = 'Y' AND n_date = '".$Y.$MD."'
ORDER BY n_id DESC LIMIT 0,5");

while($a_art_new = $db->db_fetch_row($s_art_new)){
?>
<li class="list-group-item "><i class="far fa-newspaper"></i> <?php echo $a_art_new[1];?></li>

<?php } ?>
</ul>

<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more"  class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='../DashboardMgt/article_list_view.php?tap=1'">View more</a>
</div>
</div>				
</div>
</div>



<div class="col-md-6 col-sm-6 col-xs-12 m-b-sm" >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?php echo "ข่าวสาร/บทความที่รอการอนุมัติ";?></div>


</div>
</div>
<div class="card-body" id="tab2">

<ul class="list-group">
<?php
$s_art_approve = $db->query("SELECT n_id,n_topic,n_owner 
FROM article_list WHERE n_id != '' AND n_approve = ''
ORDER BY n_id DESC LIMIT 0,5");

while($a_approve = $db->db_fetch_row($s_art_approve)){
?>
<li class="list-group-item "><i class="far fa-newspaper"></i> <?php echo $a_approve[1];?></li>

<?php } ?>
</ul>

<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
<a href="#View more"  class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='../DashboardMgt/article_list_view.php?tap=2'">View more</a>
</div>
</div>				
</div>
</div>

</div>
</div>
</div>



<div id="box_popup" class="layer-modal"></div>
</div>
<!-- END CONTAINER  -->

<div  style="padding-bottom:30px;"></div>

<?php include("panel-footer.php");?>
<style>
<!--
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
-->
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/gnmenu-js/js/gnmenu.js"></script>
<script type="text/javascript">
			$(document).ready(function(){ 
			
			$(window).scroll(function(){
				if ($(this).scrollTop() > 50) {
					$('.scrollup').fadeIn();
				} else {
					$('.scrollup').fadeOut();
				}
			}); 
			
			$('.scrollup').click(function(){
				$("html, body").animate({ scrollTop: 0 }, 300);
				return false;
			});
 
		});
</script>
<script>
$(document).ready(function(){
  $(".dropdown-toggle").dropdown();
});
</script>
<!-- Counter -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/waypoints.js"></script>
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/jquery.counterup.js"></script>

<!-- Slick Slider -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/custom.js"></script>
</body>
</html>
