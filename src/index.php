<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Mercadolibre DevConf MCO Demo</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css" rel="stylesheet">
    <script src="/assets/javascript/jquery.min.js"></script>
    <script src="/assets/javascript/bootstrap.min.js"></script>
    <script src="/assets/javascript/Chart.bundle.js"></script>
  </head>
  <body>
    <div class="carousel">
      <div class="active item">
          <div class="carousel-content">
              <img src="/assets/img/main_computer_image.png" class="main-image" alt="..." position="relative">
              <div class="carousel-caption">
                <h4>Search Stats</h4>
                <form class="" action="javascript:processData()">
                  <input id="search-box" type="text"
                    class="form-control" placeholder="Search...">
                </form>
              </div>
          </div>
        </div>
      </div>
      <!--<div class="row data">
        <div class="col-md-5">
          <h3>Estadisticas para la busqueda: </h3>
        </div>
        <div class="col-md-7">
          <h2 id="search-text"></h2>
        </div>
      </div>
    -->
      <br/>
      <div class="row data">
        <div class="col-md-3">
          <div><h1 id="max-price"></h1></div>
          <div><h4>Max Price</h4></div>
        </div>
        <div class="col-md-3">
          <div><h1 id="min-price"></h1></div>
          <div><h4>Min Price</h4></div>
        </div>
        <div class="col-md-3">
          <div><h1 id="avg-price"></h1></div>
          <div><h4>Avg Price</h4></div>
        </div>
        <div class="col-md-3">
          <div><h1 id="total-items"></h1></div>
          <div><h4>Total Items</h4></div>
        </div>
      </div>
      <div class="row data">
        <div id="data-chart"></div>
      </div>
    <script>
      function processData() {
        var data={"stats":{"max":6500000,"min":3600,"avg":262077.3424234,"total_items":154,"max_item":{"id":"MCO426127734","permalink":"http:\/\/articulo.mercadolibre.com.co\/MCO-426127734-maquina-colombiana-para-exprimir-naranjas-mandarina-y-limon-_JM","thumbnail":"http:\/\/mco-s1-p.mlstatic.com\/237911-MCO20675170411_042016-I.jpg","price":6500000},"min_item":{"id":"MCO424996738","permalink":"http:\/\/articulo.mercadolibre.com.co\/MCO-424996738-velas-frutales-en-forma-y-olor-de-mandarina-fresa-manzana-_JM","thumbnail":"http:\/\/mco-s2-p.mlstatic.com\/134521-MCO20794356012_062016-I.jpg","price":3600},"buckets":[{"text":"3600-653240","max":653240,"min":3600,"count":137,"is_top":false},{"text":"653240-1302880","max":1302880,"min":653240,"count":12,"is_top":false},{"text":"1302880-1952520","max":1952520,"min":1302880,"count":2,"is_top":false},{"text":"1952520-2602160","max":2602160,"min":1952520,"count":0,"is_top":false},{"text":"2602160-3251800","max":3251800,"min":2602160,"count":0,"is_top":false},{"text":"3251800-3901440","max":3901440,"min":3251800,"count":0,"is_top":false},{"text":"3901440-4551080","max":4551080,"min":3901440,"count":0,"is_top":false},{"text":"4551080-5200720","max":5200720,"min":4551080,"count":0,"is_top":false},{"text":"5200720-5850360","max":5850360,"min":5200720,"count":0,"is_top":false},{"text":"5850360 o mayor","max":6500000,"min":5850360,"count":1,"is_top":true}]}};

        $("#search-text").html($("#search-box").val());
        $("#max-price").html(data.stats.max);
        $("#min-price").html(data.stats.min);
        $("#avg-price").html(data.stats.avg.toFixed(2));
        $("#total-items").html(data.stats.total_items);
        $(".data").fadeIn();
      }
    </script>
  </body>
</html>
