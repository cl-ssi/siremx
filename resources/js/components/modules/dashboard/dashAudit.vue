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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Indicadores Del Año</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <!-- /.col -->
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>Último registro por Establecimiento</strong>
                    </p>

                    <div class="card-body table-responsive p-1">
                      <div class="table-responsive">
                        <template v-if="listBirads.length">
                          <table class="table table-hover ">
                            <thead class="">
                                <th>ESTABLECIMIENTO</th>
                                <th >ÚLTIMO EXAMEN ORIGEN</th>
                                <th >ÚLTIMO EXAMEN CENTRO</th>
                                <th ></th>
                            </thead>
                            <tbody class="">
                              <tr v-for="(item, index) in listLastExam" :key="index">
                                <td><strong>{{item.establishment}}</strong></td>
                                <td >{{ item.last_exam | moment("DD-MM-YYYY") }}</td>
                                <td >{{ item.last_establishment_exam | moment("DD-MM-YYYY") }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </template>
                      </div>
                      <!-- /.table-responsive -->
                    </div>

                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        
        <div class="row">
          <div class="col-12 col-sm-6">
            <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Distribución de exámenes por Comuna</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="myChart" width="400" height="300"></canvas>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Exámenes por Establecimiento de origen.</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="establishmentRadar" width="400" height="300"></canvas>
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
    import ChartDataLabels from 'chartjs-plugin-datalabels';
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
          listHistEstablishmentYear: {
            all:[],
            name_label: [],
            quantity: []
          },
          listIndicators: {
            total_exam:'',
            total_mam: '',
            total_eco: '',
            total_pro: ''
          },
          listIndicatorBirads: {
            birads_3:'',
            birads_4: '',
            birads_5: '',
            birads_6: ''
          },
          listBirads: [],
          listLastExam: []
        }
      },
      mounted(){
        this.getGraphBar();
        this.getExamYear();
        this.getHistCommuneYear();
        this.getHistEstablishmentYear();
        this.getIndicators();
        this.getIndicatorBirads();
        this.getLastExamEstablishment();
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
        // Obtiene los indicadores de exámenes por birads
        getIndicatorBirads() {
          var url = '/dashboard/getIndicatorBirads'
          axios.get(url).then(response => {
            console.log(response.data[0]);
            this.listBirads = response.data;
            this.listIndicatorBirads.birads_3  = response.data[3].exam_quantity;
            this.listIndicatorBirads.birads_4  = response.data[4].exam_quantity;
            this.listIndicatorBirads.birads_5  = response.data[5].exam_quantity;
            this.listIndicatorBirads.birads_6  = response.data[6].exam_quantity;
            this.getIndicatorBiradsFilter();
          })
        },
         // Obtiene los indicadores de exámenes por birads
        getLastExamEstablishment() {
          var url = '/dashboard/getLastExamEstablishment'
          axios.get(url).then(response => {
            console.log(response.data[0]);
            this.listLastExam = response.data;
          })
        },
       getIndicatorBiradsFilter() {
          let me = this;
          this. listExamYear.all.map(function(x,y){
            me.listExamYear.name.push(x.month);
            me.listExamYear.month_name.push(x.month_name);
            me.listExamYear.quantity.push(x.exam_quantity);
          })
        },
        getExamYear() {
          var url = '/dashboard/getExamYearEstablishment'
          axios.get(url).then(response => {
            this.listExamYear.all = response.data;
            this.getExamYearFilter();
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
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
        getHistEstablishmentYear() {
          var url = '/dashboard/getHistEstablishmentYear'
          axios.get(url).then(response => {
            this.listHistEstablishmentYear.all = response.data;
            this.getHistEstablishmentYearFilter();
          })
        },
        getHistEstablishmentYearFilter() {
          let me = this;
          this.listHistEstablishmentYear.all.map(function(x,y){
            me.listHistEstablishmentYear.name_label.push(x.name_label);
            me.listHistEstablishmentYear.quantity.push(x.exam_quantity);
          })
          this.getGraphRadar();
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
        getGraphRadar() {
          let me = this;
          var ctx = document.getElementById("establishmentRadar");
          var dataValues = me.listHistEstablishmentYear.quantity;
          var dataLabels = me.listHistEstablishmentYear.name_label;
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: dataLabels,
              datasets: [{
                label: "Establecimiento Origen",
                backgroundColor: "rgba(5, 179, 166.2)",
                data: dataValues
              }]
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
              options: {
                maintainAspectRatio: false,
                responsive: true, 
                 plugins: {
                      // Change options for ALL labels of THIS CHART
                      datalabels: {
                          color: '#A0A0A0',
                          align: 'top',
                          clamp: 'true'
                      }
                  }
                
              }
          });
        }
      },
      
    }
</script>
