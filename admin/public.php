<?php

//https://gc2023.com.br
$server = 'http://localhost/gc2023';


ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

require 'init.php';

$route = $_REQUEST['_ROUTE_'] ?? 'Home';

$routes = [
    'home' => 'Home',
    'contato' => 'Contato',
    'galeria' => 'Galeria'
];

$controller = $routes[$route] ?? 'P404View';

$content = AdiantiCoreApplication::execute($controller, 'getContent', []);        
$base = file_get_contents('app/resources/site/components/base.html');
$base = str_replace( '{CONTENT}', $content, $base );
$base = str_replace('{SERVER_URL}', $server, $base);
$base = str_replace('{BASE_URL}', $server.'\/admin/', $base);
$base = str_replace('{HOME_URL}', $server.'/home', $base);

echo $base;

