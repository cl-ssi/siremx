<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reporte MX por Birads Antiguedad</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Criterios de Búsqueda</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <div class="card-body">
                <form role="form">

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-6 col-form-label">Años de Antiguedad</label>
                        <div class="col-md-9">
                          <el-slider
                            v-model="fillBsqReport.year"
                            :step="12"
                            :min="12"
                            :max="60"
                            :marks="marks"
                            show-stops>
                          </el-slider>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Tipo exámen</label>
                        <div class="col-md-9">
                          <el-select v-model="fillBsqReport.selectExamType"
                              placeholder="Seleccione" multiple
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
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">BIRARDS</label>
                        <div class="col-md-9">
                          <el-select v-model="fillBsqReport.selectBIRADS"
                              placeholder="Seleccione" 
                              clearable>
                                <el-option
                                  v-for="item in listBIRADS"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value">
                                </el-option>
                           </el-select>
                        </div>
                      </div>
                    </div>
                    <!-- <template v-if="listRolePermissionsByUser.includes('commune.filter')">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-md-3 col-form-label">Comuna</label>
                            <div class="col-md-9">
                              <el-select v-model="fillBsqReport.commune" filterable
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
                  </template> -->
                  </div>

                  <!-- <div class="row">
                    <template v-if="listRolePermissionsByUser.includes('establishment.filter')">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-4 col-form-label">Establecimiento Origen</label>
                          <div class="col-md-9">
                            <el-select v-model="fillBsqReport.establishmentRequest" filterable
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
                      </div>
                    </template>
                    
                    <template v-if="listRolePermissionsByUser.includes('establishmentExam.filter')">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-7 col-form-label">Establecimiento Toma de Exámen</label>
                          <div class="col-md-9">
                            <el-select v-model="fillBsqReport.establishmentExam" filterable
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
                      </div>
                    </template>
                  </div> -->

                  
                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="getRespReport">Buscar</button>
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                    <template v-if="listarUsuariosPaginated.length">
                        <el-tooltip class="item" effect="dark" content="Descargar en Excel" placement="bottom-start">
                            <i class="fas fa-file-excel text-success" @click.prevent="exportExcel"></i>
                        </el-tooltip>
                    </template>
                    Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive p-1">
                <template v-if="listarUsuariosPaginated.length">
                 <table id="data-table" class="table table-hover table-sm table-bordered  table-striped table-header-fixed table-valign-middle projects">
                    <tr class="small text-nowrap">
                      <th>Run</th>
                      <th>Nombre</th>
                      <th>Genero</th>
                      <th>F. Nacimiento</th>
                      <th>Edad</th>
                      <th>Dirección</th>
                      <th>Fono</th>
                      <th>Ultimo Exámen</th>
                      <th>MAMOGRAFÍA</th>
                      <th>ECO MAMARIA</th>
                      <th>PROYECCIÓN</th>
                    </tr>
                    <tr  class="small" v-for="(item, index) in listarUsuariosPaginated" :key="index">
                      <td v-text="item.run+'-'+item.dv"></td>
                      <td v-text="item.name+' '+item.fathers_family+' '+item.mothers_family"></td>
                      <td v-text="item.gender"></td>
                      <td v-text="item.birthday"></td>
                      <td class="text-center align-middle" v-text="item.age"></td>
                      <td v-text="item.address"></td>
                      <td v-text="item.telephone"></td>
                      <td v-text="item.ultimo_examen"></td>
                      <td class="text-center align-middle" v-text="item.birards_mamografia"></td>
                      <td class="text-center align-middle" v-text="item.birards_ecografia"></td>
                      <td class="text-center align-middle" v-text="item.birards_proyeccion"></td>
                    </tr>
                  </table>
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm pagination-secondary m-0 float-right">
                      <li class="page-item" v-if="pageNumber > 0">
                        <a href="#" class="page-link" @click.prevent="prevPage">Ant</a>
                      </li>
                      <li class="page-item" v-for="(page, index) in pagesList" :key="index"
                        :class="[page == pageNumber ? 'active' : '']">
                        <a href="#" class="page-link" @click.prevent="selectPage(page)">{{ page+1 }}</a>
                      </li>
                      <li class="page-item" v-if="pageNumber < pageCount -1">
                        <a href="#" class="page-link" @click.prevent="nextPage">Sig</a>
                      </li>
                    </ul>
                  </div>
                </template>
                <template v-else>
                  <div class="callout callout-info">
                      <h5>No se encontraron resultados...</h5>
                  </div>
                </template>
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
                    <h5 class="modal-title"> Mensaje</h5>
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
import XLSX from 'xlsx'
    export default {
      data(){
          return {
            fillBsqReport: {
              run: '',
              name: '',
              Fathers_family: '',
              year: '',
              date_end: '',
              selectBIRADS: '',
              establishmentRequest: '',
              establishmentExam: '',
              commune: '',
              selectExamType: ''
            },
            listRolePermissionsByUser: JSON.parse(localStorage.getItem('listRolePermissionsByUser')),
            listEstablishments: [],
            listCommunes: [],
            listUsuarios: [],
            listStatus: [
              {value: 'vig', label: 'Vigente'},
              {value: 'noVig', label: 'No Vigente'},
              {value: 'vencer', label: 'Por Vencer'}
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
              {value: 'eco', label: 'Ecografía mamaria'},
              {value: 'pro', label: 'Proyección mamaria'}
            ],
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
            mensajeError: [],
            pageNumber: 0,
            perPage: 75,
            marks: {
              12: '1',
              24: '2',
              36: '3',
              48: '4',
              60: '5',
            }
          }
      },
      computed: {
        //  Obtener el número de páginas
        pageCount() {
          let a = this.listUsuarios.length,
              b = this.perPage;
              return Math.ceil(a/b);
        },
        // Obtener registros paginados
        listarUsuariosPaginated() {
          let inicio = this.pageNumber * this.perPage,
              fin    = inicio + this.perPage;
          return this.listUsuarios.slice(inicio,fin)
        },
        pagesList() {
          let a = this.listUsuarios.length,
              b = this.perPage;
              let pageCount = Math.ceil(a/b);
              let count = 0;
              let pagesArray = [];

              while (count < pageCount) {
                pagesArray.push(count);
                count++;
              }
              return pagesArray;
        },
      },
      mounted() {
        this.getListEstablishments();
        this.getListCommunes();
      },
      methods: {
        limpiarCriteriosBsq(){
          this.fillBsqReport.nRun  = '';
          this.fillBsqReport.cName = '';
          this.fillBsqReport.cFathers_family  = '';
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        limpiarBandejaUsuarios(){
          this.listUsuarios = [];
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
        getListCommunes() {
          var route = '/administracion/communes/getListCommunes'
          axios.get(route).then( response => {
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
        getRespReport(){
          //console.log(this.fillBsqReport.selectBIRADS);
          if(this.validForm()) {
                this.modalShow = true;
                return;
          }
          this.fullscreenLoading = true;
          
          var url = '/report/exams/getMXBiradYears'
          axios.get(url, {
            params: {
              'year' : this.fillBsqReport.year,
              'listBirards' : this.fillBsqReport.selectBIRADS,
              'listExamType' : this.fillBsqReport.selectExamType,
              'codeDeisRequest' : (!this.fillBsqReport.establishmentRequest) ? '' : this.fillBsqReport.establishmentRequest,
              'codeDeis' : (!this.fillBsqReport.establishmentExam) ? '' : this.fillBsqReport.establishmentExam,
              'commune' : (!this.fillBsqReport.commune) ? '' : this.fillBsqReport.commune,
            }
          }).then(response => {
            console.log(response.data);
            this.inicializarPaginacion();
            this.listUsuarios = response.data;
            this.fullscreenLoading = false;
          })
        },
        
        setGenerateDocument() {
            /*const loading = this.$vs.loading([
                type: "square",
                color: '#D53978',
                background: '#FFFFFF',
                text: 'Cargando...'
            ])*/
            console.log("en Funcion");
            var config = {
                responseType: 'blob'
            }
            
            var url = '/report/exam/export'
            axios.get(url, config).then(response => {
                console.log(response.data);
                var oMyBlob = new Blob([response.data], {type : 'application/vnd.ms-excel'}); // the blob
                var url = document.createElement('a')
                url.href = URL.createObjectURL(oMyBlob);
                url.download = 'reporte.xlsx'
                url.click()
                window.open(url)
            }).catch((error) => {
            console.log(error)
         })  
        },
        // tableExcel(type, fn, dl) {
        //   var elt = document.getElementById('data-table');
        //   const filename = 'reporte-siremx'
        //   var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
        //   return dl ?
        //     XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
        //     XLSX.writeFile(wb, `${filename}.xlsx`)
        // },
        exportExcel: function () {
        let data = XLSX.utils.json_to_sheet(this.listUsuarios)
        const workbook = XLSX.utils.book_new()
        const filename = 'reporte-siremx'
        XLSX.utils.book_append_sheet(workbook, data, filename)
        XLSX.writeFile(workbook, `${filename}.xlsx`)
        },
        nextPage() {
          this.pageNumber++;
        },
        prevPage() {
          this.pageNumber--;
        },
        selectPage(page) {
          this.pageNumber = page;
        },
        inicializarPaginacion() {
          this.pageNumber = 0;
        },
        validForm() {
            this.error = 0;
            this.mensajeError = [];
            if(!this.fillBsqReport.selectBIRADS) {
                this.mensajeError.push("Birads es un campo obligatorio")
            }

            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        
      }
      }
    }
</script>

<style>
    .el-range-editor.el-input__inner{
        width: 100% !important;
    }
    .el-range-editor .el-range-separator{
        width: 10% !important;
    }
</style>