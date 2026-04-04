<?php

function getDbConnection(): ?PDO
{
    $host = getenv('DB_HOST') ?: 'mysql.hostify.cz';
    $port = getenv('DB_PORT') ?: '3306';
    $dbName = getenv('DB_NAME') ?: 'db_69248_scmysql';
    $user = getenv('DB_USER') ?: 'db_69248_scmysql';
    $pass = getenv('DB_PASS') ?: 'VQ3iR1DZLmAieaDR';
    $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

    if ($dbName === '' || $user === '') {
        return null;
    }

    $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset={$charset}";

    try {
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (Throwable $e) {
        return null;
    }
}
