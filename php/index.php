<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

// curl http://localhost:8080/alunni
$app->get('/alunni', "AlunniController:index");

// curl http://localhost:8080/alunni/2
$app->get('/alunni/{id:\d+}', "AlunniController:show");  //mostro alunno con id specifico

// curl -X POST http://localhost:8080/alunni -H "Content-Type: application/json" -d '{"nome": "ciccio", "cognome": "bello"}'
$app->post('/alunni', "AlunniController:create");  //aggiungo alunno

// curl -X PUT http://localhost:8080/alunni/2 -H "Content-Type: application/json" -d '{"nome": "ciccio", "cognome": "bello"}'
$app->put('/alunni/{id:\d+}', "AlunniController:update");  //aggiorno/modifico l'alunno

// curl -X DELETE http://localhost:8080/alunni/2
$app->delete('/alunni/{id:\d+}', "AlunniController:destroy");  //elimina alunno

$app->get('/search/alunni/{key}' , "AlunniController:search"); //ricerca

$app->get('/sort/alunni/{col}' , "AlunniController:sort"); //ordinamento

$app->run();
