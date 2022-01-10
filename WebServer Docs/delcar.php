<?php

include "connection.php";

if (isset($_GET['del'])){
    $id = $_GET['del'];
}
else {
    die("Error. ID not given.");
}

$query = $conn->prepare('SELECT * FROM uredena_vozila WHERE id_vozila = :id');
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$row = $query->fetch();
if ($row == false){
    die("Error fetching data.");
}

$delete = $conn->prepare('DELETE FROM vozila WHERE id_vozila = :id');

if ( isset($_POST['delete']) ){
    $delete->bindParam(':id', $id);
    try {
        $delres = $delete->execute();
        if ( $delres === false ) {
            $error = $insert->errorInfo();
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }    

    header("Location: index.php");
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Izbrisi Vozilo</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5" style="border-left:6px solid black; border-right:6px solid black; border-radius: 5px; background-color: lightgrey;">
    <br />
        
        <h2 class="mt-3">
            Jeste li sigurni da zelite obrisati odabrani zapis iz baze?
        </h2>
        
        <h3 class="mt-3">
            <?php echo $row['godiste']." ".$row['proizvodac']." ".$row['model'];?> 
        </h3>
        <div class="d-flex justify-content-center">
        <form method="POST" action="">
        <button name='delete' class="btn btn-success m-3" type="submit">Da, izbrisi</button>
        <a href="index.php" name='back' class='btn btn-danger m-3'>Natrag</a>
        </form>    
    </div>
</div>

</body>

</html>