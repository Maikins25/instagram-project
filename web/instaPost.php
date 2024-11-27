<script>
function loadFile(event) {
    var preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.onload = function() {
      URL.revokeObjectURL(preview.src) // free memory
    }
  };
</script>    
<?php

if(isset($user)){



  
  /*************************************************************************************************
   * permitDetail.php
   *
   * Content page to display the detail form for a single application. This page is expected to be
   * contained within index.php.
   *************************************************************************************************/
  
  
  
  $dbh = get_database_connection();
  
  
  ?>


  <form class="createProfileForm" style="margin-top:20px;" action="save.php" method="POST" enctype='multipart/form-data'>
    <div class="imageDiv">
      <img id="preview" class="post-img" />
    </div>
    <div class="imageSelector">
      <label for="image">Select an image:</label>
      <input type="file" placeholder="Upload Image" name="image" id="fileToUpload" onchange="loadFile(event)">
    </div>
    <br>
    
    <div class="postCaption">
      <label for="caption"> Type your caption</label>
      <input type="text" id="caption" name="caption"> 
      
      
      <?php



$dbh->close();

?>
    </select>
 
  <div class="buttons">
    <button type="submit" class="btn btn-primary">Save</button>
    <a style="margin-top:10px;" href="index.php?content=feed" class=" btn btn-secondary" role="button">Cancel</a>
  </div>
  <?php

if (isset($id))
{
  echo '<div class="center">';
  echo '<a href="javascript:deleteApplication(' . $id . ')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>';
  echo '</div>';
}

}else{

  
  
  
  echo'<div class="notLoggedIn">';
    echo'<h1>Not Logged In</h1>';
    
    echo'<h3>You can not view content on this page. </h3>';
    echo'<h3>Please <a class="signUp" href="index.php?content=Login"> Log In </a>';
    echo'If you have an account, or ';
    echo'<a class="signUp" href="index.php?content=Register"> Sign Up</a> if you dont have one.</h3>';
    
    
    echo'</div>';
  }
?>

<div class="center">
  </div>
</form>

</div>