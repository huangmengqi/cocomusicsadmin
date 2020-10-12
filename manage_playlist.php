<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");
    
    if(isset($_POST['search_data']))
   {
     
    
    $data_qry="SELECT * FROM tbl_playlist
               WHERE tbl_playlist.playlist_name like '%".addslashes($_POST['search_value'])."%' ORDER BY tbl_playlist.pid DESC";  
               
    $result=mysqli_query($mysqli,$data_qry);
    
     
   }
   else
   {
      
      $tableName="tbl_playlist";   
      $targetpage = "manage_playlist.php"; 
      $limit = 10; 
      
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
      
     $data_qry="SELECT * FROM tbl_playlist
                   ORDER BY tbl_playlist.pid DESC LIMIT $start, $limit";
 
     $result=mysqli_query($mysqli,$data_qry); 
   }

	
	if(isset($_GET['playlist_id']))
	{

	 
		$cat_res=mysqli_query($mysqli,'SELECT * FROM tbl_playlist WHERE pid=\''.$_GET['playlist_id'].'\'');
		$cat_res_row=mysqli_fetch_assoc($cat_res);


		if($cat_res_row['playlist_image']!="")
	    {
	    	unlink('images/'.$cat_res_row['playlist_image']);
			  unlink('images/thumbs/'.$cat_res_row['playlist_image']);

		}
 
		Delete('tbl_playlist','pid='.$_GET['playlist_id'].'');

      
		$_SESSION['msg']="12";
		header( "Location:manage_playlist.php");
		exit;
		
	}	 

?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Playlist</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="search_data" class="btn-search"><i class="fa fa-search"></i></button>
                      </form>  
                    </div>
                <div class="add_btn_primary"> <a href="add_playlist.php?add=yes">Add Playlist</a> </div>
              </div>
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
            <div class="row">
              <?php 
              $i=0;
              while($row=mysqli_fetch_array($result))
              {         
          ?>
              <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="block_wallpaper">           
                  <div class="wall_image_title">
                    <h2><a href="#"><?php echo $row['playlist_name'];?></a></h2>
                    <ul>                
                      <li><a href="add_playlist.php?playlist_id=<?php echo $row['pid'];?>" target="_blank" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>  

                      <li>
                        <a href="" class="btn_delete_a" data-id="<?php echo $row['pid'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                      </li>
                      
                      <?php if($row['status']!="0"){?>
                      <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['pid'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="" /></a></div></li>

                      <?php }else{?>
                      <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['pid'];?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="" /></a></div></li>
                      <?php }?>

                    </ul>
                  </div>
                  <span><img src="images/<?php echo $row['playlist_image'];?>" /></span>
                </div>
              </div>
          <?php
            
            $i++;
              }
        ?>     
               
      </div>
          </div>
           <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
                <?php if(!isset($_POST["search_data"])){ include("pagination.php");}?>            
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?> 

<script type="text/javascript">
  $(".toggle_btn a").on("click",function(e){
    e.preventDefault();
    
    var _for=$(this).data("action");
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_playlist';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'pid'},
      success:function(res){
          console.log(res);
          if(res.status=='1'){
            location.reload();
          }
        }
    });

  });

  $(".btn_delete_a").click(function(e){
      e.preventDefault();

      var _ids = $(this).data("id");

      if(_ids!='')
      {
        if(confirm("Are you sure you want to delete this playlist?")){
          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_playlist'},
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
