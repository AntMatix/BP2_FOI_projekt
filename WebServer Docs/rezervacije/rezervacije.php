<?php
    include "../connection.php";
    
    $rezervacije = $conn->query('SELECT * FROM uredene_rezervacije;');

?>


<!DOCTYPE html>
<html>
<head>
<title>Rezervacije</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="../style.css" rel="stylesheet">
</head>

<div class="container" style="border-radius: 10px;">
  <ul class = "cstmlist">  
    <li><a href="#" id="active">Rezervacije</a></li>
    <li><a href="../index.php">Pocetna</a></li>
  </ul>
</nav>
</div>

<body>
    <div class="container mt-5" style="border-left:6px solid black; border-right:6px solid black; border-radius: 5px; background-color: lightgrey;">
        <br />
        <div class="d-flex justify-content-center mt-4"><a href="createres.php" class="btn btn-dark" >Unesi novu rezervaciju</a></div>
        <h1 class="mt-3">Popis rezervacija</h1>

        <table class = "table">
            <thead>
                <tr>
                    <th>Broj rezervacije</th>
                    <th>Rezervirao</th>
                    <th></th>
                    <th>Rezervirano vozilo</th>
                    <th></th>
                    <th>Odobrio zaposlenik:</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $rezervacije->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <?php $id = $row['broj']; ?>
                        <?php $idVozila = $row['id_vozila']; ?>
                        <td><?php echo htmlspecialchars($row['broj']); ?></td>
                        <td><?php echo htmlspecialchars($row['ime']); ?></td>
                        <td><?php echo htmlspecialchars($row['prezime']); ?></td>
                        <td><?php echo "<a href='../detaljno.php?id=".$idVozila."' class='btn btn-warning'>Vozilo</a>";?></td>
                        <td><?php echo htmlspecialchars($row['auto']); ?></td>
                        <td><?php echo htmlspecialchars($row['odobrio']); ?></td>
                        <td><?php echo "<a href='delres.php?del=".$id."' class='btn btn-danger' type='submit' name='del'>Izbrisi zapis</a>";?></td>
                        <td><?php echo "<a href='editres.php?id=".$id."' class='btn btn-success' type='submit' name='edit'>Uredi</a>";?></td>
                    </tr>
                <?php endwhile; 
                ?>
            </tbody>
        </table>

    <br />
    </div>
</body>
</html>