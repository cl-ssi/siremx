<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pacientes</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/patient/create'">
              <i class="fas fa-plus-square"></i> Nuevo Paciente
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
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Rut</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillBsqUsuario.nRun" @keyup.enter="getListarUsuarios">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillBsqUsuario.cName" @keyup.enter="getListarUsuarios">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-3 col-form-label">Apellido Paterno</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillBsqUsuario.cFathers_family" @keyup.enter="getListarUsuarios">
                        </div>
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
                    <thead>
                      <th>Rut</th>
                      <th>Nombres</th>
                      <th>F. Nacimiento</th>
                      <th>Edad</th>
                      <th>Dirección</th>
                      <th>Telefóno</th>
                      <th></th>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in listarUsuariosPaginated" :key="index">
                        <td v-text="item.run+'-'+item.dv"></td>
                        <td v-text="item.name+' '+item.fathers_family+' '+item.mothers_family"></td>
                        <td v-text="item.birthday"></td>
                        <td v-text="item.age"></td>
                        <td v-text="item.address"></td>
                        <td v-text="item.telephone"></td>
                        <td>
                          <!--<template v-if="listRolePermissionsByUser.includes('user.edit')">-->
                              <router-link class="btn btb-flat btn-xs btn-default" :to="{name: 'patient.edit', params: {id: item.id}}">
                                <i class="fas fa-pencil-alt"></i> 
                              </router-link>
                           <!-- </template>-->
                        </td>
                      </tr>
                    </tbody>
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
    export default {
      data(){
          return {
            fillBsqUsuario: {
              nRun: '',
              cName: '',
              cFathers_family: ''
            },
            listUsuarios: [],
            listEstados: [
              {value: 'A', label: 'Activo'},
              {value: 'I', label: 'Inactivo'}
            ],
            pageNumber: 0,
            perPage: 50
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
          this.fillBsqUsuario.nRun  = '';
          this.fillBsqUsuario.cName = '';
          this.fillBsqUsuario.cFathers_family  = '';
        },
        limpiarBandejaUsuarios(){
          this.listUsuarios = [];
        },
        getListarUsuarios(){
          var url = '/administracion/patient/getListarPatients'
          axios.get(url, {
            params: {
              'nRun' : this.fillBsqUsuario.nRun,
              'cName' : this.fillBsqUsuario.cName,
              'cFathers_family': this.fillBsqUsuario.cFathers_family,
            }
          }).then(response => {
            console.log(response.data);
            this.inicializarPaginacion();
            this.listUsuarios = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
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
