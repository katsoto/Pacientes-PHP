<?php
include('confi.php');

class conexion{
       
    public $mycon = null; 
    
    static $instancia = null;



    function __construct(){
           $this->myCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    }

    function __destruct(){
             
        mysqli_close($this->myCon);
    }

    public static function ejecutar($sql, $retornarID = false){
        if(self::$instancia == null){
          self::$instancia = new conexion();
        }
        $rs = mysqli_query(self::$instancia->myCon, $sql); 
        
        if($retornarID){
            $idx = mysqli_insert_id(self::$instancia->myCon);
            return $idx;
        }


        return $rs;
  
    }
   
  public static function consulta($sql){
      if(self::$instancia == null){
        self::$instancia = new conexion();
      }
      $rs = mysqli_query(self::$instancia->myCon, $sql); 
      $final = [];
      while($fila = mysqli_fetch_object($rs)){
          $final[] = $fila;
      }
      return $final;

    }

    

  public static function consulta_array($sql){
    if(self::$instancia == null){
      self::$instancia = new conexion();
    }
    $rs = mysqli_query(self::$instancia->myCon, $sql); 
    $final = [];
   
    while($fila = mysqli_fetch_assoc($rs)){ 
        $final[] = $fila;
    }
    return $final;
}

}