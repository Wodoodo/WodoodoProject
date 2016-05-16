<?php
    if (is_file('config.php')){
        require_once('config.php');
    }
    require_once(SYSTEM_DIRECTORY . 'db/mysqli.php');
    require_once(SYSTEM_DIRECTORY . 'controller.php');
    require_once(SYSTEM_DIRECTORY . 'model.php');
    require_once(SYSTEM_DIRECTORY . 'registry.php');
    require_once(SYSTEM_DIRECTORY . 'loader.php');
    require_once(SYSTEM_DIRECTORY . 'device_type.php');
    require_once(SYSTEM_DIRECTORY . 'function.php');
    $deviceType = new Mobile_Detect();

    if ($deviceType->isMobile() or $deviceType->isTablet()){
        $devicePrefix = '_mobile';
    } else {
        $devicePrefix = '';
    }

    $registry = new Registry();
    $loader = new Loader($registry);

    $db = new DB\Mysqli(HOST, USER, PASS, DB);

    $registry->set('db', $db);
    $registry->set('load', $loader);
    $registry->set('devicePrefix', $devicePrefix);

    if (isset($_SESSION['USER'])){
        $userHash = $db->escape($_SESSION['USER']);
        $date = date('Y-m-d H:i:s');
        $db->query("UPDATE `users` SET `last_activity` = '$date' WHERE `user_hash` = '$userHash'");
    }

    $loader->controller($_GET['route']);   
?>