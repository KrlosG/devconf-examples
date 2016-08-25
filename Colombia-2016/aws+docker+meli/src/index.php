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
      <div class="loader">
        <div class="row">
          <div class="col-md-12 loader_img">
            <img src="/assets/img/loader.gif" class="loader_img" />
          </div>
        </div>
      </div>
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
        <div class="col-md-2"></div>
        <div class="col-md-7" id="data-chart-container">
          <canvas id="data-chart" width="300" height="150"></canvas>
        </div>
      </div>
    <script>
      var chart;
      function draw(data) {
        if(chart) {
          chart.destroy();
        }
        $("#search-text").html($("#search-box").val());
        $("#max-price").html(data.stats.max);
        $("#min-price").html(data.stats.min);
        $("#avg-price").html(data.stats.avg.toFixed(2));
        $("#total-items").html(data.stats.total_items);
        $(".data").fadeIn();
        //Chart
        var mainDataset = {
          label:'Price Distribution',
          data:[],
          backgroundColor: []
        };
        var chartData = {
          type:'bar',
          data:{
            labels:[],
            datasets:[mainDataset],
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
                }]
              }
            }
          }
        };
        data.stats.buckets.forEach(function(e) {
          chartData.data.labels.push(e.text);
          mainDataset.data.push(e.count);
          mainDataset.backgroundColor.push("rgba(255,248,26,1)");
        })
        var ctx = $("#data-chart");
        console.log(chartData)
        chart = new Chart(ctx, chartData);

      }
      function processData() {
        $(".data").fadeOut();
        $(".loader").show();
        $.get("/search_stats.php?q="+encodeURI($("#search-box").val()),function(data) {
          $(".loader").hide();
          draw(data);
        }).fail(function(err) {
          $(".loader").hide();
          console.log("Error")
          console.log(err)
        })
      }
    </script>
  </body>
</html>
