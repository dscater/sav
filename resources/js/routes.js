import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    routes: [
        // INICIO
        {
            path: '/administracion/inicio',
            name: 'inicio',
            component: require('./components/Inicio.vue').default
        },

        // LOGIN
        {
            path: '/administracion/login',
            name: 'login',
            component: require('./Auth.vue').default
        },

        // Usuarios
        {
            path: '/administracion/usuarios/perfil/:id',
            name: 'usuarios.perfil',
            component: require('./components/modulos/usuarios/perfil.vue').default,
            props: true
        },
        {
            path: '/administracion/usuarios',
            name: 'usuarios.index',
            component: require('./components/modulos/usuarios/index.vue').default
        },

        // FAQs
        {
            path: '/administracion/faqs',
            name: 'faqs.index',
            component: require('./components/modulos/faqs/index.vue').default,
        },

        // Chats
        {
            path: '/administracion/chats',
            name: 'chats.index',
            component: require('./components/modulos/chats/index.vue').default,
        },

        // Modelos
        {
            path: '/administracion/modelos',
            name: 'modelos.index',
            component: require('./components/modulos/modelos/index.vue').default,
        },

        // Marcas
        {
            path: '/administracion/marcas',
            name: 'marcas.index',
            component: require('./components/modulos/marcas/index.vue').default,
        },

        // Tipos
        {
            path: '/administracion/tipos',
            name: 'tipos.index',
            component: require('./components/modulos/tipos/index.vue').default,
        },

        // Anios
        {
            path: '/administracion/anios',
            name: 'anios.index',
            component: require('./components/modulos/anios/index.vue').default,
        },

        // Vehiculos
        {
            path: '/administracion/vehiculos',
            name: 'vehiculos.index',
            component: require('./components/modulos/vehiculos/index.vue').default,
        },

        // Caracteristicas
        {
            path: '/administracion/caracteristicas',
            name: 'caracteristicas.index',
            component: require('./components/modulos/caracteristicas/index.vue').default,
        },

        // Visitantes
        {
            path: '/administracion/visitantes',
            name: 'visitantes.index',
            component: require('./components/modulos/visitantes/index.vue').default,
        },

        // Configuración
        {
            path: '/administracion/configuracion',
            name: 'configuracion',
            component: require('./components/modulos/configuracion/index.vue').default,
            props: true
        },

        // Reportes
        {
            path: '/administracion/reportes/usuarios',
            name: 'reportes.usuarios',
            component: require('./components/modulos/reportes/usuarios.vue').default,
            props: true
        },
        {
            path: '/administracion/reportes/kardex',
            name: 'reportes.kardex',
            component: require('./components/modulos/reportes/kardex.vue').default,
            props: true
        },
        {
            path: '/administracion/reportes/ventas',
            name: 'reportes.ventas',
            component: require('./components/modulos/reportes/ventas.vue').default,
            props: true
        },
        {
            path: '/administracion/reportes/stock_productos',
            name: 'reportes.stock_productos',
            component: require('./components/modulos/reportes/stock_productos.vue').default,
            props: true
        },
        {
            path: '/administracion/reportes/historial_acciones',
            name: 'reportes.historial_acciones',
            component: require('./components/modulos/reportes/historial_acciones.vue').default,
            props: true
        },
        {
            path: '/administracion/reportes/grafico_ingresos',
            name: 'reportes.grafico_ingresos',
            component: require('./components/modulos/reportes/grafico_ingresos.vue').default,
            props: true
        },
        {
            path: '/administracion/reportes/grafico_orden',
            name: 'reportes.grafico_orden',
            component: require('./components/modulos/reportes/grafico_orden.vue').default,
            props: true
        },

        // PÁGINA NO ENCONTRADA
        {
            path: '/administracion*',
            component: require('./components/modulos/errors/404.vue').default
        },
    ],
    mode: 'history',
    linkActiveClass: 'active'
});