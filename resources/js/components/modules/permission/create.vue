<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Permiso</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/permission'">
              <i class="fas fa-arrow-left"></i> Regresar
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Permiso</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <form role="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label">Nombre</label>
                                            <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillCreatePermission.name" @keyup.enter="setAddRole">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label">Url Amigable</label>
                                            <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillCreatePermission.slug" @keyup.enter="setAddRole">
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-md-6 offset-6">
                            <button class="btn btn-flat btn-info btnWidth" @click.prevent="setAddRole" 
                            v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
                            <button class="btn btn-flat btn-default btnWidth" @click.prevent="cleanForm">Limpiar</button>
                        </div>
                        </div>
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
                    <h5 class="modal-title"> Sismam</h5>
                    <button class="close" @click="openModal"></button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-danger" v-for="(item, index) in mensajeError" :key="index" v-text="item">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="openModal">Cerrar</button>
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
            fillCreatePermission: {
              name: '',
              slug: '',
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
      mounted() {
        
      },
      methods: {
        cleanForm(){
          this.fillCreatePermission.name = '';
          this.fillCreatePermission.role = '';
        },
        openModal(){
            this.modalShow = !this.modalShow;
        },
        setAddRole() {
            
            if(this.validStore()) {
                console.log("en agregar");
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading = true;
            this.setStorePermission();
        },
        setStorePermission(){
          var  url = '/administracion/permission/setStorePermission'
          axios.post(url, {
            'name'                   : this.fillCreatePermission.name,
            'slug'                   : this.fillCreatePermission.slug

          }).then(response => {
            console.log("Se creao Rol exitosamente");
            this.fullscreenLoading = false;
            this.$router.push('/permission');
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                localStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        validStore() {
            this.error = 0;
            this.mensajeError = [];
            if(!this.fillCreatePermission.name) {
                this.mensajeError.push("Nombre es un campo obligatorio")
            }
            if(!this.fillCreatePermission.slug) {
                this.mensajeError.push("Url es un campo obligatorio")
            }

            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        }
      }
    }
</script>
