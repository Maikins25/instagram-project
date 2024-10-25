<?php
include('library.php');

$conn = get_database_connection();


$sql = <<<SQL
SELECT user_username, user_id, follow_id
    FROM users
    LEFT OUTER JOIN follow 
    ON follow_user_id = $user 
    AND follow_followed_user_id = user_id
    WHERE user_id <> $user
SQL;

$result = mysqli_query($conn, $sql);

$userArray = []; // Initialize an empty array

// Check if the query was successful
if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Build each user entry with whether they are followed
        $userArray[] = [
            'user_id' => $row['user_id'],
            'username' => $row['user_username'],
            'is_following' => $row['follow_id'] ? true : false
        ];
    }
} else {
    // Handle query failure
    echo 'Error: Could not retrieve users.';
}









if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Establish database connection
    $conn = get_database_connection();
    $image_path = 'profilePics/';
    // Search in the database (modify the query as per your database schema)
    $sql = "SELECT user_username, user_id FROM users WHERE user_username LIKE '%" . mysqli_real_escape_string($conn, $query) . "%'";
    $result = mysqli_query($conn, $sql);

    echo'<div class="resultDiv">';
    if (mysqli_num_rows($result) > 0) {
        // Output search results as a list
        while ($row = mysqli_fetch_assoc($result)) {
            // Find the corresponding user in the $userArray based on their user_id
            $userId = $row['user_id'];
            $isFollowing = false;
        
            // Check if the user is being followed
            foreach ($userArray as $user) {
                if ($user['user_id'] == $userId) {
                    $isFollowing = $user['is_following'];
                    break;
                }
            }
        
            echo '<div class="person">';
            echo '<h5><a href="index.php?content=Otherprofile&user_id=' . $row['user_id'] . '">';
            echo '<img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
            echo $row['user_username'];
        
            // Decide whether to show 'Follow' or 'Following' button
            if ($isFollowing) {
                echo '</a><button class="followingButton" id="follow' . $row['user_id'] . '" onclick="unfollow(' . $row['user_id'] . ')">Following</button>';
            } else {
                echo '</a><button class="followButton" id="follow' . $row['user_id'] . '" onclick="follow(' . $row['user_id'] . ')">Follow</button>';
            }
        
            echo '</div>';
        }
    } else {
        echo 'No results found';
    }
    echo'</div>';

    mysqli_close($conn);
}
?>
