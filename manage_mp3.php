<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

    if(isset($_POST['data_search']))
    {
      $mp3_qry="SELECT * FROM tbl_mp3
                LEFT JOIN tbl_category ON tbl_mp3.`cat_id`= tbl_category.`cid` 
                WHERE tbl_mp3.`mp3_title` like '%".addslashes($_POST['mp3_title'])."%'  
                ORDER BY tbl_mp3.mp3_title";

      $result=mysqli_query($mysqli,$mp3_qry);

    }

    else if(isset($_GET['f_category'])){

      $cat_id=trim($_GET['f_category']);

      $tableName="tbl_mp3";   
      $targetpage = "manage_mp3.php?f_category=".$cat_id; 
      $limit = 12; 
      
      $query = "SELECT COUNT(*) as num FROM $tableName WHERE cat_id='$cat_id'";
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
      
      $sql="SELECT * FROM tbl_mp3
                LEFT JOIN tbl_category ON tbl_mp3.`cat_id`= tbl_category.`cid` 
                WHERE tbl_mp3.`cat_id`='$cat_id'
                ORDER BY tbl_mp3.`id` DESC LIMIT $start, $limit";
 
      $result=mysqli_query($mysqli,$sql); 

   }

   else
   {

	   //Get all mp3 
	
      $tableName="tbl_mp3";   
      $targetpage = "manage_mp3.php"; 
      $limit = 12; 
      
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
      
     $mp3_qry="SELECT * FROM tbl_mp3
                  LEFT JOIN tbl_category ON tbl_mp3.cat_id= tbl_category.cid 
                  ORDER BY tbl_mp3.id DESC LIMIT $start, $limit";
 
     $result=mysqli_query($mysqli,$mp3_qry); 
	 }

  function get_total_songs($cat_id)
  { 

    global $mysqli;   
    $qry_songs="SELECT COUNT(*) as num FROM tbl_mp3 WHERE cat_id='".$cat_id."'";
    $total_songs = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
    $total_songs = $total_songs['num'];
    return $total_songs;

  }


?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Mp3</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                <form  method="post" action="">
                        <input class="form-control input-sm" placeholder="Search songs..." aria-controls="DataTables_Table_0" type="search" value="<?php if(isset($_POST['data_search'])){ echo $_POST['mp3_title'];} ?>" name="mp3_title" required>
                        <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                </form>
              </div>
                <div class="add_btn_primary"> <a href="add_mp3.php">Add Mp3</a> </div>
              </div>
            </div>

            <div class="col-md-8">
              <h4 style="float: left;">Filter: |</h4>
                <div class="search_list" style="padding: 0px 0px 5px;float: left;margin-left: 20px">
                    <select name="f_category" class="form-control f_category" style="padding: 5px 10px;height: 40px;">
                      <option value="">All Category</option>
                      <?php
                        $sql="SELECT * FROM tbl_category ORDER BY category_name";
                        $res=mysqli_query($mysqli,$sql);
                        while($row=mysqli_fetch_array($res))
                        {
                      ?>                       
                      <option value="<?php echo $row['cid'];?>" <?php if(isset($_GET['f_category']) && $_GET['f_category']==$row['cid']){echo 'selected';} ?>><?php echo $row['category_name'],' ('.get_total_songs($row['cid']).')';?></option>                           
                      <?php
                        }
                        mysqli_free_result($row);
                      ?>
                    </select>
                    
                </div>
            </div>

            <div class="col-md-3 col-xs-12" style="float: right;width: 18%">
                <div class="checkbox">
                  <input type="checkbox" name="checkall" id="checkall" value="">
                  <label for="checkall">Select All</label>
                  <button type="submit" class="btn btn-danger btn_delete" name="delete_rec" value="delete_wall">Delete</button>
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
                  <div class="wall_category_block">
                    <h2>
                      <?php 
                        if(strlen($row['category_name']) > 18){
                          echo mb_substr(stripslashes($row['category_name']), 0, 17).'...';  
                        }else{
                          echo $row['category_name'];
                        }
                      ?>
                    </h2>  

                    <div class="checkbox" style="float: right;">
                      <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $row['id']; ?>" class="post_ids">
                      <label for="checkbox<?php echo $i;?>">
                      </label>
                    </div>

                  </div>
                  <div class="wall_image_title">
                    <p>
                      <?php 
                        if(strlen($row['mp3_title']) > 30){
                          echo mb_substr(stripslashes($row['mp3_title']), 0, 29).'...';  
                        }else{
                          echo $row['mp3_title'];
                        }
                      ?>
                    </p>
                    <ul>
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['total_views'];?> Views"><i class="fa fa-eye"></i></a></li>                      
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['total_download'];?> Download"><i class="fa fa-download"></i></a></li>
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['rate_avg'];?> Rating"><i class="fa fa-star"></i></a></li>

                      <li><a href="edit_mp3.php?mp3_id=<?php echo $row['id'];?>" target="_blank" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>

                      <li>
                        <a href="" class="btn_delete_a" data-id="<?php echo $row['id'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                      </li>
                    </ul>
                  </div>
                  <span><img src="images/<?php echo $row['mp3_thumbnail'];?>" /></span>
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
                <?php if(!isset($_POST["data_search"])){ include("pagination.php");}?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>  

<script type="text/javascript">
  $(".btn_delete_a").click(function(e){
      e.preventDefault();

      var _ids = $(this).data("id");

      if(_ids!='')
      {
        if(confirm("Are you sure you want to delete this song?")){
          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_mp3'},
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

  $("button[name='delete_rec']").click(function(e){
      e.preventDefault();

      var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });

      if(_ids!='')
      {
        if(confirm("Are you sure you want to delete this songs?")){
          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_mp3'},
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
      else{
        alert("No songs selected");
      }
  });


  $("select[name='f_category']").on("change",function(e){
    if($(this).val()!='')
    {
      window.location.href="manage_mp3.php?f_category="+$(this).val();
    }else{
      window.location.href="manage_mp3.php";
    }
  });

</script>   

<script>
  $("#checkall").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script>    
