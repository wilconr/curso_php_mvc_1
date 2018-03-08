<?php
/**
 *clase controlador principal
 *se encarga de cargar los modelos y las vistas
 */
class Controlador
{

  function __construct()
  {
    # code...
  }

  //cargar modelo
  public function modelo($modelo)
  {
    //carga
    require_once '../app/modelos/' . $modelo . '.php';
    //instaciar el modelo
    return new $modelo();
  }

  //cargar vista
  public function vista($vista, $datos = [])
  {
    //chequear si el archivo existe
    if (file_exists('../app/vistas/' . $vista . '.php'))
    {
      require_once '../app/vistas/' . $vista . '.php';  
    }
    else
    {
      //si el archivo de vista no existe
      die('la vista no existe');
    }
  }

}

?>
