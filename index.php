<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/customColors.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/index.css"  media="screen,projection"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Formulario Buscador</title>
</head>


<body>
  <video src="img/casa_venta.mp4" id="vidFondo"></video>

  <div class="contenedor">
    <div class="card rowTitulo">
      <h1>Buscador</h1>
    </div>
    <div class="colFiltros">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="formulario">

    <?php

    
  $listadociudad = array();//el listadociudad y tipo son arreglos
  $listadotipo = array();
  
  $data = file_get_contents("data-1.json");//$data obtiene los datos del json
  $array = json_decode($data, true); // decodifica un json y lo convierte en una variable de php

  foreach ($array as $key => $jsons) { 
     foreach($jsons as $key => $value) {//para cada elemento del array se toma  como clave - valor
         if($key == 'Id'){// si el atributo Id es = a la clave
            $id = $value; // la clave Id = al valor que tenga obtenido del json 
        }
         if($key == 'Direccion'){
            $direccion = $value;
        }
         if($key == 'Ciudad'){
            $ciudad = $value;
            if (!in_array($ciudad, $listadociudad)) { //Si la ciudad y el listado de ciudades no existen se crearan
              array_push($listadociudad, $ciudad); 

            }
        }
         if($key == 'Telefono'){
            $telefono = $value;
        }
         if($key == 'Codigo_Postal'){
            $codigo_postal = $value;
        }
         if($key == 'Tipo'){
            $tipo = $value;
            if (!in_array($tipo, $listadotipo)) {
              array_push($listadotipo, $tipo);
            }
        }
         if($key == 'Precio'){
            $precio = $value;
        }
   
    }
  }
  
?>

        <div class="filtrosContenido">
          <div class="tituloFiltros">
            <h5>Realiza una búsqueda personalizada</h5>
          </div>
          
          <div class="filtroCiudad input-field">
            <label for="selectCiudad">Ciudad:</label>
            <select name="verciudad" id="selectCiudad">//se crea un select para seleccionar la ciudad
            <option value="" selected>Elige una ciudad</option>
            <?php
            
              foreach($listadociudad as $key => $value) {//Se recorre el listadociudad con el valor de cada propiedad ciudad
            ?>
              <option value="<?php echo $value; ?>" <?=($value == $value)?>> <?php echo $value; ?> </option>//se introduce el nombre de cada ciudad
            <?php  
              }
            ?>
            </select>
          </div>
          <div class="filtroTipo input-field">
            <label for="selecTipo">Tipo:</label><br>
            <select name="vertipo" id="selectTipo">
              <option value="" selected>Elige un tipo</option>
            <?php
            
              foreach($listadotipo as $key => $value) {
            ?>
              <option value="<?php echo $value; ?>" <?=($value == $value)?>> <?php echo $value; ?> </option>
            <?php  
              }
            ?>
          
            </select>
          </div>
          <div class="filtroPrecio">
            <label for="rangoPrecio">Precio:</label>
            <input type="text" id="rangoPrecio" name="verprecio" value="" />


          </div>
          <div class="botonField">
            <input name="Filtrar" type="submit" class="btn white" value="Buscar" id="submitButton">
          </div>
          <div class="botonField">
            <input name="Todos" type="submit" class="btn white" value="Mostrar todos" id="todosButton">
          </div>
        </div>
      </form>
    </div>

    <div class="colContenido">
      <div class="tituloContenido card">
        <h5>Resultados de la búsqueda:</h5>
        <div class="divider"></div>
    
    
    </div> 

   
   <?php
 
  if(isset($_POST['Filtrar'])) //Si existe el name= Filtrar
  {
  $selectCiudad = $_POST['verciudad']; //se obtiene la ciudad 
  $selectTipo = $_POST['vertipo'];  //se obtiene el tipo 
  $selectPrecio = $_POST['verprecio']; //Se obtiene el precio 
  $separarcantidad = strripos($selectPrecio, ';'); //funcion de php strripos= Encuentra la posición de la última aparición de una cadena dentro de otra cadena
  
  $minimo = substr($selectPrecio, 0, ($separarcantidad));//substr=regresa una parte de una cadena. arrancando desde el primer valor 0
  $maximo = substr($selectPrecio, ($separarcantidad+1), 5);//Regresa el maximo valor definido hasta 5 cifras.
  
  foreach ($array as $key => $jsons) { 
     foreach($jsons as $key => $value) {
         if($key == 'Id'){
            $id = $value;
        }
         if($key == 'Direccion'){
            $direccion = $value;
        }
         if($key == 'Ciudad'){
            $ciudad = $value;
        }
         if($key == 'Telefono'){
            $telefono = $value;
        }
         if($key == 'Codigo_Postal'){
            $codigo_postal = $value;
        }
         if($key == 'Tipo'){
            $tipo = $value;
        }
         if($key == 'Precio'){
            $precio = substr($value,1,12);//devuelve el valor del precio arancando desde el primer valor e incluyendo todas sus cifras
        }   
    }
   
    
    if(trim($selectTipo)<>'' and trim($selectCiudad)<>'')//El trim elimina espacios en blanco al principio y final de la cadena
    {
     if(trim($selectCiudad) == trim($ciudad) and trim($selectTipo) == trim($tipo) and ($precio >= $minimo and $precio <=$maximo))//Si se selecciona la ciudad, el tipo y el rango de precios comprendido entre el minimo y el maximo entonces imprimira la informacion correspondiente con el formato de clase que sigue:
        {
          echo "<div class='tituloContenido card'>";
          echo "<div class='itemMostrado'>";
          echo "<img src = 'img/home.jpg' height=85% width=85%>";
          echo "Dirección:  $direccion <br>";
          echo "Ciudad: $ciudad <br>";
          echo "Teléfono: $telefono <br>";
          echo "Còdigo Postal: $codigo_postal <br>";
          echo "Tipo: $tipo <br>";
          echo "Precio: $precio <br>";
          echo "</div>";
          echo "</div>";
        }
    }
    
    if(trim($selectCiudad)=='' and trim($selectTipo)=='') //Si la ciudad y el tipo estan vacios
    {
     if($precio >= $minimo and $precio <=$maximo)//pero el precio si esta definido, en los rangos min y maximo entonces mostrará segun opcion precio.
        {
          echo "<div class='tituloContenido card'>";
          echo "<div class='itemMostrado'>";
          echo "<img src = 'img/home.jpg' height=85% width=85%>";
          echo "Dirección:  $direccion <br>";
          echo "Ciudad: $ciudad <br>";
          echo "Teléfono: $telefono <br>";
          echo "Còdigo Postal: $codigo_postal <br>";
          echo "Tipo: $tipo <br>";
          echo "Precio: $precio <br>";
          echo "</div>";
          echo "</div>";
        }
    }
    
    if(trim($selectTipo)=='')
    {
     if(trim($selectCiudad) == trim($ciudad) and ($precio >= $minimo and $precio <=$maximo))//Si el tipo es vacio pero se especifica la ciudad y el valor entre rangos entonces mostrará segun ciudad y precio
        {
          echo "<div class='tituloContenido card'>";
          echo "<div class='itemMostrado'>";
          echo "<img src = 'img/home.jpg' height=85% width=85%>";
          echo "Dirección:  $direccion <br>";
          echo "Ciudad: $ciudad <br>";
          echo "Teléfono: $telefono <br>";
          echo "Còdigo Postal: $codigo_postal <br>";
          echo "Tipo: $tipo <br>";
          echo "Precio: $precio <br>";
          echo "</div>";
          echo "</div>";
        }
    }
        
    if(trim($selectCiudad)=='')
    {
     if(trim($selectTipo) == trim($tipo) and ($precio >= $minimo and $precio <=$maximo))//Si la ciudad esta vacia pero designa tipo y valor entonces se mostrara segun estos parametros validos.
        {
          echo "<div class='tituloContenido card'>";
          echo "<div class='itemMostrado'>";
          echo "<img src = 'img/home.jpg' height=85% width=85%>";
          echo "Dirección:  $direccion <br>";
          echo "Ciudad: $ciudad <br>";
          echo "Teléfono: $telefono <br>";
          echo "Còdigo Postal: $codigo_postal <br>";
          echo "Tipo: $tipo <br>";
          echo "Precio: $precio <br>";
          echo "</div>";
          echo "</div>";
        }
    }
        
      
 }
  }
    

