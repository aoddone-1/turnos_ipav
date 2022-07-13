<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/


$route['default_controller'] = "turnos";
$route['404_override'] = 'error404';
$route['translate_uri_dashes'] = FALSE;


//nuevasrutas
$route['noticias/pagina/(:num)'] = 'noticias';//cuando no sea la primera p‡gina
$route['noticias/pagina']        = 'noticias';//cuando sea la primera p‡gina
$route['gerencia-(:any)']        = 'gerencia/index/gerencia-$1';
$route['gerencias']        = 'gerencia/gerencias';

$route['noticias/pagina/(:num)'] = 'noticias';//cuando no sea la primera p‡gina
$route['noticias/pagina']        = 'noticias';//cuando sea la primera p‡gina
$route['noticia/(:any)']        = 'noticias/noticia/$1';
$route['boletas/(:any)/(:any)/(:any)']        = 'boletadigital/boletas/$1/$2/$3';
$route['planes/(:any)']        = 'planesviviendas/planes/$1';
$route['resumen/(:any)']        = 'boletadigital/resumen/$1';


$route['boletasaux/(:any)/(:any)/(:any)']        = 'boletadigitalaux/boletas/$1/$2/$3';
$route['resumenaux/(:any)']        = 'boletadigitalaux/resumen/$1';

//localhost/sitioWEB/gerencia-general

/*$route['servicios_listado/pagina/(:num)'] = 'servicios_listado';//cuando no sea la primera p‡gina
$route['servicios_listado/pagina']        = 'servicios_listado';//cuando sea la primera p‡gina

$route['noticias_listado/pagina/(:num)'] = 'noticias_listado';//cuando no sea la primera p‡gina
$route['noticias_listado/pagina']        = 'noticias_listado';//cuando sea la primera p‡gina

$route['sorteos_listado/pagina/(:num)'] = 'sorteos_listado';//cuando no sea la primera p‡gina
$route['sorteos_listado/pagina']        = 'sorteos_listado';//cuando sea la primera p‡gina

$route['noticias/(:any)']        = 'noticia_detalle/noticias/$1';
$route['sorteos/(:any)']        = 'sorteo_detalle/sorteo/$1';
$route['servicios/(:any)']        = 'servicio_detalle/servicio/$1';
$route['licitaciones/(:any)']        = 'licitacion_detalle/licitacion/$1';
$route['localidades/(:any)']        = 'localidades/localidad/$1';
$route['boletadigital']        = 'facturadigital';
$route['facturas/vencimiento/(:any)']        = 'facturadigital/vencimiento/$1';
$route['facturas/actualizarvencimiento']        = 'facturadigital/modificarvencimiento';
*/



/*$route['gerencia-(:any)']        = 'contenidos/contenido/gerencia-$1';
$route['nuevo-plan-provincial-de-viviendas-sociales']        = 'contenidos/contenido/nuevo-plan-provincial-de-viviendas-sociales';
$route['el-atuel-tambien-es-pampeano']        = 'contenidos/contenido/el-atuel-tambien-es-pampeano';
$route['normativa-de-subsidio-de-cuotas']        = 'contenidos/contenido/normativa-de-subsidio-de-cuotas';
$route['turnos/comprobanteTurno/(:any)']        = 'turnos/comprobanteTurno/$1';*/

/* End of file routes.php */
/* Location: ./application/config/routes.php */
?>
