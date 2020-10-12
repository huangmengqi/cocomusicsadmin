<?php 
    include("includes/header.php");
    include("includes/function.php");

    $file_path = getBaseUrl().'api.php';
?>
<div class="row">
      <div class="col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
              Example API urls
            </div>
                <div class="card-body no-padding">
            
               <pre><code class="html">
                <br><b>API URL</b> <?php echo $file_path;?>

                <br><b>Home Videos</b> (Method: home)
                <br><b>All Songs</b> (Method: all_songs)(Parameter: page)
                <br><b>Latest Songs</b> (Method: latest)(Parameter: page)
                <br><b>Category List</b> (Method: cat_list)(Parameter: page)
                <br><b>Songs List By Cat ID</b> (Method: cat_songs)(Parameter: cat_id,page)
                <br><b>Recent Artist List</b> (Method: recent_artist_list)
                <br><b>Artist List</b> (Method: artist_list)(Parameter: page)
                <br><b>Artist Album List</b> (Method: artist_album_list)(Parameter: artist_id,page)
                <br><b>Songs List By Artist Name</b> (Method: artist_name_songs)(Parameter: artist_name,page)
                <br><b>Album List</b> (Method: album_list)(Parameter: page)
                <br><b>Songs List By Album ID</b> (Method: album_songs)(Parameter: album_id,page)
                <br><b>Playlist List</b> (Method: playlist)(Parameter: page)
                <br><b>Songs List By Playlist ID</b> (Method: playlist_songs)(Parameter: playlist_id,page)
                <br><b>Single Song</b> (Method: single_song)(Parameter: song_id,device_id)
                <br><b>Song Download </b> (Method: song_download)(Parameter: song_id)
                <br><b>Songs Search</b> (Method: song_search)(Parameter: search_text,search_type,page)(For Particualr : search_type=album,artist,songs)
                <br><b>Song Rating </b> (Method: song_rating)(Parameter: post_id,device_id,rate)
                <br><b>User Register</b>(Method: user_register)(Parameter:name,email,password,phone)
                <br><b>User Login</b>(Method: user_login)(Parameter:email,password)
                <br><b>User Profile</b>(Method: user_profile)(Parameter:user_id)
                <br><b>User Profile Update</b>(Method: user_profile_update)(Parameter:user_id,name,email,password,phone)
                <br><b>Forgot Password</b>(Method: forgot_pass)(Parameter:user_email)
                <br><b>Report Songs</b>(Method: song_report)(Parameter:user_id,song_id,report)
                <br><b>Song Suggestion</b>(Method: song_suggest)(Parameter:user_id,song_title,message,song_image)
                <br><b>App Details</b>(Method: app_details)
             </code></pre>
          
              </div>
            </div>
        </div>
</div>
    <br/>
    <div class="clearfix"></div>
        
<?php include("includes/footer.php");?>       
