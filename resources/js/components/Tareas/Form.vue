<template>
    
    <div class="w-full sm:w-8/12 md:w-5/12 p-5 bg-white shadow-lg  mb-10">
        <h1 class="text-3xl text-center font-bold py-10 text-gray-800">
            Crear Tarea
        </h1>
        <form method="POST" v-on:submit.prevent="submitForm">
            <div class="px-2 py-4">
                <input
                    type="text"
                    placeholder="Título"
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="titulo"
                />
                <textarea
                    placeholder="Descripción"
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="descripcion"
                ></textarea>
                <select
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="status"
                >
                    <option value="Pendiente">Pendiente</option>
                    <option value="En Proceso">En proceso</option>
                    <option value="Bloqueado">Bloqueado</option>
                    <option value="Completado">Completado</option>
                </select>
                <select
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="id_empleado_tarea"
                >
                    <option
                        v-for="empleado in empleados"
                        :key="empleado.id"
                        :value="empleado.id"
                    >
                        {{ empleado.nombres }}
                    </option>
                </select>

                <div class="flex justify-center mt-6">
                    <button
                        type="submit"
                        class="text-center bg-green-500 text-white px-4 py-2 rounded"
                    >
                        Guardar
                    </button>
                </div>
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
            titulo: "",
            descripcion: "",
            status: "En Proceso",
            id_empleado_tarea: null,
            successMessage: "",
            errorMessage: "",
        };
    },
    mounted() {
        let isAuthenticated = localStorage.getItem("super_usuario");

        if (isAuthenticated == 1) {
            this.listarEmpleados();
        } else if (isAuthenticated == 0) {
            this.$router.push("/accesoDenegado");
        } else {
            this.$router.push("/login");
        }
    },
    methods: {
        listarEmpleados() {
            axios
                .get("http://127.0.0.1:8000/api/empleados")
                .then((response) => {
                    this.empleados = response.data;
                })
                .catch((error) => {
                    console.error("Error al obtener los empleados:", error);
                });
        },
        submitForm() {
            const formData = {
                titulo: this.titulo,
                descripcion: this.descripcion,
                status: this.status,
                id_empleado_tarea: this.id_empleado_tarea,
            };

            axios
                .post("http://127.0.0.1:8000/api/tareas", formData)
                .then((response) => {
                    this.successMessage = "Tarea guardada exitosamente";

                    this.titulo = "";
                    this.descripcion = "";
                    this.status = "En Proceso";
                    this.id_empleado_tarea = null;

                    // Después de un tiempo, ocultar el mensaje de éxito
                    setTimeout(() => {
                        this.successMessage = "";
                    }, 3000);
                })
                .catch((error) => {
                    console.error("Error al guardar la tarea:", error);
                    // Mostrar mensaje de error
                    this.errorMessage = "Error al guardar la tarea";
                    // Después de un tiempo, ocultar el mensaje de error
                    setTimeout(() => {
                        this.errorMessage = "";
                    }, 3000);
                });
        },
    },
};
</script>
