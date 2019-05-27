<?php
include "../dbconnector.php";
if (isset($_POST['file'])) {
    $connection->sudoer();
} else {
    echo "null";
}
?>
<html>
<head></head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    <input name="file" type="file" required>
    <input name="name" type="text" required title="name">
    <button type="submit">submit</button>


</form>
</body>
</html>
