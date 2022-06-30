<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reporte MX</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <div class="content container-fluid">
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
                    <label class="col-md-3 col-form-label">Inicio</label>
                    <div class="col-md-9">
                        <el-date-picker
                        v-model="fillBsqReport.date_ini"
                        type="date"
                        placeholder="Fecha"
                        value-format="yyyy-MM-dd"
                        format="dd/MM/yyyy">
                      </el-date-picker>
                      <small class="form-text text-muted"> * Considera fecha de toma de exámen</small>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-3 col-form-label">Fin</label>
                    <div class="col-md-9">
                      <el-date-picker
                        v-model="fillBsqReport.date_end"
                        type="date"
                        placeholder="Fecha"
                        value-format="yyyy-MM-dd"
                        format="dd/MM/yyyy">
                      </el-date-picker>
                      <small class="form-text text-muted"> * Considera fecha de toma de exámen</small>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <template v-if="listRolePermissionsByUser.includes('commune.filter')">
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
                </template>
                <template v-if="listRolePermissionsByUser.includes('establishment.filter')">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-4 col-form-label">Establecimiento Origen</label>
                      <div class="col-md-9">
                        <el-select v-model="fillBsqReport.establishmentRequest" filterable
                            placeholder="Seleccione" multiple
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
              </div>

              <div class="row">
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
              
            </form>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-4 offset-4">
                <button class="btn btn-flat btn-info btnWidth" @click.prevent="getRespReport">Buscar</button>
                <button class="btn btn-flat btn-default btnWidth" @click.prevent="cleanForm">Limpiar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Examenes por BIRADS -->
        <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                     Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive p-1">
                <template v-if="listBirardsMamAgeMX.length">
                 <table id="data-table" class="table table-hover table-sm table-striped table-bordered table-header-fixed text-nowrap table-valign-middle">
                    <thead class=" text-nowrap">
                        <tr>
                            <th colspan="11" class="text-center bordered align-middle table-default">BIRARDS POR RANGO DE EDAD MAMOGRAFÍA</th>
                        </tr>
                        <tr class="text-center align-middle table-default">
                            <th>BIRARDS</th>
                            <th>< 35</th>
                            <th>35 a 49</th>
                            <th>50 a 54</th>
                            <th>55 a 59</th>
                            <th>60 a 64</th>
                            <th>65 a 69</th>
                            <th>70 a 74</th>
                            <th>75 a 79</th>
                            <th>80 y más</th>
                            <th>total</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in listBirardsMamAgeMX" :key="index">
                        <td class="text-center" v-text="item.birards"></td>
                        <td class="text-center" v-text="item.range1"></td>
                        <td class="text-center" v-text="item.range2"></td>
                        <td class="text-center" v-text="item.range3"></td>
                        <td class="text-center" v-text="item.range4"></td>
                        <td class="text-center" v-text="item.range5"></td>
                        <td class="text-center" v-text="item.range6"></td>
                        <td class="text-center" v-text="item.range7"></td>
                        <td class="text-center" v-text="item.range8"></td>
                        <td class="text-center" v-text="item.range9"></td>
                        <td class="text-center" v-text="item.total"></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="card-footer clearfix">
                  </div>
                </template>
                <template v-else>
                  <div class="callout callout-info">
                      <h5>No se encontraron resultados...</h5>
                  </div>
                </template>
              </div>
            </div>

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">
                
                  Bandeja de Resultados</h3>
          </div>
          <div class="card-body table-responsive p-1">
            <template v-if="listBirardsEcoAgeMX.length">
              <table id="data-table-eco" class="table table-hover table-sm  table-striped table-bordered table-header-fixed text-nowrap table-valign-middle">
                <thead >
                    <tr>
                        <th colspan="11" class="text-center bordered align-middle table-default">BIRARDS POR RANGO DE EDAD ECO-MAMARIA</th>
                    </tr>
                    <tr class="text-center align-middle table-default">
                        <th>BIRARDS</th>
                        <th>< 35</th>
                        <th>35 a 49</th>
                        <th>50 a 54</th>
                        <th>55 a 59</th>
                        <th>60 a 64</th>
                        <th>65 a 69</th>
                        <th>70 a 74</th>
                        <th>75 a 79</th>
                        <th>80 y más</th>
                        <th>total</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in listBirardsEcoAgeMX" :key="index">
                    <td class="text-center" v-text="item.birards"></td>
                    <td class="text-center" v-text="item.range1"></td>
                    <td class="text-center" v-text="item.range2"></td>
                    <td class="text-center" v-text="item.range3"></td>
                    <td class="text-center" v-text="item.range4"></td>
                    <td class="text-center" v-text="item.range5"></td>
                    <td class="text-center" v-text="item.range6"></td>
                    <td class="text-center" v-text="item.range7"></td>
                    <td class="text-center" v-text="item.range8"></td>
                    <td class="text-center" v-text="item.range9"></td>
                    <td class="text-center" v-text="item.total"></td>
                  </tr>
                </tbody>
              </table>
              <div class="card-footer clearfix">
              </div>
            </template>
            <template v-else>
              <div class="callout callout-info">
                  <h5>No se encontraron resultados...</h5>
              </div>
            </template>
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
              <table id="data-table" class="table table-hover table-sm table-striped table-bordered table-header-fixed text-nowrap table-valign-middle table-responsive">
                <tr class="small text-nowrap">
                  <th class="text-center bg-secondary">S. SALUD</th>
                  <th class="text-center bg-secondary">CESFAM SOL.</th>
                  <th class="text-center bg-secondary">PROFESIONAL SOL.</th>
                  <th class="text-center bg-secondary">RUN</th>
                  <th class="text-center bg-secondary">NOMBRE</th>
                  <th class="text-center bg-secondary">GENERO</th>
                  <th class="text-center bg-secondary">F. NACIMIENTO</th>
                  <th class="text-center bg-secondary">EDAD</th>
                  <th class="text-center bg-secondary">DIRECCIÓN</th>
                  <th class="text-center bg-secondary">EST. EXAMEN</th>
                  <th class="text-center bg-secondary">F. ORDEN</th>
                  <th class="text-center bg-secondary">F. EXAMEN</th>
                  <th class="text-center bg-secondary">F. RECEPCION</th>
                  <th class="text-center bg-secondary">MAMOGRAFÍA</th>
                  <th class="text-center bg-secondary">ECO MAMARIA</th>
                  <th class="text-center bg-secondary">PROYECCIÓN</th>
                  <th class="text-center bg-secondary">MÉDICO</th>
                </tr>
                <tr class="small "v-for="(item, index) in listarUsuariosPaginated" :key="index">
                  <td v-text="item.servicio_salud"></td>
                  <td v-text="item.cesfam_name"></td>
                  <td v-text="item.profesional_solicita"></td>
                  <td v-text="item.run+'-'+item.dv"></td>
                  <td v-text="item.name+' '+item.fathers_family+' '+item.mothers_family"></td>
                  <td v-text="item.gender"></td>
                  <td v-text="item.birthday"></td>
                  <td class="text-center align-middle" v-text="item.age"></td>
                  <td v-text="item.address"></td>
                  <td v-text="item.establecimiento_realiza_examen"></td>
                  <td v-text="item.date_exam_order"></td>
                  <td v-text="item.date_exam"></td>
                  <td v-text="item.date_exam_reception"></td>
                  <td class="text-center align-middle" v-text="item.birards_mamografia"></td>
                  <td class="text-center align-middle" v-text="item.birards_ecografia"></td>
                  <td class="text-center align-middle" v-text="item.birards_proyeccion"></td>
                  <td v-text="item.Médico"></td>
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
</template>

