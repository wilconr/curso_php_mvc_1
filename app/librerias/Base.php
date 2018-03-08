<?php
  /**
   * clase para conectar a la base de datos y ejecutar consultas
   */
  class Base
  {
    private  $dbHost = DB_HOST;
    private  $dbUser = DB_USER;
    private  $dbPassword = DB_PASSWORD;
    private  $dbName = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
      //configurar la conexion
      $conexion = 'mysql:dbhost=' . $this->dbHost . ';dbname=' . $this->dbName;
      $opciones = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );

      //Creamos una instancia de PDO
      try
      {
        $this->dbh = new PDO($conexion, $this->dbUser, $this->dbPassword, $opciones);
        $this->dbh->exec('set names utf8');
      }
      catch (PDOException $e)
      {
        $this->error = $e->getMessage();
        echo $this->error;
      }

    }
    //funcion que prepara la consulta
    public function consulta($sql)
    {
      $this->stmt = $this->dbh->prepare($sql);
    }
    //funcion que vincula la consulta con bind
    public function vincular($parametro, $valor, $tipo = null)
    {
      if (is_null($tipo))
      {
        switch (true) {
          case is_int($valor):
            $tipo = PDO::PARAM_INT;
            break;
          case is_bool($valor):
            $tipo = PDO::PARAM_BOOL;
            break;
          case is_null($valor):
            $tipo = PDO::PARAM_NULL;
            break;

          default:
            $tipo = PDO::PARAM_STR;
            break;
        }
      }
      $this->stmt->bindValue($parametro, $valor, $tipo);
    }
    //funcion para ejecutar la consulta
    public function ejecutar()
    {
      return $this->stmt->execute();
    }
    //funcion para obtener los registros
    public function registros()
    {
      $this->ejecutar();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    //funcion para obtener solo un registro
    public function registro()
    {
      $this->ejecutar();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    //funcion para obtener la cantidad un registros con rowCount
    public function cantRegistros()
    {
      return $this->stmt->rowCount();
    }

  }

?>
