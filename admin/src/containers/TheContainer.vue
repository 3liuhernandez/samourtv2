<template>
  <div class="c-app">
    <TheSidebar/>
    <CWrapper>
      <TheHeader/>
      <div class="c-body">
        <main class="c-main">
          <CContainer fluid>
            <transition name="fade" mode="out-in">
              <router-view :key="$route.path"></router-view>
            </transition>
          </CContainer>
        </main>
      </div>
      <TheFooter/>
    </CWrapper>
  </div>
</template>

<script>
import TheSidebar from './TheSidebar'
import TheHeader from './TheHeader'
import TheFooter from './TheFooter'
import { mapGetters } from "vuex";
import vueinterval from "vue-interval/dist/VueInterval.common";

export default {
  name: 'TheContainer',
  components: {
    TheSidebar,
    TheHeader,
    TheFooter
  },
  mixins: [vueinterval],
  computed: Object.assign(mapGetters(["isLoggedIn", "token", "user"]), {}),
  methods: {
    /**
     * Revisa la sesión y los datos del usuario para asegurarse de que no exista un logout de su token
     * Si hay un logout del token, se cierra su actividad en la app
     */
    checkUser() {
      if (this.isLoggedIn) {

        let formData = new FormData();
        formData.append('token', this.token);

        this.$store.dispatch("owner", formData)
        .then(data => {
          this.$store.commit("auth_refresh", {id: data.id, name: data.name, email: data.email});
        })
        // Si ya no está logeado, sacamos
        .catch(() => {
          this.$store.dispatch("logout")
          .then(() => {
            this.$router.push("/login");
          });
          
        });
      }
    },
    /**
     * Hace la revisión constante de checkUser
     */
    INTERVAL__1e4$checkSession() {
      this.checkUser();
    },
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
