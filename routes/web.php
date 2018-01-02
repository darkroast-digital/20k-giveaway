<?php

/*
|--------------------------------------------------------------------------
| #WEB
|--------------------------------------------------------------------------
*/



use App\Controllers\FormController;
use App\Controllers\HomeController;
use App\Controllers\SiteController;
use App\Controllers\TempController;



// #HOME
// =========================================================================

$app->get('/', HomeController::class . ':index')->setName("home");
$app->post('/', HomeController::class . ':post');

$app->get('/count', SiteController::class . ':count')->setName("count");
$app->get('/submission', SiteController::class . ':form')->setName("form");
$app->get('/success', SiteController::class . ':success')->setName("success");
$app->post('/success', FormController::class . ':index')->setName("formSubmit");
$app->get('/sorry', SiteController::class . ':noSpots')->setName("noSpots");
$app->post('/sorry', FormController::class . ':subscribe')->setName("subscribeSubmit");

$app->post('/log', TempController::class . ':log')->setName("log");
$app->post('/log/delete', TempController::class . ':delete')->setName("log.delete");

// $app->get('/batchSend', SiteController::class . ':batchSend')->setName('batchSend');