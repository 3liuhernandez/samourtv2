<template>
    <div>
        <CRow>
            <CCol md="12">
                <CCard>
                    <CCardHeader class="d-flex align-items-center flex-wrap">
                        <div>
                            <CIcon name="cil-grid"/> Listado de usuarios
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
                            <template #role="{item}">
                                <td>
                                    {{ role.find(data => data.value == item.role).label  }}
                                </td>
                            </template>
                            <template #type="{item}">
                                <td>
                                    {{ type.find(data => data.value == item.type).label  }}
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
                                        <CDropdownItem v-if="item.accion != user.id" @click="deleteUser(item.accion)">Eliminar</CDropdownItem>
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

            <form autocomplete="off" role="form" @submit.prevent="action ? save() : edit()" id="saveuser">
                <CRow>
                   
                    <CCol sm="6">
                        <CInput
                            name="name" 
                            v-model="userData.name" 
                            placeholder="Nombre del usuario" 
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
                        <CInput 
                            type="email" 
                            name="email" 
                            placeholder="Correo electrónico" 
                            v-model="userData.email"
                        >
                            <template #label>
                                <label>
                                   Email <span class="text-danger">*</span>
                                </label>
                            </template>

                            <template #description>
                                <small class="text-danger">{{ errors.email }}</small>
                            </template>
                        </CInput>
                    </CCol>


                    <CCol sm="6">
                        <CSelect 
                            name="role" 
                            @update:value="updateRole" 
                            :value="userData.role" 
                            :options="role"
                        >
                            <template #label>
                                <label>
                                    Seleccionar rol <span class="text-danger">*</span>
                                </label>
                            </template>

                            <template #description>
                                <small class="text-danger">{{ errors.role }}</small>
                            </template>
                            
                        </CSelect>
                    </CCol>

                    <CCol sm="6">
                        <CSelect 
                            name="type" 
                            @update:value="updateType" 
                            :value="userData.type" 
                            :options="type"
                        >
                            <template #label>
                                <label>
                                    Seleccionar Tipo de usuario <span class="text-danger">*</span>
                                </label>
                            </template>

                            <template #description>
                                <small class="text-danger">{{ errors.type }}</small>
                            </template>
                            
                        </CSelect>
                    </CCol>


                    <CCol sm="6">
                        <CInput 
                            type="password" 
                            name="password" 
                            placeholder="Contraseña de ingreso"
                        >
                            <template #label>
                                <label>
                                   Contraseña <span v-if="password_required" class="text-danger">*</span>
                                </label>
                            </template>

                            <template #description>
                                <small class="text-danger">{{ errors.password }}</small>
                            </template>
                        </CInput>
                    </CCol>

                    <CCol sm="6">
                        <CInput 
                            type="password" 
                            name="password_confirmation" 
                            placeholder="Vuelve a escribir la contraseña"
                        >
                            <template #label>
                                <label>
                                   Repetir contraseña <span v-if="password_required" class="text-danger">*</span>
                                </label>
                            </template>

                            <template #description>
                                <small class="text-danger">{{ errors.password_confirmation }}</small>
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
    name: 'Becados',
    components: { CTableWrapper },
    computed: Object.assign(mapGetters(["api", "user"]), {  }),
    mixins: [commons],
    data () {
        return {
            type: [{
                value: '0',
                label: 'Usuario'
            }, {
                value: '1',
                label: 'Administrador'
            }],
            role: [{
                value: '0',
                label: 'Registrado'
            }, {
                value: '1',
                label: 'Premium'
            }],
            fields: [
            {
                key: 'name',
                label: 'Nombre'
            },
            {
                key: 'email',
                label: 'Email'
            },
            {
                key: 'role',
                label: 'Rol'
            },
            {
                key: 'type',
                label: 'Tipo'
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
            userData: {
                name: '',
                email: '',
                role: '',
                type: '',
                user_id: ''
            },
            errors: {
                name: '',
                email: '',
                role: '',
                type: '',
                password: '',
                password_confirmation: ''
            },
            password_required: false,
            action: true
        }
    },
    methods: {
        /**
         * Valor del usuario
         */
        updateRole(value){
            this.userData.role = value;
        },
        /**
         * Valor del tipo de usuario
         */
        updateType(value) {
            this.userData.type = value;
        },
        /**
         * Abre el modal en editar o guardar
         */
        ToggleModal(data = null){
            this.clearValues(this.userData);
            if(data != null) {
                this.userData = {
                    name: data.name,
                    email: data.email,
                    role: data.role,
                    type: data.type,
                    user_id: data.accion
                };
                this.modal_title = 'Editar usuario';
                this.action = false;
                this.password_required = false;
            }
            else{
                this.modal_title = 'Agregar nuevo usuario';
                this.action = true;
                this.password_required = true;
            }
            this.modal = !this.modal;
        },
        /**
         * Obtiene todos los usuarios
         */
        getData() {
            var $this = this;
            this.loading_table = true;
            axios
            .get(this.api + "users")
            .then(resp => {
                let data = resp.data;
                let parsedData = [];

                data.forEach(d => {
                    parsedData.push({
                        'name': d.name,
                        'email': d.email,
                        'role': d.role,
                        'type': d.admin,
                        'accion': d.id
                    });
                });
                $this.data = parsedData;
                $this.loading_table = false;
            })
        },
        /**
         * Se encarga en eliminar un usuario
         * 
         * @param user_id: Id del usuario
         */
        deleteUser(user_id){
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
                    .delete(this.api + 'users/'+user_id)
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
         * Guarda un usuario
         */
        save(){
            this.loading_submit = true;
            let __data = new FormData(document.getElementById('saveuser'));
            var $this = this;
            this.clearValues(this.errors);

            axios
            .post(this.api + "users", __data, {
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
                            $this.clearValues($this.userData);
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
         * Edita un registro de un usuario
         */
        edit(){
            this.loading_submit = true;
            let __data = {
                name: this.userData.name,
                email: this.userData.email,
                role: this.userData.role,
                type: this.userData.type,
                password: this.userData.password,
                password_confirmation: this.userData.password_confirmation,
                id: this.userData.user_id
            };

            var $this = this;
            this.clearValues(this.errors);

            axios
            .put(this.api + "users/"+this.userData.user_id, __data, {
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
                            $this.clearValues($this.userData);
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
