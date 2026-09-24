<?php

include "db.php";

if (isset($_GET['email']) && isset($_GET['v_code'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $v_code = mysqli_real_escape_string($conn, $_GET['v_code']);

    $query = "SELECT * FROM `vendors` WHERE `email` = '$email' AND `verification_code` = '$v_code'";
    // $query = "SELECT * FROM `registered_users` WHERE `email` = '$email' AND `verification_code` = '$v_code'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);

            if ($result_fetch['is_verified'] == 'Not Joined') {
                $update = "UPDATE `vendors` SET `is_verified`='Joined' WHERE `email` = '$result_fetch[email]'";
                // $update = "UPDATE `registered_users` SET `is_verified`='1' WHERE `email` = '$result_fetch[email]'";
                if (mysqli_query($conn, $update)) {
                    echo "<script> 
                            alert('Email verification successful');
                             window.location.href = 'index.php';
                        </script>";    
                } else {
                    echo "<script> 
                            alert('Cannot Run Update Query');
                            window.location.href = 'index.php';
                        </script>";
                }
            } else {
                echo "<script> 
                        alert('Email already verified');
                        window.location.href = 'index.php';
                    </script>";    
            }
        } else {
            echo "<script> 
                    alert('Invalid verification code or email');
                    window.location.href = 'index.php';
                </script>";
        }
    } else {
        echo "<script> 
                alert('Cannot Run Select Query');
                window.location.href = 'index.php';
            </script>";
    }
} else {
    echo "<script> 
            alert('Invalid Access');
            window.location.href = 'index.php';
        </script>";
}

?>
