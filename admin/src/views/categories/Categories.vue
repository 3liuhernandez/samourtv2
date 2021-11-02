<template>
    <div>
        <CRow>
            <CCol md="12">
                <CCard>
                    <CCardHeader class="d-flex align-items-center flex-wrap">
                        <div>
                            <CIcon name="cil-grid"/> Listado de categorías
                        </div>
                        
                        <div class="card-header-actions ml-auto d-flex">
                            <CButton class="text-nowrap m-0" @click="ToggleModal()"  block variant="outline" color="primary">Agregar nuevo</CButton>
                        </div>
                        
                    </CCardHeader>
                    <CCardBody>
                        <CDataTable 
                            :hover="true" 
                            :striped="true"
                            :border="true"
                            :small="true" 
                            :items="data"
                            :fields="fields"
                            :loading="loading_table" 
                            :itemsPerPageSelect="{
                              label: 'Mostrar por página',
                              external: false
                            }" 
                            :tableFilter="{
                                label: 'Buscar',
                                placeholder: 'Buscar registro...',
                                external: false
                            }" 
                            :noItemsView="{ noResults: 'No hay resultados disponibles', noItems: 'No hay resultados' }" 
                            pagination 
                        >
                            <template #description="{item}">
                                <td>
                                    {{ null == item.description ? '' : item.description  }}
                                </td>
                            </template>

                            <template #accion="{item}">
                                <td>
                                    <CDropdown 
                                        toggler-text="Acción"
                                        color="info"
                                        class="m-0" 
                                        addTogglerClasses="btn-block"
                                    >
                                        <CDropdownItem @click="ToggleModal(item)">Editar</CDropdownItem>
                                        <CDropdownItem @click="deleteCategory(item.accion)">Eliminar</CDropdownItem>
                                    </CDropdown>
                                </td>
                            </template>
                        </CDataTable>
                    </CCardBody>
                </CCard>
            </CCol>
        </CRow>

        <CModal
            :show.sync="modal"
            :no-close-on-backdrop="true"
            :centered="true"
        >
            
            <template #header>
                <h6 class="modal-title">{{ modal_title }}</h6>
                <CButtonClose @click="ToggleModal()"/>
            </template>
            <template #footer>
                <CButton @click="ToggleModal()" color="danger">Cerrar</CButton>
                <CButton :disabled="loading_submit" @click="action ? save() : edit()" color="primary">Guardar</CButton>
            </template>

            <form autocomplete="off" role="form" @submit.prevent="action ? save() : edit()" id="savecategory">
                <CRow>
                   
                    <CCol sm="12">
                        <CInput
                            name="name" 
                            v-model="categoryData.name" 
                            placeholder="Nombre de la categoría" 
                        >
                            <template #label>
                                <label>
                                   Nombre <span class="text-danger">*</span>
                                </label>
                            </template>

                            <template #description>
                                <small class="text-danger">{{ errors.name }}</small>
                            </template>
                        </CInput>
                    </CCol>

                    <CCol sm="12">
                        <CTextarea
                            name="description" 
                            v-model="categoryData.description" 
                            placeholder="Nombre de la categoría" 
                        >
                            <template #label>
                                <label>
                                   Descripción 
                                </label>
                            </template>

                            <template #description>
                                <small class="text-danger">{{ errors.description }}</small>
                            </template>
                        </CTextarea>
                    </CCol>

                </CRow>
            </form>
            <CElementCover v-if="loading_submit" :opacity="0.8"/>
        </CModal>



    </div>
</template>

<style lang="scss">
    .custom-file-label{
        &::after{
            content: 'Buscar';
        }
    }
</style>
<script>
import CTableWrapper from '../../containers/Table.vue'
import axios from "axios";
import { mapGetters } from "vuex";
import { commons } from "../../mixins/commons";

