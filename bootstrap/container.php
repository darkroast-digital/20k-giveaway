<?php

/*
|--------------------------------------------------------------------------
| #CONTAINER
|--------------------------------------------------------------------------
*/



// #BOOT CONTAINER
// =========================================================================

$container = $app->getContainer();



// #FLASH
// =========================================================================

$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages;
};



// #VIEWS
// =========================================================================

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => $container->settings['views']['cache']
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');

    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    $view->getEnvironment()->addGlobal('flash', $container['flash']);
    $view->getEnvironment()->addGlobal('url', $container->settings['url']);

    return $view;
};

$twig = $container->view->getEnvironment();
