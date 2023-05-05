<?php

/*************************************************************************************************
 * permitDetail.php
 *
 * Content page to display the detail form for a single application. This page is expected to be
 * contained within index.php.
 *************************************************************************************************/

session_start();
$user =  $_SESSION['userId'];

$dbh = get_database_connection();


?>



<form action="save.php" method="POST" enctype='multipart/form-data'>

  <label for="image">Select an image:</label>
  <input type="file" id="image" name="image">

<br>

 <label for="caption"> Type your caption</label>
<input type="text" id="caption" name="caption"> 

 
<?php



$dbh->close();

?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
<?php

if (isset($id))
{
    echo '<a href="javascript:deleteApplication(' . $id . ')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>';
}

?>
    <a href="index.php?content=list" class="btn btn-secondary" role="button">Cancel</a>
</form>