export default {
    name: 'Categories',
    components: { CTableWrapper },
    computed: Object.assign(mapGetters(["api", "user"]), {  }),
    mixins: [commons],
    data () {
        return {
            fields: [
            {
                key: 'name',
                label: 'Categoría'
            },
            {
                key: 'description',
                label: 'Descripción'
            },
            {
                key: 'accion',
                label: 'Acción'
            }],
            modal_title: '',
            data: [],
            loading_table: false,
            modal: false,
            loading_submit: false,
            categoryData: {
                name: '',
                description: '',
                category_id: ''
            },
            errors: {
                name: '',
                description: '',
            },
            password_required: false,
            action: true
        }
    },
    methods: {
        /**
         * Abre el modal en editar o guardar
         */
        ToggleModal(data = null){
            this.clearValues(this.categoryData);
            if(data != null) {
                this.categoryData = {
                    name: data.name,
                    description: data.description,
                    category_id: data.accion
                };
                this.modal_title = 'Editar categoría';
                this.action = false;
                this.password_required = false;
            }
            else{
                this.modal_title = 'Agregar nueva categoría';
                this.action = true;
                this.password_required = true;
            }
            this.modal = !this.modal;
        },
        /**
         * Obtiene todas las categorías
         */
        getData() {
            var $this = this;
            this.loading_table = true;
            axios
            .get(this.api + "categories")
            .then(resp => {
                let data = resp.data;
                let parsedData = [];

                data.forEach(d => {
                    parsedData.push({
                        'name': d.name,
                        'description': d.description,
                        'accion': d.id
                    });
                });
                $this.data = parsedData;
                $this.loading_table = false;
            })
        },
        /**
         * Se encarga en eliminar una categoría
         * 
         * @param category_id: Id de lacategoría
         */
        deleteCategory(category_id){
            var $this = this;
            this.$swal({
                title: '¿Estás seguro?',
                text: "¡Usted no podrá revertir ésto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {

                    axios
                    .delete(this.api + 'categories/'+category_id)
                    .then(resp => {
                        if (resp.status == '200') {
                            this.$swal({
                                position: "center",
                                icon: "success",
                                title: "Eliminado",
                                text: 'Eliminado correctamente',
                                showConfirmButton: false,
                                timer: 1500,
                                onDestroy: () => {
                                    $this.getData();
                                }
                            });
                        } 
                    })
                    .catch(err => {
                        this.$swal({
                            position: "center",
                            icon: "error",
                            title: "Ups!",
                            text: err.message,
                            showConfirmButton: false,
                            timer: 2500,
                            onDestroy: () => { }
                        });
                    });
                    
                    
                }
            });
        },
        /**
         * Guarda una categoría
         */
        save(){
            this.loading_submit = true;
            let __data = new FormData(document.getElementById('savecategory'));
            var $this = this;
            this.clearValues(this.errors);

            axios
            .post(this.api + "categories", __data, {
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
            })
            .then(resp => {
                const data = resp.data;
                if (data.success) {
                    
                    this.$swal({
                        position: "center",
                        icon: "success",
                        title: "Guardado",
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500,
                        onDestroy: () => {
                            $this.modal = false;
                            $this.loading_submit = false;
                            $this.clearValues($this.categoryData);
                            $this.getData();
                        }
                    });
                } else {
                    throw data;
                }
            })
            .catch(err => {
                if(!err.hasOwnProperty('errors')){
                    $this.$swal({
                        position: "center",
                        icon: "error",
                        title: "Ups!",
                        text: err.message,
                        showConfirmButton: false,
                        timer: 2500,
                        onDestroy: () => {
                            $this.loading_submit = false;
                        }
                    });
                }else{
                    $this.loading_submit = false;
                    $this.parseErrors($this.errors, err.errors);
                }
            });
        },

        /**
         * Edita una categoría
         */
        edit(){
            this.loading_submit = true;
            let __data = {
                name: this.categoryData.name,
                description: this.categoryData.description,
                id: this.categoryData.category_id
            };

            var $this = this;
            this.clearValues(this.errors);

            axios
            .put(this.api + "categories/"+this.categoryData.category_id, __data, {
            headers: {
                "Content-Type": "application/json"
            }
            })
            .then(resp => {
                const data = resp.data;
                if (data.success) {
                    
                    this.$swal({
                        position: "center",
                        icon: "success",
                        title: "Guardado",
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500,
                        onDestroy: () => {
                            $this.modal = false;
                            $this.loading_submit = false;
                            $this.clearValues($this.categoryData);
                            $this.getData();
                        }
                    });
                } else {
                    throw data;
                }
            })
            .catch(err => {
                if(!err.hasOwnProperty('errors')){
                    this.$swal({
                        position: "center",
                        icon: "error",
                        title: "Ups!",
                        text: err.message,
                        showConfirmButton: false,
                        timer: 2500,
                        onDestroy: () => {
                            $this.loading_submit = false;
                        }
                    });
                }else{
                    $this.loading_submit = false;
                    this.parseErrors($this.errors, err.errors);
                }
                
            });
        },

    },
    mounted(){
        this.getData();
    }
}
</script>
