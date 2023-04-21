<?php
include("../EWT_ADMIN/comtop.php");
$sso = new sso();
DEFINE('HOST_SSO', 'http://203.151.166.132/PRD_INTRA_SSO/');
?>

<style>
	.panel-default>.panel-heading {
		/*color: #FFFFFF;*/
		/*background-color: #FFC153 ;*/
		background-color: #FFFFFF;
		border-color: #ddd;
	}

	.faqHeader {
		font-size: 27px;
		margin: 20px;
	}

	.panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
		content: "\f105";
		/* "play" icon */
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
		background: rgba(255, 255, 255, 0.1);
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
		background: rgba(255, 255, 255, 1);
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
	.ewt-icon-effect-1b .ewt-icon:hover {
		background: rgba(255, 255, 255, 1);
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

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	?>
	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<h4><?php echo 'รายชื่อผู้ที่ได้รับคะแนน'; ?></h4>
							<p></p>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="km_setting.php"><?php echo 'รายชื่อผู้ที่ได้รับคะแนน'; ?></a></li>
									<li class=""></li>
								</ol>
							</div>
						</div>
					</div>
				</div>
				<!--END card-header -->

				<!--start card-body -->
				<div class="card-body">
					<div class="row ">
						<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">
							<div class="row active-with-click">
								<?php
								$perpage = 10;
								$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
								if ($page <= 0) $page = 1;
								$start = ($page * $perpage) - $perpage;
								$wh = '';
								$_sql = $db->query("SELECT km_user.*, km_point.km_name, km_point.km_point, km_point.km_icon 
								FROM km_user INNER JOIN km_point ON (km_user.km_id = km_point.id)
								WHERE km_point.km_status = 'Y' {$wh} ORDER BY km_user.create_date DESC LIMIT {$start} , {$perpage}");
								$statement = "SELECT count(id) AS b FROM km_user WHERE 1=1 {$wh} ";
								$a_rows = $db->db_num_rows($_sql);
								$s_count = $db->query($statement);
								$a_count = $db->db_fetch_array($s_count);
								$total_record = $a_count['b'];
								$total_page = (int)ceil($total_record / $perpage);
								$i = 0;
								$dir_base = "../ewt/" . $_SESSION['EWT_SUSER'] . "/profile/";

								if ($a_rows > 0) {
									while ($a_data = $db->db_fetch_array($_sql)) {
										switch ($a_data["module_name"]) {
											case 'ecard':
												$m_txt = "ส่งการ์ดวันเกิด";
												$_sql_u = $db->query("SELECT gen_user FROM ewt_user_prd_intra_web.gen_user WHERE gen_user_id = {$a_data['module_id']}");
												$u_data = $db->db_fetch_array($_sql_u);
												$aa_data = $sso->getUser($u_data['gen_user'])["data"];
												$m_name = "ให้คุณ ".  $aa_data["USR_FNAME"] . ' ' . $aa_data["USR_LNAME"];
												break;
											case 'article':
												$m_txt = "บทความ";
												$_sql_aa = $db->query("SELECT n_topic FROM article_list WHERE n_id = {$a_data['module_id']}");
												$aa_data = $db->db_fetch_array($_sql_aa);
												$m_name = $aa_data["n_topic"];
												break;
											case 'webboard':
												$m_txt = "กระทู้";
												$_sql_aa = $db->query("SELECT t_name FROM w_question WHERE t_id = {$a_data['module_id']}");
												$aa_data = $db->db_fetch_array($_sql_aa);
												$m_name = $aa_data["t_name"];
												break;
											case 'km':
												$m_txt = "บทความ km";
												$_sql_aa = $db->query("SELECT n_topic FROM article_list WHERE n_id = {$a_data['module_id']}");
												$aa_data = $db->db_fetch_array($_sql_aa);
												$m_name = $aa_data["n_topic"];
												break;
										}
										

										if ($a_data["km_id"] == 4) {
											$_sql_cc = $db->query("SELECT comment FROM news_comment WHERE id_comment = {$a_data['module_id']}");
										}

										//ข้อมูล User SSO
										$s_data = $sso->getUser($a_data['username'])["data"];
										$fullname = $s_data["USR_PREFIX"] . ' ' .  $s_data["USR_FNAME"] . ' ' . $s_data["USR_LNAME"];
										//ข้อมูลหน่วยงาน SSO
										$o_data = $sso->getDepartment($s_data["DEP_ID"])["data"]; 
										?>

										<div class="panel panel-default ">
											<div class="panel-heading ewt-bg-success">
												<h4 class="panel-title">
													<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>">
														<div class="blockico">
															<i class="fa fa-user" style="color:#FFBE7D;"></i>
														</div>
														<?php $km_name = $a_data['km_id'] == 1 ? "ส่ง".$a_data['km_name'] : $a_data['km_name']; ?>
														<?php echo $fullname . ' :: ' . $km_name . ' ได้รับ ' . $a_data['km_point'] . ' คะแนน :: ' . date('d/m/Y H:i', strtotime($a_data["create_date"])) . ' น.'; ?>
													</a>
												</h4>
											</div>

											<div id="collapseOne<?php echo $i; ?>" class="panel-collapse collapse">
												<div class="panel-body">
													<h4 class="panel-title">
														<div class="blockico"><i class="fa fa-building" style="color:#FFBE7D;"></i></div>
														<?php echo "หน่วยงาน :: " . $o_data['DEP_NAME']; ?>
													</h4>
													<h4 class="panel-title">
														<div class="blockico"><i class="<?php echo $a_data["km_icon"]; ?>" style="color:#FFBE7D;"></i></div>
														<?php echo $m_txt . " :: " . $m_name; ?>
													</h4>
												</div>
											</div>
										</div>
									<?php $i++;
									}
								} else {
									?>
									<div class="panel-group" id="accordion">
										<div class="panel panel-default ">
											<div class="panel-heading text-center">
												<h4 class="panel-title">
													<p class="text-danger"><?php echo $txt_ewt_data_not_found; ?></p>
												</h4>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php echo pagination_ewt($statement,$perpage,$page,$url='?');?>	
							</div>
						</div>
					</div>

				</div>
				<!--END card-body-->
			</div>
			<!--END card-->
		</div>
	</div>
</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<link rel="stylesheet" href="../js/jQuery-Cards/dist/material-cards.css">
<script>
	$(function() {
		$('.material-card > .mc-btn-action').click(function() {
			var card = $(this).parent('.material-card');
			var icon = $(this).children('i');
			icon.addClass('fa-spin-fast');

			if (card.hasClass('mc-active')) {
				card.removeClass('mc-active');

				window.setTimeout(function() {
					icon
						.removeClass('fa-arrow-left')
						.removeClass('fa-spin-fast')
						.addClass('fa-bars');

				}, 800);
			} else {
				card.addClass('mc-active');

				window.setTimeout(function() {
					icon
						.removeClass('fa-bars')
						.removeClass('fa-spin-fast')
						.addClass('fa-arrow-left');

				}, 800);
			}
		});
	});
</script>