<template>
    <div class="w-full sm:w-8/12 md:w-5/12 p-5 bg-white">
        <h1 class="text-3xl text-center font-bold py-10 text-gray-800">
            Login
        </h1>
        <form method="POST" v-on:submit.prevent="submitForm">
            <div class="px-2 py-4">
                <input
                    type="email"
                    placeholder="Correo"
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="correo"
                />
                <input
                    type="password"
                    placeholder="Contraseña"
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="contrasenia"
                />

                <input
                    type="submit"
                    value="Ingresar"
                    class="bg-green-500 w-2/12 mt-10 text-white"
                />
            </div>
        </form>
        <div v-if="successMessage" class="text-green-600">
            {{ successMessage }}
        </div>
        <div v-if="errorMessage" class="text-red-600">{{ errorMessage }}</div>
    </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";

export default {
    data() {
        return {
            correo: "",
            contrasenia: "",
            errorMessage: "",
        };
    },
    mounted() {
        let isAuthenticated = localStorage.getItem("nombres");
        if (isAuthenticated) {
            this.$router.push("/usuario");
        }
    },
    methods: {
        submitForm() {
            const formData = {
                correo: this.correo,
                contrasenia: this.contrasenia,
            };
            console.log(formData);
            axios
                .post("http://127.0.0.1:8000/api/login", formData)
                .then((response) => {
                    console.log("Ingreso con exito:", response.data);

                    localStorage.setItem("id", response.data.id);
                    localStorage.setItem("token", response.data.contrasenia);
                    localStorage.setItem("nombres", response.data.nombres);
                    localStorage.setItem("apellido", response.data.apellido);
                    localStorage.setItem("correo", response.data.correo);
                    localStorage.setItem(
                        "super_usuario",
                        response.data.super_usuario
                    );
                    console.log(localStorage);
                    this.$router.push("/tareas");
                })
                .catch((error) => {
                    console.error("Error al intentar ingresar", error);
                    // Mostrar mensaje de error
                    this.errorMessage =
                        "Error al intentar ingresar, contraseña o correo incorrecto.";
                });
        },
    },
};
</script>
