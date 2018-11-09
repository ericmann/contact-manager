<?php declare(strict_types=1);
/**
 * Basic application handler and router. This file builds up the various
 * paths and mappings supported by the module and routes requests to
 * specific methods implemented in the `lesson.php` file for the module.
 */

namespace EAMann\ContactManager\Server;

use League\Route\Router;
use League\Route\Strategy\JsonStrategy;
use League\Route\Http\Exception\NotFoundException;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Zend\Diactoros\{ResponseFactory, ServerRequestFactory};
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/lesson.php';

session_start();

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$responseFactory = new ResponseFactory();
$strategy = new JsonStrategy($responseFactory);
$router   = (new Router)->setStrategy($strategy);

// Basic contact API

// Get all contacts
$router->map('GET', '/', function (ServerRequestInterface $request) : array {
    $queryParams = $request->getQueryParams();
    $offset = isset($queryParams['offset']) ? (int) $queryParams['offset'] : 0;
    $limit = isset($queryParams['limit']) ? (int) $queryParams['limit'] : 10;

    return Lesson\getAllContacts($offset, $limit);
});

// Create a new contact
$router->map('POST', '/', function (ServerRequestInterface $request) : object {
    return Lesson\createContact($request->getParsedBody());
});

// Search for a contact
$router->map('POST', '/search', function (ServerRequestInterface $request) : array {
    return Lesson\findContacts($request->getQueryParams());
});

// Get a specific contact
$router->map('GET', '/{id:number}', function (ServerRequestInterface $request, array $args) : object {
    return Lesson\getContact((int) $args['id']);
});

// Update a specific contact
$router->map('POST', '/{id:number}', function (ServerRequestInterface $request, array $args) : object {
    return Lesson\updateContact((int) $args['id']);
});

// Delete a specific contact
$router->map('DELETE', '/{id:number}', function (ServerRequestInterface $request, array $args) : bool {
    return Lesson\deleteContact((int) $args['id']);
});

// Authentication API

$router->map('POST', '/register', function (ServerRequestInterface $request) : void {
    $body = $request->getParsedBody();
    $username = $body['username'] ?? null;
    $password = $body['password'] ?? null;

    Lesson\register($username, $password);
});

$router->map('POST', '/login', function (ServerRequestInterface $request) : void {
    $body = $request->getParsedBody();
    $username = $body['username'] ?? null;
    $password = $body['password'] ?? null;

    Lesson\login($username, $password);
});

// Additional API Methods

// Make Chrome happy ...
$router->map('GET', 'favicon.ico', function (ServerRequestInterface $request) : ResponseInterface {
   throw new NotFoundException();
});

$response = $router->dispatch($request);

// send the response to the browser
(new SapiEmitter)->emit($response);