<?php
require './Meli/meli.php';
$buckets_count = 8;
function getItems($q) {
  $meli = new Meli('','');
  $items = array();
  $offset = 0;
  $restItems = 1;
  $limit = 200;
  $result = $meli->get('/sites/MCO/search',array('q' => rawurlencode($q),'$offset' => $offset,'limit' => $limit));
  if($result['httpCode'] != 200) {
    print_r(json_encode($result));
  }
  while($result['httpCode'] == 200 && $restItems > 0 ) {
    $body = $result['body'];
    $paging = $body->paging;

    foreach ($body->results as $item) {
      $items[] = $item;
    }
    $limit = $body->paging->limit;
    $offset = $offset + $limit;
    $restItems = $paging->total - $offset;
    if($restItems > 0) {
      $result = $meli->get('/sites/MCO/search',array('q' => rawurlencode($q),'limit' => $limit,'offset' => $offset));
    }

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
  $buckets = array();
  $actual = $min;
  $step = ($max - $min) / $buckets_count;

  while($actual < $max) {
    $next = $actual + $step;
    $text = $actual."-".$next;
    $top = false;
    if($next >= $max) {
      $text = $actual." o mayor";
      $top = true;
    }
    $buckets[] = array("text"=>$text, "max" => $next, "min" => $actual, "count" => 0, "is_top" => $top);
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
      $min = max($item->price,0);
      $min_item = basicItemData($item);
    }else {
      if($item->price != null && $max < $item->price) {
        $max = $item->price;
        $max_item = basicItemData($item);
      }
      if($item->price != null && $min > $item->price) {
        $min = $item->price;
        $min_item = basicItemData($item);
      }
    }
    $count = $count+1;
    $sum = $sum + $item->price;
  }
  $avg = $sum / $count;

  $buckets = getBuckets($max,$min,$GLOBALS['buckets_count']);
  if(sizeof($buckets) == 0) {
    $buckets[] = array("max" => $max, "min" => $min, "count" => $count);
  } else {
    foreach ($items as $item) {
      for ($i = 0; $i < sizeof($buckets); $i++) {
        if(($item->price >= $buckets[$i]["min"] && $item->price < $buckets[$i]["max"]) ||
            ($item->price >= $buckets[$i]["max"] && $buckets[$i]["is_top"] == 1)) {
          $buckets[$i]["count"] = $buckets[$i]["count"] +1;
          break;
        }
      }
    }
  }


  return array("stats" =>
                array("max" => $max,
                      "min" => $min,
                      "avg" => $avg,
                      "total_items" => $count,
                      "max_item" => $max_item,
                      "min_item" => $min_item,
                      "buckets" => $buckets
                    )
               );
}

$items = getItems($_GET['q']);
header('Content-Type: application/json');
if(sizeof($items) == 0) {
  header('HTTP/1.0 404 Not Found');
  echo json_encode(array("error" => "No items found"));
} else {
  echo json_encode(calculateStats($items));
}
?>
