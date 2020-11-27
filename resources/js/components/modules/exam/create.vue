<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Hito 1 - Ingreso orden de Examen</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/exam'">
              <i class="fas fa-arrow-left"></i> Regresar
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Registrar Orden - Paso 1</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="card-body">
                <form role="form">

                  <div class="row">
                    <div class="col-8 col-sm-4">
                      <div class="form-group">
                        <label>Run</label>
                        <input ref="run" type="text" class="form-control" v-model="fillCreateExam.run" >
                        <small class="form-text text-muted">Utilizar: 12213213-1</small>
                      </div>
                    </div>
                    <div class="col-4 col-sm-1">
                      <div class="form-group">
                        <label class="text-light">.</label>
                         <button class="form-control btn btn-info btn-sm" @click.prevent="getListPatients" >Buscar</button>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" v-model="fillCreateExam.name" disabled>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Apellido Paterno</label>
                        <input type="text" class="form-control" v-model="fillCreateExam.fathers_family" disabled>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Apellido Materno</label>
                        <input type="text" class="form-control" v-model="fillCreateExam.mothers_family" disabled>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Genero</label>
                        <el-select v-model="fillCreateExam.gender" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listGender"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value"
                                  :disabled="true">
                                </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Telefóno</label>
                        <input type="text" class="form-control" v-model="fillCreateExam.telephone" disabled>
                      </div>
                    </div>
                    <div class="col-12 col-sm-2">
                      <div class="form-group">
                        <label>Fecha Nacimiento</label>
                        <input type="text"  class="form-control" v-model="fillCreateExam.birthday" disabled>
                      </div>
                    </div>
                    <div class="col-12 col-sm-2">
                      <div class="form-group">
                        <label>Edad</label>
                        <input type="text" class="form-control" v-model="fillCreateExam.age" disabled>
                      </div>
                    </div>
                  </div>
                  

                  <el-divider content-position="left">Ingreso de Examen</el-divider>

                  <div class="row">
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Servicio de Salud</label>
                        <el-select v-model="fillCreateExam.servicioSalud" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listServicioSalud"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Comuna</label>
                        <el-select v-model="fillCreateExam.commune" filterable
                            placeholder="Seleccione"
                            clearable>
                              <el-option
                                v-for="item in listCommunes"
                                :key="item.id"
                                :label="item.code_deis+' - '+item.name"
                                :value="item.code_deis">
                              </el-option>
                        </el-select>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Establecimiento solicita Examen</label>
                        <el-select v-model="fillCreateExam.establishmentRequest" filterable
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listEstablishments"
                                  :key="item.id"
                                  :label="item.new_code_deis+' - '+item.alias"
                                  :value="item.new_code_deis">
                                </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Profesional solicita Examen</label>
                        <el-select v-model="fillCreateExam.professional" filterable
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listProfessional"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Fecha Solicitud</label>
                        <el-date-picker
                            v-model="fillCreateExam.date_exam_order"
                            type="date"
                            placeholder="Fecha"
                            format="dd/MM/yyyy"
                            value-format="yyyy-MM-dd">
                        </el-date-picker>
                      </div>
                    </div>
                  </div>
                  
                  <hr>

                  <div class="row">
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Establecimiento donde toma Examen</label>
                        <el-select  v-on:change="onChange" v-model="fillCreateExam.establishmentExam" filterable
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listEstablishments"
                                  :key="item.id"
                                  :label="item.new_code_deis+' - '+item.alias"
                                  :value="item.new_code_deis">
                                </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Profesional toma Examen</label>
                        <input type="text" class="form-control" v-model="fillCreateExam.doctor" @keyup.enter="setRegisterExam">
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Fecha Toma Examen</label>
                        <el-date-picker
                            v-model="fillCreateExam.date_exam"
                            type="date"
                            placeholder="Fecha"
                            format="dd/MM/yyyy"
                            value-format="yyyy-MM-dd">
                        </el-date-picker>
                      </div>
                    </div>
                  </div>

                  <hr>

                   <div class="row">
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Motivo Derivación</label>
                        <el-select v-model="fillCreateExam.derivation" filterable
                            placeholder="Seleccione"
                            clearable>
                              <el-option
                                v-for="item in listDerivations"
                                :key="item.id"
                                :label="item.id+' - '+item.title"
                                :value="item.id">
                              </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Tipo de Examen</label>
                        <el-select v-model="fillCreateExam.examType" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listExamType"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                        </el-select>
                      </div>
                    </div>
                  </div>

                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setRegisterExam" 
                    v-loading.fullscreen.lock="fullscreenLoading">Guardar</button>
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="cleanForm">Limpiar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" :class="{show: modalShow}" :style=" modalShow ? mostrarModal : ocultarModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Siremx</h5>
                    <button class="close" @click="abrirModal"><i class="fas fa-times"></i> </button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-danger" v-for="(item, index) in mensajeError" :key="index" v-text="item">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="abrirModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
    export default {
      data(){
          return {
            fillCreateExam: {
              idPatient: '',
              run: '',
              name: '',
              fathers_family: '',
              mothers_family: '',
              address: '',
              birthday: '',
              gender: '',
              telephone: '',
              age: '',
              servicioSalud: '',
              establishmentRequest: '',
              professional: '',
              date_exam_order: '',
              establishmentExam: '',
              doctor: '',
              date_exam: '',
              derivation: '',
              listBIRADSMam: '',
              listBIRADSEcoMam: '',
              date_exam_reception: '',
              diagnostic: '',
              exams: '',
              commune: '',
              examType: ''
            },

            listDerivations: [],
            listCommunes: [],
            listEstablishments: [],
            listGender: [
              {value: 'female', label: 'Femenino'},
              {value: 'male', label: 'Masculino'},
              {value: 'other', label: 'Otro'},
              {value: 'unknown', label: 'Prefiero no decir'}
            ],
            listServicioSalud: [
              {value: 'IQUIQUE', label: 'IQUIQUE'}
            ],
            listProfessional: [
              {value: 'Matrona', label: 'Matrona'},
              {value: 'Medico', label: 'Médico'},
              {value: 'Otro', label: 'Otro Profesional'}
            ],
            listExamType: [
              {value: 'mam', label: 'Mamografía'},
              {value: 'eco', label: 'Ecografía'},
              {value: 'pro', label: 'Proyección Mamaria'}
            ],
            listBIRADS: [
              {value: '0', label: '0'},
              {value: '1', label: 'I'},
              {value: '2', label: 'II'},
              {value: '3', label: 'III'},
              {value: '4', label: 'IV'},
              {value: '5', label: 'V'},
              {value: '6', label: 'VI'},
              {value: 'NSP', label: 'NSP'}
            ],
            form: new FormData,
            fullscreenLoading: false,
            modalShow: false,
            mostrarModal: {
              display: 'block',
              background: '#0000006b',
            },
            ocultarModal: {
                display: 'none',
            },
            error: 0,
            mensajeError: []
          }
      },
      computed: {
        
      },
      mounted(){
        this.getListEstablishments();
        this.getListCommunes();
        this.$refs.run.focus();
      },
      methods: {
        onChange: function (event)
        {
            console.log(this.fillCreateExam.establishmentExam)
            this.fillCreateExam.derivation = '';
            var code_deis = this.fillCreateExam.establishmentExam;
            this.getListDerivations(code_deis);
        },
        cleanForm(){
          this.fillCreateExam.run = '';
          this.fillCreateExam.dv  = '';
          this.fillCreateExam.name  = '';
          this.fillCreateExam.fathers_family = '';
          this.fillCreateExam.mothers_family  = '';
          this.fillCreateExam.gender  = '';
          this.fillCreateExam.birthday  = '';
          this.fillCreateExam.telephone  = '';
          this.fillCreateExam.age = '';
          this.fillCreateExam.servicioSalud = '';
          this.fillCreateExam.servicioSalud = '';  
          this.fillCreateExam.commune = '';          
          this.fillCreateExam.establishmentRequest = '';
          this.fillCreateExam.professional = '';      
          this.fillCreateExam.date_exam_order = '';   
          this.fillCreateExam.establishmentExam = ''; 
          this.fillCreateExam.doctor = '';          
          this.fillCreateExam.date_exam = '';         
          this.fillCreateExam.derivation = '';
          this.fillCreateExam.examType = '';
          this.$refs.run.focus();
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getFile(e) {
            this.fillCreateExam.oFotografia = e.target.files[0];       
        },
        getListEstablishments() {
          var route = '/administracion/establishments/getListEstablishments'
          axios.get(route).then( response => {
            this.listEstablishments = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListPatients(){
          if(this.validRunForm()) {
                this.modalShow = true;
                return;
          }

          var run = this.fillCreateExam.run.split('-');
          console.log(run);
          var url = '/administracion/patient/getPatient'
          axios.get(url, {
            params: {
              'run' : run[0],
              'dv'  : run[1]
            }
          }).then(response => {
            if(response.data.code == 204){
                this.responseFailed();
              
            }
            else {
              this.fillCreateExam.idPatient = response.data.id;
              this.fillCreateExam.name = response.data.name;
              this.fillCreateExam.run = response.data.run+'-'+response.data.dv;
              this.fillCreateExam.fathers_family = response.data.fathers_family;
              this.fillCreateExam.mothers_family = response.data.mothers_family;
          
              this.fillCreateExam.address = response.data.address;
              this.fillCreateExam.birthday = response.data.birthday;
              this.fillCreateExam.gender = response.data.gender;
              this.fillCreateExam.age = response.data.age;
              this.fillCreateExam.exams = response.data.exams;

              this.fillCreateExam.telephone = response.data.telephone;

              this.fullscreenLoading = false;
            } 
          }).catch(error => {
            console.log("Pasa a API");
            this.getListPatientsApi();
          });
        },
        getListPatientsApi(){
          var run = this.fillCreateExam.run.split('-');
          console.log(run);
          var session_url = 'https://i.saludiquique.cl/monitor/api/webservices/fonasa?run='+run[0]+'&dv='+run[1];
          var username = 'api@redsalud.gob.cl';
          var password = 'apiesmeralda';
          var basicAuth = 'Basic ' + btoa(username + ':' + password);

          const res =  axios.get(session_url, {
            auth: {
              username: username,
              password: password
            }
          }).then(response => {
            
            console.log(response);

            var data = JSON.stringify(response.data);
            if(response.data.run)
            {
             
              
              Swal.fire({
              title: '¿El paciente se ha encontrado en sistema monitor, desea cargarlo?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, cargar'
              }).then((result) => {
                  if (result.value) {
                    this.fullscreenLoading = true;
                    this.fillCreateExam.name = response.data.name;
                    this.fillCreateExam.run = response.data.run+'-'+response.data.dv;
                    this.fillCreateExam.dv = response.data.dv;
                    this.fillCreateExam.fathers_family = response.data.fathers_family;
                    this.fillCreateExam.mothers_family = response.data.mothers_family;
                    this.fillCreateExam.birthday = response.data.birthday;
                    if(response.data.gender== 'Masculino'){
                      this.fillCreateExam.gender = 'male';
                    }
                    else if(response.data.gender== 'Femenino'){
                      this.fillCreateExam.gender = 'female';
                    }
                    else {
                      this.fillCreateExam.gender = 'other'
                    }
                    // SE LLAMA A FUNCION PARA RESGISTRAR PACIENTE OBTENIDO DE LA API
                    this.setStorePatient();
                  }
              })
              
            }
            else {
              console.log("error no se encontro registro");
              Swal.fire({
                icon: 'warning',
                title: 'El paciente no se encuentra en los registros del sistema monitor',
                showConfirmButton: false,
                timer: 1500
              })
            }
            
            

            console.log(data);

          }).catch(error => {
            console.log("Error en autenticacion");
          });
        },
        setStorePatient(){
          var run = this.fillCreateExam.run.split('-');
          var url = '/administracion/patient/setStorePatient'
          axios.post(url, {
            'run'            : run[0],
            'dv'             : run[1],
            'name'           : this.fillCreateExam.name,
            'fathers_family' : this.fillCreateExam.fathers_family,
            'mothers_family' : this.fillCreateExam.mothers_family,
            'gender'         : this.fillCreateExam.gender,
            'birthday'       : this.fillCreateExam.birthday,

          }).then(response => {
            console.log(response);
            this.fillCreateExam.idPatient = response.data.id;
            Swal.fire({
                icon: 'success',
                title: 'Registro Paciente exitosamente',
                showConfirmButton: false,
                timer: 1500
              })
            this.fullscreenLoading = false;
          })
        },
        /*Swal.fire({
              title: '¿El paciente no se encuentra en los registros de Siremx, dese cargarlo desde monitor?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, cargar'
              }).then((result) => {
                  if (result.value) {
                    //this.setStoreExam();
                }
              })*/
        getListCommunes() {
          
          var route = '/administracion/communes/getListCommunes'
          axios.get(route).then( response => {
            console.log(response.data)
            this.listCommunes = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListDerivations(code_deis) {
          
          var route = '/administracion/derivations/getListDerivationsSelect'
          axios.get(route,{
            params: {
              'establishment_code_deis' : code_deis
            }
          }).then( response => {
            console.log(response.data)
            this.listDerivations = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        setRegisterExam() {
            
            if(this.validForm()) {
                this.modalShow = true;
                return;
            }
            
            
            Swal.fire({
            title: '¿Desea cargar el registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cargar'
          }).then((result) => {
              if (result.value) {
                this.setStoreExam();
            }
          })
            
        },
        setStoreExam(){
          this.fullscreenLoading = true;
          var  url = '/exam/setStoreExam'
          axios.post(url, {
            'idPatient'      : this.fillCreateExam.idPatient,
            'run'            : this.fillCreateExam.run,
            'dv'             : this.fillCreateExam.dv,
            'name'           : this.fillCreateExam.name,
            'fathers_family' : this.fillCreateExam.fathers_family,
            'mothers_family' : this.fillCreateExam.mothers_family,
            'gender'         : this.fillCreateExam.gender,
            'birthday'       : this.fillCreateExam.birthday,
            'telephone'      : this.fillCreateExam.telephone,
            'age'            : this.fillCreateExam.age,
            'servicioSalud'  : this.fillCreateExam.servicioSalud,
            'commune'        : this.fillCreateExam.commune,
            'establishmentRequest': this.fillCreateExam.establishmentRequest,
            'professional'   : this.fillCreateExam.professional,
            'date_exam_order': this.fillCreateExam.date_exam_order,
            'establishmentExam': this.fillCreateExam.establishmentExam,
            'doctor'         : this.fillCreateExam.doctor,
            'date_exam'      : this.fillCreateExam.date_exam,
            'derivation'     : this.fillCreateExam.derivation,
            'listBIRADSMam'  : this.fillCreateExam.listBIRADSMam,
            'listBIRADSEcoMam': this.fillCreateExam.listBIRADSEcoMam,
            'date_exam_reception': this.fillCreateExam.date_exam_reception,
            'diagnostic': this.fillCreateExam.diagnostic,
            'examType':  this.fillCreateExam.examType,

          }).then(response => {
            console.log("Registro Paciente exitosamente");
            this.fullscreenLoading = false;
            this.$router.push('/exam');
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        validRunForm() {
            this.error = 0;
            this.mensajeError = [];
            if(!this.fillCreateExam.run) {
                this.mensajeError.push("Run campo obligatorio")
            }
            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        },
        validForm() {
            this.error = 0;
            this.mensajeError = [];
            if(!this.fillCreateExam.run) {
                this.mensajeError.push("Run campo obligatorio")
            }
            if(!this.fillCreateExam.name) {
                this.mensajeError.push("Nombre es un campo obligatorio")
            }
            if(!this.fillCreateExam.fathers_family) {
                this.mensajeError.push("Apellido Paterno es un campo obligatorio")
            }
            if(!this.fillCreateExam.servicioSalud) {
                this.mensajeError.push("Servicio de Salud es un campo obligatorio")
            }
            if(!this.fillCreateExam.establishmentRequest) {
                this.mensajeError.push("Establecimiento que solicita es un campo obligatorio")
            }
            if(!this.fillCreateExam.professional) {
                this.mensajeError.push("Profesional que solicita es un campo obligatorio")
            }
            if(!this.fillCreateExam.date_exam_order) {
                this.mensajeError.push("Fecha de solicitud de Examen es un campo obligatorio")
            }
            if(!this.fillCreateExam.establishmentExam) {
                this.mensajeError.push("Establecimiento donde toma Examen es un campo obligatorio")
            }
            if(!this.fillCreateExam.doctor) {
                this.mensajeError.push("Profesional toma Examen es un campo obligatorio")
            }
            if(!this.fillCreateExam.date_exam) {
                this.mensajeError.push("Fecha de toma de Examen es un campo obligatorio")
            }

            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        },
        responseFailed() {
          this.getListPatientsApi();
         /* Swal.fire({
              title: '¿El paciente no se encuentra en los registros de Siremx, desea buscarlo en sitema monitor?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, Buscar'
              }).then((result) => {
                  if (result.value) {
                    this.getListPatientsApi();
                  }
          })*/
        }
      }
    }
</script>
