<?php

// mapear url ingresada en el navegador,
// 0. controlador
// 1. metodo
// 2. parametro
// Ejemplo: /articulos/actualizar/4

class Core
{
    protected $controladorActual = 'Paginas';
    protected $metodoActual = 'index';
    protected $parametros = [];

    // constructor
    public function __construct()
    {
      //print_r($this->getUrl());
      $url = $this->getUrl();
      //Buscar en controladores si el controlador existe
      if (file_exists('../app/controladores/' . ucwords($url[0]) . '.php'))
      {
        //Si existe se  setea coo controlador por defecto
        $this->controladorActual = ucwords($url[0]);

        //se hace un unset para quitar el controlador anterior y montar el nuevo
        unset($url[0]);
      }
      //requerimos el controlador nuevo
      require_once '../app/controladores/' . $this->controladorActual . '.php';
      $this->controladorActual = new $this->controladorActual;

      //revisamos la segunda parte de la url que seria el metodo
      if (isset($url[1]))
      {
        if (method_exists($this->controladorActual, $url[1]))
        {
          //chequeamos el metodo
          $this->metodoActual = $url[1];

          //se hace un unset para quitar el metodo anterior y montar el nuevo
          unset($url[1]);
        }
      }
      //Probar para traer metodo
      //echo $this->metodoActual;

      //obtener los $parametros
      $this->parametros = $url ? array_values($url) : [];
      //llamamos la funcion callback con parametros
      call_user_func_array([$this->controladorActual, $this->metodoActual], $this->parametros);
    }

    public function getUrl()
    {
      //echo $_GET['url'];
      if (isset($_GET['url']))
      {
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url,FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    }
}

?>
