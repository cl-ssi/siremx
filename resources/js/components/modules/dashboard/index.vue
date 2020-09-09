<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-default">
              <div class="inner">
                <h3>{{listIndicators.total_exam}}</h3>

                <p>Exámenes Aplicados</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-bar"></i>
              </div>
              <a href="#" class="small-box-footer"><i class=""></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-default">
              <div class="inner">
                <h3>{{listIndicators.total_mam}}<sup style="font-size: 20px"></sup></h3>

                <p>Mamografías</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-pie"></i>
              </div>
              <a href="#" class="small-box-footer"><i class=""></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-default">
              <div class="inner">
                <h3>{{listIndicators.total_eco}}</h3>

                <p>Ecografías</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-bar"></i>
              </div>
              <a href="#" class="small-box-footer"><i class=""></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-default">
              <div class="inner">
                <h3>{{listIndicators.total_pro}}</h3>

                <p>Proyecciones</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-pie"></i>
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
                    <h3 class="card-title">Distribución cantidad de exámenes por Comuna</h3>
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
                    <h3 class="card-title">Cantidad de exámenes aplicados en el año actual distribuido por mes.</h3>
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
      data() {
        return {
          listExamYear: {
            all:[],
            name: [],
            month_name: [],
            quantity: [],
            color:[]
          },
          listHistCommuneYear: {
            all:[],
            name_label: [],
            quantity: []
          },
          listIndicators: {
            total_exam:'',
            total_mam: '',
            total_eco: '',
            total_pro: ''
          }
        }
      },
      mounted(){
        this.getGraphBar();
        this.getExamYear();
        this.getHistCommuneYear();
        this.getIndicators();
      },
      methods:{
        getIndicators() {
          var url = '/dashboard/getIndicators'
          axios.get(url).then(response => {
            this.listIndicators.total_exam = response.data[0].quantity;
            this.listIndicators.total_mam = response.data[1].quantity;
            this.listIndicators.total_eco = response.data[2].quantity;
            this.listIndicators.total_pro = response.data[3].quantity;
            this.getIndicatorsFilter();
          })
        },
        getIndicatorsFilter() {
          let me = this;
          this. listExamYear.all.map(function(x,y){
            me.listExamYear.name.push(x.month);
            me.listExamYear.month_name.push(x.month_name);
            me.listExamYear.quantity.push(x.exam_quantity);
          })
        },
        getExamYear() {
          var url = '/dashboard/getExamYear'
          axios.get(url).then(response => {
            this.listExamYear.all = response.data;
            this.getExamYearFilter();
          })
        },
        getExamYearFilter() {
          let me = this;
          this. listExamYear.all.map(function(x,y){
            me.listExamYear.name.push(x.month);
            me.listExamYear.month_name.push(x.month_name);
            me.listExamYear.quantity.push(x.exam_quantity);
          })
          this.getGraphLine();
        },
        getHistCommuneYear() {
          var url = '/dashboard/getHistYear'
          axios.get(url).then(response => {
            this.listHistCommuneYear.all = response.data;
            this.getHistCommuneYearFilter();
          })
        },
        getHistCommuneYearFilter() {
          let me = this;
          this.listHistCommuneYear.all.map(function(x,y){
            me.listHistCommuneYear.name_label.push(x.name_label);
            me.listHistCommuneYear.quantity.push(x.exam_quantity);
          })
          this.getGraphBar();
        },
        getGraphBar() {
          let me = this;
          var ctx = document.getElementById("myChart").getContext('2d');
          var dataValues = me.listHistCommuneYear.quantity;
          var dataLabels = me.listHistCommuneYear.name_label;
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: dataLabels,
              datasets: [{
                label: 'Distribución por Comuna',
                data: dataValues,
                backgroundColor: 'rgba(235, 214, 148)',
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
          let me = this;
          var ctx = document.getElementById('myChart2').getContext('2d');
          var chart = new Chart(ctx, {
              // The type of chart we want to create
              type: 'line',

              // The data for our dataset
              data: {
                  labels: me.listExamYear.month_name,
                  datasets: [{
                      label: "Cantidad",
                      backgroundColor: 'rgb(99, 99, 132)',
                      borderColor: 'rgb(99, 99, 132)',
                      data: me.listExamYear.quantity,
                  }]
              },

              // Configuration options go here
              options: {}
          });
              }
      },

    }
</script>
