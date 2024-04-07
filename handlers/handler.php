<?
session_start();
// include_once '../utils/pathes.php';
// $db = include_once(ROOT . "/utils/db.php");
$pdo = include_once "../utils/db.php";



$request_data = file_get_contents("php://input");
if (!empty($request_data)) {
  $request_data_params = json_decode($request_data, true);
  if ($request_data_params['param'] === 'addFavourite') {
    echo $res = addFavourite($pdo, $request_data_params);
  } else if ($request_data_params['param'] === 'getFavourites'){
    
    $posts = getFavourites($pdo);
    if($posts){
      echo json_encode($posts);

    } else {
      echo'false';
    }
  }
}

function getFavourites($pdo){
  try {
    $stmt = $pdo->prepare("SELECT * FROM favourites");
    $stmt->execute();
    $favourite_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $favourite_posts;
  } catch (\Throwable $th) {
    return false;
  }


}








// if ($db == false) {
//   die('Ошибка подключения к БД');
// }

// if (isset($_GET['url']) and !empty($_GET['url']) and isset($_GET['category']) and !empty($_GET['category'])) {
//   $category = $_GET['category'];
//   $url = $_GET['url'];

//   $key = array_search($url, array_column($data[$category], 'url'));
//   if (!$key) {
//     die();
//   }

//   $post = $data[$category][$key];
// }


function addFavourite(&$pdo, &$param_post)
{
  $data = json_decode($_SESSION['data'], true);

  if (empty($data))
    die('Ошибка! Перезагрузите страницу');

  $category = $param_post['category'];
  $url = $param_post['url'];

  $key = array_search($url, array_column($data[$category], 'url'));
  if (!$key) {
    die();
  }

  $post = $data[$category][$key];

  try {
    $stmt = $pdo->prepare("INSERT INTO favourites (author,title,description,url,urlToImage,publishedAt,content) VALUES (:author,:title,:description,:url,:urlToImage,:publishedAt,:content)");

    // $stmt->setAttribute()
    $stmt->execute([
      'author' => $post['author'],
      'title' => $post['title'],
      'description' => $post['description'],
      'url' => $post['url'],
      'urlToImage' => $post['urlToImage'],
      'publishedAt' => $post['publishedAt'],
      'content' => $post['content']
    ]);
    return 'true';
  } catch (PDOException $err) {
    echo 'false';
  }

  // header('Location: ' . $_SERVER['PHP_SELF']);
}

// addFavourite($pdo, $post);

// }