<script>
import XLSX from 'xlsx'
    export default {
      data(){
          return {
            fillBsqReport: {
              date_ini: '',
              date_end: '',
              establishmentRequest: '',
              establishmentExam: '',
              commune: '',
              selectExamType: ''
            },
            listRolePermissionsByUser: JSON.parse(localStorage.getItem('listRolePermissionsByUser')),
            listEstablishments: [],
            listCommunes: [],
            listUsuarios: [],
            listBirardsMamAgeMX: [],
            listBirardsEcoAgeMX: [],
            listExamType: [
              {value: 'mam', label: 'Mamografía'},
              {value: 'eco', label: 'Ecografía mamaria'},
              {value: 'pro', label: 'Proyección mamaria'}
            ],
            pageNumber: 0,
            perPage: 75
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

        //this.getRespReportAge();
        this.getListEstablishments();
        this.getListCommunes();
      },
      methods: {
        cleanForm(){
          this.fillBsqReport.date_ini  = '';
          this.fillBsqReport.date_end = '';
          this.fillBsqReport.establishmentRequest  = '';
          this.fillBsqReport.establishmentExam  = '';
          this.fillBsqReport.commune  = '';
          this.fillBsqReport.selectExamType  = '';
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
          this.getRespReportAge();
          const loading = this.$loading({
            lock: true,
            text: 'Generando Informe',
            spinner: 'el-icon-loading',
            background: 'rgba(0, 0, 0, 0.7)'
          });

          var url = '/report/exams/getMX'
          axios.get(url, {
            params: {
              'dateIni' : (!this.fillBsqReport.date_ini) ? '' : this.fillBsqReport.date_ini,
              'dateEnd' : (!this.fillBsqReport.date_end) ? '' : this.fillBsqReport.date_end,
              'codeDeisRequest' : (!this.fillBsqReport.establishmentRequest) ? '' : this.fillBsqReport.establishmentRequest,
              'codeDeis' : (!this.fillBsqReport.establishmentExam) ? '' : this.fillBsqReport.establishmentExam,
              'commune' : (!this.fillBsqReport.commune) ? '' : this.fillBsqReport.commune,
              'listExamType' : this.fillBsqReport.selectExamType
            }
          }).then(response => {
            console.log(response.data);
            this.inicializarPaginacion();
            this.listUsuarios = response.data;
            loading.close();
          })
        },

         getRespReportAge(){
          this.listBirardsMamAgeMX = this.listBirardsEcoAgeMX = [];
          if(this.fillBsqReport.selectExamType == '' || this.fillBsqReport.selectExamType.includes('mam')){
            var url = '/report/exams/getBirardsAgeMX'
            axios.get(url, {
              params: {
                'dateIni' : (!this.fillBsqReport.date_ini) ? '' : this.fillBsqReport.date_ini,
                'dateEnd' : (!this.fillBsqReport.date_end) ? '' : this.fillBsqReport.date_end,
                'codeDeisRequest' : (!this.fillBsqReport.establishmentRequest) ? '' : this.fillBsqReport.establishmentRequest,
                'codeDeis' : (!this.fillBsqReport.establishmentExam) ? '' : this.fillBsqReport.establishmentExam,
                'commune' : (!this.fillBsqReport.commune) ? '' : this.fillBsqReport.commune,
              }
            }).then(response => {
              this.inicializarPaginacion();
              this.listBirardsMamAgeMX = response.data;
            })
          }

          if(this.fillBsqReport.selectExamType == '' || this.fillBsqReport.selectExamType.includes('eco')){
            var url = '/report/exams/getBirardsEcoAgeMX'
            axios.get(url, {
              params: {
                'dateIni' : (!this.fillBsqReport.date_ini) ? '' : this.fillBsqReport.date_ini,
                'dateEnd' : (!this.fillBsqReport.date_end) ? '' : this.fillBsqReport.date_end,
                'codeDeisRequest' : (!this.fillBsqReport.establishmentRequest) ? '' : this.fillBsqReport.establishmentRequest,
                'codeDeis' : (!this.fillBsqReport.establishmentExam) ? '' : this.fillBsqReport.establishmentExam,
                'commune' : (!this.fillBsqReport.commune) ? '' : this.fillBsqReport.commune,
              }
            }).then(response => {
              this.inicializarPaginacion();
              this.listBirardsEcoAgeMX = response.data;
            })
          }
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
        exportExcel: function () {
        let data = XLSX.utils.json_to_sheet(this.listUsuarios)
        const workbook = XLSX.utils.book_new()
        const filename = 'reporte-siremx'
        XLSX.utils.book_append_sheet(workbook, data, filename)
        XLSX.writeFile(workbook, `${filename}.xlsx`)
        },
        // tableExcel(type, fn, dl) {
        //   var elt = document.getElementById('data-table');
        //   const filename = 'reporte-sismam'
        //   var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
        //   return dl ?
        //     XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
        //     XLSX.writeFile(wb, `${filename}.xlsx`)
        // },
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