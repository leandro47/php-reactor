<?php

$streamlist = [
    stream_socket_client('tcp://localhost:8080'),
    fopen('file.txt', 'r'),
    fopen('file2.txt', 'r'),
];

fwrite($streamlist[0], 'GET /http-server.php HTTP/1.1' . PHP_EOL . PHP_EOL);

foreach ($streamlist as $stream) {
    stream_set_blocking($stream, false);
}

do {
    $copyReadStream = $streamlist;
    $numstreams = stream_select($copyReadStream, $write, $except, 0, 200000);
    
    if ($numstreams === 0) {
        continue;
    }
    
    foreach ($copyReadStream as $key => $stream) {
       $content = stream_get_contents($stream);
       $positionEndHttp = strpos($content, "\r\n\r\n");
       if ($positionEndHttp !== false) {
           echo substr($content, $positionEndHttp + 4);
       } else {
           echo $content . PHP_EOL;
       }
        unset($streamlist[$key]);
    }

} while (!empty($streamlist));

echo "Li todos os arquivos" . PHP_EOL;