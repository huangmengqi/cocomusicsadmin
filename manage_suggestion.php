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
  $tableName="tbl_song_suggest";    
  $targetpage = "manage_suggestion.php";  
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


   $qry="SELECT * FROM tbl_song_suggest ORDER BY tbl_song_suggest.id DESC LIMIT $start, $limit";   
  $result=mysqli_query($mysqli,$qry);
 
  
  if(isset($_GET['suggest_id']))
  {
    Delete('tbl_song_suggest','id='.$_GET['suggest_id'].'');

    $_SESSION['msg']="12";
    header( "Location:manage_suggestion.php");
    exit;
     
  } 
   
?>

<link rel="stylesheet" type="text/css" href="assets/css/stylish-tooltip.css">

    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Songs Suggestion</div>
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
                  <th>Song Title</th>
                  <th>Image</th> 
                  <th>Message</th> 
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
                   <td><?php echo $row['song_title'];?></td>

                   <td nowrap="">
                    <?php 
                      if(file_exists('images/'.$row['song_image'])){
                    ?>
                    <span class="mytooltip tooltip-effect-3">
                      <span class="tooltip-item">
                        <img src="images/<?php echo $row['song_image'];?>" alt="no image" style="width: 50px;height: 60px;border-radius: 5px">
                      </span> 
                      <span class="tooltip-content clearfix">
                        <a href="images/<?php echo $row['song_image'];?>" target="_blank"><img src="images/<?php echo $row['song_image'];?>" alt="no image" /></a>
                      </span>
                    </span>
                    <?php }else{
                      ?>
                      <img src="" alt="no image" style="width: 50px;height: 60px;border-radius: 5px">
                      <?php
                    } ?>
                  </td>
                  <td><?php echo $row['message'];?></td> 

                  <td>
                    <a href="" class="btn btn-danger btn_delete btn_delete_a" data-id="<?php echo $row['id'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
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
  $('a[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'bottom',
    html: true
});

  $(".btn_delete_a").click(function(e){
      e.preventDefault();

      var _ids = $(this).data("id");

      if(_ids!='')
      {
        if(confirm("Are you sure you want to delete this suggestion?")){
          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_song_suggest'},
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
      }
  }); 

</script>          
