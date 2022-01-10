<?php

    include "../connection.php";

    $rezerIzbor = $conn->query("SELECT id_klijenta, CONCAT(ime, ' ', prezime) as imeprezime, mail FROM klijenti;");
    $voziloIzbor = $conn->query("SELECT id_vozila, CONCAT(proizvodac, ' ', model) as pmodel FROM uredena_vozila;");
    $odobrioIzbor = $conn->query("SELECT id_zaposlenika, CONCAT(ime, ' ', prezime) as imeprezime FROM zaposlenici;");

    if (isset($_GET['id'])){
        $id = $_GET['id'];
    }
    else {
        die("Error. ID not given.");
    }

    $update = $conn->prepare('UPDATE rezervacije SET
                              rezervirao = :rezervirao,
                              id_vozila = :vozilo, 
                              odobrio = :odobrio
                              WHERE id_rezervacije = :id;');



    $query = $conn->prepare('SELECT * FROM rezervacije WHERE id_rezervacije = :id');
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $resrow = $query->fetch();
    if ($resrow == false){
        die("Error fetching data.");
    }


    if (isset($_POST['edit'])){

        
        $rezervirao = $_POST['rezervirao'];
        $vozilo = $_POST['vozilo'];
        $odobrio = $_POST['odobrio'];

        $update->bindParam(':id', $id, PDO::PARAM_STR);
        $update->bindParam(':rezervirao', $rezervirao, PDO::PARAM_STR);
        $update->bindParam(':vozilo', $vozilo, PDO::PARAM_STR);
        $update->bindParam(':odobrio', $odobrio, PDO::PARAM_STR);

        try {
            $result = $update->execute();
            if ($result === false){
                $error = $update->errorInfo();
            }
            else {
                echo "<div class='container mt-'><h3>Uspjesno uredivanje.</h3></div>";
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
<title>Uredi Rezervaciju</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5" style="border-left:6px solid blue; border-right:6px solid black; border-radius: 5px; background-color: lightgrey;">
    <br />
        
        <h2 class="mt-3">
            Uredivanje podataka o odabranoj rezervaciji
        </h2>
        
        <h3 class="mt-3">
            <?php //echo $row['broj']; ?> 
        </h3>
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
                            <option value = "<?php echo $row['id_klijenta'];?>"
                            <?php if ($row['id_klijenta'] == $resrow['rezervirao']){
                                echo "selected";
                            }
                            ?>>
                            <?php echo htmlspecialchars($row['imeprezime']); ?></option>
                        <?php endwhile; $conn=null; ?>
                    </select>
                </div>
            
                <div class="col-sm">
                    <label for="vozilo">Rezervirano vozilo:</label>
                    <select name="vozilo" id="vozilo" class="form-control">
                        <option selected>--Vozilo--</option>
                        <?php while ($row = $voziloIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value = "<?php echo $row['id_vozila'];?>"
                            <?php if ($row['id_vozila'] == $resrow['id_vozila']){
                                echo "selected";
                            }
                            ?>>
                            <?php echo htmlspecialchars($row['pmodel']); ?></option>
                        <?php endwhile; $conn=null; ?>
                    </select>
                </div>

                <div class="col-sm">
                    <label for="odobrio">Rezervaciju odobrava:</label>
                    <select name="odobrio" id="odobrio" class="form-control">
                        <option selected>--Ovlastena osoba--</option>
                        <?php while ($row = $odobrioIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value = "<?php echo $row['id_zaposlenika'];?>"
                            <?php if ($row['id_zaposlenika'] == $resrow['odobrio']){
                                echo "selected";
                            }
                            ?>>
                            <?php echo htmlspecialchars($row['imeprezime']); ?></option>
                        <?php endwhile; $conn=null; ?>
                    </select>
                </div>

            </div>

            <!-- Drugi red -->

            <div class="row mt-4 justify-content-center w-25 m-auto">
                <button type="submit" class='btn btn-primary mt-4' name="edit">Uredi</button>
            </div>

        </div>
        <br />
        </form>    
      
    </div>
</div>

</body>

</html>