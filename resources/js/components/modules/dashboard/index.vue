<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

            <div class="row">
              <div class="col-8 col-sm-2">
                  <div class="form-group">
                    <el-date-picker
                        v-model="year"
                        size="mini"
                        type="year"
                        placeholder="Año"
                        value-format="yyyy"
                        format="yyyy">
                    </el-date-picker>
                  </div>
              </div>
              <div class="col-4 col-sm-1">
                <el-button size="mini btn-info" @click.prevent="getRespReport"><i class="fas fa-redo-alt"></i></el-button></div>
            </div>

        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-default">
              <div class="inner">
                <h3>{{listIndicators.total_exam}}</h3>

                <p>Exámenes Aplicados</p>
                <small class="text-light">.</small>
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
                <small>
                  <cite title="Source Title">50 a 69 Años:</cite> 
                  <strong>{{listIndicator5069.age5069_percent}}% </strong>
                  <cite title="Source Title">con </cite> <strong>{{listIndicator5069.age5069}}</strong> exámenes.
                </small>
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
                <small class="text-light">.</small>
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
                <small class="text-light">.</small>
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
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>Cantidad de exámenes aplicados en el año actual distribuido por mes.</strong>
                    </p>

                    <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                      <!-- Sales Chart Canvas -->
                      <canvas id="myChart2" height="320" style="height: 320px; display: block; width: 1050px;" width="1050" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Exámenes por Birads</strong>
                    </p>

                    <div class="card-body">
                      <div class="table-responsive">
                        <template v-if="listBirads.length">
                          <table class="table table-hover ">
                            <tbody class="small">
                              <tr v-for="(item, index) in listBirads" :key="index">
                                <td><strong>BIRADS {{item.birads}}</strong></td>
                                <td v-text="item.exam_quantity"></td>
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
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <h1 class="description-header">{{listIndicatorBirads.birads_3}}</h1>
                      <span class="description-text">TOTAL BIRARDS III</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <h1 class="description-header">{{listIndicatorBirads.birads_4}}</h1>
                      <span class="description-text">TOTAL BIRARDS IV</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <h1 class="description-header">{{listIndicatorBirads.birads_5}}</h1>
                      <span class="description-text">TOTAL BIRARDS V</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <h1 class="description-header">{{listIndicatorBirads.birads_6}}</h1>
                      <span class="description-text">TOTAL BIRARDS VI</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
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

        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Exámenes por Establecimiento de origen y Profesional</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="establishmentRadarSource" width="400" height="300"></canvas>
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
          year: '',
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
          listHistEstablishmentYearProfessional: {
            all:[],
            name_label: [],
            quantity: [],
            quantity_med: [],
            quantity_mat: [],
            quantity_other: []
          },
          listIndicators: {
            total_exam:'',
            total_mam: '',
            total_eco: '',
            total_pro: ''
          },
          listIndicator5069: {
            age5069:'',
            total_mam: '',
            age5069_percent: ''
          },
          listIndicatorBirads: {
            birads_3:'',
            birads_4: '',
            birads_5: '',
            birads_6: ''
          },
          listBirads: []
        }
      },
      mounted(){
        this.getGraphBar();
        this.getExamYear();
        this.getHistCommuneYear();
        this.getHistEstablishmentYear();
        this.getHistEstablishmentYearProfessional();
        this.getIndicators();
        this.getIndicator5069();
        this.getIndicatorBirads();
      },
      methods:{
        getRespReport(){
          this.getIndicators();
          this.getIndicator5069();
          this.getIndicatorBirads();

          this.getExamYear();
          this.getHistCommuneYear();
          this.getHistEstablishmentYear();
          this.getHistEstablishmentYearProfessional();
        },
        getIndicators() {
          var url = '/dashboard/getIndicators'
          axios.get(url,{ 
            params: {
              'year' : (!this.year) ? '' : this.year,
            }
          }).then(response => {
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
        // INDICADOR QUE PERMITE OBTENER LA CANTIDAD DE EXAMENES ENTRE 50 Y 60 AÑOS DE EDAD
        getIndicator5069() {
          var url = '/dashboard/getIndicator5069'
          axios.get(url,{ 
            params: {
              'year' : (!this.year) ? '' : this.year,
            }
          }).then(response => {
            this.listIndicator5069.age5069   = response.data[0].age5069;
            this.listIndicator5069.total_mam = response.data[0].total_mam;
            this.listIndicator5069.age5069_percent = Number((response.data[0].age5069/response.data[0].total_mam)*100).toFixed(0);

          })
        },
        // Obtiene los indicadores de exámenes por birads
        getIndicatorBirads() {
          var url = '/dashboard/getIndicatorBirads'
          axios.get(url,{ 
            params: {
              'year' : (!this.year) ? '' : this.year,
            }
          }).then(response => {
            this.listBirads = response.data;
            this.listIndicatorBirads.birads_3  = response.data[3].exam_quantity;
            this.listIndicatorBirads.birads_4  = response.data[4].exam_quantity;
            this.listIndicatorBirads.birads_5  = response.data[5].exam_quantity;
            this.listIndicatorBirads.birads_6  = response.data[6].exam_quantity;
            this.getIndicatorBiradsFilter();
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
          this.listExamYear.all = [];
          this.listExamYear.name = [];
          this.listExamYear.month_name = [];
          this.listExamYear.quantity = [];

          var url = '/dashboard/getExamYear'
          axios.get(url,{ 
            params: {
              'year' : (!this.year) ? '' : this.year,
            }
          }).then(response => {
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
          this.listExamYear.all.map(function(x,y){
            me.listExamYear.name.push(x.month);
            me.listExamYear.month_name.push(x.month_name);
            me.listExamYear.quantity.push(x.exam_quantity);
          })
          this.getGraphLine();
        },        
        getHistCommuneYear() {

          this.listHistCommuneYear.all = [];
          this.listHistCommuneYear.name_label = [];
          this.listHistCommuneYear.quantity = [];

          var url = '/dashboard/getHistYear'
          axios.get(url,{ 
            params: {
              'year' : (!this.year) ? '' : this.year,
            }
          }).then(response => {
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

          this.listHistEstablishmentYear.all = [];
          this.listHistEstablishmentYear.name_label = [];
          this.listHistEstablishmentYear.quantity = [];

          var url = '/dashboard/getHistEstablishmentYear'
          axios.get(url,{ 
            params: {
              'year' : (!this.year) ? '' : this.year,
            }
          }).then(response => {
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
        getHistEstablishmentYearProfessional() {

          this.listHistEstablishmentYearProfessional.all = [];
          this.listHistEstablishmentYearProfessional.name_label = [];
          this.listHistEstablishmentYearProfessional.quantity = [];
          this.listHistEstablishmentYearProfessional.quantity_med = [];
          this.listHistEstablishmentYearProfessional.quantity_mat = [];
          this.listHistEstablishmentYearProfessional.quantity_other = [];

          var url = '/dashboard/getHistEstablishmentYearProfessional'
          axios.get(url,{ 
            params: {
              'year' : (!this.year) ? '' : this.year,
            }
          }).then(response => {
            this.listHistEstablishmentYearProfessional.all = response.data;
            this.getHistEstablishmentYearProfessionalFilter();
          })
        },
        getHistEstablishmentYearProfessionalFilter() {
          let me = this;
          this.listHistEstablishmentYearProfessional.all.map(function(x,y){
            me.listHistEstablishmentYearProfessional.name_label.push(x.name_label);
            me.listHistEstablishmentYearProfessional.quantity.push(x.exam_quantity);
            me.listHistEstablishmentYearProfessional.quantity_med.push(x.exam_quantity_med);
            me.listHistEstablishmentYearProfessional.quantity_mat.push(x.exam_quantity_mat);
            me.listHistEstablishmentYearProfessional.quantity_other.push(x.exam_quantity_other);
          })
          this.getGraphRadarSource();
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
        getGraphRadarSource() {
          let me = this;
          var dataValues       = me.listHistEstablishmentYearProfessional.quantity;
          var dataValues_med   = me.listHistEstablishmentYearProfessional.quantity_med;
          var dataValues_mat   = me.listHistEstablishmentYearProfessional.quantity_mat;
          var dataValues_other = me.listHistEstablishmentYearProfessional.quantity_other;
          var dataLabels = me.listHistEstablishmentYearProfessional.name_label;

          var ctx = document.getElementById("establishmentRadarSource");
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: dataLabels,
              datasets: [{
                  label: 'Medico',
                   data: dataValues_med,
                  backgroundColor: 'rgba(188, 242, 247)',
                  borderColor: 'rgba(5, 179, 166.2)',
                  borderWidth: 2
                },
                {
                  label: 'Matrona',
                   data: dataValues_mat,
                  backgroundColor: 'rgba(255, 214, 214)',
                  borderColor: 'rgba(217, 20, 20)',
                  borderWidth: 2
                },
                {
                  label: 'Otro',
                   data: dataValues_other,
                  backgroundColor: 'rgba(227, 227, 227)',
                  borderColor: 'rgba(140, 140, 140)',
                  borderWidth: 2
                }
              ]
            },
            options: {
              scales: {
                yAxes: [{
                  stacked: true,
                  ticks: {
                    beginAtZero: true
                  }
                }],
                xAxes: [{
                  stacked: true,
                  ticks: {
                    beginAtZero: true
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
