<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/foo', function () {
    Artisan::call('migrate');
});
Route::get('/storageo', function () {
    Artisan::call('storage:link');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('tramite/virtual','tramiteVirtual');
Route::post('tramite/insert',[App\Http\Controllers\TramiteVirtualController::class, 'insert']);

Auth::routes(['register' => false]);

Route::view('/tramite/virtual', 'tramite_virtual.index')->name('tramite.virtual');
Route::get('/documento-leer/{id?}',[App\Http\Controllers\DocumentoController::class, 'leerDocumento']);
Route::view('/tramite/consultar', 'tramite_virtual.consultar');
Route::get('/tramite-virtual-registrado/{id}/{documento}', [App\Http\Controllers\TramiteVirtualController::class, 'successInsert']);
Route::get('/seguimiento-externo/{id}/{documento?}', [App\Http\Controllers\TramiteVirtualController::class, 'seguimientoExterno']);
Route::view('/consultar/documento', 'tramite_virtual.formularioBuscar');

Route::post('consultar/documento/basico',[App\Http\Controllers\TramiteVirtualController::class,'buscarBasico'])->name('buscarDocumentoExternoBasico');
Route::post('consultar/documento/personalizado',[App\Http\Controllers\TramiteVirtualController::class,'buscarPersonalizado'])->name('buscarDocumentoExternoPersonalizado');


Route::get('/prueva-email', [App\Http\Controllers\TramiteVirtualController::class, 'emailSend']);

// Route::view('sucursales','sucursales.index')->name('sucursales');
// Route::view('catalogos','configuracion.catalogos')->name('catalogos');
// Route::view('productos','inventario.productos')->name('productos');

Route::middleware(['auth'])->group(function() {
  Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
  Route::view('usuarios','usuarios.index')->name('usuarios');
  Route::view('tipo-documentos','tipo_documentos.index')->name('tipo-documentos');
  Route::view('dependencia','dependencia.index')->name('dependencia');
  Route::view('archivadores','archivadores.index')->name('archivadores');
  Route::view('tramite','tramite.index')->name('nuevo-tramite');
  Route::view('reportes/','tramite.reportes')->name('reportes');

  Route::get('tramite/{id}/{operacion}/{modo?}',[App\Http\Controllers\DocumentoController::class, 'responder']);

  Route::get('archivadores/list', [App\Http\Controllers\ArchivadorController::class, 'list']);
  Route::get('archivadores/list/user', [App\Http\Controllers\ArchivadorController::class, 'listUser']);
  Route::post('archivadores/insert', [App\Http\Controllers\ArchivadorController::class,'insert']);
  Route::post('archivadores/update', [App\Http\Controllers\ArchivadorController::class, 'update']);

  Route::post('documento/insertInternal', [App\Http\Controllers\DocumentoController::class, 'insertInternal']);
  Route::post('documento/insertExternal', [App\Http\Controllers\DocumentoController::class, 'insertExternal']);

  Route::post('documento/derivar', [App\Http\Controllers\OperacionController::class, 'derivar']);
  Route::post('documento/archivar', [App\Http\Controllers\OperacionController::class, 'archivar']);
  Route::post('documento/eliminar-derivacion', [App\Http\Controllers\OperacionController::class, 'eliminarDerivacion']);
  Route::post('documento/recibir', [App\Http\Controllers\OperacionController::class, 'recibir']);
  Route::post('documento/desarchivar', [App\Http\Controllers\OperacionController::class, 'desarchivar']);

  
  Route::get('documento/ver/tramite/{id}/{documento}',[App\Http\Controllers\DocumentoController::class,'verTramite']); 
  Route::view('documento/buscar','tramite.formularioBuscar');
  Route::post('buscar/documento',[App\Http\Controllers\DocumentoController::class,'buscarDocumento'])->name('buscarDocumento');
  Route::post('buscar/personalizada',[App\Http\Controllers\DocumentoController::class,'buscarDocumentoPersonalizada'])->name('buscarDocumentoPersonalizada');

  Route::get('/documento/en-proceso/listar',[App\Http\Controllers\DocumentoController::class,'listEnProceso']);
  Route::get('/documento/derivados/listar',[App\Http\Controllers\DocumentoController::class,'listDerivados']);
  Route::get('/documento/por-recibir/listar',[App\Http\Controllers\DocumentoController::class,'listPorRecibir']);
  Route::get('/documento/archivados/listar',[App\Http\Controllers\DocumentoController::class,'listArchivados']);

  Route::view('documento/proceso/','tramite.enProceso'); 
  Route::view('documento/derivados/','tramite.derivados'); 
  Route::view('documento/por-recibir/','tramite.porRecibir'); 
  Route::view('documento/archivados/','tramite.archivados'); 

  Route::get('dependencia/list', [App\Http\Controllers\DependenciaController::class, 'list']);
  Route::post('dependencia/insert', [App\Http\Controllers\DependenciaController::class,'insert']);
  Route::post('dependencia/update', [App\Http\Controllers\DependenciaController::class, 'update']);

  // Route::get('numeracion-numero-documento/get', [App\Http\Controllers\DocumentoController::class,'getNumeracionNumeroDocumento']);
  Route::get('tipo-documento/list', [App\Http\Controllers\TipoDocumentoController::class,'list']);
  Route::get('numeracion-tipo-documento', [App\Http\Controllers\TipoDocumentoController::class,'getNumeracionTipoDocumento']);
  Route::post('tipo-documento/insert', [App\Http\Controllers\TipoDocumentoController::class, 'insert']);
  Route::post('tipo-documento/update', [App\Http\Controllers\TipoDocumentoController::class, 'update']);

  Route::get('user/list', [App\Http\Controllers\UserController::class,'list']);
  Route::post('user/insert', [App\Http\Controllers\UserController::class,'insert']);
  Route::post('cambiar-password', [App\Http\Controllers\UserController::class,'changePassword']);
  Route::post('user/update', [App\Http\Controllers\UserController::class,'update']);
  Route::get('user/list/area', [App\Http\Controllers\UserController::class,'listForArea']);
  Route::get('user/list/area-value/{idArea}', [App\Http\Controllers\UserController::class,'listForAreaValue']);

  Route::get('role/list', [App\Http\Controllers\RoleController::class,'list']);

  Route::post('generic-table/change-status', [App\Http\Controllers\GenericTableController::class,'changeStatus']);
  Route::post('generic-table/delete', [App\Http\Controllers\GenericTableController::class,'delete']);
  Route::get('logouth',[App\Http\Controllers\Auth\LoginController::class,'logout']);


  /******************************** NUMERACION TIPO DOCUMENTO*********************************/
  Route::post('numeracion-tipo-documento/seleccionar-usuario-autenticado',[App\Http\Controllers\NumeracionTipoDocumentoController::class,'selectByUserAuth']);


  /**********************************************    REPORTES    *****************************************************************/
  Route::post('reporte/derivados',[App\Http\Controllers\OperacionController::class,'reporteDerivados']);
  Route::post('reporte/por-recibir',[App\Http\Controllers\OperacionController::class,'reportePorRecibir']);
  Route::post('reporte/generados',[App\Http\Controllers\OperacionController::class,'reporteGenerados']);
  Route::post('reporte/recibidos',[App\Http\Controllers\OperacionController::class,'reporteRecibidos']);
  Route::post('reporte/archivados',[App\Http\Controllers\OperacionController::class,'reporteArchivados']);
  Route::get('consulta/api/{tipo}/{documento}',[App\Http\Controllers\ConsultaApiController::class,'consultar']);

  Route::view('formulario/derivados','tramite.formularioDerivados');
  Route::view('formulario/por-recibir','tramite.formularioPorRecibir');
  Route::view('formulario/generados','tramite.formularioGenerados');
  Route::view('formulario/recibidos','tramite.formularioRecibidos');
  Route::view('formulario/archivados','tramite.formularioArchivados');

  Route::post('editar-guardar/',[App\Http\Controllers\DocumentoController::class,'saveEditar']);




});

Route::post('generic-table/list-all-actives', [App\Http\Controllers\GenericTableController::class,'listTableRegisterActives']);


// Route::view('login','auth.login')->name('login');
// Route::post('login',[App\Http\Controllers\LoginController::class,'login']);
// Route::get('logouth',[App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');