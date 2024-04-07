<?
session_start();
// Считывание json через include
/*
ob_start();
include 'assets/health.json';
$data = ob_get_clean();
$data = json_decode($data, true);
*/
//  var_dump($data['articles'][0]);

//Считывание через file_get_contents
// $resp = file_get_contents("assets/health.json");
// $data = json_decode($resp, true);
// if ($data) {
//   var_dump($data['articles'][0]);
// }

$categories = [
  'business',
  'entertainment',
  'general',
  'health',
  'science',
  'sports',
  'technology'
];

$data = [
  // 'business' => [
  //   0 => [
  //     ['title'='asd','id'=1]
  //   ],
  //   1 => [
  //     ['title'='vvvvv','id'=2]
  //   ]
  // ],
  // 'entertainment' => [

  // ],
  // 'general' => [],
  // 'health' => [],
  // 'science' => [],
  // 'sports' => [],
  // 'technology' => []
];

$random_posts = [];

function debug($arr)
{
  echo '<pre>';
  print_r($arr);
  echo '<pre>';
}

function request($category)
{
  $resp = file_get_contents("assets//{$category}.json");
  $data = json_decode($resp, true);
  return $data;
}

function get_data(&$categories, &$data)
{
  foreach ($categories as $category) {
    $resp = request($category);
    if ($resp) {
      $data[$category] = $resp['articles'];
    }
  }

  $_SESSION['data'] = json_encode($data);
}

function get_random_categories($max, $min = 0)
{
  $random_categories = [];
  $i = 0;

  while ($i < 3) {
    $random_category = rand($min, $max - 1); // 0-6
    if (empty($random_categories) or !in_array($random_category, $random_categories)) {
      array_push($random_categories, $random_category);
      $i++;
    }
  }
  return $random_categories;
}

function get_random_posts(&$random_categories, &$data, &$categories, &$random_posts)
{
  foreach ($random_categories as $category_ind) {
    $cat_name = $categories[$category_ind]; // business
    $cat_posts = $data[$cat_name];
    $post_ind = rand(0, count($cat_posts) - 1);
    $random_posts[$cat_name] = $cat_posts[$post_ind];
  }
}

if (!empty($_SESSION['data'])) {
  $data = json_decode($_SESSION['data'], true);
} else {
  get_data($categories, $data); // Получаем данные с сервера
}


$random_categories = get_random_categories(count($data)); // [0,0,4] // Получаем рандом категории
get_random_posts($random_categories, $data, $categories, $random_posts); // Рандом посты

// debug($random_posts);



?>