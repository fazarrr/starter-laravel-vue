import { createRouter, createWebHistory } from "vue-router";

import SigninView from "@/Pages/Authentication/SigninView.vue";
import SignupView from "@/Pages/Authentication/SignupView.vue";
import CalendarView from "@/Pages/CalendarView.vue";
import BasicChartView from "@/Pages/Charts/BasicChartView.vue";
import ECommerceView from "@/Pages/Dashboard/ECommerceView.vue";
import FormElementsView from "@/Pages/Forms/FormElementsView.vue";
import FormLayoutView from "@/Pages/Forms/FormLayoutView.vue";
import SettingsView from "@/Pages/Pages/SettingsView.vue";
import ProfileView from "@/Pages/ProfileView.vue";
import TablesView from "@/Pages/TablesView.vue";
import AlertsView from "@/Pages/UiElements/AlertsView.vue";
import ButtonsView from "@/Pages/UiElements/ButtonsView.vue";

import UserView from "@/Pages/User/UserView.vue";
import UserCreateView from "../Pages/User/UserCreateView.vue";
import UserEditView from "../Pages/User/UserEditView.vue";

const routes = [
    {
        path: "/",
        name: "eCommerce",
        component: ECommerceView,
        meta: {
            title: "eCommerce Dashboard",
        },
    },
    {
        path: "/calendar",
        name: "calendar",
        component: CalendarView,
        meta: {
            title: "Calendar",
        },
    },
    {
        path: "/profile",
        name: "profile",
        component: ProfileView,
        meta: {
            title: "Profile",
        },
    },
    {
        path: "/forms/form-elements",
        name: "formElements",
        component: FormElementsView,
        meta: {
            title: "Form Elements",
        },
    },
    {
        path: "/forms/form-layout",
        name: "formLayout",
        component: FormLayoutView,
        meta: {
            title: "Form Layout",
        },
    },
    {
        path: "/tables",
        name: "tables",
        component: TablesView,
        meta: {
            title: "Tables",
        },
    },
    {
        path: "/pages/settings",
        name: "settings",
        component: SettingsView,
        meta: {
            title: "Settings",
        },
    },
    {
        path: "/charts/basic-chart",
        name: "basicChart",
        component: BasicChartView,
        meta: {
            title: "Basic Chart",
        },
    },
    {
        path: "/ui-elements/alerts",
        name: "alerts",
        component: AlertsView,
        meta: {
            title: "Alerts",
        },
    },
    {
        path: "/ui-elements/buttons",
        name: "buttons",
        component: ButtonsView,
        meta: {
            title: "Buttons",
        },
    },
    {
        path: "/auth/signin",
        name: "signin",
        component: SigninView,
        meta: {
            title: "Signin",
        },
    },
    {
        path: "/auth/signup",
        name: "signup",
        component: SignupView,
        meta: {
            title: "Signup",
        },
    },


    {
        path: "/user",
        name: "user",
        component: UserView,
        meta: {
            title: "Daftar User",
        },
    },
    {
        path: "/user/create",
        name: "userCreate",
        component: UserCreateView,
        meta: {
            title: "Tambah User",
        },
    },
    {
        path: "/user/edit/:id",
        name: "userEdit",
        component: UserEditView,
        meta: {
            title: "Edit User",
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return savedPosition || { left: 0, top: 0 };
    },
});

router.beforeEach((to, from, next) => {
    const { title } = to.meta;
    const defaultTitle = 'Starter Laravel Vue';
  
    document.title = `Starter Laravel Vue || ${title}` || defaultTitle

    // KALAU BELUM LOGIN DI ARAHKAN KE LOGIN
    if (to.name !== 'signin' && localStorage.getItem('token') === null) {next({ name: 'signin' })}

    // KALAU SUDAH LOGIN MENGAKSES LOGIN DI ARAHKAN KE HOME
    if (to.name === 'signin' && localStorage.getItem('token') !== null) {next({ fullPath: '/' })}

    // KALAU SUDAH LOGIN MENGAKSES SIGNUP DI ARAHKAN KE HOME
    if (to.name === 'signup' && localStorage.getItem('token') !== null) {next({ fullPath: '/' })}

    else next()
  })

export default router;
