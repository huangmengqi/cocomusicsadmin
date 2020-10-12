<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  $qry="SELECT * FROM tbl_smtp_settings where id='1'";
  $result=mysqli_query($mysqli,$qry);
  $row=mysqli_fetch_assoc($result);

  if(isset($_POST['submit'])){

      $password='';
      if($_POST['smtp_password']!=''){
        $password=$_POST['smtp_password'];
      }else{
        $password=$row['smtp_password'];
      }

      $data = array(    
          'smtp_host'  =>  $_POST['smtp_host'],
          'smtp_email'  =>  $_POST['smtp_email'],
          'smtp_password'  =>  $password,
          'smtp_secure'  =>  $_POST['smtp_secure'],
          'port_no'  =>  $_POST['port_no']
        );
       

      $sql="SELECT * FROM tbl_smtp_settings WHERE id='1'";
      $res=mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

      if(mysqli_num_rows($res) > 0){
        $update=Update('tbl_smtp_settings', $data, "WHERE id = '1'");  
      }
      else{
        $insert=Insert('tbl_smtp_settings',$data);
      }

      $_SESSION['msg']="11";
      header( "Location:smtp_settings.php");
      exit;

  }

?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">SMTP Settings</div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
                 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?> 
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
               
              <div class="section">
                <div class="section-body">

                  <div class="form-group">
                    <label class="col-md-3 control-label">SMTP Host <span style="color: red">*</span>:-</label>
                    <div class="col-md-6">
                      <input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?=$row['smtp_host']?>" placeholder="mail.example.in" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Email <span style="color: red">*</span>:-</label>
                    <div class="col-md-6">
                      <input type="text" name="smtp_email" id="smtp_email" class="form-control" value="<?=$row['smtp_email']?>" placeholder="info@example.com" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">Password <span style="color: red">*</span>:-</label>
                    <div class="col-md-6">
                      <input type="password" name="smtp_password" id="smtp_password" class="form-control" value="" placeholder="********">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">SMTPSecure :-</label>
                    <div class="col-md-6">
                      <select name="smtp_secure" id="cat_id" class="select2" required>
                       <option value="tls" <?php if($row['smtp_secure']=='tls'){ echo 'selected';} ?>>TLS</option>
                       <option value="ssl" <?php if($row['smtp_secure']=='ssl'){ echo 'selected';} ?>>SSL</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Port No. <span style="color: red">*</span>:-</label>
                    <div class="col-md-6">
                      <input type="text" name="port_no" id="port_no" class="form-control" value="<?=$row['port_no']?>" placeholder="Enter Port No." required>
                    </div>
                  </div>

                </div>   
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
