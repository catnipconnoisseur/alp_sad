<?php
$host = 'sub3.sift-uc.id';
$db   = 'subsift4_db_a6';
$user = 'subsift4_user_a6';
$pass = '4r];73z[;bab';
$port = "3306";
$charset = 'utf8mb4';

$options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];
$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
$pdo = new \PDO($dsn, $user, $pass, $options);

function alert($m): void
{
    echo "<script>alert('$m')</script>";
}
