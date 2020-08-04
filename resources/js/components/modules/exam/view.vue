<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Historial de Mamografías</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-purple card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                    </div>

                    <h3 class="profile-username text-center" 
                    v-text="fillShowPatient.name+' '+fillShowPatient.fathers_family+' '+fillShowPatient.mothers_family">
                    </h3>

                    <p class="text-muted text-center">Run: {{fillShowPatient.run}}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Exámenes Realizados</b> <a class="float-right" >00</a>
                        </li>
                        <li class="list-group-item">
                            <b>Exámenes Pendientes</b> <a class="float-right" >00</a>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-info btn-block"><b>Emitir Orden</b></a>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Información</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Datos Personales</strong>

                    <p class="text-muted" 
                    v-text="fillShowPatient.name+' '+fillShowPatient.fathers_family+' '+fillShowPatient.mothers_family"></p>

                    <p class="text-muted" v-text="fillShowPatient.run"></p>
                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección</strong>
                    <p class="text-muted" v-text="fillShowPatient.address"></p>

                    <hr>

                    <strong><i class="fas fa-phone mr-1"></i> Contacto</strong>

                    <p class="text-muted">
                    <span class="tag tag-danger" v-text="fillShowPatient.telephone"></span>
                    </p>

                    <hr>

                    <strong><i class="far fa-file-alt mr-1"></i> Notas</strong>

                    <p class="text-muted">Comentario Simulado de texto para utilizar</p>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                    <li class="nav-item">
                        <router-link class="btn btn-info btn-sm" :to="'/exam'">
                          <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                      </li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="timeline">
                        <!-- The timeline -->
                        <div class="timeline timeline-inverse"  v-for="(item, index) in sortArrays(fillShowPatient.exams)" :key="index">
                          <div class="time-label">
                              <span class="bg-info" v-text="item.date_exam_reception">
                              
                              </span>
                          </div>
                          <div>
                              <i class="fas fa-check bg-primary"></i>

                              <div class="timeline-item">
                                  <span class="time"  v-text="item.date_exam_reception"><i class="far fa-clock"></i> </span>

                                  <h3 class="timeline-header"><a href="#" class="text-dark">Entrega de Exámen a Paciente</a> </h3>

                                  <div class="timeline-body">
                                      Se informa resultado de exámen a paciente.
                                  </div>
                              </div>
                          </div>
                          <div>
                              <i class="fas fa-user bg-info"></i>

                              <div class="timeline-item">
                                  <span class="time" v-text="item.date_exam"><i class="far fa-clock"></i> </span>

                                  <h3 class="timeline-header"><a href="#" class="text-dark">Recepción de Exámen</a> </h3>

                                  <div class="timeline-body">
                                      Se recepciona toma de exámen.
                                  </div>
                              </div>
                          </div>
                          <div>
                              <i class="fas fa-arrow-alt-circle-right bg-dark"></i>

                              <div class="timeline-item">
                                  <span class="time" v-text="item.date_exam_order"><i class="far fa-clock"></i> </span>

                                  <h3 class="timeline-header"><a href="#" class="text-dark">Orden de Exámen</a> </h3>

                                  <div class="timeline-body">
                                      Se emite orden de toma de exámen.
                                  </div>
                              </div>
                          </div>

                          <div class="time-label">
                              <span class="bg-warning" v-text="item.date_exam_order"> </span>
                          </div>

                          
                          <!-- /.timeline-label -->
                          <!-- END timeline item -->
                          <div>
                              <i class="far fa-clock bg-gray"></i>
                          </div>

                          
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
       </div>
    </div>
  </div>
</template>

<script>
    export default {
      data(){
          return {
            fillShowPatient: {
              idPatient: this.$attrs.id,
              run: '',
              name: '',
              fathers_family: '',
              mothers_family: '',
              address: '',
              birthday: '',
              gender: '',
              telephone: '',
              exams: ''
            },
            listUsuarios: [],
            listEstados: [
              {value: 'A', label: 'Activo'},
              {value: 'I', label: 'Inactivo'}
            ]
          }
      },
      computed: {
        
      },
      mounted() {
        this.getListPatients(); 
      },
      methods: {
        limpiarCriteriosBsq(){
          this.fillShowPatient.nRun  = '';
          this.fillShowPatient.cName = '';
          this.fillShowPatient.cFathers_family  = '';
        },
        limpiarBandejaUsuarios(){
          this.listUsuarios = [];
        },
        sortArrays(exams) {
            return _.orderBy(exams, 'id', 'desc');
        },
        getListPatients(){
          var url = '/administracion/patient/showPatient'
          console.log("id "+this.fillShowPatient.idPatient);
          axios.get(url, {
            params: {
              'idPatient' : this.fillShowPatient.idPatient,
            }
          }).then(response => {
            console.log(response.data);
            this.fillShowPatient.name = response.data.name;
            this.fillShowPatient.run = response.data.run;
            this.fillShowPatient.fathers_family = response.data.fathers_family;
            this.fillShowPatient.mothers_family = response.data.mothers_family;
        
            this.fillShowPatient.address = response.data.address;
            this.fillShowPatient.birthday = response.data.birthday;
            this.fillShowPatient.gender = response.data.gender;
            this.fillShowPatient.exams = response.data.exams;

            this.fullscreenLoading = false;
          })
        }
      }
    }
</script>
