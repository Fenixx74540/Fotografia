<!DOCTYPE html>
<html>
<body>

<?php

$ftp_server = "153.92.6.140";
$ftp_username = "u781260265.galeria";
$ftp_userpass = "zaq1@WSX";

// set up basic ssl connection
$ftp = ftp_ssl_connect($ftp_server);

// login with username and password
$login_result = ftp_login($ftp, $ftp_username, $ftp_userpass);

if (!$login_result) {
    // PHP will already have raised an E_WARNING level message in this case
    die("can't login");
}

echo ftp_pwd($ftp);

// close the ssl connection
ftp_close($ftp);
?>

</body>
</html>
