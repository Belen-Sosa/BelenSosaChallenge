<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Tarea;
use App\Models\Tarea_empleado;
use App\Models\Empleado;
use App\Models\Comentario;
use App\Models\Archivo;


Route::post('login', function (Request $request) {
  // Validar los datos del formulario
  $credentials = $request->validate([
    'correo' => ['required', 'email'],
    'contrasenia' => ['required'],
  ]);

  // Buscar el empleado por correo electrónico y contraseña
  $empleado = Empleado::where('correo', $credentials['correo'])
    ->where('contrasenia', $credentials['contrasenia'])
    ->first();

  // Verificar si se encontró un empleado con las credenciales proporcionadas
  if ($empleado) {
    return $empleado;
  } else {
    return response()->json(['message' => 'Credenciales inválidas'], 401);
  }
});
//listar tareas 
Route::get('tareas', function () {
  $tareas = Tarea::with(['comentarios', 'archivos', 'empleado'])->get();
  return $tareas;
});
//listar empleados 
Route::get('empleados', function () {
  $empleados = Empleado::get();
  return $empleados;
});
//listar tareas por usuario
Route::get('tareas/{id}', function ($id) {
  $tarea_empleado = Tarea::with(['comentarios', 'archivos', 'empleado'])->where('id_empleado_tarea', $id)->get();
  return $tarea_empleado;
});

Route::post('tareas', function (Request $request) {
  //valida los campos antes de guardar en la base
  $request->validate([
    'titulo' => 'required|max:50',
    'descripcion' => 'required|max:50',
    'status' => 'required',
    'id_empleado_tarea' => 'required',
  ]);

  //guarda los campos traidos en la base

  $tarea = new Tarea;
  $tarea->titulo = $request->input('titulo');
  $tarea->descripcion = $request->input('descripcion');
  $tarea->status = $request->input('status');


  $tarea->id_empleado_tarea = $request->input('id_empleado_tarea');

  $tarea->save();
  return 'tarea creada';
});




//actualizar tarea
Route::put('tareas/{id}', function ($id, Request $request) {

  $tarea = Tarea::findOrFail($id);

  $request->validate([
    'status' => 'required',
  ]);

  $tarea->status = $request->input('status');

  $tarea->save();

  return 'Tarea actualizada';
});


//actualizar el empleado de la tarea
Route::put('actualizar_empleado_tarea/{id}', function ($id, Request $request) {

  $tarea = Tarea::findOrFail($id);


  $request->validate([
    'id_empleado_tarea' => 'required',
  ]);

  $tarea->id_empleado_tarea = $request->input('id_empleado_tarea');

  $tarea->save();
  $tarea = Tarea::with(['comentarios', 'archivos', 'empleado'])->find($id);


  return $tarea;
});

//eliminar tarea
Route::delete('tareas/{id}', function ($id) {

  $tarea = Tarea::findOrFail($id);

  // Elimina los comentarios relacionados
  $tarea->comentarios()->delete();
  // Elimina los archivos relacionados
  $tarea->archivos()->delete();
  $tarea->delete();

  return 'tarea eliminada exitosamente';
});


//registrar empleado
Route::post('empleados', function (Request $request) {
  $request->validate([
    'nombres' => 'required|max:60',
    'apellido' => 'required|max:50',
    'correo' => 'required|max:100|unique:empleados',
    'contrasenia' => 'required|max:50',
    'super_usuario' => 'required',
  ]);


  $empleado = new Empleado;
  $empleado->nombres = $request->input('nombres');
  $empleado->apellido = $request->input('apellido');
  $empleado->correo = $request->input('correo');
  $empleado->contrasenia = $request->input('contrasenia');
  $empleado->super_usuario = $request->input('super_usuario');
  $empleado->save();

  return 'empleado creado';
});


//registrar comentario
Route::post('comentarios', function (Request $request) {
  $request->validate([
    'descripcion' => 'required|max:200',

  ]);

  $comentario = new Comentario;
  $comentario->id_tarea_comentario = $request->input('id_tarea_comentario');
  $comentario->descripcion = $request->input('descripcion');
  $comentario->save();

  return 'comentario creado';
});


//trae los datos para el reporte del pdf

Route::post('tareas/reporte', function (Request $request) {

  
  $fechaInicial = $request->input('fecha_inicial');
  $fechaFinal = $request->input('fecha_final');


  // Consulta las tareas que estén en el rango de fechas y con estado "Completado"
  $tareas = Tarea::select('tareas.titulo', 'tareas.status', 'tareas.created_at', 'tareas.updated_at', 'empleados.nombres', 'empleados.apellido')
    ->join('empleados', 'tareas.id_empleado_tarea', '=', 'empleados.id')
    ->where('tareas.created_at', '>=', $fechaInicial)
    ->where('tareas.created_at', '<=', $fechaFinal)
    ->where('tareas.status', 'Completado')
    ->get();


   return   $tareas;
});
