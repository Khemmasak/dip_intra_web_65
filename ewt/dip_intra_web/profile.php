<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->

<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
session_start();
dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

$fname = $_SESSION['EWT_NAME'];
$lname = $_SESSION['EWT_SURNAME'];
$idCard = $_SESSION['EWT_Idcard'];
$UsrId = $_SESSION['EWT_USRID'];

$sql_profile = "SELECT * ,(select DEP_NAME FROM USR_DEPARTMENT WHERE M_PER_PROFILE.DEP_LV1_ID = USR_DEPARTMENT.DEP_ID) AS DEP_1,
(select DEP_NAME FROM USR_DEPARTMENT WHERE M_PER_PROFILE.DEP_LV2_ID = USR_DEPARTMENT.DEP_ID) AS DEP_2 FROM M_PER_PROFILE
LEFT JOIN USR_DEPARTMENT ON M_PER_PROFILE.DEP_LV1_ID = USR_DEPARTMENT.DEP_ID
LEFT JOIN M_PER_TYPE ON M_PER_PROFILE.PER_TYPE = M_PER_TYPE.PER_TYPE_ID
LEFT JOIN M_POSITION_LEVEL ON M_PER_PROFILE.PER_POSITION_LVL = M_POSITION_LEVEL.POS_LEVEL_ID
LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
LEFT JOIN USR_POSITION ON M_PER_PROFILE.PER_POS_ID = USR_POSITION.POS_ID
LEFT JOIN M_POSITION_MANAGE ON M_PER_PROFILE.PER_POS_MANAGE_ID = M_POSITION_MANAGE.POS_ADMIN_ID
WHERE
M_PER_PROFILE.PER_IDCARD = '" . $idCard . "' 
";
$result = dbdpis::getFetch($sql_profile);

// echo "<pre>";
// print_r($result);
// echo "</pre>";
// exit();

$s_gen_user_id  = " WHERE gen_user_id = $user_ewt[gen_user_id]";
$_sql_pro     = " SELECT * FROM gen_user as gen
                        INNER JOIN title ON title.title_id = gen.title_thai
                        INNER JOIN emp_type ON emp_type.emp_type_id = gen.emp_type_id
                        INNER JOIN org_name ON org_name.org_id = gen.org_id 
                        INNER JOIN position_name ON position_name.pos_id = gen.posittion
                        INNER JOIN level ON level.level_id = gen.level_id
                        $s_gen_user_id";
$a_data_pro   = db::getfetch($_sql_pro);

?>

<style>
  ::placeholder {
    font-weight: bold;
  }

  .icon-edit {
    position: absolute;
    bottom: 0px;
    color: #82288c;
    top: 4px;
    right: 32px;
  }

  .image-upload>input {
    display: none;
  }

  .form-control {
    border: 1px solid #981c9d !important;
    border-radius: 5px !important;
  }

  .box-pic-profile {
    max-width: 180px;
    max-height: 180px;
    height: 180px;
    border-radius: 15px;
    /* margin-top: 50px; */
  }
