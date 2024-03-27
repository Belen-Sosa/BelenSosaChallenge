<template>
    <div class="w-full sm:w-8/12 md:w-5/12 p-5 bg-white mb-10">
        <h1 class="text-3xl text-center font-bold py-10 text-gray-800">
            Crear Empleado
        </h1>
        <form method="POST" v-on:submit.prevent="submitForm">
            <div class="px-2 py-4">
                <input
                    type="text"
                    placeholder="Nombres"
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="nombres"
                />
                <input
                    type="text"
                    placeholder="Apellido"
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="apellido"
                />
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

                <label for="super_usuario" class="block text-xl mb-2"
                    >Super Usuario:</label
                >

                <select
                    id="super_usuario"
                    class="text-xl p-2 mr-2 w-full border-b-2 border-green-500"
                    v-model="super_usuario"
                >
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>

                <input
                    type="submit"
                    value="Guardar"
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

export default {
    data() {
        return {
            empleados: [],
            nombres: "",
            apellido: "",
            correo: "",
            contrasenia: "",
            super_usuario: "1", // Valor predeterminado
            successMessage: "",
            errorMessage: "",
        };
    },
    mounted() {
        let isAuthenticated = localStorage.getItem("super_usuario");
    
        if (isAuthenticated == 0) {
            this.$router.push("/accesoDenegado");
        
        } 
        if(isAuthenticated){
            console.log("ok")
        }else{
            this.$router.push("/login");
        }
    },
    methods: {
        submitForm() {
            const formData = {
                nombres: this.nombres,
                apellido: this.apellido,
                correo: this.correo,
                contrasenia: this.contrasenia,
                super_usuario: this.super_usuario,
            };
            console.log(formData);
            axios
                .post("http://127.0.0.1:8000/api/empleados", formData)
                .then((response) => {
                    console.log(
                        "Empleado guardado exitosamente:",
                        response.data
                    );
                    // Mostrar mensaje de éxito
                    this.successMessage = "Empleado guardado exitosamente";
                    // Limpiar campos del formulario
                    this.nombres = "";
                    this.apellido = "";
                    this.correo = "";
                    this.contrasenia = "";
                    this.super_usuario = "1"; 
                    // Después de un tiempo, ocultar el mensaje de éxito
                    setTimeout(() => {
                        this.successMessage = "";
                    }, 3000);
                })
                .catch((error) => {
                    console.error("Error al guardar el empleado:", error);
                    // Mostrar mensaje de error
                    this.errorMessage = "Error al guardar el empleado";
                    // Después de un tiempo, ocultar el mensaje de error
                    setTimeout(() => {
                        this.errorMessage = "";
                    }, 3000);
                });
        },
    },
};
</script>
