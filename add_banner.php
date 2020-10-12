<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

     $mp3_qry="SELECT * FROM tbl_mp3 ORDER BY tbl_mp3.id DESC"; 
     $mp3_result=mysqli_query($mysqli,$mp3_qry); 
	 
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
	
	   $banner_image=rand(0,99999)."_".$_FILES['banner_image']['name'];
		 	 
       //Main Image
	   $tpath1='images/'.$banner_image; 			 
       $pic1=compress_image($_FILES["banner_image"]["tmp_name"], $tpath1, 80);
	 
		//Thumb Image 
	   $thumbpath='images/thumbs/'.$banner_image;		
       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');    
          
       $data = array( 
 			   'banner_title'  =>  $_POST['banner_title'],
         'banner_sort_info'  =>  $_POST['banner_sort_info'],
			   'banner_image'  =>  $banner_image,
         'banner_songs'  =>  implode(',',$_POST['banner_songs'])
			    );		

 		$qry = Insert('tbl_banner',$data);	

 	    
		$_SESSION['msg']="10";
 
		header( "Location:manage_banners.php");
		exit;			 
		
	}
	
	if(isset($_GET['banner_id']))
	{
			 
			$qry="SELECT * FROM tbl_banner where bid='".$_GET['banner_id']."'";
			$result=mysqli_query($mysqli,$qry);
			$row=mysqli_fetch_assoc($result);

	}
	if(isset($_POST['submit']) and isset($_POST['banner_id']))
	{
		 
		 if($_FILES['banner_image']['name']!="")
		 {		


				$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_banner WHERE bid='.$_GET['banner_id'].'');
			    $img_res_row=mysqli_fetch_assoc($img_res);
			

			    if($img_res_row['banner_image']!="")
		        {
					unlink('images/thumbs/'.$img_res_row['banner_image']);
					unlink('images/'.$img_res_row['banner_image']);
			     }

 				   $banner_image=rand(0,99999)."_".$_FILES['banner_image']['name'];
		 	 
			       //Main Image
				   $tpath1='images/'.$banner_image; 			 
			       $pic1=compress_image($_FILES["banner_image"]["tmp_name"], $tpath1, 80);
				 
					//Thumb Image 
				   $thumbpath='images/thumbs/'.$banner_image;		
			       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');

                    $data = array(
 					    'banner_title'  =>  $_POST['banner_title'],
              'banner_sort_info'  =>  $_POST['banner_sort_info'],
					    'banner_image'  =>  $banner_image,
              'banner_songs'  =>  implode(',',$_POST['banner_songs'])
						);

					$category_edit=Update('tbl_banner', $data, "WHERE bid = '".$_POST['banner_id']."'");

		 }
		 else
		 {

					 $data = array(
 			          'banner_title'  =>  $_POST['banner_title'],
                'banner_sort_info'  =>  $_POST['banner_sort_info'],
                'banner_songs'  =>  implode(',',$_POST['banner_songs'])
						);	
 
			         $artist_edit=Update('tbl_banner', $data, "WHERE bid = '".$_POST['banner_id']."'");

		 }
 
		
		$_SESSION['msg']="11"; 
		header( "Location:add_banner.php?banner_id=".$_POST['banner_id']);
		exit;
 
	}


?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?php if(isset($_GET['banner_id'])){?>Edit<?php }else{?>Add<?php }?> Banner</div>
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
            	<input  type="hidden" name="banner_id" value="<?php echo $_GET['banner_id'];?>" />

              <div class="section">
                <div class="section-body">
               
                  <div class="form-group">
                    <label class="col-md-3 control-label">Banner Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="banner_title" id="banner_title" value="<?php if(isset($_GET['banner_id'])){echo $row['banner_title'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Banner Sort Info :-</label>
                    <div class="col-md-6">
                      <input type="text" name="banner_sort_info" id="banner_sort_info" value="<?php if(isset($_GET['banner_id'])){echo $row['banner_sort_info'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Banner Image :-
                    	<p class="control-label-help">(Recommended resolution: 300x300,400x400 or Square Image)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="banner_image" value="fileupload" id="fileupload">
                             
                        	  <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                        	 
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp; </label>
                    <div class="col-md-6">
                      <?php if(isset($_GET['banner_id']) and $row['banner_image']!="") {?>
                            <div class="block_wallpaper"><img src="images/<?php echo $row['banner_image'];?>" alt="image" /></div>
                          <?php } ?>
                    </div>
                  </div><br>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Songs :-</label>
                    <div class="col-md-6">
                      <select name="banner_songs[]" id="banner_songs" class="select2 form-control" required multiple="multiple">
                        <option value="">--Select Songs--</option>
                        <?php
                            while($mp3_row=mysqli_fetch_array($mp3_result))
                            {
                        ?>   
                        <?php if(isset($_GET['banner_id'])){?>

                           <option value="<?php echo $mp3_row['id'];?>" <?php $songs_list=explode(",", $row['banner_songs']);
                  foreach($songs_list as $song_id)
                {if($mp3_row['id']==$song_id){?>selected<?php }}?>><?php echo $mp3_row['mp3_title'];?></option>
                            
                          </option>   

                        <?php }else{?>  

                          <option value="<?php echo $mp3_row['id'];?>"><?php echo $mp3_row['mp3_title'];?></option>
                            
                        <?php }?>   
                         
                        <?php
                          }
                        ?>
                      </select>
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
