<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="row">
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
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</template>

<script>
    import Chart from 'chart.js';
    export default {
      mounted(){
        this.getGraphBar();
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
        }
      },

    }
</script>
