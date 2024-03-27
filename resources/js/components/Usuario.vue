<template>
    <div class="w-full sm:w-8/12 md:w-5/12 p-5 bg-white">
        <h1 class="text-3xl text-center font-bold py-5 text-gray-800">
            Usuario Logueado
        </h1>

        <div class=" border-gray-300 my-4 p-2">
            <div class="mb-4">
                <p class="text-2xl text-center font-bold py-2 text-gray-800">
                    {{ nombre }}
                </p>
            </div>

            <div class="mb-4">
                <p class="text-gray-500 text-center font-bold">correo:</p>
                <p class="text-gray-900 text-center">{{ correo }}</p>
            </div>
            <div class="mb-4 flex justify-center items-center">
                <p class="text-gray-500 font-bold mr-4">Super usuario:</p>
                <p class="text-gray-900">{{ super_usuario }}</p>
            </div>

            <div class="flex justify-center mt-6">
                <button
                    @click="cerrarSesion()"
                    class="bg-red-500 px-4 py-2 text-white rounded"
                    type="submit"
                >
                    Cerrar Sesion
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            nombre: "",
            correo: "",
            super_usuario: "",
        };
    },
    mounted() {
        let isAuthenticated = localStorage.getItem("nombres");
        if (isAuthenticated) {
            // Obtener datos de localStorage al cargar el componente
            this.nombre =
                localStorage.getItem("nombres") +
                " " +
                localStorage.getItem("apellido");
            this.correo = localStorage.getItem("correo");
            if (localStorage.getItem("super_usuario") == 1) {
                this.super_usuario = "si";
            } else {
                this.super_usuario = "no";
            }
        } else {
            this.$router.push("/login");
        }
    },
    methods: {
        cerrarSesion() {
            localStorage.removeItem("id");
            localStorage.removeItem("nombres");
            localStorage.removeItem("apellido");
            localStorage.removeItem("correo");
            localStorage.removeItem("token");
            localStorage.removeItem("super_usuario");
            this.$router.push("/login");
        },
    },
};
</script>
