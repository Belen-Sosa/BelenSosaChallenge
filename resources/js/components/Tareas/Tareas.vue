<template>

    <div class="w-full sm:w-8/12 md:w-5/12 p-5 bg-white shadow-lg mb-10">
        <div class="shadow-lg">
        <h1 class="text-3xl text-center font-bold py-5 text-gray-800">
            Lista de Tareas Propias
        </h1>

        <div
            v-for="tarea in tareasEmpleado"
            :key="tarea.id"
            class="border-b border-gray-300 my-4 p-6"
        >
            <div class="mb-4">
                <p class="text-gray-500 text-center font-bold">Titulo</p>
                <p class="text-2xl text-center font-bold py-2 text-gray-800">
                    {{ tarea.titulo }}
                </p>
            </div>

            <div class="mb-4 flex justify-center items-center">
                <p class="text-gray-500 font-bold mr-4">Empleado asignado:</p>
                <p class="text-gray-900">
                    {{ tarea.empleado.nombres + " " + tarea.empleado.apellido }}
                </p>
                <div v-if="esSuperUsuario">
                    <button
                        @click="mostrarSelectEmpleado = tarea.id"
                        class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                    >
                        Editar
                    </button>
                </div>
            </div>
            <!-- Mostrar el select y el botón Guardar solo cuando mostrarSelectEmpleado sea true -->
            <div
                v-if="mostrarSelectEmpleado == tarea.id"
                class="mb-4 flex justify-center items-center"
            >
                <select
                    class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                    v-model="id_empleado_tarea"
                >
                    <option
                        v-for="empleado in empleados"
                        :key="empleado.id"
                        :value="empleado.id"
                    >
                        {{ empleado.nombres + " " + empleado.apellido }}
                    </option>
                </select>
                <button
                    @click="submitNuevoEmpleado(tarea)"
                    class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                >
                    Guardar
                </button>
            </div>
            <div class="mb-4">
                <p class="text-gray-500 text-center font-bold">Descripcion</p>
                <p class="text-gray-900 text-center">{{ tarea.descripcion }}</p>
            </div>
            <div class="mb-4 flex justify-center items-center">
                <p class="text-gray-500 font-bold mr-4">Estado:</p>
                <p class="text-gray-900">{{ tarea.status }}</p>

                <button
                    @click="mostrarSelectEstadoEmpleado = tarea.id"
                    class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                >
                    Editar
                </button>
            </div>

            <!-- Mostrar el select y el botón Guardar solo cuando mostrarSelect sea true -->
            <div
                v-if="mostrarSelectEstadoEmpleado == tarea.id"
                class="mb-4 flex justify-center items-center"
            >
                <select
                    v-model="tarea.estadoSeleccionado"
                    class="border border-gray-300 p-2"
                >
                    <option value="Pendiente">Pendiente</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Bloqueado">Bloqueado</option>
                    <option value="Completado">Completado</option>
                </select>
                <button
                    @click="submitFormEstado(tarea)"
                    class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                >
                    Guardar
                </button>
            </div>
            <div class="mb-4 rounded p-4">
                <h3 class="text-1xl text-center font-bold py-2">Comentarios</h3>
                <ul>
                    <li
                        v-for="comentario in tarea.comentarios"
                        :key="comentario.id"
                        class="border text-gray-800 bg-gray-200 border-gray-300 rounded p-2 mb-2"
                    >
                        {{ comentario.descripcion }}
                    </li>
                </ul>
            </div>

            <div class="mb-4">
                <h3 class="text-1xl text-center font-bold py-2 text-gray-800">
                    Archivos
                </h3>
                <ul>
                    <li v-for="archivo in tarea.archivos" :key="archivo.id">
                        {{ archivo.nombre_archivo }}
                    </li>
                </ul>
            </div>

            <form class="flex justify-center mt-6" method="POST">
                <input
                    type="file"
                    accept=".pdf,.jpg,.jpeg,.png"
                    class="border border-gray-300 p-2"
                />
                <button class="bg-green-500 ml-4 px-4 py-2 text-white rounded">
                    Subir archivo
                </button>
            </form>

            <form
                method="POST"
                class="flex justify-center mt-6"
                v-on:submit.prevent="submitFormComentario(tarea)"
            >
                <input
                    type="text"
                    placeholder="Agregar comentario"
                    v-model="tarea.descripcionComentario"
                    class="border border-gray-300 p-2"
                />
                <button class="bg-green-500 ml-4 px-4 py-2 text-white rounded">
                    Enviar
                </button>
            </form>
            <div v-if="tarea.successMessage" class="text-green-600 mt-2">
                {{ tarea.successMessage }}
            </div>
            <div v-if="esSuperUsuario">
                <div class="flex justify-center mt-6">
                    <button
                        @click="eliminarTarea(tarea)"
                        class="bg-red-500 px-4 py-2 text-white rounded"
                        type="submit"
                    >
                        Eliminar tarea
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Muestra tarea de los demas-->

    <div class="w-full sm:w-8/12 md:w-5/12 p-5 bg-white mb-10">
        <div class="flex justify-center mt-6">
            <button
                @click="mostrarListaGeneral = !mostrarListaGeneral"
                class="bg-blue-500 px-4 py-2 text-white rounded"
                type="submit"
            >
                {{ mostrarListaGeneral ? "Cerrar" : "Mostrar Lista General" }}
            </button>
        </div>
        <div class="shadow-lg">
       

        <div v-if="mostrarListaGeneral">
            <h1 class="text-3xl text-center font-bold py-10 text-gray-800">
                Lista de Tareas General
            </h1>

            <div
                v-for="tarea in tareas"
                :key="tarea.id"
                class="border-b border-gray-300 my-4 p-6"
            >
                <div class="mb-4">
                    <p class="text-gray-500 text-center font-bold">Titulo</p>
                    <p
                        class="text-2xl text-center font-bold py-2 text-gray-800"
                    >
                        {{ tarea.titulo }}
                    </p>
                </div>

                <div class="mb-4 flex justify-center items-center">
                    <p class="text-gray-500 font-bold mr-4">
                        Empleado asignado:
                    </p>
                    <p class="text-gray-900">
                        {{
                            tarea.empleado.nombres +
                            " " +
                            tarea.empleado.apellido
                        }}
                    </p>
                    <div v-if="esSuperUsuario">
                        <button
                            @click="mostrarSelect = tarea.id"
                            class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                        >
                            Editar
                        </button>
                    </div>
                </div>
                <!-- Mostrar el select y el botón Guardar solo cuando mostrarSelectEmpleado sea true -->
                <div v-if="esSuperUsuario">
                    <div
                        v-if="mostrarSelect == tarea.id"
                        class="mb-4 flex justify-center items-center"
                    >
                        <select
                            class="text-xl p-5 mr-2 w-full border-b-2 border-green-500"
                            v-model="id_empleado_tarea"
                        >
                            <option
                                v-for="empleado in empleados"
                                :key="empleado.id"
                                :value="empleado.id"
                            >
                                {{ empleado.nombres + " " + empleado.apellido }}
                            </option>
                        </select>
                        <button
                            @click="submitNuevoEmpleado(tarea)"
                            class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                        >
                            Guardar
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-gray-500 text-center font-bold">
                        Descripcion
                    </p>
                    <p class="text-gray-900 text-center">
                        {{ tarea.descripcion }}
                    </p>
                </div>
                <div class="mb-4 flex justify-center items-center">
                    <p class="text-gray-500 font-bold mr-4">Estado:</p>
                    <p class="text-gray-900">{{ tarea.status }}</p>
                    <div v-if="esSuperUsuario">
                        <button
                            @click="mostrarSelectEstado = tarea.id"
                            class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                        >
                            Editar
                        </button>
                    </div>
                </div>

                <div v-if="esSuperUsuario">
                    <!-- Mostrar el select y el botón Guardar solo cuando mostrarSelect sea true -->
                    <div
                        v-if="mostrarSelectEstado == tarea.id"
                        class="mb-4 flex justify-center items-center"
                    >
                        <select
                            v-model="tarea.estadoSeleccionado"
                            class="border border-gray-300 p-2"
                        >
                            <option value="Pendiente">Pendiente</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Bloqueado">Bloqueado</option>
                            <option value="Completado">Completado</option>
                        </select>
                        <button
                            @click="submitFormEstado(tarea)"
                            class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                        >
                            Guardar
                        </button>
                    </div>
                </div>

                <div class="mb-4 rounded p-4">
                    <h3 class="text-1xl text-center font-bold py-2">
                        Comentarios
                    </h3>
                    <ul>
                        <li
                            v-for="comentario in tarea.comentarios"
                            :key="comentario.id"
                            class="border text-gray-800 bg-gray-200 border-gray-300 rounded p-2 mb-2"
                        >
                            {{ comentario.descripcion }}
                        </li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h3
                        class="text-1xl text-center font-bold py-2 text-gray-800"
                    >
                        Archivos
                    </h3>
                    <ul>
                        <li v-for="archivo in tarea.archivos" :key="archivo.id">
                            {{ archivo.nombre_archivo }}
                        </li>
                    </ul>
                </div>

                <form class="flex justify-center mt-6" method="POST">
                    <input
                        type="file"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="border border-gray-300 p-2"
                    />
                    <button
                        class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                    >
                        Subir archivo
                    </button>
                </form>

                <form
                    method="POST"
                    class="flex justify-center mt-6"
                    v-on:submit.prevent="submitFormComentario(tarea)"
                >
                    <input
                        type="text"
                        placeholder="Agregar comentario"
                        v-model="tarea.descripcionComentario"
                        class="border border-gray-300 p-2"
                    />
                    <button
                        class="bg-green-500 ml-4 px-4 py-2 text-white rounded"
                    >
                        Enviar
                    </button>
                </form>
                <div v-if="tarea.successMessage" class="text-green-600 mt-2">
                    {{ tarea.successMessage }}
                </div>
                <div v-if="esSuperUsuario">
                    <div class="flex justify-center mt-6">
                        <button
                            @click="eliminarTarea(tarea)"
                            class="bg-red-500 px-4 py-2 text-white rounded"
                            type="submit"
                        >
                            Eliminar tarea
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            tareas: [],
            tareasEmpleado: [],
            mostrarSelect: null,
            mostrarSelectEmpleado: null,
            empleados: [],
            id_empleado_tarea: "",
            mostrarSelectEstado: null,
            mostrarSelectEstadoEmpleado: null,
            mostrarListaGeneral: false,
            esSuperUsuario: false,
        };
    },
    mounted() {
        let isAuthenticated = localStorage.getItem("id");
        if (isAuthenticated !== null && isAuthenticated !== undefined) {
            let tipoUsuario = localStorage.getItem("super_usuario");
            if (tipoUsuario && tipoUsuario == "1") {
                this.esSuperUsuario = true;
            }
            this.obtenerTareas();
            this.obtenerTareasEmpleado();
            this.listarEmpleados();
        } else {
            this.$router.push("/login");
        }
    },
    methods: {
        MostrarListaGeneral() {
            this.mostrarListaGeneral = !this.mostrarListaGeneral;
        },
        obtenerTareas() {
            axios
                .get("http://127.0.0.1:8000/api/tareas")
                .then((response) => {
                    this.tareas = response.data;
                })
                .catch((error) => {
                    console.error("Error al obtener las tareas:", error);
                });
        },
        obtenerTareasEmpleado() {
            axios
                .get(
                    `http://127.0.0.1:8000/api/tareas/${localStorage.getItem(
                        "id"
                    )}`
                )
                .then((response) => {
                    this.tareasEmpleado = response.data;
                })
                .catch((error) => {
                    console.error(
                        "Error al obtener las tareas del empleado:",
                        error
                    );
                });
        },
        submitFormComentario(tarea) {
            const formData = {
                descripcion: tarea.descripcionComentario,
                id_tarea_comentario: tarea.id,
            };
            axios
                .post("http://127.0.0.1:8000/api/comentarios", formData)
                .then((response) => {
                    tarea.successMessage = "Comentario agregado exitosamente";
                    tarea.descripcionComentario = "";
                    // Actualizar solo la tarea específica después de agregar el comentario
                    this.obtenerTareas();
                    this.obtenerTareasEmpleado();
                    setTimeout(() => {
                        tarea.successMessage = "";
                    }, 3000);
                })
                .catch((error) => {
                    console.error("Error al guardar el comentario:", error);
                });
        },
        submitFormEstado(tarea) {
            const formData = {
                status: tarea.estadoSeleccionado,
            };

            axios
                .put(`http://127.0.0.1:8000/api/tareas/${tarea.id}`, formData)
                .then((response) => {
                    const tareaActualizada = this.tareas.find(
                        (t) => t.id === tarea.id
                    );
                    if (tareaActualizada) {
                        tareaActualizada.status = formData.status;
                    }

                    // Actualizar el estado en la lista de tareasEmpleado
                    const tareaEmpleadoActualizada = this.tareasEmpleado.find(
                        (te) => te.id === tarea.id
                    );
                    if (tareaEmpleadoActualizada) {
                        tareaEmpleadoActualizada.status = formData.status;
                    }

                    this.mostrarSelect = null;
                    this.mostrarSelectEmpleado = null;
                    tarea.successMessage = "Estado actualizado exitosamente";
                    tarea.estadoSeleccionado = "";

                    setTimeout(() => {
                        tarea.successMessage = "";
                    }, 3000);
                })
                .catch((error) => {
                    console.error("Error al guardar el estado:", error);
                });
        },
        eliminarTarea(tarea) {
            axios
                .delete(`http://127.0.0.1:8000/api/tareas/${tarea.id}`)
                .then((response) => {
                    // Actualizar lista de tareas del empleado después de eliminar la tarea
                    this.obtenerTareasEmpleado();
                    this.obtenerTareas();
                    tarea.successMessage = "Tarea eliminada exitosamente";

                    setTimeout(() => {
                        tarea.successMessage = "";
                    }, 3000);
                })
                .catch((error) => {
                    console.error("Error al eliminar la tarea:", error);
                });
        },
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
        submitNuevoEmpleado(tarea) {
            const formData = {
                id_empleado_tarea: this.id_empleado_tarea,
            };

            axios
                .put(
                    `http://127.0.0.1:8000/api/actualizar_empleado_tarea/${tarea.id}`,
                    formData
                )
                .then((response) => {
                    const empleadoActualizado = response.data.empleado;
                    const tareaActualizada = this.tareas.find(
                        (t) => t.id === tarea.id
                    );
                    if (tareaActualizada) {
                        tareaActualizada.empleado = empleadoActualizado;
                    }
                    tarea.successMessage =
                        "Empleado asignado a la tarea exitosamente";
                    this.mostrarSelectEstado = null;
                    this.mostrarSelectEstadoEmpleado = null;

                    // en el caso de que haya cambiado de empleado
                    this.obtenerTareasEmpleado();

                    setTimeout(() => {
                        tarea.successMessage = "";
                    }, 3000);
                })
                .catch((error) => {
                    console.error(
                        "Error al actualizar el empleado de la tarea:",
                        error
                    );
                });
        },
        eliminarTareaPropia(idTarea) {
            this.tareasEmpleado = this.tareasEmpleado.filter(
                (tarea) => tarea.id !== idTarea
            );
        },
    },
};
</script>
