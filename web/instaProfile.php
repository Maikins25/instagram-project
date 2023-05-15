<form action="saveProfile.php" method="POST" enctype='multipart/form-data'>
    <label for="profilePicture">Select a Profile Picture:</label>
    <input type="file" id="profilePicture" name="profilePicture">

    <br>

    <label for="Bio">About you</label>
    <input type="text" id="Bio" name="Bio"> 

    
    <?php
    include('library.php');


    $dbh->close();

    ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    <?php

   

    ?>
        <a href="index.php?content=list" class="btn btn-secondary" role="button">Cancel</a>
    </form>