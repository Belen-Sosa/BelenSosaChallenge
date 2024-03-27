@extends('layouts.app')
@section('content')

<nav class="flex p-4">
    <router-link to="/form" class="text-xl text-white mx-3 p-2" active-class="font-bold" exact>Crear Tarea</router-link>
    <router-link to="/tareas" class="text-xl text-white mx-3 p-2" active-class="font-bold" exact>Tareas</router-link>
    <router-link to="/empleado" class="text-xl text-white mx-3 p-2" active-class="font-bold" exact>Crear Empleado</router-link>
    <router-link to="/usuario" class="text-xl text-white mx-3 p-2" active-class="font-bold" exact>Usuario</router-link>
    <router-link to="/reporte" class="text-xl text-white mx-3 p-2" active-class="font-bold" exact>Reporte</router-link>
    <router-link to="/login" class="text-xl text-white mx-3 p-2" active-class="font-bold" exact>Login</router-link>
    
</nav>



<div class="flex justify-center mt-12">
    <router-view></router-view>
</div>
@endsection
