<?php

declare(strict_types=1);

use Swoole\Coroutine\PostgreSQL;

use function Swoole\Coroutine\run;

run(function () {
    $pg = new PostgreSQL();
    // 'pgsql:host=127.0.0.1;port=5432;dbname=postgres'
    $conn = $pg->connect('host=127.0.0.1 port=5432 dbname=postgres user=postgres password=example');
    if (!$conn) {
        var_dump($pg->error);
        return;
    }
    // $stmt = $pg->query('select * from pg_tables;');
    $stmt = $pg->query('SELECT version();');
    $stmt = $pg->query('SHOW search_path;');
    $stmt = $pg->query('select now();');
    $stmt = $pg->query('select * from information_schema.columns ');
    $stmt = $pg->query('SELECT * from  pg_stat_activity;');
    // $stmt = $pg->query('SELECT * FROM test;');
    $arr = $stmt->fetchAll();
    var_dump($arr);
});

# auth_user: postgres
# auth_password: example
