<?php
require __DIR__ . "/inc/bootstrap.php";
$uri = explode( '/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) );

//echo json_encode( $uri );
$a = 5; $b = $a + 1;
if ((isset($uri[$a]) && $uri[$a] != 'user') || !isset($uri[$b])) {
    $objFeedController = new UserController();
    $objFeedController->sendOutput(OutputBuilder::notFoundOutput());
    exit();
}
require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
$objFeedController = new UserController();
$objFeedController->{$uri[$b] . 'Action'}();
//echo __DIR__;
?>