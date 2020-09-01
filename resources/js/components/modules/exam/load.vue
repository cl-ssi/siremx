<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Carga de exámenes</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Ingrese archivo</h3>
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
                          <label class="col-md-3 col-form-label">Título de la Carga</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" v-model="fillSetLoad.title" >
                            <small class="form-text text-muted"> * Ej: 2020-01 Carga exámenes CESFAM SUR</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-4 col-form-label">Seleccionar Archivo</label>
                          <div class="col-md-9">
                              <input type="file" class="form-control" @change="importExcel">
                              <small class="form-text text-muted">* Extensión xls</small>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-3 col-form-label">Descripción</label>
                          <div class="col-md-9">
                            <textarea class="form-control" v-model="fillSetLoad.description"  rows="3" placeholder="Redactar ..."></textarea>
                            <small class="form-text text-muted"></small>
                          </div>
                        </div>
                      </div>
                    </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="storeExcel">Cargar</button>
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Bandeja de Resultados</h3>
              </div>
              <div class="card-body table-responsive">
                <template >
                    <div class="myTable">
                        <el-table
                            max-height="600"
                            :data="dataArr"
                            v-loading="tableLoading"
                            border
                            style="width: 100%"
                            striped
                            size="mini"
                            fit>
                            <el-table-column
                            :prop="item.prop"
                            :label="item.label"
                            :width="item.width"
                            v-for="(item, i) in tableColumn"
                            :key="i"
                            ></el-table-column>
                        </el-table>
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
                    <h5 class="modal-title"> Siremx</h5>
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
    import xlsx from "xlsx";
    export default {
      data(){
          return {
            dataArr: [], // Table content data array
            // countArr: {}, // Analyze the table data and header to get a cross reference array for user-defined consolidation. For the time being, this article only writes the basis, and does not introduce the automatic consolidation of cells~~My other articles have custom merge implementation methods~
            tableColumn: [], // Table header configuration array
            tableLoading: false, // Whether the table is loading
            examsData: [],
            fillSetLoad: {
              file: '',
              title: '',
              description: ''
            },
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
      methods: {
        limpiarCriteriosBsq(){
          this.fillSetLoad.file  = '';
        },

        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        limpiarBandejaUsuarios(){
          this.examsData = [];
          this.dataArr = [];
        },

        getHeader(sheet) {
            const XLSX = xlsx;
            const headers = [];
            const range = XLSX.utils.decode_range(sheet["!ref"]); // worksheet['!ref'] Is the valid range of the worksheet
            let C;
            /* Get cell value start in the first row */
            const R = range.s.r; //Line / / column C
            let i = 0;
            for (C = range.s.c; C <= range.e.c; ++C) {
                var cell =
                sheet[
                    XLSX.utils.encode_cell({ c: C, r: R })
                ]; /* Get the cell value based on the address  find the cell in the first row */
                var hdr = "UNKNOWN" + C; // replace with your desired default
                // XLSX.utils.format_cell Generate cell text value
                if (cell && cell.t) hdr = XLSX.utils.format_cell(cell);
                if(hdr.indexOf('UNKNOWN') > -1){
                if(!i) {
                    hdr = '__EMPTY';
                }else {
                    hdr = '__EMPTY_' + i;
                }
                i++;
                }
                headers.push(hdr);
            }
            return headers;
        },
    /**
     * Import table
     */
        importExcel(e) {
            const files = e.target.files;
            console.log(files);
            if (!files.length) {
                return ;
            } else if (!/\.(xls|xlsx)$/.test(files[0].name.toLowerCase())) {
                return alert("The upload format is incorrect. Please upload xls or xlsx format");
            }
            const fileReader = new FileReader();
            fileReader.onload = ev => {
                try {
                const data = ev.target.result;
                const XLSX = xlsx;
                const workbook = XLSX.read(data, {
                    type: "binary"
                    , cellDates: true, dateNF: 'yyyy/mm/dd;@'
                });
                const wsname = workbook.SheetNames[0]; // Take the first sheet，wb.SheetNames[0] :Take the name of the first sheet in the sheets
                const ws = XLSX.utils.sheet_to_json(workbook.Sheets[wsname], {raw: false , defval:''}); // Generate JSON table content，wb.Sheets[Sheet]    Get the data of the first sheet
                const excellist = []; // Clear received data
                
                // Edit data
                for (var i = 0; i < ws.length; i++) {
                    excellist.push(ws[i]);
                    this.examsData.push(ws[i]);
                    
                }
                console.log("Read results", excellist); // At this point, you get an array containing objects that need to be processed
                // Get header2-1
                const a = workbook.Sheets[workbook.SheetNames[0]];
                const headers = this.getHeader(a);
                console.log('headers', headers);
                this.setTable(headers, excellist);
                // Get header2-2
                } catch (e) {
                return alert("Read failure!");;
                }
            };
            fileReader.readAsBinaryString(files[0]);
            //var input = document.getElementById("upload");
            //input.value = "";
        },

        setTable(headers, excellist) {
            const tableTitleData = []; // Store table header data
            const tableMapTitle = {}; // Set table content for Chinese and English
            headers.forEach((_, i) => {
                tableMapTitle[_] = "prop" + i;
                tableTitleData.push({
                prop: "prop" + i,
                label: _,
                width: 100
                });
            });
            console.log("tableTitleData", tableTitleData);
            // Mapping table content attribute name is English
            const newTableData = [];
            excellist.forEach(_ => {
                const newObj = {};
                Object.keys(_).forEach(key => {
                newObj[tableMapTitle[key]] = _[key];
                });
                newTableData.push(newObj);
            });
            console.log('newTableData',newTableData);
            this.tableColumn = tableTitleData;
            this.dataArr = newTableData;
        },

        storeExcel() {
          if(this.validForm()) {
            this.modalShow = true;
            return;
          }

          Swal.fire({
            title: '¿Está Seguro de desea cargar el archivo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cargar'
          }).then((result) => {
              if (result.value) {

                let post = {
                  exams: this.examsData,
                  title: this.fillSetLoad.title,
                  description: this.fillSetLoad.description,
                };

                // AQUI IRA LA CONFIRMACIÓN DEL BOTON Y PETICIÓN DEL SERVIDOR
                var  url = '/exam/setLoadExams'

                axios.post(url,post).then(response => {
                     Swal.fire({
                      icon: 'success',
                      title: 'Acción Finalizada',
                      showConfirmButton: false,
                      timer: 1500
                    })
                    //this.getListarUsuarios();
                }).catch(error => {
                    if(error.response.status == 401){
                      this.$router.push({name: 'login'})
                      location.reload();
                      sessionStorage.clear();
                      this.fullscreenLoading = false;
                    }
                })
              
            }
          }) 

        },
        validForm() {
            this.error = 0;
            this.mensajeError = [];

            if(!this.fillSetLoad.title) {
                this.mensajeError.push("Ingrese un título para cargar")
            }
            if(!this.fillSetLoad.description) {
                this.mensajeError.push("Ingrese una descripción de la carga")
            }
            if(!this.examsData.length) {
                this.mensajeError.push("Debe ingresar un archivo de carga")
            }
        
            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        }

      }
    }
</script>
