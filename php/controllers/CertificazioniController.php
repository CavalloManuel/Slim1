<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CertificazioniController
{
    public function index(Request $request, Response $response, $args){    
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $result = $mysqli_connection->query("SELECT * FROM certificazioni where alunno_id = '" . $args['id'] . "'"); 
        $results = $result->fetch_all(MYSQLI_ASSOC);
    
        $response->getBody()->write(json_encode($results));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }

    public function show(Request $request, Response $response, $args){    
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $result = $mysqli_connection->query("SELECT * FROM certificazioni where alunno_id = '" . $args["id"] . "'AND id = '" . $args['id_cert'] . "'"); 
        $results = $result->fetch_all(MYSQLI_ASSOC);
    
        $response->getBody()->write(json_encode($results));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }

    public function create(Request $request, Response $response, $args){     //create --> inserimento 
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    
        $body = json_decode($request->getBody()->getContents(), true);  //prende i dati inseriti
        $nome = $mysqli_connection->real_escape_string($body["nome"]);
        $cognome = $mysqli_connection->real_escape_string($body["cognome"]);
    
        $result = $mysqli_connection->query("INSERT INTO alunni (nome, cognome) VALUES ('" . $nome ."' , '" . $cognome . "') "); 
        
        if ($result) {
            $response->getBody()->write(json_encode(["msg" => "Creazione eseguita"]));
            return $response->withHeader("Content-type", "application/json")->withStatus(201);
        } else {
            $response->getBody()->write(json_encode(["error" => "Creazione non andata a buon fine"]));
            return $response->withHeader("Content-type", "application/json")->withStatus(500);
        }
    }
    

    public function update(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $body = json_decode($request->getBody()->getContents(), true);  //prende i dati inseriti
        $nome = $mysqli_connection->real_escape_string($body["nome"]);
        $cognome = $mysqli_connection->real_escape_string($body["cognome"]);

        $result = $mysqli_connection->query("UPDATE alunni SET nome = '$nome', cognome = '$cognome' WHERE id = " . $args["id"] . " "); 
        
        if ($mysqli_connection->affected_rows > 0) {
            $response->getBody()->write(json_encode(["msg" => "Aggiornamento eseguito"]));
            return $response->withHeader("Content-type", "application/json")->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["error" => "Aggiornamento non andato a buon fine"]));
            return $response->withHeader("Content-type", "application/json")->withStatus(400);
        }
    }
    
    
    public function delete(Request $request, Response $response, $args){
        $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
        $result = $mysqli_connection->query("DELETE FROM alunni WHERE id = " . $args['id']. "");
    
        if ($mysqli_connection->affected_rows > 0) {
            $response->getBody()->write(json_encode(["msg" => "Eliminazione eseguita"]));
            return $response->withHeader("Content-type", "application/json")->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["error" => "Eliminazione non andata a buon fine"]));
            return $response->withHeader("Content-type", "application/json")->withStatus(400);
        }
    }
}