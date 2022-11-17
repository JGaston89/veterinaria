<?php
session_start();
if(!$_SESSION['autenticado']){
    header('Location: login.php');
}else{
    if($_SESSION['administrador']== 0){
        header('Location: login.php');
    }
}

    $datos = $_POST;
    require 'db.php';

    
    if($_POST){
        $sql = "UPDATE historialclinico SET observaciones = :observacion, FechaObservaciones = NOW() WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $id=$_GET['id'];
 
        $stmt->bindParam(':observacion',$datos["observacion"],PDO::PARAM_STR);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);

       
        $stmt->execute();
        
        header('Location: listadoRecetario.php');
        
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria</title>
</head>
<body>
    <h1>Consultas</h1>
    <form action="" method="post">
        <label for="observacion">Obsrvacion</label>       
        <textarea name="observacion"></textarea>
        <br>
        
        <input type="submit" value="enviar">

    </form>
    
    
</body>
</html>