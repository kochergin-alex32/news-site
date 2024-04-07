<?
$host = 'localhost';
$dbname = 'techblog';
$login = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host={$host};dbname={$dbname}", "{$login}", "{$password}");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec("set names 'utf8'");
  return $pdo;
} catch (PDOException $err) {
  return false;
}
