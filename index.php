////index.php////

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">
    <title>PHPTOETS</title>
</head>
<body>
    <h1>Autovoorraad</h1>

    <?php

    try {
        $db = new PDO("mysql:host=localhost;dbname=autovoorraad", "root", "");

            $query=$db->prepare("SELECT * FROM autos");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $data){
                echo "<b>" . $data["model"] . "</b>" . " ";
                echo $data["type"] . " ";
                echo $data["kleur"] . " ";
                echo $data["gewicht"] . " ";
                echo $data["prijs"] . " ";
                echo $data["voorraad"] . "<br>";
            }
    } catch(PDOExeption $e) {
        die("ERROR STATUS" . $e->getMessage());
    }

    echo "<br>";

    ?> 

<br>
<br>
<h3>Functies hieronder:</h3>
    <a href="insert.php">Auto Toevoegen</a>
    <br>
    <a href="update.php">Auto Bewerken</a>
    <br>
    <a href="delete.php">Auto Verwijderen</a>
    <br>
    <a href="detail.php">Auto Wegenbelasting bekijken</a>
</body>
</html>


///insert.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>

<form method="post" action="">
    <label>Model</label>
    <input type="text" name="model">
    <br>
     <label>Type</label>
    <input type="text" name="type">
    <br>
     <label>Kleur</label>
    <input type="text" name="kleur">
    <br>
     <label>Gewicht</label>
    <input type="text" name="gewicht">
    <br>
     <label>Prijs</label>
    <input type="text" name="prijs">
    <br>
     <label>Voorraad</label>
    <input type="text" name="voorraad">
    <br>
    <input type="submit" name="verzenden" value="Toevoegen">
</form>
    <?php

try{
    $db = new PDO("mysql:host=localhost;dbname=autovoorraad", "root", "");

    if(isset($_POST["verzenden"])){
      if(!empty($_POST["model"]) && !empty($_POST["type"]) && !empty($_POST["kleur"]) && !empty($_POST["gewicht"]) && !empty($_POST["prijs"]) && !empty($_POST["voorraad"])) {
    if($_POST["voorraad"] < 1 ) {
        echo "<br>" ."Dit getal bestaat niet!";
    } else if ($_POST["voorraad"] >= 1){
        $model = filter_input(INPUT_POST, "model", FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
        $kleur = filter_input(INPUT_POST, "kleur", FILTER_SANITIZE_STRING);
        $gewicht = filter_input(INPUT_POST, "gewicht", FILTER_SANITIZE_STRING);
        $prijs = filter_input(INPUT_POST, "prijs", FILTER_SANITIZE_STRING);
        $voorraad = filter_input(INPUT_POST, "voorraad", FILTER_SANITIZE_STRING);

        $query = $db->prepare("INSERT INTO autos(model,type,kleur,gewicht,prijs,voorraad) VALUES(:model, :type, :kleur, :gewicht, :prijs, :voorraad)");

        $query->bindParam("model", $model);
        $query->bindParam("type", $type);
        $query->bindParam("kleur", $kleur);
        $query->bindParam("gewicht", $gewicht);
        $query->bindParam("prijs", $prijs);
        $query->bindParam("voorraad", $voorraad);
    }
    if($query->execute()){
    echo "<div class=alert alert-danger role=alert  >
        A simple warning alert—check it out!  
      </div>";
        echo "De nieuwe gegevens zijn toegevoed";
    } else {
        echo "Er heeft zich een fout opgetreden";
    }
    echo "<br>";
    
} else {
    echo "Vul alle velden in";
}
    }
 } catch(PDOExeption $e) {
    die("ERROR STATUS" . $e->getMessage());
 }
    ?>

<br>
<br>
<h2><a href="index.php">Terug naar de Homepagina</a></h2>
</body>
</html>

///update.php///

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>updateMaster</title>
</head>
<body>
    <?php
    try {
        $db = new PDO("mysql:host=localhost;dbname=autovoorraad", "root", "");

        $query = $db->prepare("SELECT * FROM autos");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $data){
            echo "<a href='updatedetail.php?id=" .  $data['id']."'>";
            echo $data["model"] . " " .  $data["type"] . " " .  $data["kleur"] . " " .   $data["gewicht"] . " " .  $data["prijs"] . " " .  $data["voorraad"];
            echo "</a>";
            echo "<br>";
        }
    } catch(PDOExeption $e){
        die("Error Code:" . $e->getMessage);
    }
    ?>
    <br>
    <br>
    <h2><a href="index.php">Terug naar de Homepagina</a></h2>
</body>
</html>

///updatedetail.php///

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" action="">
    <label>kleur</label>
    <input type="text" name="kleur"><br>
    <label>gewicht</label>
    <input type="text" name="gewicht"><br>
    <label>prijs</label>
    <input type="text" name="prijs"><br>
    <label>voorraad</label>
    <input type="text" name="voorraad"><br>
    <input type="submit" name="verzenden" value="verzenden">
