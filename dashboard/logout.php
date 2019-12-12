<?php
session_start();

include("inc/db.php");
include("inc/global_vars.php");
include("inc/functions.php");

session_destroy();

go("https://ukmarketingclub.com/");