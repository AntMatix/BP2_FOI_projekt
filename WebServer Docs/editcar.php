<?php

include "connection.php";

$gorivoIzbor = $conn->query('SELECT id_vrste_goriva, gorivo FROM vrste_goriva;');
$proizvodacIzbor = $conn->query('SELECT id_proizvodaci, naziv FROM proizvodaci;');
$karoserijaIzbor = $conn->query('SELECT id_tip_vozila, tip FROM tip_vozila;');
$mjenjacIzbor = $conn->query('SELECT id_tip_transmisije, tip FROM tip_transmisije;');
$pogonIzbor = $conn->query('SELECT id_vrste_pogona, naziv FROM vrste_pogona;');

if (isset($_GET['id'])){
    $id = $_GET['id'];
}
else {
    die("Error. ID not given.");
}

$query = $conn->prepare('SELECT * FROM uredena_vozila WHERE id_vozila = :id');
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$carrow = $query->fetch();
if ($carrow == false){
    die("Error fetching data.");
}

$update = $conn->prepare('UPDATE vozila SET godiste = :godiste,
                                            proizvodac = :proizvodac,
                                            model = :model,
                                            polovan = :polovan,
                                            kilometraza = :kilometraza,
                                            gorivo = :gorivo,
                                            br_vrata = :br_vrata,
                                            tip_vozila = :tip_vozila,
                                            zapremina_motora = :zapremina_motora,
                                            snaga = :snaga,
                                            transmisija = :transmisija,
                                            pogon = :pogon,
                                            boja = :boja,
                                            opis = :opis,
                                            rezerviran = :rezerviran                  
                                            WHERE id_vozila = :id');

if ( isset($_POST['edit']) ){

    $godiste = $_POST['godiste'];
    $proizvodac = $_POST['proizvodac'];
    $model = $_POST['model'];
    $gorivo = $_POST['gorivo'];
    $kilometraza = $_POST['kilometraza'];
    $karoserija = $_POST['karoserija'];
    $br_vrata = $_POST['br_vrata'];
    $zapremina = $_POST['zapremina'];
    $snaga = $_POST['snaga'];
    $mjenjac = $_POST['mjenjac'];
    $pogon = $_POST['pogon'];
    $boja = $_POST['boja'];
    $opis = $_POST['opis'];
    $polovan = $_POST['polovan'];
    $rezerviran = $_POST['rezerviran'];
 
    $update->bindParam(':id', $id, PDO::PARAM_STR);

    $update->bindParam(':godiste', $godiste, PDO::PARAM_STR);
    $update->bindParam(':proizvodac', $proizvodac, PDO::PARAM_STR);
    $update->bindParam(':model', $model, PDO::PARAM_STR);
    $update->bindParam(':polovan', $polovan, PDO::PARAM_STR);
    $update->bindParam(':kilometraza', $kilometraza, PDO::PARAM_STR);
    $update->bindParam(':gorivo', $gorivo, PDO::PARAM_STR);
    $update->bindParam(':br_vrata', $br_vrata, PDO::PARAM_STR);
    $update->bindParam(':tip_vozila', $karoserija, PDO::PARAM_STR);
    $update->bindParam(':zapremina_motora', $zapremina, PDO::PARAM_STR);
    $update->bindParam(':snaga', $snaga, PDO::PARAM_STR);
    $update->bindParam(':transmisija', $mjenjac, PDO::PARAM_STR);
    $update->bindParam(':pogon', $pogon, PDO::PARAM_STR);
    $update->bindParam(':boja', $boja, PDO::PARAM_STR);
    $update->bindParam(':opis', $opis, PDO::PARAM_STR);
    $update->bindParam(':rezerviran', $rezerviran, PDO::PARAM_STR);

    try {
        $result = $update->execute();
        if ($result === false){
            $error = $update->errorInfo();
            //print_r($error);
            //echo "$error[2]... is the error reported by trigger\n";
        }
        else {
            echo "<div class='container mt-'><h3>Uspjesno uredivanje.</h3></div>";
            echo "<div class='d-flex justify-content-center'><a href='index.php' class='btn btn-primary'>Nazad na pocetnu</a></div>";
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
    

    //header("location:yourfilenamehere.php");    
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Uredi vozilo</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5" style="border-left:6px solid blue; border-radius: 5px; background-color: lightgrey;">
        <br />
        <h2>Uredivanje podataka o odabranom vozilu</h2>
        <form method="POST" action="" class="mt-5">
        
        <div class="form-group mt-3">

            <!-- Prvi red -->
            <div class="row mt-5">
                
                <div class="col-sm mt-4">
                    <input name="godiste" type="text" class="form-control" placeholder="Godiste" value=<?php echo $carrow['godiste'] ?>></input>
                </div>
            
                <div class="col-sm">
                    <label for="proizvodac">Proizvodac:</label>
                    <select name="proizvodac" id="proizvodac" class="form-control">
                        <!-- <option selected>--Proizvodac--</option> -->
                    <?php while($row = $proizvodacIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value= "<?php echo $row['id_proizvodaci'];?>"
                        <?php 
                            if ($row['naziv'] == $carrow['proizvodac']){
                                echo "selected";
                            }
                                ?>>
                                <?php echo htmlspecialchars($row['naziv']);?></option>    
                    <?php endwhile; $conn == null; ?>
                    </select>
                </div>
                          
                <div class="col-sm mt-4">
                    <input name="model" type="text" class="form-control" placeholder="Model" value="<?php echo $carrow['model'] ?>"></input>
                </div>
                
                <div class="col-sm mt-4">
                    <input name="kilometraza" type="text" class="form-control" placeholder="Kilometraza" value=<?php echo $carrow['kilometraza'] ?>></input>
                </div>

            </div>

            <!-- Drugi red -->

            <div class="row mt-5">
                
                <div class="col-sm">
                    <label for="gorivo">Vrsta goriva:</label>
                    <select name="gorivo" id="gorivo" class="form-control">
                       <!-- <option selected>--Vrsta goriva--</option> -->
                    <?php while($row = $gorivoIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value= "<?php echo $row['id_vrste_goriva'];?>"
                        <?php 
                            if ($row['gorivo'] == $carrow['gorivo']){
                                echo "selected";
                            }
                                ?>>
                                <?php echo htmlspecialchars($row['gorivo']);?></option>    
                    <?php endwhile; $conn == null; ?>
                    </select>
                </div>
                
                <div class="col-sm">
                    <label for="karoserija">Tip karoserije:</label>
                    <select name="karoserija" id="karoserija" class="form-control">
                        <!-- <option selected>--Tip karoserije--</option> -->
                    <?php while($row = $karoserijaIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value= "<?php echo $row['id_tip_vozila'];?>"
                        <?php 
                            if ($row['tip'] == $carrow['karoserija']){
                                echo "selected";
                            }
                                ?>>
                                <?php echo htmlspecialchars($row['tip']);?></option>    
                    <?php endwhile; $conn == null; ?>
                    </select>
                </div>

                <div class="col-sm">
                    <label for="mjenjac">Vrsta mjenjaca:</label>
                    <select name="mjenjac" id="mjenjac" class="form-control">
                        <!-- <option selected>--Vrsta mjenjaca--</option> -->
                    <?php while($row = $mjenjacIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value= "<?php echo $row['id_tip_transmisije'];?>" 
                        <?php 
                            if ($row['tip'] == $carrow['mjenjac']){
                                echo "selected";
                            }
                                ?>>
                        <?php echo htmlspecialchars($row['tip']);?>
                    </option>    
                    <?php endwhile; $conn == null; ?>
                    </select>
                </div>

                <div class="col-sm">
                    <label for="pogon">Vrsta pogona:</label>
                    <select name="pogon" id="pogon" class="form-control">
                       <!-- <option selected>--Vrsta pogona--</option> -->
                    <?php while($row = $pogonIzbor->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value= "<?php echo $row['id_vrste_pogona'];?>"
                        <?php 
                            if ($row['naziv'] == $carrow['pogon']){
                                echo "selected";
                            }
                                ?>>
                                <?php echo htmlspecialchars($row['naziv']);?></option>    
                    <?php endwhile; $conn == null; ?>
                    </select>
                </div>

                <div class="col-sm mt-4">
                    <input name="br_vrata" type="text" class="form-control" placeholder="Broj vrata" value=<?php echo $carrow['br_vrata'] ?>></input>
                    <small id="br_vrataHelp" class="form-text text-muted">U obliku broja (2 ili 4).</small>
                </div>

                <div class="col-sm mt-4">
                    <input name="zapremina" type="text" class="form-control" placeholder="Zapremina motora" value="<?php echo $carrow['zapremina_motora'] ?>"></input>
                    <small id="zapreminaHelp" class="form-text text-muted">Npr. 1390 cc</small>
                </div>

                <div class="col-sm mt-4">
                    <input name="snaga" type="text" class="form-control" placeholder="Snaga motora u ks" value="<?php echo $carrow['snaga'] ?>"></input>
                    <small id="snagaHelp" class="form-text text-muted">Npr. 184 ks</small>
                </div>
                
                <div class="col-sm mt-4">
                    <input name="boja" type="text" class="form-control" placeholder="Boja vozila" value="<?php echo $carrow['boja'] ?>"></input>
                </div>

            </div>
            
            <!-- Treci red -->

            <div class="row mt-4">
                
                <div class="col-sm-100% mt-2">
                    <input name="opis" type="text" class="form-control" placeholder="Opis vozila" value="<?php echo $carrow['opis'] ?>"></input>
                </div>

            </div>
            
            <!-- Cetvrti red -->
            <div class="row mt-4 justify-content-center">
                
                <div class="col-sm mt-1">
                    <label for="polovan">Polovan?</label><br />
                    <?php
                        if ($carrow['polovan'] == "Ne") {
                            echo '<input name="polovan" type="hidden" class="form-check-input mt" value="0"/>
                            <input name="polovan" type="checkbox" class="form-check-input" value="1"/> ';
                        }
                        else {
                            echo '<input name="polovan" type="hidden" class="form-check-input mt" value="0"/>
                            <input name="polovan" type="checkbox" class="form-check-input" value="1" checked/>';
                            
                        }
                    ?>
                    
                    
                </div>

                <div class="col-sm mt-1">
                    <label for="rezerviran">Rezerviran?</label><br />
                    <?php
                        if ($carrow['rezerviran'] == "Ne") {
                            echo '<input name="rezerviran" type="hidden" class="form-check-input mt" value="0"/>
                            <input name="rezerviran" type="checkbox" class="form-check-input" value="1"/>';
                        }
                        else {
                            echo '<input name="rezerviran" type="hidden" class="form-check-input mt" value="0"/>
                            <input name="rezerviran" type="checkbox" class="form-check-input" value="1" checked/>';

                        }
                    ?>
                </div>

            </div>
            
            <div class="row mt-4 justify-content-center w-25 m-auto">
                <button type="submit" class='btn btn-primary mt-4' name="edit">Uredi</button>
            
            </div>
        </div>

        <br />
        </form>
        
    </div>
</body>
</html>
