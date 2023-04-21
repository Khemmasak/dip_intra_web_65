<?php
include("../EWT_ADMIN/comtop_pop.php");

//$faq_cid = (int)(!isset($_GET['faq_cid']) ? 0 : $_GET['faq_cid']);
$db->query("USE ".$EWT_DB_USER);
?>

<form id="form_main" name="form_main" method="POST" action="func_add_org_list_ldap.php" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_OrgUser">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content ">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close"  onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"> <i class="fas fa-plus-circle"></i> นำเข้าบุคลากรผ่าน LDAP</h4>
</div>

<div class="modal-body">
	<div class="card ">
		<div class="card-body" >

			<div class="form-group row " >
				<div class="col-md-12 col-sm-12 col-xs-12 text-center" >
					<button onclick="check_ldap($('#form_main'));" type="button" class="btn btn-info" >
						นำเข้าข้อมูล
					</button>
					<br/>
					<span class="text-danger">
					</span>
				</div>
			</div>

			<div class="ldap_user_section form-group row" hidden>
				<hr>
				<div id="ldap_user_list" class="col-md-12 col-sm-12 col-xs-12" >
				</div>
			</div>

		</div>
	</div>	
</div>
		
<div class="modal-footer ">
	<div class="ldap_user_section col-md-12 col-sm-12 col-xs-12 text-center" hidden>
		<button onclick="$('#box_popup').fadeOut();location.reload();" type="button" class="btn btn-success  btn-ml " >
			<i class="fas fa-save"></i>&nbsp;สิ้นสุดการนำเข้าข้อมูล
		</button>
	</div> 	
</div>


</div>
 
</div>
</div>	 
</form>
<!-- Custom js -->
<script type="text/javascript">
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('.image-upload-wrap').hide();
      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();
      $('.image-title').html(input.files[0].name);
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
		$('.image-upload-wrap').addClass('image-dropping');
	});
$('.image-upload-wrap').bind('dragleave', function () {
		$('.image-upload-wrap').removeClass('image-dropping');
});

$(document).ready(function() {
	$('.selectpicker').selectpicker();	

	$('input[name="ldap_use"]').change(function(){
		var ldap_use = $(this).val();

		if(ldap_use=="1"){
			$(".userpass_section").prop("hidden",true);
		}
		else{
			$(".userpass_section").prop("hidden",false);
		}
	})
	
	$('input[name="expire_use"]').change(function(){
		var expire_use = $(this).val();

		if(expire_use=="1"){
			$(".userexpire_section").prop("hidden",false);
		}
		else{
			$(".userexpire_section").prop("hidden",true);
		}
	})

	
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy',
		language: 'th-th',
		//thaiyear: true,
		leftArrow: '<i class="fas fa-angle-double-left"></i>',
		rightArrow: '<i class="fas fa-angle-double-right"></i>',
	})
	
});

$(".toggle-password").click(function() {
	$(this).toggleClass("fa-eye fa-eye-slash");
	var input = $($(this).attr("toggle"));
	if (input.attr("type") == "password") {
		input.attr("type", "text");
		} else {
			input.attr("type", "password");
			}
});

function CKupdate(){
	for ( instance in CKEDITOR.instances )
		CKEDITOR.instances[instance].updateElement();
}    

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_sub').attr("disabled",false);
		}else{
			$('#category_sub').attr("disabled",true);
		}	
	console.log(check);
}

function JQAdd_OrgUser(form){	
CKupdate();

//disable check temporary
//var fail = CKSubmitData(form);
var fail = false;

if (fail == false) {	
	var action  = form.attr('action'); 
	var method  = form.attr('method'); 
	var formData = false;
	if (window.FormData){
		formData = new FormData(form[0]);
	} 	
		
	$.confirm({
		title: '<?php echo $txt_org_add;?>',
		content: '<?php echo $txt_ewt_confirm_alert;?>',
		//content: 'url:form.html',
		boxWidth: '30%',
		icon: 'far fa-question-circle',
		theme: 'modern',
		buttons: {
			confirm: {
			text: '<?php echo $txt_ewt_confirm_submit;?>',
			btnClass: 'btn-blue',
			action: function () {

				$.ajax({
					type: method,
					url: action,					
					data: formData ? formData : form.serialize(),
					async: true,
					processData: false,
					contentType: false,
					success: function (data) {												

						$.alert({
							title: '',
							theme: 'modern',
							content: '<?php echo $txt_ewt_action_alert;?>',
							boxWidth: '30%',
							onAction: function () {
								//console.log(data);	
								//location.reload(true);	
								var Newdata= JSON.stringify(eval("("+data+")"));
								var Obj = jQuery.parseJSON(Newdata);											
								//console.log(data);											
								//console.log(Obj);	
								//alert("URL:"+Obj.url);				

								if(Obj.err){
									$.alert({
									title: 'Error',
									content: Obj.message,
									icon: 'fa fa-exclamation-circle',
									theme: 'modern',                          
									type: 'orange',
									closeIcon: false,						
									buttons: {
									close: {
									text: 'ปิด',
										btnClass: 'btn-orange',
										}
									}
								
								});		
								return false;													
								}
		
								if(Obj.warn){
									$.alert({
										title: 'Warning',
										content: Obj.message,
										icon: 'fa fa-exclamation-circle',
										theme: 'modern',                          
										type: 'orange',
										closeIcon: false,						
										buttons: {
										close: {
										text: 'ปิด',
											btnClass: 'btn-orange',
											}
										}
									
									});		
								return false;													
								}
							
								if(Obj.url){													
									window.location.href = Obj.url;	
								}			
							}													
						});
							
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												
							}
						});																										
					}															
				},
				cancel: {
					text: '<?php echo $txt_ewt_cancel;?>',
					action: function () {
					//$('#box_popup').fadeOut(); 	
					}									
				}
			},                          
			animation: 'scale',
			type: 'blue'
		
		});
	} 
								
}



function check_ldap(form){	
	$(".ldap_user_section").prop("hidden",true);

	var action  = form.attr('action'); 
	var method  = form.attr('method'); 
	var formData = false;
	if (window.FormData){
		formData = new FormData(form[0]);
	} 	
				
	$.ajax({
		type: method,
		url: action,					
		data: formData ? formData : form.serialize(),
		async: true,
		processData: false,
		contentType: false,
		success: function (data){	
			data = JSON.parse(data);					
			console.log(data);

			$("#ldap_user_list").html(data.ldap_user);
			$(".ldap_user_section").prop("hidden",false);
		}
	});		
								
}

</script>