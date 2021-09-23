<?php 

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Message\ResponseInterface;

require_once 'vendor/autoload.php';

$client = new Client();

$resposta1 = $client->getAsync('http://localhost:8080/http-server.php');
$resposta2 = $client->getAsync('http://localhost:8000/http-server.php');

/**
 * @var ResponseInterface[] $respostas
 */
$respostas = Utils::unwrap([$resposta1, $resposta2]);

echo 'Resposta 1:' . $respostas[0]->getBody()->getContents();
echo 'Resposta 2:' . $respostas[1]->getBody()->getContents();