</form>

    <?php

        try{
            $db = new PDO("mysql:host=localhost;dbname=autovoorraad", "root", "");
            
            if(isset($_POST["verzenden"])){
                if(empty($_POST["kleur"]) && empty($_POST["gewicht"]) && empty($_POST["prijs"]) && empty($_POST["voorraad"])) {
                    echo "Vul alle velden in";
                } else {
                $model = filter_input(INPUT_POST, "model", FILTER_SANITIZE_STRING);
                $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
                $kleur = filter_input(INPUT_POST, "kleur", FILTER_SANITIZE_STRING);
                $gewicht = filter_input(INPUT_POST, "gewicht", FILTER_SANITIZE_STRING);
                $prijs = filter_input(INPUT_POST, "prijs", FILTER_SANITIZE_STRING);
                $voorraad = filter_input(INPUT_POST, "voorraad", FILTER_SANITIZE_STRING);

                $query = $db->prepare("UPDATE autos SET kleur = :kleur, gewicht = :gewicht, prijs = :prijs, voorraad = :voorraad WHERE id = :id");
                $query->bindParam("kleur", $kleur);
                $query->bindParam("gewicht", $gewicht);
                $query->bindParam("prijs", $prijs);
                $query->bindParam("voorraad", $voorraad);
                $query->bindParam("id", $_GET['id']);
                if($query->execute()){
                    echo "De gegevens zijn bijgewerkt";
                } else {
                    echo "Er heeft zich een fout opgetreden!";
                }
            }
                echo "<br>";
            } else {
                $query = $db->prepare("SELECT * FROM autos WHERE id = :id");
                $query->bindParam("id", $_GET['id']);
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach($result as $data) {
                   echo  "<b>" . $data["model"] . "</b>" .  " ";
                   echo $data["type"] . " ";
                   echo $data["kleur"] . " ";
                   echo $data["gewicht"] . " ";
                   echo $data["prijs"] . " ";
                   echo $data["voorraad"] . " ";
                }
            }
        } catch(PDOExeption $e) {
            die("ERROR REASON:" . $e->getMessage());
        }
    ?>

<br>
<h2><a href="index.php">Terug naar de Homepagina</a></h2>
</body>
</html>

///delete.php///

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    try{
        $db = new PDO("mysql:host=localhost;dbname=autovoorraad", "root", "");

        if(isset($_GET['id'])) {
            $query = $db->prepare("DELETE FROM autos WHERE id = :id");
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
            $query->bindParam("id", $id);
            if($query->execute()){
                echo "Het item is verwijderd!";
            } else {
                echo "Er heeft zich een fout opgetreden";
            }
            echo "<br>";
        }
    } catch(PDOExeption $e){
        die("ERROR REASON:" . $e->getMessage());
    }

    $query = $db->prepare("SELECT * FROM autos");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $data){
        echo "<a href='delete.php?id=" . $data['id'] . "'>";
        echo $data["model"] . " " .  $data["type"] . " " .  $data["kleur"] . " " .   $data["gewicht"] . " " .  $data["prijs"] . " " .  $data["voorraad"];
        echo "</a>";
        echo "<br>"; 
    }

    ?>
<br>
<br>
    <h2><a href="index.php">Terug naar de Homepagina</a></h2>
</body>
</html>

///detail.php///

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

try{
    $db = new PDO("mysql:host=localhost;dbname=autovoorraad", "root", "");

    if(isset($_POST["verzenden"])){
      if(!empty($_POST["model"]) && !empty($_POST["type"]) && !empty($_POST["kleur"]) && !empty($_POST["gewicht"]) && !empty($_POST["prijs"]) && !empty($_POST["voorraad"])) {

        if($data["gewicht"] >= 500) {
            echo "Wegenbelasting per maand : €18,00";
        } else if ($data["gewicht"] >= 750){
            echo "Wegenbelasting per maand : €22,00";
        } else if ($data["gewicht"] >= 1000) {
            echo "Wegenbelasting per maand : €40,00";
        } else if ($data["gewicht"] >= 1500) {
        echo "Wegenbelasting per maand : €60,00";
            
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $data){
            echo "<b>" . $data["model"] . "</b>" . " ";
            echo $data["type"] . " ";
            echo $data["kleur"] . " ";
            echo $data["gewicht"] . " ";
            echo $data["prijs"] . " ";
            echo $data["voorraad"] . "<br>";
        }
        }
    
      }
    }
 } catch(PDOExeption $e) {
    die("ERROR STATUS" . $e->getMessage());
 }
    
    ?>
<br>
<br>
<h2><a href="index.php">Terug naar de Homepagina</a></h2>
</body>
</html>

// potentioal css//

table{
    border-collapse: collapse;
    border: 1px solid black;
}
td {
    border: 1px solid black;
    width: 100px;
}
