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
                            <i class="fas fa-file-excel text-success" @click.prevent="tableExcel"></i>
                        </el-tooltip>
                    </template>
                    Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive">
                <template v-if="listarUsuariosPaginated.length">
                 <table id="data-table" class="table table-hover table-sm table-bordered  table-striped table-header-fixed table-valign-middle projects">
                   <tr class="small text-nowrap">
                      <th>S. Salud</th>
                      <th>Cesfam</th>
                      <th>Profesional Solicita</th>
                      <th>Run</th>
                      <th>Nombre</th>
                      <th>Genero</th>
                      <th>F. Nacimiento</th>
                      <th>Dirección</th>
                      <th>Establecimiento Exámen</th>
                      <th>F. Orden</th>
                      <th>F. Exámen</th>
                      <th>F. Recepción</th>
                      <th>Mamografía</th>
                      <th>Eco Mamografía</th>
                      <th>Médico</th>
                    </tr>
                    <tr class="small ">
                      <tr v-for="(item, index) in listarUsuariosPaginated" :key="index">
                        <td v-text="item.servicio_salud"></td>
                        <td v-text="item.cesfam"></td>
                        <td v-text="item.profesional_solicita"></td>
                        <td v-text="item.patients.run+'-'+item.patients.dv"></td>
                        <td v-text="item.patients.name+' '+item.patients.fathers_family+' '+item.patients.mothers_family"></td>
                        <td v-text="item.patients.gender"></td>
                        <td v-text="item.patients.birthday"></td>
                        <td v-text="item.patients.address"></td>
                        <td v-text="item.establecimiento_realiza_examen"></td>
                        <td v-text="item.date_exam_order"></td>
                        <td v-text="item.date_exam"></td>
                        <td v-text="item.date_exam_reception"></td>
                        <td class="text-center align-middle" v-text="item.birards_mamografia"></td>
                        <td class="text-center align-middle" v-text="item.birards_ecografia"></td>
                        <td v-text="item.medico"></td>
                      </tr>
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
              date_ini: '',
              date_end: ''
            },
            listUsuarios: [],
            listStatus: [
              {value: 'vig', label: 'Vigente'},
              {value: 'noVig', label: 'No Vigente'},
              {value: 'vencer', label: 'Por Vencer'}
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
      methods: {
        limpiarCriteriosBsq(){
          this.fillBsqReport.nRun  = '';
          this.fillBsqReport.cName = '';
          this.fillBsqReport.cFathers_family  = '';
        },
        limpiarBandejaUsuarios(){
          this.listUsuarios = [];
        },
        getRespReport(){
          var url = '/report/exams/getMX'
          axios.get(url, {
            params: {
              'dateIni' : (!this.fillBsqReport.date_ini) ? '' : this.fillBsqReport.date_ini,
              'dateEnd' : (!this.fillBsqReport.date_end) ? '' : this.fillBsqReport.date_end,
            }
          }).then(response => {
            console.log(response.data);
            this.inicializarPaginacion();
            this.listUsuarios = response.data;
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