import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import Form from './components/Tareas/Form.vue';
import Tareas from './components/Tareas/Tareas.vue';
import FormEmpleado from './components/FormEmpleado.vue';
import Login from './components/Login.vue';
import Usuario from './components/Usuario.vue';
import AccesoDenegado from './components/AccesoDenegado.vue';
import FormReporte from './components/Reportes/FormReporte.vue';

const routes = [{
        path: '/',
        redirect: '/login' // Redirige a la página de inicio de sesión por defecto
    },
    {
        path: '/usuario',
        component: Usuario,
    },
    {
        path: '/form',
        component: Form,

    },
    {
        path: '/tareas',
        component: Tareas,

    },
    {
        path: '/empleado',
        component: FormEmpleado,

    },
    {
        path: '/reporte',
        component: FormReporte,
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/accesoDenegado',
        component: AccesoDenegado
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp({});


app.use(router);

app.mount('#app');