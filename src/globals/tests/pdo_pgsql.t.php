<?php

declare(strict_types=1);

try {
    $dbh = new PDO('pgsql:dbname=postgres host=127.0.0.1 port=5432 ', 'postgres', 'example');

    $stmt = $dbh->prepare('SELECT version()');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($result);

    $stmt = $dbh->prepare('SELECT * from  pg_stat_activity');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($result);
    $dbh = null;
} catch (PDOException $e) {
    exit('Database connection failed: ' . $e->getMessage());
}
