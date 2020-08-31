<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-default">
              <div class="inner">
                <h3>15.023</h3>

                <p>Exámenes Aplicados</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-bar"></i>
              </div>
              <a href="#" class="small-box-footer"><i class=""></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-default">
              <div class="inner">
                <h3>9.853<sup style="font-size: 20px"></sup></h3>

                <p>Mamografías</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-pie"></i>
              </div>
              <a href="#" class="small-box-footer"><i class=""></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-default">
              <div class="inner">
                <h3>4.134</h3>

                <p>Eco Mamografías</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-bar"></i>
              </div>
              <a href="#" class="small-box-footer"><i class=""></i></a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Distribución por Edad</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="myChart" width="400" height="300"></canvas>
                  </div>
                </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-8 col-8">
            <!-- small box -->
            <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Exámenes en el Año</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="myChart2" width="400" height="142"></canvas>
                  </div>
                </div>
            </div>
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</template>

<script>
    import Chart from 'chart.js';
    export default {
      mounted(){
        this.getGraphBar();
        this.getGraphLine();
        console.log("montado");
      },
      methods:{
        getGraphBar() {
          var ctx = document.getElementById("myChart").getContext('2d');
          var dataValues = [22, 59, 73, 46, 20,10];
          var dataLabels = [0, 20, 30, 40, 50, 60];
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: dataLabels,
              datasets: [{
                label: 'Distribución por Edad',
                data: dataValues,
                backgroundColor: 'rgba(201, 201, 201, 1)',
              }]
            },
            options: {
              scales: {
                xAxes: [{
                  display: false,
                  barPercentage: 1.3,
                  ticks: {
                      max: 3,
                  }
              }, {
                  display: true,
                  ticks: {
                      autoSkip: false,
                      max: 4,
                  }
                }],
                yAxes: [{
                  ticks: {
                    beginAtZero:true
                  }
                }]
              }
            }
          });
        },
        getGraphLine() {
          var ctx = document.getElementById('myChart2').getContext('2d');
          var chart = new Chart(ctx, {
              // The type of chart we want to create
              type: 'line',

              // The data for our dataset
              data: {
                  labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"],
                  datasets: [{
                      label: "Exámenes",
                      backgroundColor: 'rgb(99, 99, 132)',
                      borderColor: 'rgb(99, 99, 132)',
                      data: [0, 10, 5, 2, 20, 30, 45],
                  }]
              },

              // Configuration options go here
              options: {}
          });
              }
      },

    }
</script>
