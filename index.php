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
