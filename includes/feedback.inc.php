<?php
if (isset($_POST['feed_but'])) {
    require '../helpers/init_conn_db.php';
    $email = $_POST['email'];
    $q1 = $_POST['1'];
    $q2 = $_POST['2'];
    $q3 = $_POST['3'];
    // $q3 = $_POST['3'];
    $stars = $_POST['stars'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../feedback.php?error=invalidemail');
        exit();
    }
    $sql = 'INSERT INTO feedback (email, q1, q2, q3, rate) VALUES (?, ?, ?, ?, ?)';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: ../feedback.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'ssssi', $email, $q1, $q2, $q3, $stars);
        if (mysqli_stmt_execute($stmt)) {
            // If the query is successful, redirect to feedback.php with the success parameter
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: ../feedback.php?error=success');
            exit();
        } else {
            // If there was an error executing the query, handle the error
            $error_message = mysqli_stmt_error($stmt); // Get the error message
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            // Redirect to an error page or display an error message
            header('Location: ../error.php?message=' . urlencode($error_message));
            exit();
        }
    }
} else {
    header('Location: ../feedback.php');
    exit();
}
?>
