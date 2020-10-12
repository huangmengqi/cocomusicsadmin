<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");
  
  function get_user_info($user_id)
   {
    global $mysqli;

     
    $user_qry="SELECT * FROM tbl_users where id='".$user_id."'";
    $user_result=mysqli_query($mysqli,$user_qry);
    $user_row=mysqli_fetch_assoc($user_result);

    return $user_row;
   }
    
  // Get page data
  $tableName="tbl_reports";    
  $targetpage = "manage_reports.php";  
  $limit = 15; 
  
  $query = "SELECT COUNT(*) as num FROM $tableName";
  $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
  $total_pages = $total_pages['num'];
  
  $stages = 3;
  $page=0;
  if(isset($_GET['page'])){
  $page = mysqli_real_escape_string($mysqli,$_GET['page']);
  }
  if($page){
    $start = ($page - 1) * $limit; 
  }else{
    $start = 0; 
    }


   $qry="SELECT tbl_reports.*,tbl_mp3.mp3_title FROM tbl_reports
LEFT JOIN tbl_mp3 ON tbl_reports.song_id= tbl_mp3.id ORDER BY tbl_reports.id DESC LIMIT $start, $limit";   
  $result=mysqli_query($mysqli,$qry);
 
  
  if(isset($_GET['report_id']))
  {
    Delete('tbl_reports','id='.$_GET['report_id'].'');

    $_SESSION['msg']="12";
    header( "Location:manage_reports.php");
    exit;
     
  } 
   
?>
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Songs Reports</div>
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
          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Song Title</th>
                  <th>Report</th> 
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php
  						    $i=0;
  						    while($row=mysqli_fetch_array($result))
  						    {
						 
				        ?>
                <tr>
                  <td><?php echo get_user_info($row['user_id'])['name'];?></td>
                  <td><?php echo get_user_info($row['user_id'])['email'];?></td>
                  <td><?php echo $row['mp3_title'];?></td>
                  <td><?php echo $row['report'];?></td>                  
                  <td nowrap="">
                      <a href="" data-id="<?php echo $row['id'];?>" data-toggle="tooltip" data-tooltip="Delete" class="btn btn-danger btn_delete btn_delete_a">
                        <i class="fa fa-trash"></i>
                      </a>
                </td>
                </tr>
               <?php
						
						$i++;
						}
			   ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
              	<?php if(!isset($_POST["search"])){ include("pagination.php");}?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>            
               
        
<?php include("includes/footer.php");?>  

<script type="text/javascript">
  $(".btn_delete_a").on("click",function(e){

    var _id=$(this).data("id");

      if(confirm("Are you sure you want to delete this report?")){
          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_id,'action':'removeData','tbl_nm':"tbl_reports","tbl_id":"id"},
            success:function(res){
                console.log(res);
                if(res.status=='1'){
                  location.reload();
                }
                else if(res.status=='-2'){
                  alert(res.message);
                }
              }
          });
        }
  });
</script>     
