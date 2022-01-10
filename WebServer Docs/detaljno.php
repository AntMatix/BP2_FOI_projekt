<?php

include "connection.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];
}
else {
    die("Error. ID not given.");
}

$query = $conn->prepare('SELECT * FROM uredena_vozila WHERE id_vozila = :id');
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$row = $query->fetch();
if ($query == false){
    die("Error fetching data.");
}

$oprema = $conn->prepare('SELECT proizvodac as proizvodac, naziv as oprema 
                          from uredena_vozila uv join oprema_vozila ov on uv.id_vozila = ov.id_vozila 
                          inner join moguca_oprema mo on ov.id_oprema = mo.id_oprema WHERE uv.id_vozila = :id');

$oprema->bindParam(':id', $id, PDO::PARAM_STR);
$oprema->execute();
if ($oprema == false){
    die("Error fetching data from OPREMA.");
}

?>


<!DOCTYPE html>
<html>
<head>
<title>Detaljno</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
</head>

<div class="container" style="border-radius: 10px;">
  <ul class="cstmlist">  
    <li><a href="/rezervacije/rezervacije.php">Rezervacije</a></li>
    <li><a href="index.php">Pocetna</a></li>
  </ul>
</nav>
</div>

<body>
    <div class="container mt-5" style="border-left:6px solid black; border-right:6px solid black; border-radius: 5px; background-color: lightgrey;">
        <br />
        <div class="d-flex justify-content-center mt-4"><?php echo "<a href='editcar.php?id=".$id."' class='btn btn-success p-2' type='submit' name='edit'>Uredi podatke</a>";?></div>
        <h1 class="mt-3">
            <?php echo $row['godiste']." ".$row['proizvodac']." ".$row['model'];?> 
        </h1>
        <table class = "table">
            <thead>
                <tr>
                    <th>Polovan</th>
                    <th>Kilometraza</th>
                    <th>Gorivo</th>
                    <th>Broj vrata</th>
                    <th>Tip karoserije</th>
                    <th>Zapremina motora</th>
                    <th>Snaga (ks)</th>
                    <th>Transmisija</th>
                    <th>Pogon</th>
                    <th>Boja</th>
                    <th>Rezerviran</th>

                </tr>
            </thead>
            <tbody>
            <h4>Kratak opis:</h4>
            <div class="mt-3 mb-3"><?php echo htmlspecialchars($row['opis']); ?></div>
                    <tr>
                        <td><?php echo htmlspecialchars($row['polovan']); ?></td>
                        <td><?php echo htmlspecialchars($row['kilometraza']); ?> </td>
                        <td><?php echo htmlspecialchars($row['gorivo']); ?></td>
                        <td><?php echo htmlspecialchars($row['br_vrata']); ?></td>
                        <td><?php echo htmlspecialchars($row['karoserija']); ?></td>
                        <td><?php echo htmlspecialchars($row['zapremina_motora']); ?></td>
                        <td><?php echo htmlspecialchars($row['snaga']); ?></td>
                        <td><?php echo htmlspecialchars($row['mjenjac']); ?></td>
                        <td><?php echo htmlspecialchars($row['pogon']); ?></td>
                        <td><?php echo htmlspecialchars($row['boja']); ?></td>
                        <td><?php echo htmlspecialchars($row['rezerviran']); ?></td>

                    </tr>
                    
                    <br />                  
                
            </tbody>
        </table>

        <br />

        <div class="d-flex justify-content-center"> 
            <h3 class="font-italic">Oprema vozila:</h3>
        

        
        <div class="w-25 m-auto">
            <?php
            while ($opremarow = $oprema->fetch(PDO::FETCH_ASSOC)) : ?>
            <ul class="list-group m-auto">
                <li class="list-group-item list-group-item-dark mb-1 pb-1"><?php echo htmlspecialchars($opremarow['oprema']) ?></li>
            </ul>
            <?php
               endwhile;
        ?>
        <br />
        </div>   
               
    </div>
    <?php  
                $conn = null; ?>
</body>
</html>


