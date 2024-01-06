<?php
require __DIR__ . "/inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
//echo json_encode( $uri );
$a = 5; $b = $a + 1;
if ((isset($uri[$a]) && $uri[$a] != 'user') || !isset($uri[$b])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
$objFeedController = new UserController();
$strMethodName = $uri[$b] . 'Action';
$objFeedController->{$strMethodName}();
//echo __DIR__;
?>