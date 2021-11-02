<template>
    <div>
        <CRow>
            <CCol md="12">
                <CCard>
                    <CCardHeader class="d-flex align-items-center flex-wrap">
                        <div>
                            <CIcon name="cil-grid"/> Listado de productos
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
            size="lg" 
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
                   
                    <CCol sm="6">
                        <CInput
                            name="name" 
                            v-model="productData.name" 
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

                    <CCol sm="6">
                        <CSelect
                            :options="categories"
                            placeholder="Seleccionar categoría"
                            v-model="productData.category_id" 
                            name="category_id"
                        >
                            <template #label>
                                <label>
                                   Categoría <span class="text-danger">*</span>
                                </label>
                            </template>

                             <template #description>
                                <small class="text-danger">{{ errors.category_id }}</small>
                            </template>
                        </CSelect>
                    </CCol>

                    <CCol sm="6">
                        <CInput
                            name="author" 
                            v-model="productData.author" 
                            placeholder="Nombre del autor" 
                        >
                            <template #label>
                                <label>
                                   Autor <span class="text-danger">*</span>
                                </label>
                            </template>

                            <template #description>
                                <small class="text-danger">{{ errors.name }}</small>
                            </template>
                        </CInput>
                    </CCol>

                    <CCol sm="6">
                        <CSelect
                            :options="type"
                            placeholder="Seleccionar tipo"
                            v-model="productData.type" 
                            name="type"
                        >
                            <template #label>
                                <label>
                                   Tipo de producto <span class="text-danger">*</span>
                                </label>
                            </template>

                             <template #description>
                                <small class="text-danger">{{ errors.type }}</small>
                            </template>
                        </CSelect>
                    </CCol>

                    <CCol sm="12">
                        <CTextarea
                            name="description" 
                            v-model="productData.description" 
                            placeholder="Nombre de la categoría" 
                            rows="9" 
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

                    <CCol sm="12">
                        <label for="id_thumbnail">Imagen de portada <span class="text-danger">*</span></label>
                        <div class="image-upload">
                            <label for="id_thumbnail">
                                <CImg
                                    :thumbnail="true" 
                                    :src="image_thumb" 
                                    block 
                                    class="mb-2"
                                />
                            </label>
                            <input type="file" class="file" name="thumbnail" id="id_thumbnail" @change="selectImage">
                        </div>
                    </CCol>

                    <CCol sm="12">
                        <CInput
                            type="email" 
                            name="media_name"
                            placeholder="Subir archivo de música" 
                            :readonly="media_name_readonly" 
                            v-model="media_name"
                        >
                            <template #label>
                                <label>
                                   Archivo de música <span class="text-danger">*</span> 
                                </label>
                            </template>
                            <template #append>
                                <CButton type="button" color="primary" @click="$refs.media_file.click()">Subir archivo</CButton>
                                <input type="file" name="media" id="id_media"  @change="mediaFile" style="display: none;" ref="media_file">
                            </template>
                        </CInput>
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
    name: 'Products',
    components: { CTableWrapper },
    computed: Object.assign(mapGetters(["api", "user"]), { 
        image_thumb(){
            return this.image;
        }
    }),
    mixins: [commons],
    data () {
        return {
            type: [
                {label: 'Gratis', value: '0'},
                {label: 'Premium', value: '1'},
            ],
            categories: [],
            fields: [
            {
                key: 'name',
                label: 'Título'
            },
            {
                key: 'category_id',
                label: 'Categoría'
            },
            {
                key: 'author',
                label: 'Autor'
            },
            {
                key: 'type',
                label: 'Tipo'
            },
            {
                key: 'thumbnail',
                label: 'Portada'
            },
            {
                key: 'media',
                label: 'Media'
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
            productData: {
                name : '',
                category_id : '',
                author : '',
                type : '',
                thumbnail : '',
                media : '',
                description : '',
                product_id : '',
            },
            errors: {
                name : '',
                category_id : '',
                author : '',
                type : '',
                thumbnail : '',
                media : '',
                description : '',
            },
            password_required: false,
            action: true,
            image: 'https://www.sinrumbofijo.com/wp-content/uploads/2016/05/default-placeholder.png',
            media_name: '',
            media_name_readonly: true
        }
    },
    methods: {
        /**
         * Archivo de música a subir
         */
        mediaFile(e){
            const file = e.target.files[0];
            this.media_name = file.name;
            this.media_name_readonly = false;
        },
        /**
         * Cambia una imagen
         */
        selectImage(e){
            const file = e.target.files[0];
            this.image = URL.createObjectURL(file);
        },
        /**
         * Abre el modal en editar o guardar
         */
        ToggleModal(data = null){
            this.clearValues(this.productData);
            if(data != null) {
                this.productData = {
                    name: data.name,
                    category_id: data.category_id,
                    author: data.author,
                    type: data.type,
                    thumbnail: data.thumbnail,
                    media: data.media,
                    description: data.description,
                    product_id: data.accion
                };
                this.modal_title = 'Editar producto';
                this.action = false;
                this.password_required = false;
            }
            else{
                this.modal_title = 'Agregar nuevo producto';
                this.action = true;
                this.password_required = true;
            }
            this.modal = !this.modal;
        },
         /**
         * Obtiene todas las categorías
         */
        getCategories() {
            var $this = this;
            axios
            .get(this.api + "categories")
            .then(resp => {
                let data = resp.data;
                let parsedData = [];

                data.forEach(d => {
                    parsedData.push({
                        label: d.name,
                        value: d.id
                    });
                });
                $this.categories = parsedData;
            })
        },
        /**
         * Obtiene todas las músicas
         */
        getData() {
            var $this = this;
            this.loading_table = true;
            axios
            .get(this.api + "products")
            .then(resp => {
                let data = resp.data;
                let parsedData = [];

                data.forEach(d => {
                    parsedData.push({
                        'name' : d.name,
                        'category_id' : d.category_id, 
                        'author' : d.author,
                        'type' : d.type,
                        'thumbnail' : d.thumbnail,
                        'media' : d.media,
                        'description' : d.description,
                        'accion' : d.id,
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
                            $this.clearValues($this.productData);
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
                name: this.productData.name,
                description: this.productData.description,
                id: this.productData.category_id
            };

            var $this = this;
            this.clearValues(this.errors);

            axios
            .put(this.api + "categories/"+this.productData.category_id, __data, {
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
                            $this.clearValues($this.productData);
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
        this.getCategories();
    }
}
</script>
