import Vue from "vue";
import Router from "vue-router";
import Home from "../pages/Home.vue";
import Settings from "../pages/Settings.vue";
import Inspire from "../pages/Inspire.vue";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "Home",
      component: Home,
    },
    {
      path: "/settings",
      name: "Settings",
      component: Settings,
    },
    {
      path: "/inspire",
      name: "Inspire",
      component: Inspire,
    },
  ],
});
