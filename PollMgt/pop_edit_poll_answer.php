<?php
include("../EWT_ADMIN/comtop_pop.php");

$a_id = (int)(!isset($_GET['a_id']) ? 0 : $_GET['a_id']);

$_sql = $db->query("SELECT * FROM poll_ans  WHERE  a_id = '{$a_id}' ");
$a_data = $db->db_fetch_array($_sql);

$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/download/poll/"; 	  
?>
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_poll_answer')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Poll_Answer" > 
<input type="hidden" name="a_id" id="a_id"  value="<?php echo $a_id;?>" >
<input type="hidden" name="a_images_old" id="a_images_old"  value="<?php echo $a_data['a_images'];?>" > 
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i>  <?php echo 'แก้ไขคำตอบแบบสำรวจ';?></h4>
</div>

<div class="modal-body">

<div class="card ">

<div class="card-body" >

<div class="form-group row " >
<label for="poll_title" class="col-sm-12 control-label"><b><?php echo 'คำตอบแบบสำรวจ';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo 'คำตอบแบบสำรวจ';?>"  rows="6" id="poll_ans_title" name="poll_ans_title"  required="required" ><?php echo $a_data['a_name'];?></textarea>
</div>
</div>

<div class="form-group row " > 
<label for="poll_ans_color" class="col-sm-12 control-label"><b><?php echo 'สีคำตอบแบบสำรวจ';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input type="text" value="<?php echo $a_data['a_color'];?>" placeholder="<?php echo 'สีคำตอบแบบสำรวจ';?>" name="poll_ans_color" id="poll_ans_color" class="pick-a-color form-control"  required="required"  />
</div>
</div>

<div class="form-group row " >
<label for="poll_images" class="col-sm-12 control-label"><b><?php echo 'ภาพประกอบคำตอบ';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
  <label><input type="checkbox" name="show_image" id="show_image" value="1" onclick="JSChange(this.id);" >
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>เปลี่ยนรูปภาพ
  </label>
</div>
<div class="file-upload-drag " id="old-image" > 
<img src="<?php echo $dir_base.$a_data['a_images'];?>" alt="" class="img-rounded img-responsive file-upload-image-old" />
</div>

<div class="file-upload-drag " id="news-image" style="display:none;" >
  <div class="image-upload-wrap"> 
    <input class="file-upload-input" name="poll_images" id="poll_images" type="file" onchange="readURL(this);JSCheck_Img(this.id,this.value);" accept="image/*" />
    <div class="drag-icon"> 
	<i class="fas fa-cloud-upload-alt fa-5x"></i>
	</div>	
	<div class="drag-text"> 
      <h4>Drag and Drop your files or Browse</h4>
    </div>	
  </div>
<div class="file-upload-content">
<img class="file-upload-image" src="#" alt="your image" />
    <!--<div class="image-title-wrap">
      <button type="button" onclick="removeUpload();" class="remove-image"><i class="fas fa-trash-alt"></i> Remove </button>
    </div>-->
<div style="padding-top:10px;text-align:left;">
<button type="button" class="btn btn-danger  btn-circle  btn-sm " onclick="removeUpload();" data-toggle="tooltip" data-placement="top" title="Remove"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</div>
</div>
		
<span class="text-danger">
<code>
ประเภทไฟล์ที่สามารถใช้ได้คือ <?php echo EwtTypefile('img');?>
</code>
</span>
<br>
<span class="text-danger"><code>
ขนาดไฟล์ต้องไม่เกิน <?php echo EwtMaxfile('img');?> MB.
</code>
</span>
</div>

</div>
</div>

</div>	
</div>
</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Poll_Ans($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save ;?>
</button>
</div>
</div>


</div>
 
</div>
</div>	 
</form>
	
<script> 
$(document).ready(function() {
	var img = $('#a_images_old').val(); 
	if(img == '' || img == 'undefined') 
	{
		$('#news-image').show();
		$('#old-image').hide();  
	}
 
	$('.pick-a-color').pickAColor({
			  showSpectrum            : true,
				showSavedColors         : true,
				saveColorsPerElement    : true,
				fadeMenuToggle          : true,
				showAdvanced			: true,
				showBasicColors         : true,
				showHexInput            : true,
				allowBlank				: true,
				inlineDropdown			: true
			});			
});

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

function JSChange(ID) {
	if($('#'+ID).is(':checked') == true){	
			$('#old-image').hide();
			$('#news-image').show();
		}else if($('#'+ID).is(':checked') == false){
			$('#news-image').hide();
			$('#old-image').show(); 
		}
}  

function JQEdit_Poll_Ans(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'แก้ไขคำตอบแบบสำรวจ',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
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
												console.log(data);
												var cdata= JSON.stringify(eval("("+data+")"));
												var jsonObject = jQuery.parseJSON(cdata);
												console.log(jsonObject);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '50%',
													onAction: function () {
														
														//self.location.href="poll_builder.php?c_id="+jsonObject;	
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="complain_builder.php?com_cid="+data;											
												//$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
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

</script>