</style>
<div class="container mar-spacehead">
  <form id="profile_form">
    <div class="row">
      <!-- picture profile -->
      <div class="col-lg-3 col-md-5 col-sm-12 col-12">
        <div class="line-pic-profile my-5"></div>
        <div>
          <?php if ($result['USR_PICTURE']) { ?>
            <img src="<?php echo SSO_PATH ?>profile/<?php echo $result['USR_PICTURE'] ?>" class="shadow box-pic-profile" alt="pictureProfile">
          <?php } else { ?>
            <img src="assets/img/avatar-2.png" class="shadow box-pic-profile" alt="pictureProfile">
          <?php } ?>
          <div class="image-upload">
            <label for="path_image">
              <!-- <i class="fa fa-plus-circle" aria-hidden="true"></i> -->
              <i class="fa-solid fa fa-plus-circle btn btn-change-pic" role="button"></i>
            </label>
            <input type="file" class="form-control" name="path_image" id="path_image" />
          </div>
        </div>
      </div>

      <!-- ข้อมูลส่วนตัว -->
      <div class="col-lg-9 col-md-7 col-sm-12 col-12 martop-profile">
        <div class="row">
          <div class="col-lg-8 col-md-12 col-sm-12 col-12">
            <h2 class="h2-color "><?php echo $result["USR_PREFIX"] . $result['PER_NAME_TH']  . "  " . $result['PER_LASTNAME_TH']; ?></h2>
            <h3 class="mb-2"><?php echo $result["USR_OPTION7"] .$result['USR_FNAME_EN'] . "  " . $result['USR_LNAME_EN']; ?></h3>
            <p class="mb-0">กลุ่มงาน :<span> <?php echo $result['DEP_2']; ?> </span></p>
            <p>สังกัด :<span> <?php echo $result['DEP_1']; ?> </span></p>
          </div>
          <!-- <div class="col-lg-4 col-md-12 col-sm-12 col-12">
            <a href="personal_information.php" class="btn Gradient-Color border-ra-15px white-text  btn-sm">ข้อมูลส่วนบุคคล</a>
          </div> -->
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class=" col-xl-12">
            <!-- ส่วนของข้อมูลผู้ใช้ -->
            <h2 class="h2-color pt-4">
              <i class="fa fa-user" aria-hidden="true"></i>
              <?php //var_dump("./ewtadmin/ewt/pic_upload/" . $user_ewt["path_image"]); 
              ?>
              ข้อมูลผู้ใช้งาน
            </h2>
          </div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-xl-10 col-md-10">
              <div class="row">
              <input type="hidden" name="Flag" id="Flag" value="EditPro">
              <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo $result['USR_ID'] ?>">
              <input type="hidden" name="PER_ID" id="PER_ID" value="<?php echo $result['PER_ID'] ?>">
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="USR_USERNAME" class="label-form">Username<span class="txt-red"></span> </label>
                    <input type="text" class="form-control" id="USR_USERNAME" name="USR_USERNAME" placeholder="Username" value="<?php echo $result["USR_USERNAME"]?>" readonly></input>
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                <div class="form-group">
                      <label for="PER_TYPE" class="label-form">ประเภทบุคลากร<span class="txt-red"></span></label>
                      <select class="form-control" name="PER_TYPE" id="PER_TYPE"readonly>
                      <option value="" disabled selected>โปรดระบุประเภทบุคลากร</option>
                      <?php 
                      $s_per ="SELECT * FROM M_PER_TYPE ";
                      $res = dbdpis::getFetchAll($s_per);
                      foreach($res as $value){
                      
                      ?>
                      <option value="<?php echo $value["PER_TYPE_ID"] ?>" <?php echo $result['PER_TYPE'] == $value["PER_TYPE_ID"] ? 'selected' : ' '; ?>><?php echo $value["PER_TYPE_NAME"] ?></option>
                      <?php }?>
                      </select>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                  <div class="form-group">
                    <label for="PER_IDCARD" class="label-form">เลขบัตรประจำตัวประชาชน<span class="txt-red"></span> </label>
                    <input type="text" class="form-control" id="PER_IDCARD" name="PER_IDCARD" placeholder="เลขบัตรประจำตัวประชาชน" value="<?php echo $result["PER_IDCARD"]?>" readonly></input>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="USR_PREFIX" class="label-form">คำนำหน้า(ภาษาไทย)<span class="txt-red"></span> </label>
                    <select class="form-control" name="USR_PREFIX" id="USR_PREFIX" required>
                      <option value="" disabled selected>โปรดระบุคำนำหน้า(ภาษาไทย)</option>
                      <?php 
                      $s_per ="SELECT * FROM USR_PREFIX ";
                      $res = dbdpis::getFetchAll($s_per);
                      foreach($res as $value){
                      ?>
                      <option value="<?php echo $value["PREFIX_TH"] ?>" <?php echo $result['PREFIX_NAME'] == $value["PREFIX_TH"] ? 'selected' : ' '; ?>><?php echo $value["PREFIX_TH"] ?></option>
                      <?php }?>
                      </select>
                    <!-- <input type="text" class="form-control" id="#" name="#" placeholder="คำนำหน้า" value="<?php //echo $result["USR_PREFIX"]?>" ></input> -->
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="name_thai" class="label-form"> ชื่อ(ภาษาไทย)<span class="txt-red"></span> </label>
                    <input type="text" class="form-control" id="name_thai" name="name_thai" placeholder="ชื่อ(ภาษาไทย)" value="<?php echo $result['PER_NAME_TH']; ?>" ></input>
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="surname_thai" class="label-form"> นามสกุล(ภาษาไทย)<span class="txt-red"></span> </label>
                    <input type="text" class="form-control" id="surname_thai" name="surname_thai" placeholder="นามสกุล(ภาษาไทย)" value="<?php echo $result['PER_LASTNAME_TH']; ?>" ></input>
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="nickname" class="label-form"> ชื่อเล่น <span class="txt-red"></span> </label>
                    <input type="text" class="form-control" id="nickname_thai" name="nickname_thai" placeholder="ชื่อเล่น" value="<?php echo $result['USR_NICKNAME']; ?>"></input>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="USR_OPTION7" class="label-form">คำนำหน้า(ภาษาอังกฤษ)<span class="txt-red"></span> </label>
                    <select class="form-control" name="USR_OPTION7" id="USR_OPTION7" required>
                      <option value="" disabled selected>โปรดระบุคำนำหน้า(ภาษาอังกฤษ)</option>
                      <?php 
                      $s_per ="SELECT * FROM USR_PREFIX ";
                      $res = dbdpis::getFetchAll($s_per);
                      foreach($res as $value){
                      ?>
                      <option value="<?php echo $value["PREFIX_EN"] ?>" <?php echo $result['USR_OPTION7'] == $value["PREFIX_EN"] ? 'selected' : ' '; ?>><?php echo $value["PREFIX_TH"]." (".$value["PREFIX_EN"] .")" ?></option>
                      <?php }?>
                      </select>
                    <!-- <input type="text" class="form-control" id="USR_OPTION7" name="USR_OPTION7" placeholder="คำนำหน้าภาษาอังกฤษ" value="<?php //echo $result["USR_OPTION7"]?>" ></input> -->
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="name_eng" class="label-form"> ชื่อ(ภาษาอังกฤษ)<span class="txt-red"></span> </label>
                    <input type="text" class="form-control" id="name_eng" name="name_eng" placeholder="ชื่อ(ภาษาอังกฤษ)" value="<?php echo $result['USR_FNAME_EN']; ?>"></input>
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="surname_eng" class="label-form"> นามสกุล(ภาษาอังกฤษ)<span class="txt-red"></span> </label>
                    <input type="text" class="form-control" id="surname_eng" name="surname_eng" placeholder="นามสกุล(ภาษาอังกฤษ)" value="<?php echo $result['USR_LNAME_EN']; ?>"></input>
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="pos_name" class="label-form"> ตำแหน่งการบริหารงาน<span class="txt-red"></span> </label>
                    <select class="form-control" name="pos_name" id="pos_name" disabled>
                      <option value="" disabled selected>โปรดระบุตำแหน่งการบริหารงาน</option>
                      <?php 
                      $s_per ="SELECT * FROM M_POSITION_MANAGE ";
                      $res = dbdpis::getFetchAll($s_per);
                      foreach($res as $value){
                      ?>
                      <option value="<?php echo $value["POS_ADMIN_ID"] ?>" <?php echo $result['PER_POS_MANAGE_ID'] == $value["POS_ADMIN_ID"] ? 'selected' : ' '; ?>><?php echo $value["POS_ADMIN_NAME"] ?></option>
                      <?php }?>
                      </select>
                    <!-- <input type="text" class="form-control" id="pos_name" name="pos_name" placeholder="-" value="<?php // echo $result['POS_ADMIN_NAME']; ?>" ></input> -->
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="position_person" class="label-form"> ตำแหน่งในสายงาน<span class="txt-red"></span> </label>
                    <select class="form-control" name="position_person" id="position_person"  disabled>
                      <option value="" disabled  selected>โปรดระบุตำแหน่งในสายงาน</option>
                      <?php 
                      $s_per ="SELECT * FROM USR_POSITION ";
                      $res = dbdpis::getFetchAll($s_per);
                      foreach($res as $value){
                      ?>
                      <option value="<?php echo $value["POS_ID"] ?>" <?php echo $result['PER_POS_ID'] == $value["POS_ID"] ? 'selected' : ' '; ?>><?php echo $value["POS_NAME"] ?></option>
                      <?php }?>
                      </select>
                    <!-- <input type="text" class="form-control" id="position_person" name="position_person" placeholder="-" value="<?php echo $result['POS_NAME']; ?>" ></input> -->
                  </div>
                </div>
                <div class="col-xl-3 col-md-3" id="div_level_name">
                  <div class="form-group">
                    <label for="level_name" class="label-form"> ระดับตำแหน่ง<span class="txt-red"></span> </label>
                    <select class="form-control" name="level_name" id="level_name"  disabled>
                      <option value="" disabled selected>โปรดระบุระดับตำแหน่ง</option>
                      <?php 
                      $s_per ="SELECT * FROM M_POSITION_LEVEL ";
                      $res = dbdpis::getFetchAll($s_per);
                      foreach($res as $value){
                      ?>
                      <option value="<?php echo $value["POS_LEVEL_ID"] ?>" <?php echo $result['PER_POSITION_LVL'] == $value["POS_LEVEL_ID"] ? 'selected' : ' '; ?>><?php echo $value["POS_LEVEL_NAME"] ?></option>
                      <?php }?>
                      </select>
                    <!-- <input class="form-control" id="level_name" name="level_name" placeholder="-" value="<?php //echo $result['POS_LEVEL_NAME']; ?>" > -->
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="afft_name" class="label-form"> สังกัด*<span class="txt-red"></span> </label>
                    <select class="form-control" name="afft_name" id="afft_name" required   onchange="getDepartment(this.value, document.getElementById('name_org').value, document.getElementById('name_org').value);">
                      <option value="" disabled  selected>โปรดระบุสังกัด</option>
                      <?php 
                      $s_per ="SELECT * FROM USR_DEPARTMENT WHERE DEPT_PARENT_ID = 0
                      ORDER BY DEP_NAME";
                      $res = dbdpis::getFetchAll($s_per);
                      foreach($res as $value){
                      ?>
                      <option value="<?php echo $value["DEP_ID"] ?>" <?php echo $result['DEP_LV1_ID'] == $value["DEP_ID"] ? 'selected' : ' '; ?>><?php echo $value["DEP_NAME"] ?></option>
                      <?php }?>
                      </select>
                    <!-- <input class="form-control" id="afft_name" name="afft_name" placeholder="-" value="<?php //echo $result['DEP_1']; ?>" > -->
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="name_org" class="label-form"> กลุ่มงาน*<span class="txt-red"></span> </label>
                    <select class="form-control" name="name_org" id="name_org" required >
                      <option value="" disabled selected>โปรดระบุกลุ่มงาน</option>
                     </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="tel_in" class="label-form"> หมายเลขโทรศัพท์<span class="txt-red"></span> </label>
                    <input class="form-control" id="tel_in" name="tel_in" list="Affiliation" value="<?php echo $result['USR_TEL']; ?>">
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="tel_convenient" class="label-form"> หมายเลขโทรสาร<span class="txt-red"></span> </label>
                    <input type="tel" class="form-control" name="tel_convenient" id="tel_convenient" placeholder="-" value="<?php echo $result['USR_TEL_FAX']; ?>">
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="mobile" class="label-form">หมายเลขมือถือ<span class="txt-red"></span> </label>
                    <input type="tel" class="form-control" name="mobile" id="mobile" placeholder="-" value="<?php echo $result['USR_TEL_PHONE']; ?>">
                  </div>
                </div>
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="email_person" class="label-form"> Email *<span class="txt-red"></span> </label>
                    <input type="email" class="form-control" name="email_person" id="email_person" aria-describedby="emailHelp" value="<?php echo $result['USR_EMAIL']; ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-3 col-md-3">
                  <div class="form-group">
                    <label for="line_id" class="label-form"> ไอดีไลน์ <span class="txt-red"></span> </label>
                    <input type="tel" class="form-control" name="line_id" id="line_id" placeholder="ไม่ระบุ" value="<?php echo $result['USR_LINE_ID']; ?>">
                  </div>
                </div>
                <div class="col-xl-9 col-md-9">
                  <div class="form-group">
                    <label for="officeaddress" class="label-form"> ที่อยู่ <span class="txt-red"></span> </label>
                    <textarea class="form-control" name="officeaddress" id="officeaddress"><?php echo $result['USR_ADDRESS']; ?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-2">
              <div class="row">
                <?php
                // CHECK ว่า เป็น ข้าราชการ, พนักงานราชการ, ลูกจ้างประจำ
                $chk_per_type = "SELECT COUNT(*) AS C_CHK
                      FROM USR_MAIN A
                      LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
                      WHERE B.PER_TYPE IN (1,2,3) 
                      AND A.USR_USERNAME = '" . $_SESSION['EWT_USERNAME'] . "' ";
                $q = dbdpis::execute($chk_per_type);
                $chk = dbdpis::Fetch($q);
                $h_1 = "";
                // echo $chk['C_CHK'];
                if ($chk['C_CHK'] == 0) {
                  $h_1 = "hidden";
                }
                ?>
                <div <?php echo $h_1; ?> class=" col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                  <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position boxsize-menu p-0" href="finance_information.php" role="button">
                    <img class="imgMenu-icon" src="images/Edit2playcopy2.png" alt="img">
                    <p class="font-boxMenu white-text ">ข้อมูลการเงิน</p>
                  </a>
                </div>
                <div <?php echo $h_1; ?> class="col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                  <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position boxsize-menu p-0" href="Request_Certificate.php" role="button">
                    <img class="imgMenu-icon" src="images/contract.png" alt="img">
                    <p class="font-boxMenu white-text ">ขอหนังสือรับรอง</p>
                  </a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                  <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position boxsize-menu p-0" href="private_floder.php" role="button">
                    <img class="imgMenu-icon" src="images/folder1.png" alt="img">
                    <p class="font-boxMenu white-text ">แฟ้มส่วนตัว</p>
                  </a>
                </div>
                <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                    <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position boxsize-menu p-0" href="private_floder.php" role="button">
                      <img class="imgMenu-icon" src="images/folder1.png" alt="img">
                      <p class="font-boxMenu white-text ">แฟ้มส่วนตัว</p>
                    </a>
                  </div> -->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-12">
              <!-- แคปชา -->
              <div class="col-12 text-center">
                <div class="mb-3 mt-3 form-check txt-center">
                  <input type="checkbox" name="policy_check" id="policy_check" checked>
                  <label class="form-check-label" for="policy_check">
                    <a href="assets/download/policy.pdf" target="_blank">
                      ยินยอมนโยบายการเก็บข้อมูลของกรมส่งเสริมอุตสาหกรรม </a>
                  </label>
                </div>
                <div class="txt-center mb-5">
                  <button type="submit" class="btn btn-success text-white btn-radius"> บันทึกการเปลี่ยนแปลงข้อมูล </button>
                </div>
              </div>
            </div>
          </div>
        </div>



      </div>
    </div>
  </form>
