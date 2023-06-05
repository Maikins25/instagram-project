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
    <img src="">
</div>
<div class="imageSelector">
  <label for="image">Select an image:</label>
  <input type="file" id="image" name="image">
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

