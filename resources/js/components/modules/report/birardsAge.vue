<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reporte REM</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
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
                  </div>

                  <template v-if="listRolePermissionsByUser.includes('commune.filter')">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-4 col-form-label">Comuna</label>
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
                    </div>
                  </template>
                  

                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="getRespReport">Generar</button>
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
                            <i class="fas fa-file-excel text-success" @click.prevent="tableExcel"></i>
                        </el-tooltip>
                    </template>
                     Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive p-1">
                <template v-if="listarUsuariosPaginated.length">
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
                      <tr v-for="(item, index) in listarUsuariosPaginated" :key="index">
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
                            <i class="fas fa-file-excel text-success" @click.prevent="tableExcelEco"></i>
                        </el-tooltip>
                    </template>
                     Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive p-1">
                <template v-if="listarUsuariosPaginated.length">
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

      </div>
    </div>
    <div class="modal fade" :class="{show: modalShow}" :style=" modalShow ? mostrarModal : ocultarModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SIREMX</h5>
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
              date_ini: '',
              date_end: '',
              establishmentRequest: '',
              establishmentExam: '',
              commune: ''
            },
            listRolePermissionsByUser: JSON.parse(localStorage.getItem('listRolePermissionsByUser')),
            listEstablishments: [],
            listCommunes: [],
            listUsuarios: [],
            listBirardsEcoAgeMX: [],
            listStatus: [
              {value: 'vig', label: 'Vigente'},
              {value: 'noVig', label: 'No Vigente'},
              {value: 'vencer', label: 'Por Vencer'}
            ],
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
            perPage: 25
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
        this.getRespReport();
        this.getListEstablishments();
        this.getListCommunes();
      },
      methods: {

        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        limpiarCriteriosBsq(){
          this.fillBsqReport.date_ini  = '';
          this.fillBsqReport.date_end = '';
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

          /*if(this.validateForm()) {
                this.modalShow = true;
                return;
          }*/

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
            //console.log(response.data);
            this.inicializarPaginacion();
            this.listUsuarios = response.data;
          })

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
            //console.log(response.data);
            this.inicializarPaginacion();
            this.listBirardsEcoAgeMX = response.data;
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
                //console.log(response.data);
                var oMyBlob = new Blob([response.data], {type : 'application/vnd.ms-excel'}); // the blob
                var url = document.createElement('a')
                url.href = URL.createObjectURL(oMyBlob);
                url.download = 'reporte.xlsx'
                url.click()
                window.open(url)
            }).catch((error) => {
            //console.log(error)
         })  
        },
        exportExcel: function () {
        let data = XLSX.utils.json_to_sheet(this.listUsuarios)
        const workbook = XLSX.utils.book_new()
        const filename = 'reporte-sismam'
        XLSX.utils.book_append_sheet(workbook, data, filename)
        XLSX.writeFile(workbook, `${filename}.xlsx`)
        },
        tableExcel(type, fn, dl) {
          var elt = document.getElementById('data-table');
          const filename = 'reporte-sismam'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
        },
        tableExcelEco(type, fn, dl) {
          var elt = document.getElementById('data-table-eco');
          const filename = 'reporte-sismam'
          var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
          return dl ?
            XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
            XLSX.writeFile(wb, `${filename}.xlsx`)
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
        validateForm() {
            this.error = 0;
            this.mensajeError = [];
            if(!this.fillCreateExam.date_ini) {
                this.mensajeError.push("Debe ingresar fecha de inicio")
            }
            if(!this.fillCreateExam.date_end) {
                this.mensajeError.push("Debe ingresar fecha de termino")
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
    .el-date-editor.el-input, .el-date-editor.el-input__inner {
        width: 100% !important;
    }
    
    .el-range-editor .el-range-separator{
        width: 10% !important;
    }
</style>