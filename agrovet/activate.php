<?php
/**
 * Created by PhpStorm.
 * User: steve muema
 * Date: 9/22/2018
 * Time: 12:25 AM
 */
include "dbconnector.php";
$connection->AccountActivate("wakulimaconnectagrovetcustomers", $_GET['hash'], "index.php");