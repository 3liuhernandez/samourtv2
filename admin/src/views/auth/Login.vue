<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="8">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm @submit.prevent="login()" id="loginform">
                  <h1>Iniciar sesión</h1>
                  <p class="text-muted">PANEL ADMISTRATIVO</p>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" role="img" class="c-icon"><path fill="var(--ci-primary-color, currentColor)" d="M411.6,343.656l-72.823-47.334,27.455-50.334A80.23,80.23,0,0,0,376,207.681V128a112,112,0,0,0-224,0v79.681a80.236,80.236,0,0,0,9.768,38.308l27.455,50.333L116.4,343.656A79.725,79.725,0,0,0,80,410.732V496H448V410.732A79.727,79.727,0,0,0,411.6,343.656ZM416,464H112V410.732a47.836,47.836,0,0,1,21.841-40.246l97.66-63.479-41.64-76.341A48.146,48.146,0,0,1,184,207.681V128a80,80,0,0,1,160,0v79.681a48.146,48.146,0,0,1-5.861,22.985L296.5,307.007l97.662,63.479h0A47.836,47.836,0,0,1,416,410.732Z" class="ci-primary"></path></svg>
                        </span>
                      </div>
                      <input type="email" name="email" placeholder="Correo electrónico" class="form-control">
                    </div>
                    <small class="text-danger">{{ errors.email }}</small>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" role="img" class="c-icon"><path fill="var(--ci-primary-color, currentColor)" d="M384,200V144a128,128,0,0,0-256,0v56H88V328c0,92.635,75.364,168,168,168s168-75.365,168-168V200ZM160,144a96,96,0,0,1,192,0v56H160ZM392,328c0,74.99-61.01,136-136,136s-136-61.01-136-136V232H392Z" class="ci-primary"></path></svg>
                        </span>
                      </div>
                      <input type="password" name="password" placeholder="Contraseña" class="form-control">
                    </div>
                    <small class="text-danger">{{ errors.password }}</small>
                  </div>
                  <CRow>
                    <CCol col="12" sm="6" md="8" class="text-left">
                      <CButton :disabled="loading_submit" type="submit" color="primary" class="px-4">Iniciar sesión</CButton>
                    </CCol>
                  </CRow>
                </CForm>
                <CElementCover v-if="loading_submit" :opacity="0.8"/>
              </CCardBody>
            </CCard>
            <CCard
              color="primary"
              text-color="white"
              class="text-center py-5 d-md-down-none"
              body-wrapper
            >
              <CCardBody>
                <h2>UNIR</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import { commons } from "../../mixins/commons";
export default {
  name: 'Login',
  mixins: [commons],
  data(){
    return {
      loading_submit: false,
      errors: {
        email: '',
        password: '',
      }
    }
  },
  methods: {
    login(){
      this.loading_submit = true;
      var formData = new FormData(document.getElementById('loginform'));
      var $this = this;
      this.clearValues(this.errors);

      this.$store
      .dispatch('login', formData)
      .then(data => {
        $this.loading_submit = false;
        this.$store.commit("auth_success", {token: data.body.access_token, user: data.user});
        $this.$router.push('/dashboard');
      })
      .catch((err) => {
        if(typeof err == 'string'){
          $this.$swal({
              position: "center",
              icon: "error",
              title: "Ups!",
              text: err,
              showConfirmButton: false,
              timer: 2500,
              onDestroy: () => {
                  $this.loading_submit = false;
              }
          });
        }else{
          $this.loading_submit = false;
          $this.parseErrors($this.errors, err);
        }
      });

      
      // this.$store.dispatch('login', );
    }
  }

}
</script>
