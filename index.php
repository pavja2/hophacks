<?php

// put full path to Smarty.class.php
require('/var/www/smarty/Smarty.class.php');
require_once '/var/www/vendor/autoload.php';

// setup Propel
require_once '/var/www/vendor/propel/schemas/generated-conf/config.php';
$smarty = new Smarty();
if(!isset($_COOKIE['user_id'])){
$smarty->display('index.tpl');
}
else{
    $userQuery = new UserQuery();
    $user = $userQuery->findPK($_COOKIE['user_id']);
    $smarty->assign('username', $user->getUsername());
    $smarty->assign('firstName', $user->getFirstName());
    $smarty->assign('lastName', $user->getLastName());
    $campaignQuery = CampaignQuery::create()->filterByUserId($user->getId())->find();
    $smarty->assign('goalList', $campaignQuery);
    $smarty->display('my_profile.tpl');
}
