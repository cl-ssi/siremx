<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Historial Clinico del Paciente</h1>
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
                        <label class="col-md-3 col-form-label">Rut</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillBsqReport.run" @keyup.enter="getRespReport">
                          <small class="form-text text-muted">Utilizar formato: 13650969-1</small>
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
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                    <template v-if="listPatientsPaginated.length">
                        <el-tooltip class="item" effect="dark" content="Descargar en Excel" placement="bottom-start">
                            <i class="fas fa-file-excel text-success" @click.prevent="tableExcel"></i>
                        </el-tooltip>
                    </template>
                    Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive p-1">
                <template v-if="listPatientsPaginated.length">
                 <table id="data-table" class="table table-hover table-sm table-striped table-bordered table-header-fixed text-nowrap table-valign-middle table-responsive">
                    <tr class="small text-nowrap">
                      <th class="text-center bg-secondary">ID</th>
                      <th class="text-center bg-secondary">S. SALUD</th>
                      <th class="text-center bg-secondary">CESFAM</th>
                      <th class="text-center bg-secondary">PROFESIONA SOL.</th>
                      <th class="text-center bg-secondary">RUN</th>
                      <th class="text-center bg-secondary">NOMBRE</th>
                      <th class="text-center bg-secondary">GENERO</th>
                      <th class="text-center bg-secondary">F. NAC</th>
                      <th class="text-center bg-secondary">EDAD</th>
                      <th class="text-center bg-secondary">DIRECCION</th>
                      <th class="text-center bg-secondary">EST. EXAMEN</th>
                      <th class="text-center bg-secondary">F. ORDEN</th>
                      <th class="text-center bg-secondary">F. EXAMEN</th>
                      <th class="text-center bg-secondary">F. RESULTADO</th>
                      <th class="text-center bg-secondary">MAMOGRAFIA</th>
                      <th class="text-center bg-secondary">ECOGRAFIA</th>
                      <th class="text-center bg-secondary">PROYECCION</th>
                      <th class="text-center bg-secondary">MEDICO</th>
                      <th class="text-center bg-secondary">INFORME</th>
                    </tr>
                    <tr class="small " v-for="(item, index) in listPatients" :key="index">
                      <td v-text="item.id"></td>
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
                      <td v-text="item.medico"></td>
                      <td >
                        <template v-if="item.path">
                            <a class="btn btb-flat btn-xs btn-default" target="_blank" :href="'/siremx/exam/downloadExamById/'+ item.id">
                                <i class="fas fa-search text-dark"></i> Ver Informe
                            </a>
                         </template>
                      </td>
                    </tr>
                 
                  </table>
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
              run: '',
              name: '',
              establishmentRequest: '',
              establishmentExam: '',
              commune: ''
            },
            listRolePermissionsByUser: JSON.parse(localStorage.getItem('listRolePermissionsByUser')),
            listEstablishments: [],
            listCommunes: [],
            listPatients: [],
            listStatus: [
              {value: 'vig', label: 'Vigente'},
              {value: 'noVig', label: 'No Vigente'},
              {value: 'vencer', label: 'Por Vencer'}
            ],
            pageNumber: 0,
            perPage: 25
          }
      },
      computed: {
        //  Obtener el número de páginas
        pageCount() {
          let a = this.listPatients.length,
              b = this.perPage;
              return Math.ceil(a/b);
        },
        // Obtener registros paginados
        listPatientsPaginated() {
          let inicio = this.pageNumber * this.perPage,
              fin    = inicio + this.perPage;
          return this.listPatients.slice(inicio,fin)
        },
        pagesList() {
          let a = this.listPatients.length,
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
        limpiarCriteriosBsq(){
          this.fillBsqReport.run  = '';
          this.fillBsqReport.name = '';
          this.fillBsqReport.fathers_family  = '';
        },
        limpiarBandejaUsuarios(){
          this.listPatients = [];
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

          const loading = this.$loading({
            lock: true,
            text: 'Generando Informe',
            spinner: 'el-icon-loading',
            background: 'rgba(0, 0, 0, 0.7)'
          });

          var url = '/report/exams/getPatientHistoryClinical'
          axios.get(url, {
            params: {
              'run' : this.fillBsqReport.run,
              'codeDeisRequest' : (!this.fillBsqReport.establishmentRequest) ? '' : this.fillBsqReport.establishmentRequest,
              'codeDeis' : (!this.fillBsqReport.establishmentExam) ? '' : this.fillBsqReport.establishmentExam,
              'commune' : (!this.fillBsqReport.commune) ? '' : this.fillBsqReport.commune,
            }
          }).then(response => {
            console.log(response.data);
            this.inicializarPaginacion();
            this.listPatients = response.data;
            console.log(this.listPatients);
            loading.close();

          })
        },
        exportExcel: function () {
        let data = XLSX.utils.json_to_sheet(this.listPatients)
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