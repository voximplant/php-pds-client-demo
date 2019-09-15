<?php
set_time_limit(0);
$socket = stream_socket_server("tcp://0.0.0.0:3000", $errno, $errstr);
if (!$socket) {
  echo "$errstr ($errno)<br />\n";
} else {
  while ($conn = stream_socket_accept($socket, -1)) {
    $response = [
      'message' => ['TTTEEESSSTT'],
      'metadata' => [],
    ];
    fwrite($conn, json_encode($response));
//    fwrite($conn, 'Локальное время ' . date('n/j/Y g:i a') . "\n");
    fclose($conn);
  }
  fclose($socket);
}