if(isset($_POST['Todos'])) //si existe la opción Todos (que es el name del boton MOSTRAR TODOS)
  {
  foreach ($array as $key => $jsons) { 
     foreach($jsons as $key => $value) {//se recorre las claves y los valores de todos losdatos en el json
         if($key == 'Id'){
            $id = $value;
        }
         if($key == 'Direccion'){
            $direccion = $value;
        }
         if($key == 'Ciudad'){
            $ciudad = $value;
        }
         if($key == 'Telefono'){
            $telefono = $value;
        }
         if($key == 'Codigo_Postal'){
            $codigo_postal = $value;
        }
         if($key == 'Tipo'){
            $tipo = $value;
        }
         if($key == 'Precio'){
            $precio = $value;
        }
   
    }
    
        echo "<div class='tituloContenido card'>"; //se muestran en pantalla bajo estas clases y contenidos
        echo "<div class='itemMostrado'>";
        echo "<img src = 'img/home.jpg' height=85% width=85%>";
        echo "Dirección:  $direccion <br>";
        echo "Ciudad: $ciudad <br>";
        echo "Teléfono: $telefono <br>";
        echo "Còdigo Postal: $codigo_postal <br>";
        echo "Tipo: $tipo <br>";
        echo "Precio: $precio <br>";

        echo "</div>";
        echo "</div>";

 }
  }
 
    
    
   ?>
     
             
 
  <script type="text/javascript" src="js/jquery-3.0.0.js"></script>
  <script type="text/javascript" src="js/ion.rangeSlider.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
  
  <script>
    $(document).ready(function() {
      $('select').material_select(); //logra que los select se muestren en materialize de forma correcta.
    })
  </script>
  
</body>
</html>
