<?php

require __DIR__ . "/inc/bootstrap.php";
require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";

$a = 5; $b = $a + 1;
$uri = explode( '/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) );
$objFeedController = new UserController();

if ((isset($uri[$a]) && $uri[$a] != 'user') || !isset($uri[$b])) {
    $objFeedController->sendOutput(OutputBuilder::notFoundOutput());
    exit();
}

$objFeedController->{$uri[$b] . 'Action'}();

?>