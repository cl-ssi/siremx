<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <canvas id="myChart" width="400" height="400"></canvas>
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
          var dataValues = [12, 19, 3, 5];
          var dataLabels = [0, 1, 2, 3, 4];
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: dataLabels,
              datasets: [{
                label: 'Group A',
                data: dataValues,
                backgroundColor: 'rgba(255, 99, 132, 1)',
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
