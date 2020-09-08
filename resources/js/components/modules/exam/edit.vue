<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Hito 2 - Ingreso de Resultado</h1>
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
                <h3 class="card-title">Editar Exámen - Hito 1</h3>
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
                          <label>Servicio de Salud</label>
                           <el-select v-model="fillEditExam.servicioSalud" 
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
                          <el-select v-model="fillEditExam.commune" filterable
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
                           <el-select v-model="fillEditExam.establishmentRequest" filterable
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
                            <input type="text" class="form-control" v-model="fillEditExam.professional" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Fecha Solicitud</label>
                          <el-date-picker
                            v-model="fillEditExam.date_exam_order"
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
                           <el-select v-model="fillEditExam.establishmentExam" filterable
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
                            <input type="text" class="form-control" v-model="fillEditExam.doctor" @keyup.enter="setRegisterExam">
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Fecha Toma Exámen</label>
                          <el-date-picker
                            v-model="fillEditExam.date_exam"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd">
                          </el-date-picker>
                      </fieldset>
                  </div>
                  <hr>
                  <div class="form-row">
                       <fieldset class="form-group col-4">
                          <label>Motivo Derivación</label>
                          <el-select v-model="fillEditExam.derivation" filterable
                            placeholder="Seleccione"
                            clearable>
                              <el-option
                                v-for="item in listDerivations"
                                :key="item.id"
                                :label="item.id+' - '+item.title"
                                :value="item.id">
                              </el-option>
                          </el-select>
                      </fieldset>
                  </div>
                </form>
              </div>

              
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="content container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Registrar Resultados -  Hito 2</h3>
                <div class="card-tools">
                    
                    <template v-if="fillEditExam.path">
                      <a target="_blank" :href="fillEditExam.path" >
                          <i class="fas fa-file-pdf text-light"></i> Ver Informe
                      </a>
                    </template>
                </div>
              </div>
              <div class="card-body">
                <form role="form">

                  <div class="form-row">
                        <fieldset class="form-group col-4">
                          <label>Fecha de Ingreso de Resultado</label>
                           <el-date-picker
                            v-model="fillEditExam.date_exam_reception"
                            type="date"
                            placeholder="Fecha"
                            value-format="yyyy-MM-dd">
                          </el-date-picker>
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Tipo de Examen</label>
                           <el-select v-model="fillEditExam.examType" 
                              placeholder="Seleccione"
                              clearable>
                                <el-option
                                  v-for="item in listExamType"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Resultado del examen mamario en BIRADS</label>
                           <el-select v-model="fillEditExam.birards" 
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
                  
                  <div class="form-group">
                        <label>Observaciones</label>
                        <textarea v-model="fillEditExam.diagnostic" class="form-control" rows="3" placeholder="Redactar ..."></textarea>
                  </div>


                  <hr>
                  <div class="form-row">
                        <fieldset class="form-group col-4">
                      </fieldset>
                      <fieldset class="form-group col-4">
                          
                      </fieldset>
                      <fieldset class="form-group col-4">
                          <label>Adjuntar Informe PDF</label>
                          <input type="file" class="form-control" @change="getFile">
                      </fieldset>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setEditExam" 
                    v-loading.fullscreen.lock="fullscreenLoading">Editar</button>
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
                    <h5 class="modal-title"> Sismam</h5>
                    <button class="close" @click="abrirModal"></button>
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
            fillEditExam: {
               idExam: this.$attrs.id,
               run : '',
               dv  : '',
               name  : '',
               fathers_family : '',
               mothers_family  : '',
               gender  : '',
               birthday  : '',
               telephone  : '',
               address  : '',
               servicioSalud: '',
              establishmentRequest: '',
              professional: '',
              date_exam_order: '',
              establishmentExam: '',
              doctor: '',
              date_exam: '',
              derivation: '',
              birards: '',
              date_exam_reception: '',
              diagnostic: '',
              exams: '',
              commune: '',
              examType: '',
              fileInform: '',
              path: ''
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
            listBIRADS: [
              {value: '0', label: '0'},
              {value: '1', label: 'I'},
              {value: '2', label: 'II'},
              {value: '3', label: 'III'},
              {value: '4', label: 'IV'},
              {value: '5', label: 'V'},
              {value: '6', label: 'VI'}
            ],
            listExamType: [
              {value: 'mam', label: 'Mamografía'},
              {value: 'eco', label: 'Ecografía'},
              {value: 'pro', label: 'Proyección Mamaria'}
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
      mounted(){
        this.getPatientById();
        this.getListEstablishments();
        this.getListCommunes();
        this.getListDerivations();
      },
      methods: {
        getFile(e) {
            this.fillEditExam.fileInform = e.target.files[0];
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
        getListDerivations() {
          
          var route = '/administracion/derivations/getListDerivations'
          axios.get(route).then( response => {
            console.log(response.data)
            this.listDerivations = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        getPatientById() {
          //this.fullscreenLoading = true;  
          var url = '/exam/getExamById'
          axios.get(url, {
            params: {
              'idExam' : this.fillEditExam.idExam,
            }
          }).then(response => {
            this.fillEditExam.servicioSalud        = response.data[0].servicio_salud;
            this.fillEditExam.commune              = (response.data[0].comuna)? response.data[0].comuna : ''; 
            this.fillEditExam.establishmentRequest = response.data[0].cesfam;
            this.fillEditExam.professional         = response.data[0].profesional_solicita;
            this.fillEditExam.date_exam_order      = response.data[0].date_exam_order;
            this.fillEditExam.establishmentExam    = (response.data[0].establecimiento_realiza_examen)? response.data[0].establecimiento_realiza_examen : ''; 
            this.fillEditExam.doctor               = response.data[0].medico;
            this.fillEditExam.date_exam            = response.data[0].date_exam;
            this.fillEditExam.derivation           = (response.data[0].derivation_reason)? response.data[0].derivation_reason : ''; 
            this.fillEditExam.date_exam_reception  = response.data[0].date_exam_reception;
            this.fillEditExam.diagnostic           = response.data[0].diagnostico? response.data[0].diagnostico : ''; 
            this.fillEditExam.path                 = response.data[0].path;

            if(response.data[0].birards_mamografia){
                this.fillEditExam.examType = 'mam';
                this.fillEditExam.birards  = response.data[0].birards_mamografia;
            }
            else if(response.data[0].birards_ecografia){
                this.fillEditExam.examType = 'eco';
                this.fillEditExam.birards  = response.data[0].birards_ecografia;
            }
            else if(response.data[0].birards_proyeccion){
                this.fillEditExam.examType = 'pro';
                this.fillEditExam.birards  = response.data[0].birards_proyeccion;
            }

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
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        setEditExam(){
            
           if(this.validForm()) {
                this.modalShow = true;
                return;
           }
           if(!this.fillEditExam.fileInform || this.fillEditExam.fileInform == undefined) {
              this.fillEditExam.fileInform = '';
            }

            console.log(this.fillEditExam.fileInform);   

           this.form.append('file'                ,this.fillEditExam.fileInform)
           this.form.append('idExam'              ,this.fillEditExam.idExam)
           this.form.append('servicioSalud'       ,this.fillEditExam.servicioSalud)
           this.form.append('commune'             ,this.fillEditExam.commune)
           this.form.append('establishmentRequest',this.fillEditExam.establishmentRequest)
           this.form.append('professional'        ,this.fillEditExam.professional)
           this.form.append('date_exam_order'     ,this.fillEditExam.date_exam_order)
           this.form.append('establishmentExam'   ,this.fillEditExam.establishmentExam)
           this.form.append('doctor'              ,this.fillEditExam.doctor)
           this.form.append('date_exam'           ,this.fillEditExam.date_exam)
           this.form.append('derivation'          ,this.fillEditExam.derivation)
           this.form.append('birards'             ,this.fillEditExam.birards)
           this.form.append('date_exam_reception' ,this.fillEditExam.date_exam_reception)
           this.form.append('diagnostic'          ,this.fillEditExam.diagnostic)
           this.form.append('examType'            ,this.fillEditExam.examType)

          const config = { headers: {'Content-Type': 'multipart/form-data'}}

          this.fullscreenLoading = true;

          var  url = '/exam/setEditExam'
          axios.post(url,this.form, config).then(response => {
            console.log(response);
            this.fullscreenLoading = false;
             Swal.fire({
                icon: 'success',
                title: 'Actualizado',
                showConfirmButton: false,
                timer: 1500
              })
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

            if(!this.fillEditExam.date_exam_reception) {
                this.mensajeError.push("Fecha de Ingreso de Resultado es un campo obligatorio")
            }
            if(!this.fillEditExam.examType) {
                this.mensajeError.push("Tipo de Examen  es un campo obligatorio")
            }
            if(!this.fillEditExam.birards) {
                this.mensajeError.push("Resultado del examen mamario en BIRADS es un campo obligatorio")
            }
        
            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        }
      }
    }
</script>
