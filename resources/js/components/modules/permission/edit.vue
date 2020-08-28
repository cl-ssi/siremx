<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Permiso</h1>
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
                        <h3 class="card-title">Editar Permiso</h3>
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
                                            <input type="text" class="form-control" v-model="fillEditPermission.name" @keyup.enter="setEditPermission">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label">Url Amigable</label>
                                            <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="fillEditPermission.slug" @keyup.enter="setEditPermission">
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-md-3 offset-4">
                            <button class="btn btn-flat btn-info btnWidth" @click.prevent="setEditPermission" 
                            v-loading.fullscreen.lock="fullscreenLoading">Editar</button>
                            <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button>
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
    export default {
      data(){
          return {
            fillEditPermission: {
              idPermission: this.$attrs.id,
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
        this.getlistPermissions();
      },
      methods: {
        limpiarCriterios(){
          this.fillEditPermission.name = '';
          this.fillEditPermission.slug = '';
        },
        abrirModal(){
            this.modalShow = !this.modalShow;
        },
        getlistPermissions(){
          var url = '/administracion/permission/getlistPermissions'
          axios.get(url, {
            params: {
              'idPermission' : this.fillEditPermission.idPermission
            }
          }).then(response => {
            console.log(response.data[0].name);
            this.fillEditPermission.name = response.data[0].name;
            this.fillEditPermission.slug = response.data[0].slug;
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        setEditPermission(){
            if(this.validStore()) {
                console.log("en agregar");
                this.modalShow = true;
                return;
            }
            this.fullscreenLoading = true;

          var  url = '/administracion/permission/setEditPermission'
          axios.post(url, {
            'idPermission'  : this.fillEditPermission.idPermission,
            'name'          : this.fillEditPermission.name,
            'slug'          : this.fillEditPermission.slug,

          }).then(response => {
            this.fullscreenLoading = false;
             Swal.fire({
                icon: 'success',
                title: 'Actualizado',
                showConfirmButton: false,
                timer: 1500
              })
          }).catch(error => {
              if(error.response.status == 401){
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
          })
        },
        validStore() {
            this.error = 0;
            this.mensajeError = [];
            if(!this.fillEditPermission.name) {
                this.mensajeError.push("Nombre es un campo obligatorio")
            }
            if(!this.fillEditPermission.slug) {
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
