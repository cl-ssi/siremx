<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Permisos</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/permission/create'">
              <i class="fas fa-plus-square"></i> Nuevo Permiso
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Búsqueda</h3>
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
                        <label class="col-md-3 col-form-label">Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillBsqPermission.name" @keyup.enter="getlistPermissions">
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="getlistPermissions">Buscar</button>
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
                <template v-if="listPermissionsPaginated.length">
                  <table class="table table-hover table-sm  table-striped table-header-fixed text-nowrap table-valign-middle projects">
                    <thead>
                      <th>Nombre</th>
                      <th>Url</th>
                      <th class="text-right"></th>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in listPermissionsPaginated" :key="index">
                        <td v-text="item.name"></td>
                        <td v-text="item.slug"></td>
                        <td class="text-right">
                           <router-link class="btn btn-xs btn-default" :to="{name: 'permission.edit', params: {id: item.id}}">
                            <i class="fas fa-pencil-alt"></i> 
                          </router-link>
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
                        <a href="#" class="page-link" @click.prevent="nextPage">Pos</a>
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
            fillBsqPermission: {
              name: '',
              url: ''
            },
            listPermissions: [],
            pageNumber: 0,
            perPage: 10
          }
      },
      computed: {
        //  Obtener el número de páginas
        pageCount() {
          let a = this.listPermissions.length,
              b = this.perPage;
              return Math.ceil(a/b);
        },
        // Obtener registros paginados
        listPermissionsPaginated() {
          let inicio = this.pageNumber * this.perPage,
              fin    = inicio + this.perPage;
          return this.listPermissions.slice(inicio,fin)
        },
        pagesList() {
          let a = this.listPermissions.length,
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
        this.getlistPermissions();
      },
      methods: {
        limpiarCriteriosBsq(){
          this.fillBsqPermission.name  = '';
        },
        limpiarBandejaUsuarios(){
          this.listPermissions = [];
        },
        getlistPermissions(){
          var url = '/administracion/permission/getlistPermissions'
          axios.get(url, {
            params: {
              'name' : this.fillBsqPermission.name,
              'url'  : this.fillBsqPermission.url,
            }
          }).then(response => {
            console.log(response.data);
            this.initPaginated();
            this.listPermissions = response.data;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
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
        initPaginated() {
          this.pageNumber = 0;
        }
      }
    }
</script>