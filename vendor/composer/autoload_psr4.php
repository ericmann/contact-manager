<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Zend\\HttpHandlerRunner\\' => array($vendorDir . '/zendframework/zend-httphandlerrunner/src'),
    'Zend\\Diactoros\\' => array($vendorDir . '/zendframework/zend-diactoros/src'),
    'Psr\\Http\\Server\\' => array($vendorDir . '/psr/http-server-handler/src', $vendorDir . '/psr/http-server-middleware/src'),
    'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-message/src', $vendorDir . '/psr/http-factory/src'),
    'Psr\\Container\\' => array($vendorDir . '/psr/container/src'),
    'League\\Route\\' => array($vendorDir . '/league/route/src'),
    'FastRoute\\' => array($vendorDir . '/nikic/fast-route/src'),
);