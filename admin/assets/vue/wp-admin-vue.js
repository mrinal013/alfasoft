import Vue from "vue";
import Vuetify from "vuetify/lib";
import App from "./App.vue";
import router from "./router";
import menuFix from "./utils/admin-menu-fix";

Vue.use(Vuetify);
Vue.config.productionTip = false;
/* eslint-disable no-new */
window.addEventListener("load", function() {
  new Vue({
    el: "#app",
    router,
    vuetify: new Vuetify(),
    render: (h) => h(App),
  });
  menuFix("wp-admin-vue");
});
