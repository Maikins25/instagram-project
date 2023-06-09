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

/*************************************************************************************************
 * permitDetail.php
 *
 * Content page to display the detail form for a single application. This page is expected to be
 * contained within index.php.
 *************************************************************************************************/



$dbh = get_database_connection();


?>



<form action="save.php" method="POST" enctype='multipart/form-data'>
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
    </div>
    <div class="buttons">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="index.php?content=feed" class="btn btn-secondary" role="button">Cancel</a>
</div>
<?php

if (isset($id))
{
    echo '<div class="center">';
    echo '<a href="javascript:deleteApplication(' . $id . ')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>';
    echo '</div>';
}

?>

<div class="center">
    </div>
</form>

