<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Registrar orden de exámen</h1>
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
                <h3 class="card-title">Registrar Orden</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="card-body">
                <form role="form">
                  
                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Run</label>
                          <input type="text" class="form-control" v-model="fillCreateExam.run" @keyup.enter="setRegisterExam">
                          <small class="form-text text-muted">Utilizar: 12213213-1</small>
                         
                      </fieldset>
                      <fieldset class="form-group col-1">
                        <label>.</label>
                         <button class="form-control btn btn-info btn-sm" @click.prevent="getListPatients" >Buscar</button>
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Nombre</label>
                           <input type="text" class="form-control" v-model="fillCreateExam.name" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Apellido Paterno</label>
                           <input type="text" class="form-control" v-model="fillCreateExam.fathers_family" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Apellido Materno</label>
                          <input type="text" class="form-control" v-model="fillCreateExam.mothers_family" @keyup.enter="setRegisterExam">
                      </fieldset>
                  </div>

                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Genero</label>
                           <el-select v-model="fillCreateExam.gender" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listGender"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>
                      <fieldset class="form-group col-4">
                        <label>Telefóno</label>
                          <input type="text" class="form-control" v-model="fillCreateExam.telephone" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-2">
                          <label>Fecha Nacimiento</label>
                           <input type="text"  class="form-control" v-model="fillCreateExam.birthday" @keyup.enter="setRegisterExam">
                      </fieldset>
                       <fieldset class="form-group col-2">
                          <label>Edad</label>
                           <input type="text" class="form-control" v-model="fillCreateExam.age" @keyup.enter="setRegisterExam">
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                      <fieldset class="form-group col-4">
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
                      </fieldset>

                      <fieldset class="form-group col-4">
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
                      </fieldset>

                  </div>
                  <hr>
                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Establecimiento solicita Exámen</label>
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
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Profesional solicita Exámen</label>
                            <input type="text" class="form-control" v-model="fillCreateExam.professional" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Fecha Solicitud</label>
                          <el-date-picker
                            v-model="fillCreateExam.date_exam_order"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd">
                          </el-date-picker>
                          <small class="form-text text-muted"></small>
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                      <fieldset class="form-group col-4">
                          <label>Establecimiento donde toma Exámen</label>
                           <el-select v-model="fillCreateExam.establishmentExam" filterable
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listEstablishments"
                                  :key="item.id"
                                  :label="item.new_code_deis+' - '+item.alias"
                                  :value="item.new_code_deis">
                                </el-option>
                           </el-select>
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Médico</label>
                            <input type="text" class="form-control" v-model="fillCreateExam.doctor" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Fecha Toma Exámen</label>
                          <el-date-picker
                            v-model="fillCreateExam.date_exam"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd">
                          </el-date-picker>
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                       <fieldset class="form-group col-6">
                          <label>Motivo Derivación</label>
                          <input type="text" class="form-control" v-model="fillCreateExam.derivation" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-3">
                          <label>BIRADS - Exámen Mamario</label>
                           <el-select v-model="fillCreateExam.listBIRADSMam" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listBIRADS"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>
                      <fieldset class="form-group col-3">
                          <label>BIRADS - Exámen EcoMamario</label>
                           <el-select v-model="fillCreateExam.listBIRADSEcoMam" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listBIRADS"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                       <fieldset class="form-group col-4">
                          <label>Fecha de Recepción</label>
                           <el-date-picker
                            v-model="fillCreateExam.date_exam_reception"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd">
                          </el-date-picker>
                      </fieldset>
                  </div>
                  
                  <div class="form-group">
                        <label>Observaciones</label>
                        <textarea v-model="fillCreateExam.diagnostic" class="form-control" rows="3" placeholder="Redactar ..."></textarea>
                      </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setRegisterExam" 
                    v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button>
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
              commune: ''
            },
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
            listDerivation: [
              {value: 'mastalgia', label: 'MASTALGIA'},
              {value: 'quisteMamaIzquierda', label: 'QUISTE MAMA IZQUIERDA'},
              {value: 'screening', label: 'SCREENING'},
              {value: 'noduloBilateral', label: 'NODULO BILATERAL'}
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
      },
      methods: {
        limpiarCriterios(){
          this.fillCreateExam.run = '';
          this.fillCreateExam.dv  = '';
          this.fillCreateExam.name  = '';
          this.fillCreateExam.fathers_family = '';
          this.fillCreateExam.mothers_family  = '';
          this.fillCreateExam.gender  = '';
          this.fillCreateExam.birthday  = '';
          this.fillCreateExam.telephone  = '';
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
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListPatients(){
          var url = '/administracion/patient/getPatient'
          console.log("id "+this.fillCreateExam.run,);
          axios.get(url, {
            params: {
              'idPatient' : this.fillCreateExam.run,
            }
          }).then(response => {
            console.log(response.data);
            this.fillCreateExam.idPatient = response.data.id;
            this.fillCreateExam.name = response.data.name;
            this.fillCreateExam.run = response.data.run;
            this.fillCreateExam.fathers_family = response.data.fathers_family;
            this.fillCreateExam.mothers_family = response.data.mothers_family;
        
            this.fillCreateExam.address = response.data.address;
            this.fillCreateExam.birthday = response.data.birthday;
            this.fillCreateExam.gender = response.data.gender;
            this.fillCreateExam.age = response.data.age;
            this.fillCreateExam.exams = response.data.exams;

            this.fillCreateExam.telephone = response.data.telephone;

            this.fullscreenLoading = false;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getListPatientsApi(){
          var session_url = 'https://i.saludiquique.cl/monitor/api/webservices/fonasa?run=15287582&dv=7';
          var username = 'api@redsalud.gob.cl';
          var password = 'apiesmeralda';
          var basicAuth = 'Basic ' + btoa(username + ':' + password);

          axios.get(session_url, {}, {
            headers: { 'Authorization': + basicAuth }
          }).then(function(response) {
            console.log('Authenticated');
          }).catch(function(error) {
            console.log('Error on Authentication');
          });
                    /*console.log("id "+this.fillCreateExam.run,);
          axios.get(url, {
            params: {
              'idPatient' : this.fillCreateExam.run,
            }
          }).then(response => {
            console.log(response.data);
            this.fillCreateExam.name = response.data.name;
            this.fillCreateExam.run = response.data.run;
            this.fillCreateExam.fathers_family = response.data.fathers_family;
            this.fillCreateExam.mothers_family = response.data.mothers_family;
        
            this.fillCreateExam.address = response.data.address;
            this.fillCreateExam.birthday = response.data.birthday;
            this.fillCreateExam.gender = response.data.gender;
            this.fillCreateExam.exams = response.data.exams;

            this.fillCreateExam.telephone = response.data.telephone;

            this.fullscreenLoading = false;
          })*/
        },
        getListCommunes() {
          var route = '/administracion/communes/getListCommunes'
          axios.get(route).then( response => {
            this.listCommunes = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
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
            'age': this.fillCreateExam.teleagephone,
            'servicioSalud': this.fillCreateExam.servicioSalud,
            'commune': this.fillCreateExam.commune,
            'establishmentRequest': this.fillCreateExam.establishmentRequest,
            'professional': this.fillCreateExam.professional,
            'date_exam_order': this.fillCreateExam.date_exam_order,
            'establishmentExam': this.fillCreateExam.establishmentExam,
            'doctor': this.fillCreateExam.doctor,
            'date_exam': this.fillCreateExam.date_exam,
            'derivation': this.fillCreateExam.derivation,
            'listBIRADSMam': this.fillCreateExam.listBIRADSMam,
            'listBIRADSEcoMam': this.fillCreateExam.listBIRADSEcoMam,
            'date_exam_reception': this.fillCreateExam.date_exam_reception,
            'diagnostic': this.fillCreateExam.diagnostic,

          }).then(response => {
            console.log("Registro Paciente exitosamente");
            this.fullscreenLoading = false;
            this.$router.push('/patient');
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
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
                this.mensajeError.push("Fecha de solicitud de exámen es un campo obligatorio")
            }
            if(!this.fillCreateExam.establishmentExam) {
                this.mensajeError.push("Establecimiento donde toma exámen es un campo obligatorio")
            }
            if(!this.fillCreateExam.doctor) {
                this.mensajeError.push("Médico es un campo obligatorio")
            }
            if(!this.fillCreateExam.date_exam) {
                this.mensajeError.push("Fecha de toma de exámen es un campo obligatorio")
            }
            if(!this.fillCreateExam.listBIRADSMam) {
                this.mensajeError.push("Birard Mamografía es un campo obligatorio")
            }
            if(!this.fillCreateExam.listBIRADSEcoMam) {
                this.mensajeError.push("Birards Eco-Mamografía es un campo obligatorio")
            }

            //console.log("en Validar"+this.mensajeError)
            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        }
      }
    }
</script>
