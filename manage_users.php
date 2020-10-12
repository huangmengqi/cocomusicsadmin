<?php include('includes/header.php'); 

    include('includes/function.php');
	include('language/language.php');  


	if(isset($_POST['user_search']))
	 {
		 
		
		$user_qry="SELECT * FROM tbl_users WHERE tbl_users.name like '%".addslashes($_POST['search_value'])."%' or tbl_users.email like '%".addslashes($_POST['search_value'])."%' ORDER BY tbl_users.id DESC";  
							 
		$users_result=mysqli_query($mysqli,$user_qry);
		
		 
	 }
	 else
	 {
	 
		$tableName="tbl_users";		
		$targetpage = "manage_users.php"; 	
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


		$users_qry="SELECT * FROM tbl_users
		ORDER BY tbl_users.id DESC LIMIT $start, $limit";  

		$users_result=mysqli_query($mysqli,$users_qry);
							
	}
	 
	
?>


 <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Users</div>
            </div>
            <div class="col-md-7 col-xs-12">              
                  <div class="search_list">
                    <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" value="<?php if(isset($_POST['user_search'])){ echo $_POST['search_value'];} ?>" required>
                        <button type="submit" name="user_search" class="btn-search"><i class="fa fa-search"></i></button>
                      </form>  
                    </div>
                    <div class="add_btn_primary"> <a href="add_user.php?add">Add User</a> </div>
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
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>						 
				  <th>Email</th>
				  <th>Phone</th>
				  <th>Status</th>					   
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php
					$i=0;
					while($users_row=mysqli_fetch_array($users_result))
					{	 
				?>
                <tr>
                   <td><?php echo $users_row['name'];?></td>
		           <td><?php echo $users_row['email'];?></td>   
		           <td><?php echo $users_row['phone'];?></td>
		           <td>
	                  <?php if($users_row['status']!="0"){?>
	                    <a title="Change Status" class="toggle_btn_a" href="javascript:void(0)" data-id="<?=$users_row['id']?>" data-action="deactive" data-column="status"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Enable</span></span></a>

	                  <?php }else{?>
	                    <a title="Change Status" class="toggle_btn_a" href="javascript:void(0)" data-id="<?=$users_row['id']?>" data-action="active" data-column="status"><span class="badge badge-danger badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Disable </span></span></a>
	                  <?php }?>
	               </td>
		           <td nowrap="">
	                   	<a href="add_user.php?user_id=<?php echo $users_row['id'];?>" target="_blank" class="btn btn-primary btn_delete" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a>
	                    <a href="" data-id="<?php echo $users_row['id'];?>" data-toggle="tooltip" data-tooltip="Delete" class="btn btn-danger btn_delete btn_delete_a">
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



<?php include('includes/footer.php');?>                  

<script type="text/javascript">

	$(".toggle_btn_a").on("click",function(e){
	    e.preventDefault();
	    
	    var _for=$(this).data("action");
	    var _id=$(this).data("id");
	    var _column=$(this).data("column");
	    var _table='tbl_users';

	    $.ajax({
	      type:'post',
	      url:'processData.php',
	      dataType:'json',
	      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'id'},
	      success:function(res){
	          console.log(res);
	          if(res.status=='1'){
	            location.reload();
	          }
	        }
	    });

	  });

	$(".btn_delete_a").on("click",function(e){

		var _id=$(this).data("id");

	    if(confirm("Are you sure you want to delete this user?")){
          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_id,'action':'removeData','tbl_nm':"tbl_users","tbl_id":"id"},
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