import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import menuFix from "./utils/admin-menu-fix";

Vue.config.productionTip = false;

/* eslint-disable no-new */
window.addEventListener("load", function() {
  new Vue({
    el: "#app",
    router,
    render: (h) => h(App),
  });
  menuFix("wp-admin-vue");
});
