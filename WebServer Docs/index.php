<?php

include "connection.php";

$query = 'SELECT v.id_vozila, v.godiste, p.naziv AS proizvodac, v.model FROM vozila v, proizvodaci p WHERE v.proizvodac = p.id_proizvodaci;';
$result = $conn->query($query);
if ($result == false){
    die("Error fetching data.");
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Pocetna</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
</head>

<div class="container" style="border-radius: 10px;">
  <ul class = "cstmlist">  
    <li><a href="/rezervacije/rezervacije.php">Rezervacije</a></li>
    <li><a href="#" id="active">Pocetna</a></li>
  </ul>
</nav>
</div>

<body>
    <div class="container mt-5" style="border-left:6px solid black; border-right:6px solid black; border-radius: 5px; background-color: lightgrey;">
        <br />
        <div class="d-flex justify-content-center mt-4"><a href="createcar.php" class="btn btn-dark" >Unesi novo vozilo u bazu</a></div>
        <h1 class="mt-3">Popis automobila</h1>
        
        <table class = "table">
            <thead>
                <tr>
                    <th>Godiste</th>
                    <th>Proizvodac</th>
                    <th>Model</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <?php $id = $row['id_vozila']; ?>
                        <td><?php echo htmlspecialchars($row['godiste']); ?></td>
                        <td><?php echo htmlspecialchars($row['proizvodac']); ?></td>
                        <td><?php echo htmlspecialchars($row['model']); ?></td>
                        <td><?php echo "<a href='detaljno.php?id=".$id."' class='btn btn-primary'>Detaljno</a>";?></td>
                        <td><?php echo "<a href='delcar.php?del=".$id."' class='btn btn-danger' type='submit' name='del'>Izbrisi zapis</a>";?></td>
                        <td><?php echo "<a href='editcar.php?id=".$id."' class='btn btn-success' type='submit' name='edit'>Uredi</a>";?></td>
                    </tr>
                <?php endwhile; 
                ?>
            </tbody>
        </table>
        
        <br />
    </div>
<?php $conn = null; ?>
</body>
</html>