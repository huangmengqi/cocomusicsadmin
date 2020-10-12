<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	require_once("thumbnail_images.class.php");

  $art_qry="SELECT * FROM tbl_artist ORDER BY artist_name";
  $art_result=mysqli_query($mysqli,$art_qry);
	 
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
	
	   $album_image=rand(0,99999)."_".$_FILES['album_image']['name'];
		 	 
       //Main Image
	   $tpath1='images/'.$album_image; 			 
       $pic1=compress_image($_FILES["album_image"]["tmp_name"], $tpath1, 80);
	 
		//Thumb Image 
	   $thumbpath='images/thumbs/'.$album_image;		
       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');   
 
          
       $data = array( 
 			   'album_name'  =>  $_POST['album_name'],
			   'album_image'  =>  $album_image,
         'artist_ids'  => implode(',', $_POST['artist_ids'])
			    );		

 		$qry = Insert('tbl_album',$data);	

 	    
		$_SESSION['msg']="10";
 
		header( "Location:manage_album.php");
		exit;	

		 
		
	}
	
	if(isset($_GET['album_id']))
	{
			 
			$qry="SELECT * FROM tbl_album where aid='".$_GET['album_id']."'";
			$result=mysqli_query($mysqli,$qry);
			$row=mysqli_fetch_assoc($result);

	}
	if(isset($_POST['submit']) and isset($_POST['album_id']))
	{
		 
		 if($_FILES['album_image']['name']!="")
		 {		


				$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_album WHERE aid='.$_GET['album_id'].'');
			    $img_res_row=mysqli_fetch_assoc($img_res);
			

			    if($img_res_row['album_image']!="")
		        {
					unlink('images/thumbs/'.$img_res_row['album_image']);
					unlink('images/'.$img_res_row['album_image']);
			     }

 				   $album_image=rand(0,99999)."_".$_FILES['album_image']['name'];
		 	 
			       //Main Image
				   $tpath1='images/'.$album_image; 			 
			       $pic1=compress_image($_FILES["album_image"]["tmp_name"], $tpath1, 80);
				 
					//Thumb Image 
				   $thumbpath='images/thumbs/'.$album_image;		
			       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');

                    $data = array(
 					    'album_name'  =>  $_POST['album_name'],
					    'album_image'  =>  $album_image,
              'artist_ids'  => implode(',', $_POST['artist_ids'])
						);

					$category_edit=Update('tbl_album', $data, "WHERE aid = '".$_POST['album_id']."'");

		 }
		 else
		 {

					 $data = array(
 			          'album_name'  =>  $_POST['album_name'],
                'artist_ids'  => implode(',', $_POST['artist_ids'])
						);	
 
			         $artist_edit=Update('tbl_album', $data, "WHERE aid = '".$_POST['album_id']."'");

		 }
 
		
		$_SESSION['msg']="11"; 
		header( "Location:add_album.php?album_id=".$_POST['album_id']);
		exit;
 
	}


?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?php if(isset($_GET['cat_id'])){?>Edit<?php }else{?>Add<?php }?> Album</div>
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
            	<input  type="hidden" name="album_id" value="<?php echo $_GET['album_id'];?>" />

              <div class="section">
                <div class="section-body">
               
                  <div class="form-group">
                    <label class="col-md-3 control-label">Album Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="album_name" id="album_name" value="<?php if(isset($_GET['album_id'])){echo $row['album_name'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Artist :-</label>
                    <div class="col-md-6">
                      <select name="artist_ids[]" id="artist_ids" class="select2 form-control" required multiple="multiple">
                        <option value="">--Select Artist--</option>
                        <?php
                            while($art_row=mysqli_fetch_array($art_result))
                            {
                        ?>                       
                        <option value="<?php echo $art_row['id'];?>" <?php if(in_array($art_row['id'], explode(",",$row['artist_ids']))){?>selected<?php }?>><?php echo $art_row['artist_name'];?></option>                           
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Album Image :-
                    	<p class="control-label-help">(Recommended resolution: 300x300,400x400 or Square Image)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="album_image" value="fileupload" id="fileupload">
                             
                        	  <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                        	 
                      </div>
                    </div>
                  </div>                  
                  <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp; </label>
                    <div class="col-md-6">
                      <?php if(isset($_GET['album_id']) and $row['album_image']!="") {?>
                            <div class="block_wallpaper"><img src="images/<?php echo $row['album_image'];?>" alt="image" /></div>
                          <?php } ?>
                    </div>
                  </div><br>
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
