<?php
include('conexion.php');

function edadp($fecha){
    $dia=date("d");
    $mes=date("m");
    $año=date("Y");

    $dianac=date("d",strtotime($fecha));
    $mesnac=date("m",strtotime($fecha));
    $anonac=date("Y",strtotime($fecha));

    if(($mesnac == $mes) && ($dianac > $dia))
    {
        $año($año-1);
    }
    if ($mesnac > $mes){
        $año=($anonac);
    }
    $edad=($año-$anonac);

    return $edad;

}



function mostrar(){
    if(isset($_GET['cedula']))
    {
        $cedula = $_GET['cedula'];
    
        $url="http://173.249.49.169:88/api/test/consulta/$cedula";
        $datos = file_get_contents($url);
        $datos=json_decode($datos,);
    
        $fecha= strtotime($datos->FechaNacimiento);
        $fecha= date('d/m/y',$fecha);
        $edad=edadp($fecha);

        $cedula=$datos->Cedula;
        $nombre=$datos->Nombres;
        $apellido=$datos->Apellido1;
        $edads=$edad;
        $foto=$datos->Foto;

        if(isset(($_GET['fechac']))){

            $actual=$_GET['fechac'];
        }

        $sql= "INSERT INTO personas(nombre, apellido, cedula, edad, foto, infeccion)
         VALUES('{$nombre}','{$apellido}','{$cedula}','{$edads}','{$foto}','{$actual}')";

         $rsid = conexion::ejecutar($sql,true);


    }
}

$sql='select * from personas';
$datoss=conexion::consulta_array($sql);

?>
<head>  
</br>
<h2><center>Registro de Personas Infectadas con covid-19</center><h2>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="estilos.css">
</head>
<body>
<form>
  <div class="form-group">
  </br>
    <h4><label for="exampleFormControlInput1">Inserte su cedula</label></h4>
    <input type="cedula" name = "cedula"class="form-control" id="exampleFormControlInput1" placeholder="000-0000000-0">
    </br>
    <h4><label for="exampleFormControlInput1">Inserte la fecha en la que dio positivo</label></h4>
    <input type="text" name = "fechac" class="form-control" id="exampleFormControlInput1" placeholder="DD/MM/AAAA">
    </br>
    <button type="submit" class="btn btn-primary">Guardar datos</button>
  </div>
  </form>
<table>
<thead>
<h5>Personas infectadas</h5>
<th>Foto</th>
<th>Cedula</th>
<th>Nombre</th>
<th>Apellido</th>
<th>Edad</th>
<th>Fecha de infeccion</th>
</thead>
<tbody>
</tbody>
<?php mostrar();
$datos=conexion::consulta_array('select * from personas');

foreach($datos as $data){
   echo"
   <tr>
   <td><img src={$data['foto']}></td>
   <td>{$data['cedula']}</td>
   <td>{$data['nombre']}</td>
   <td>{$data['apellido']}</td>
   <td>{$data['edad']}</td>
   <td>{$data['infeccion']}</td>
   
   
   </tr>
   
   "; 
}



?>


</table>

</body>