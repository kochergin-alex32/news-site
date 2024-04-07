<?
$pdo = include_once"utils/db.php";
if($pdo){
    $favourite_posts = getFavourites($pdo);
}
function getFavourites($pdo){
    $stmt = $pdo->prepare("SELECT * FROM favourites");
    $stmt->execute();
    $favourite_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $favourite_posts;
}