</div>
<script>
$(document).ready(function(){
  var selectedVal = $('#PER_TYPE').val();
  console.log("PER_TYPE selected value:", selectedVal);
  
  if (selectedVal == '1') {
  $('#pos_name').prop('disabled', false);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', false);
} else if (selectedVal == '2') {
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', true);
}else if(selectedVal == '3'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', false);
}else if(selectedVal == '4'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', true);
}else if(selectedVal == '5'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', true);
}else if(selectedVal == '6'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', true);
}else if(selectedVal == '7'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', true);
  $('#level_name').prop('disabled', true);
}


  $('#PER_TYPE').on('change', function() {
    if (this.value == '1') {
  $('#pos_name').prop('disabled', false);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', false);
} else if (this.value == '2') {
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', true);
}else if(this.value == '3'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', false);
}else if(this.value == '4'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', true);
}else if(this.value == '5'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', true);
}else if(this.value == '6'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', false);
  $('#level_name').prop('disabled', true);
}else if(this.value == '7'){
  $('#pos_name').prop('disabled', true);
  $('#position_person').prop('disabled', true);
  $('#level_name').prop('disabled', true);
}
  });
  
  $('#PER_TYPE').trigger('change');
});
</script>
<script>
  $(document).ready(function() {
    $("#profile_form").on("submit", function(event) {
      event.preventDefault();
      let formData = new FormData($(this)[0]);
      let policy_check = document.getElementById("policy_check").checked;

      if (policy_check == true) {
        $.ajax({
          url: "func_edit_profile.php",
          data: formData,
          processData: false,
          contentType: false,
          type: "POST",
          success: function(data) {
            let object = JSON.parse(data, true);
            console.log(object);
            if (object.message !== null) {
              $.alert({
                title: object.message,
                content: 'Success!',
                icon: 'fa fa-check-circle',
                theme: 'modern',
                type: 'green',
                typeAnimated: true,
                boxWidth: '30%',
                buttons: {
                  ok: {
                    btnClass: 'btn-green'
                  }
                },
                onAction: function() {
                  location.reload(true);
                }
              });
            } else {
              $.alert({
                title: object.message,
                content: 'Error!',
                icon: 'fa fa-times-circle',
                theme: 'modern',
                type: 'red',
                typeAnimated: true,
                boxWidth: '30%',
                buttons: {
                  ok: {
                    btnClass: 'btn-red'
                  }
                },
                onAction: function() {
                  location.reload(true);
                }
              });
            }

            if (object.status == "captchaFailed") {
              $('#chkpic1_edit_profile').focus();
            } else if (object.status == "emailFailed" && $('#email_person').val() !== null) {
              $('#email_person').focus();
              $('#validation_email').show();
            } else if (object.status == "phoneFailed" && $('#tel_in').val() !== null) {
              $('#tel_in').focus();
              $('#validation_phone').show();
            } else if (object.status == "success") {
              //window.location.reload();
            }
          },
          error: function(data) {
            // console.log(data);
          }
        });
      } else {
        $.alert({
          title: 'กรุณาติ๊กยินยอมนโยบายการเก็บข้อมูลของกรมประชาสัมพันธ์',
          content: "Warning!",
          icon: 'fa fa-exclamation-circle',
          theme: 'modern',
          type: 'orange',
          closeIcon: false,
          buttons: {
            ok: {
              btnClass: 'btn-orange'
            }
          },
          onAction: function() {
            location.reload(true);
          }
        });
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    var deptId = $('#afft_name').val();
    var parentId = $('#name_org').val();
    var prevVal = '';

    // call the function and pass the value of $result['DEP_LV2_ID']
    getDepartment(deptId, parentId, prevVal, '<?php echo $result["DEP_LV2_ID"] ?>');
  });
</script>

<script>
function getDepartment(deptId, parentId, prevVal, dept2) {
    $.ajax({
      url: 'get_workgroups.php',
      dataType: 'json',
      type: 'get',
      data: {dept_id: deptId, parent_id: parentId, prev_val: prevVal},
      success: function(data) {
        var options = '<option value="" disabled selected>โปรดระบุกลุ่มงาน</option>';
        for (var key in data) {
          options += '<option value="' + key + '"  '+ (dept2 == key ? 'selected' : '') +'>' + data[key] + '</option>';
        }
        $('#name_org').html(options);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
}
</script>



<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>
<!-- Include file js and properties -->