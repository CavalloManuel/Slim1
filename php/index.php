<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/controllers/CertificazioniController.php';

$app = AppFactory::create();

//ALUNNI

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



//CERTIFICAZIONI

// curl http://localhost:8080/alunni/1/certificazioni
$app->get('/alunni/{id:\d+}/certificazioni', "CertificazioniController:index"); 

// curl http://localhost:8080/alunni/1/certificazioni/1
$app->get('/alunni/{id:\d+}/certificazioni/{id_cert:\d+}', "CertificazioniController:show");

// curl -X POST http://localhost:8080/alunni/2/certificazioni -H "Content-Type: application/json" -d '{"nome": "ciccio", "cognome": "bello"}'
$app->post('/alunni/{id:\d+}/cert', "CertificazioniController:create");

// curl -X PUT http://localhost:8080/alunni/2/certificazioni/3 -H "Content-Type: application/json" -d '{"nome": "ciccio", "cognome": "bello"}'
$app->put('/alunni/{id:\d+}/cert/{id_cert:\d+}', "CertificazioniController:update");

// curl -X DELETE http://localhost:8080/alunni/2/certificazioni/3
$app->delete('/alunni/{id:\d+}/cert/{id_cert:\d+}', "CertificazioniController:destroy");


$app->run();
