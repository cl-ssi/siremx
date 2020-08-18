<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reporte Birards por rango de edad</h1>
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
                            default-value="2019-01-02">
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
                            default-value="2019-01-31">
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
                            <i class="fas fa-file-excel text-success" @click.prevent="exportExcel"></i>
                        </el-tooltip>
                    </template>
                     Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive">
                <template v-if="listarUsuariosPaginated.length">
                 <table class="table table-hover table-sm  table-striped table-bordered table-header-fixed text-nowrap table-valign-middle">
                    <thead >
                        <tr>
                            <th colspan="10" class="text-center bordered align-middle table-default">BIRARDS POR RANGO DE EDAD</th>
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
                            <th>total</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in listarUsuariosPaginated" :key="index">
                        <td v-text="item.birards"></td>
                        <td v-text="item.range1"></td>
                        <td v-text="item.range2"></td>
                        <td v-text="item.range3"></td>
                        <td v-text="item.range4"></td>
                        <td v-text="item.range5"></td>
                        <td v-text="item.range6"></td>
                        <td v-text="item.range7"></td>
                        <td v-text="item.range8"></td>
                        <td v-text="item.total"></td>
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
              date_end: ''
            },
            listUsuarios: [],
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
      },
      methods: {
        limpiarCriteriosBsq(){
          this.fillBsqReport.date_ini  = '';
          this.fillBsqReport.date_end = '';
        },
        limpiarBandejaUsuarios(){
          this.listUsuarios = [];
        },
        getRespReport(){
          var url = '/report/exams/getBirardsAgeMX'
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
    .el-date-editor.el-input, .el-date-editor.el-input__inner {
        width: 100% !important;
    }
    
    .el-range-editor .el-range-separator{
        width: 10% !important;
    }
</style>