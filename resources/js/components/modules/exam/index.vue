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
            <router-link class="btn btn-info btn-sm" :to="'/exam/create'">
              <i class="fas fa-plus-square"></i> Registrar Exámen
            </router-link>
          </div>
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
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Run</label>
                        <input type="text" class="form-control" v-model="fillBsqUsuario.nRun" @keyup.enter="getListarUsuarios">
                        <small class="form-text text-muted">Utilizar Run Sin punto y sin digito verificador</small>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" v-model="fillBsqUsuario.cName" @keyup.enter="getListarUsuarios">
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label>Apellido Paterno</label>
                        <input type="text" class="form-control" v-model="fillBsqUsuario.cFathers_family" @keyup.enter="getListarUsuarios">
                      </div>
                    </div>
                  </div>

                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="getListarUsuarios">Buscar</button>
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
                <template v-if="listarUsuariosPaginated.length">
                  <table class="table table-hover table-sm  table-striped table-header-fixed text-nowrap table-valign-middle projects">
                    <thead >
                      <th></th>
                      <th>Nº REG</th>
                      <th>COMUNA</th>
                      <th>EST. ORIGEN</th>
                      <th>FECHA TOMA EXAMEN</th>
                      <th>TIPO EXAMEN</th>
                      <th>RUN</th>
                      <th>APELLIDOS</th>
                      <th>NOMBRE</th>
                      <th>F. NACIMIENTO</th>
                      <th>USUARIO</th>
                      <th></th>
                    </thead>
                    <tbody class="small">
                      <tr v-for="(item, index) in listarUsuariosPaginated" :key="index">
                        <td>
                          <button v-if="item.date_exam_reception  && item.exam_type &&  (item.birards_proyeccion || item.birards_ecografia || item.birards_mamografia  ) " class="btn btb-flat btn-xs  btn-default" >
                            <i class="fas fa-check-double text-info"></i> 
                          </button>
                          <button v-else class="btn btb-flat btn-xs   btn-default" >
                            <i class="fas fa-check text-secondary"></i> 
                          </button>
                        </td>
                        <td v-text="item.id"></td>
                        <td v-text="item.commune"></td>
                        <td class=" text-wrap" v-text="item.establishment_origin"></td>
                        <td >{{ item.date_exam | moment("DD-MM-YYYY") }}</td>
                        <td v-text="item.exam_type"></td>
                        <td v-text="item.run+'-'+item.dv"></td>
                        <td v-text="item.fathers_family+' '+item.mothers_family"></td>
                        <td v-text="item.name"></td>
                        <td >{{ item.birthday | moment("DD-MM-YYYY") }}</td>
                        <td v-text="item.firstname+' '+item.lastname"></td>
                        <td class="text-right">
                          <template v-if="listRolePermissionsByUser.includes('exam.view')"> 
                              <router-link class="btn btn-xs btn-default" :to="{name: 'exam.view', params: {id: item.patient_id}}">
                                <i class="fas fa-history"></i> 
                              </router-link>
                          </template>

                          <template v-if="item.path">
                              <a class="btn btb-flat btn-xs btn-default" target="_blank" :href="item.path" >
                                  <i class="fas fa-search text-dark"></i> Informe
                              </a>
                          </template>
                          <template v-if="listRolePermissionsByUser.includes('exam.edit')">
                              <router-link class="btn btb-flat btn-xs btn-default" :to="{name: 'exam.edit', params: {id: item.id}}">
                                <i class="fas fa-pencil-alt"></i> 
                              </router-link>
                          </template>
                          <template v-if="listRolePermissionsByUser.includes('exam.delete')">
                            <button v-if="item.user_id == authUser_id" class="btn btb-flat btn-xs btn-default"  @click.prevent="setDelete(item.id)">
                                  <i class="fas fa-trash text-danger"></i> 
                            </button>
                            <button v-else class="btn btb-flat btn-xs btn-default">
                                  <i class="fas fa-ban text-default"></i> 
                            </button>
                          </template>
                          <template v-if="listRolePermissionsByUser.includes('admin.delete')">
                            <button class="btn btb-flat btn-xs bg-gradient-secondary"  @click.prevent="setDelete(item.id)">
                                  <i class="fas fa-trash text-default"></i> Eliminar
                            </button>
                          </template>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm pagination-info m-0 float-right">
                      <li class="page-item" v-if="pageNumber > 0">
                        <a href="#" class="page-link bg-info" @click.prevent="prevPage">Ant</a>
                      </li>
                      <li class="page-item" v-for="(page, index) in pagesList" :key="index"
                        :class="[page == pageNumber ? 'active' : '']">
                        <a href="#" class="page-link bg-info" @click.prevent="selectPage(page)">{{ page+1 }}</a>
                      </li>
                      <li class="page-item" v-if="pageNumber < pageCount -1">
                        <a href="#" class="page-link bg-info" @click.prevent="nextPage">Pos</a>
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
    export default {
      data(){
          return {
            fillBsqUsuario: {
              nRun: '',
              cName: '',
              cFathers_family: ''
            },
            authUser_id: '',
            listUsuarios: [],
            listRolePermissionsByUser: JSON.parse(localStorage.getItem('listRolePermissionsByUser')),
            authUser: JSON.parse(localStorage.getItem('authUser')), 
            listEstados: [
              {value: 'A', label: 'Activo'},
              {value: 'I', label: 'Inactivo'}
            ],
            pageNumber: 0,
            perPage: 50
          }
      }, 
      mounted(){
        this.getListarUsuarios();
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
          this.fillBsqUsuario.nRun  = '';
          this.fillBsqUsuario.cName = '';
          this.fillBsqUsuario.cFathers_family  = '';
        },
        limpiarBandejaUsuarios(){
          this.listUsuarios = [];
        },
        getListarUsuarios(){
          this.authUser_id = this.authUser.id;
          var url = '/exam/getListExams'
          axios.get(url, {
            params: {
              'nRun' : this.fillBsqUsuario.nRun,
              'cName' : this.fillBsqUsuario.cName,
              'cFathers_family': this.fillBsqUsuario.cFathers_family,
            }
          }).then(response => {
            //console.log(response.data);
            this.inicializarPaginacion();
            this.listUsuarios = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        setDelete(id){
          //console.log(id)
          Swal.fire({
            title: '¿Está Seguro de eliminar el registro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, eliminar'
          }).then((result) => {
              if (result.value) {
              // AQUI IRA LA CONFIRMACIÓN DEL BOTON Y PETICIÓN DEL SERVIDOR
                var  url = '/exam/setDeleteExam'
                axios.post(url, {
                  'idExam' : id,

                }).then(response => {
                     Swal.fire({
                      icon: 'success',
                      title: 'Se elimino el registro',
                      showConfirmButton: false,
                      timer: 1500
                    })
                    this.getListarUsuarios();
                }).catch(error => {
                    if(error.response.status == 401){
                      this.$router.push({name: 'login'})
                      location.reload();
                      localStorage.clear();
                      this.fullscreenLoading = false;
                    }
                })
              
            }
          })// end
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
