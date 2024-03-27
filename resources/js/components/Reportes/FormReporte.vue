<template>
    <div class="w-full sm:w-8/12 md:w-5/12 p-5 bg-white shadow-lg">
        <h1 class="text-3xl text-center font-bold py-10 text-gray-800">
            Crear Reporte
        </h1>
        <form  @submit.prevent="submitForm">
            <div class="px-2 py-4">
                <div class=" mb-4">
                    <label
                        class=" text-center  block  text-sm font-bold mb-2"
                        for="fecha-inicial"
                        >Fecha Inicial:</label
                    >
                    <input
                        type="date"
                        id="fecha-inicial"
                        v-model="fechaInicial"
                        class=" text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    />
                </div>
                <div class="  mb-4">
                    <label
                        class=" text-center  block text-gray-700 text-sm font-bold mb-2"
                        for="fecha-final"
                        >Fecha Final:</label
                    >
                    <input
                        type="date"
                        id="fecha-final"
                        v-model="fechaFinal"
                        class=" text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    />
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <button
                    type="submit"
                    class=" text-center  bg-green-500 text-white px-4 py-2 rounded"
                >
                    Crear Reporte
                </button>
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
            fechaInicial: "",
            fechaFinal: "",
            errorMessage: "",
            successMessage: "",
        };
    },
    mounted() {
        let isAuthenticated = localStorage.getItem("super_usuario");

        if (isAuthenticated == 1) {
            console.log();
        } else if (isAuthenticated == 0) {
              this.$router.push("/accesoDenegado");
        
        } else {
            this.$router.push("/login");
        }
    },
    methods: {
        submitForm() {
            const fechaInicialFormateada = new Date(this.fechaInicial)
                .toISOString()
                .slice(0, 19)
                .replace("T", " ");
            const fechaFinalFormateada = new Date(this.fechaFinal)
                .toISOString()
                .slice(0, 19)
                .replace("T", " ");

            const formData = {
                fechaInicial: fechaInicialFormateada,
                fechaFinal: fechaFinalFormateada,
            };
            console.log(formData);

            axios
                .post("http://127.0.0.1:8000/api/tareas/reporte", formData)
                .then((response) => {
                    console.log("Reporte exitoso:", response.data);

                    // Limpiar campos del formulario
                    this.fechaInicial = "";
                    this.fechaFinal = "";
                })
                .catch((error) => {
                    console.error("Error al crear el Reporte:", error);
                    // Mostrar mensaje de error
                    this.errorMessage = "Error al crear el reporte.";
                    // Después de un tiempo, ocultar el mensaje de error
                    setTimeout(() => {
                        this.errorMessage = "";
                    }, 3000);
                });
        },
    },
};
</script>
