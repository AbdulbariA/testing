<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css ">
    <title>telefoons</title>
</head>
<body>
<br>
<a href="insert.php">Merk toevoegen</a>
<?php

    try {
        $db= new PDO("mysql:host=localhost;dbname=telefoons", "root", "");
        $query = $db->prepare("SELECT * FROM merk");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo "<table>";
            echo "<h3>Telefoon Merken</h3>";
         foreach ($result as &$data) {
             echo "<tr>";
             echo "<td>" . $data["naam"] . "<td>";
             echo "</tr>";
         }
         echo "Aaantal merken is: ";
        print_r(count($result));

        
    }catch (PDOException $e) {
        die("Error!: " . $e->getMessage());
    }

?>
</body>
</html>

//

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert</title>
</head>
<body>

<form method="post">
    <label>Merk toevoegen</label>
    <input type="text" name="merknaam">
    <input type="submit" name="verzenden" value="Opslaan">
</form>


     <?php

      try {
        $db= new PDO("mysql:host=localhost;dbname=telefoons", "root", "");
        if(isset($_POST['verzenden'])) {
            $merk = filter_input(INPUT_POST, "merknaam", FILTER_SANITIZE_STRING);
            $query = $db ->prepare("INSERT INTO merk(naam) VALUES(:merknaam)");
            $query->bindParam("merknaam", $merk);
            if ($query->execute()) {
                echo "De nieuwe gegevens zijn toegevoegd.";
                header('Location: index.php');
            }else {
                echo "Er is een fout opgetreden!";
            }
            echo "<br>";
        }
        
     }catch (PDOException $e) {
        die("Error!: " . $e->getMessage());
    }
    ?>

</body>
</html>

// 
table{
    border-collapse: collapse;
    border: 1px solid black;
}
td {
    border: 1px solid black;
    width: 100px;
}


// 

<?php
    session_start();
    
    if (isset($_POST['send'])) {
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['games']) && !empty($_POST['dagdeel']) && !empty($_POST['check'])) {
            $check = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            if ($check === false) {
                echo 'vul een geldig e-mail in';
            } else {
                $_SESSION['name'] = $_POST['name'];
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['games'] = $_POST['games'];
                $_SESSION['dagdeel'] = $_POST['dagdeel'];
                header('Location: welcome.php');
            }
        } else {
            echo 'niet alle velden zijn ingevuld';
        }
    }
?>





<form method="POST">
    <h1> Inschrijfformulier game event</h1>
    <label> Naam: </label>
    <input type="text" name="name" placeholder="type hier uw naam "></br>
    <label> E-mail: </label>
    <input type="email" name="email" placeholder="typ hier uw email"></br>
<br>
    <label> Games: </label></br>
    <input type="radio" name="games" value="Fifa 2022"> Fifa 2022 </br>
    <input type="radio" name="games" value="Quake"> Quake </br>
    <input type="radio" name="games" value="Fortnite"> Fortnite </br>
<br>

    <label> Dagdeel: </label></br>
    <input type="radio" name="dagdeel" value="ochtend"> ochtend </br>
    <input type="radio" name="dagdeel" value="middag"> middag </br>
    <input type="radio" name="dagdeel" value="avond"> avond </br>



    <input type="checkbox" name="check"> ik ga akkoord met de voorwaarden </br>
    <input type="submit" name="send" value="inschrijven">

</form>

//

<?php
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1> Inschrijven game event <br></h1>
<?php echo $_SESSION ['email'] ?><br>
<label> Games: </label>
<?php echo $_SESSION ['games'] ?><br>
<label> Dagdeel: </label>
<?php echo $_SESSION ['dagdeel'] ?>


</body>
</html>
Footer

