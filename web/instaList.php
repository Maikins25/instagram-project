<?php

/*************************************************************************************************
 * permitList.php
 *
 * Content page to display a list of applications. This page is expected to be contained within
 * index.php.
 *************************************************************************************************/

?>

<script>
    function editApplication(id) {
        location.href = 'index.php?content=post&id=' + id;
    }
</script>

<table class='table table-bordered table-hover'>
    <thead>
        <tr class="table-dark">
           
        </tr>
    </thead>
    <tbody class="table-group-divider">

   
    </tbody>
</table>



<a href='index.php?content=post' class='btn btn-primary' role='button'><i class='fa fa-plus-circle' aria-hidden='true'></i>&nbsp;Make A post</a>
<?php


$sql = <<<SQL
    SELECT user_id
    FROM users
    WHERE user_id = $user
  
SQL;


