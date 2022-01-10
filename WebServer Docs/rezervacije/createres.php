<?php

    include "../connection.php";

    $rezerIzbor = $conn->query("SELECT id_klijenta, CONCAT(ime, ' ', prezime) as imeprezime, mail FROM klijenti;");
    $voziloIzbor = $conn->query("SELECT id_vozila, CONCAT(proizvodac, ' ', model) as pmodel FROM uredena_vozila;");
    $odobrioIzbor = $conn->query("SELECT id_zaposlenika, CONCAT(ime, ' ', prezime) as imeprezime FROM zaposlenici;");


    $insert = $conn->prepare('INSERT INTO rezervacije values (default, :rezervirao, :vozilo, :odobrio);');

    if (isset($_POST['unos'])){

        $rezervirao = $_POST['rezervirao'];
        $vozilo = $_POST['vozilo'];
        $odobrio = $_POST['odobrio'];

        $insert->bindParam(':rezervirao', $rezervirao, PDO::PARAM_STR);
        $insert->bindParam(':vozilo', $vozilo, PDO::PARAM_STR);
        $insert->bindParam(':odobrio', $odobrio, PDO::PARAM_STR);

        try {
            $result = $insert->execute();
            if ($result === false){
                $error = $insert->errorInfo();
            }
            else {
                echo "<div class='container mt-'><h3>Uspjesan unos.</h3></div>";
                echo "<div class='d-flex justify-content-center'><a href='rezervacije.php' class='btn btn-primary'>Nazad na rezervacije.</a></div>";
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


?>

<!DOCTYPE html>
<html>
<head>
<title>Unesi rezervaciju</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5" style="border-left:6px solid blue; border-right:6px solid black; border-radius: 5px; background-color: lightgrey;">
    <br />
        
        <h2 class="mt-3">
            Unos nove rezervacije:
        </h2>
        
        <div class="d-flex justify-content-center">
        <form method="POST" action="">

        <div class="form-group mt-3">

            <!-- Prvi red -->

            <div class="row mt-5">

                <div class="col-sm">
                    <label for="rezervirao">Rezervirao:</label>
                    <select name="rezervirao" id="rezervirao" class="form-control">
                        <option selected>--Rezervirao--</option>
                        <?php while ($row = $rezerIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value = "<?php echo $row['id_klijenta'];?>"><?php echo htmlspecialchars($row['imeprezime']); ?></option>
                        <?php endwhile; $conn=null; ?>
                    </select>
                </div>
            
                <div class="col-sm">
                    <label for="vozilo">Rezervirano vozilo:</label>
                    <select name="vozilo" id="vozilo" class="form-control">
                        <option selected>--Vozilo--</option>
                        <?php while ($row = $voziloIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value = "<?php echo $row['id_vozila'];?>"><?php echo htmlspecialchars($row['pmodel']); ?></option>
                        <?php endwhile; $conn=null; ?>
                    </select>
                </div>

                <div class="col-sm">
                    <label for="odobrio">Rezervaciju odobrava:</label>
                    <select name="odobrio" id="odobrio" class="form-control">
                        <option selected>--Ovlastena osoba--</option>
                        <?php while ($row = $odobrioIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value = "<?php echo $row['id_zaposlenika'];?>"><?php echo htmlspecialchars($row['imeprezime']); ?></option>
                        <?php endwhile; $conn=null; ?>
                    </select>
                </div>

            </div>

            <!-- Drugi red -->

            <div class="row mt-4 justify-content-center w-25 m-auto">
                <button type="submit" class='btn btn-primary mt-4' name="unos">Unesi</button>
            </div>

        </div>
        <br />
        </form>    
      
    </div>
</div>

</body>

</html>