<?php
    $client = new \swoole_client(SWOOLE_SOCK_TCP);
    if (!$client->connect('127.0.0.1', 9503,-1))
    {
        exit("connect failed. Error: {$client->errCode}\n");
    }
    $client->send("select * from users");
    echo $client->recv();
    $client->close();
?>