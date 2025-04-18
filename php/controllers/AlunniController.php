<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){     //index --> visualizzazione
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function show(Request $request, Response $response, $args){     //show --> visualizzazione con id dato
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni where id = " . $args["id"] . " "); 
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create(Request $request, Response $response, $args){     //create --> inserimento 
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $body = json_decode($request->getBody()->getContents(), true);  //prende i dati inseriti
    $nome = $body["nome"];
    $cognome = $body["cognome"];

    $result = $mysqli_connection->query("INSERT INTO alunni (nome, cognome) VALUES ('" . $nome ."' , '" . $cognome . "') "); 
    if($result)
      $mess = ["msg"=>"inserimento eseguito", "ret"=>true];
    else
      $mess = ["msg"=>"inserimento non eseguito", "ret"=>false];
    
    $response->getBody()->write(json_encode($mess));
    return $response;
  }

  public function update(Request $request, Response $response, $args){     //put --> aggiorna
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $body = json_decode($request->getBody()->getContents(), true);  //prende i dati inseriti
    $nome = $body["nome"];
    $cognome = $body["cognome"];

    $result = $mysqli_connection->query("UPDATE alunni SET nome = '$nome', cognome = '$cognome' WHERE id = " . $args["id"] . " "); 
    
    if($result)
      $mess = ["msg"=>"inserimento eseguito", "ret"=>true];
    else
      $mess = ["msg"=>"inserimento non eseguito", "ret"=>false];
    
    $response->getBody()->write(json_encode($mess));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function destroy(Request $request, Response $response, $args){     //delete --> elimina
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');



    $result = $mysqli_connection->query("DELETE FROM alunni WHERE id = " . $args["id"] . " "); 
    if($result)
      $mess = ["msg"=>"inserimento eseguito", "ret"=>true];
    else
      $mess = ["msg"=>"inserimento non eseguito", "ret"=>false];
    
    $response->getBody()->write(json_encode($mess));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function search(Request $request, Response $response, $args){     //search --> ricerca
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE (nome LIKE '%". $args["key"]."%' OR cognome LIKE '%". $args["key"]."%')");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function sort(Request $request, Response $response, $args){     //search --> ricerca
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    

    $found = false;
    $columns = $mysqli_connection->query("describe alunni")->fetch_all(MYSQLI_ASSOC); //query che fa vedere non solo il field(id, nome, cognome) ma anche type, key ecc..
    foreach($columns as $col){  //controllo se la colonna inserita esiste
      if($col["Field"] == $args["col"]){
        $found = true;
        break;
      }
    }

    if(!$found){ //se non esiste
      $response->getBody()->write("Colonna non trovata");
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }


    $results = $mysqli_connection->query("SELECT * FROM alunni ORDER BY " . $args["col"] . " ASC")->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

}

