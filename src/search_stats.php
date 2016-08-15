<?php
require './Meli/meli.php';
$buckets_count = 10;
function getItems($q) {
  $meli = new Meli('','');
  $items = array();
  $limit = 100;
  $offset = 0;
  $restItems = 1;
  $result = $meli->get('/sites/MCO/search',array('q' => $q,'limit' => $limit,'$offset' => $offset));
  while($result['httpCode'] == 200 && $restItems >= 0 ) {
    $body = $result['body'];
    $paging = $body->paging;
    $restItems = $paging->total - $offset*$limit;
    foreach ($body->results as $item) {
      $items[] = $item;
    }
    $offset = $offset + 1;
    $result = $meli->get('/sites/MCO/search',array('q' => $q,'limit' => $limit,'$offset' => $offset));

  }
  return $items;
}

function basicItemData($item) {
  return array('id' => $item->id,
               'permalink' => $item->permalink,
               'thumbnail' => $item->thumbnail,
               'price' => $item->price);
}
function getBuckets($max, $min, $buckets_count) {
  $buckets = array(
  $actual = $min;
  $step = ($max - $min) / $buckets_count;
  while($actual < $max) {
    $next = $actual + $step;
    $text = $actual."-".$next;
    if($next >= $max) {
      $text = $actual." o mayor";
    }
    $buckets[] = array("max" => $next, "min" => $actual, "count" => 0);
    $actual = $next;
  }
  return $buckets;
}
function calculateStats($items) {
  $max_item = array();
  $min_item = array();
  $max = 0;
  $min = 0;
  $sum = 0;
  $avg = 0;
  $count = 0;
  $first = 1;
  $buckets = array();
  foreach ($items as $item) {
    if($first == 1){
      $first = 0;
      $max = $item->price;
      $max_item = basicItemData($item);
      $min = $item->price;
      $min_item = basicItemData($item);
    }else {
      if($max < $item->price) {
        $max = $item->price;
        $max_item = basicItemData($item);
      }
      if($min > $item->price) {
        $min = $item->price;
        $min_item = basicItemData($item);
      }
    }
    $count = $count+1;
    $sum = $sum + $item->price;
  }
  $avg = $sum / $count;

  $buckets = getBuckets($max,$min,$buckets_count);
  foreach ($items as $item) {
    foreach ($buckets as $key => $value) {
      # code...
    }
  }


  return array("stats" =>
                array("max" => $max,
                      "min" => $min,
                      "avg" => $avg,
                      "max_item" => $max_item,
                      "min_item" => $min_item
                    )
               );
}

$items = getItems($_GET['q']);
header('Content-Type: application/json');
echo json_encode(calculateStats($items));
?>
