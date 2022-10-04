// opdracht 1 //

<?php
$melding = "";

if(isset($_POST['verzenden'])){
    //empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['age']) || empty($_POST['geslacht'])
    if($_POST['fname']==NULL || $_POST['lname']==NULL || $_POST['age']==NULL || $_POST['geslacht']==NULL) {
        $melding = "Vul iets in.";
    }else {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $geslacht = $_POST['geslacht'];
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);

        if(!$age){
            $melding = "Vul een getal in.";
        }
        else{
            $melding =  "Hallo $fname $lname. Je leeftijd is $age. Je geslaccht is $geslacht.";

        }
    }
}
?>

<form method='post'>
    <label>Voornaam: </label>
    <input type='text' name='fname'> <br>

    <label>Achternaam: </label>
    <input type='text' name='lname'> <br>

    <label>Leeftijd: </label>
    <input type='text' name='age'> <br>
    <br>
    <label>Geslacht: </label> <br>
    <input type='radio' name='geslacht' value='m'>Man <br>
    <input type='radio' name='geslacht' value='v'>Vrouw <br>
    <input type='radio' name='geslacht' value='a'>Anders <br>


    <input type='submit' name='verzenden' value='Verzenden'>
</form>

<?php
    echo $melding;
?>

OR With page

<?php
    session_start();
    //hiermee check of je uberhaupt een formulier kan verzenden
    if (isset($_POST['send'])) {
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['class']) && !empty($_POST['workshop']) && !empty($_POST['check'])) {
            $check = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            if ($check === false) {
                echo 'vul een geldig e-mail in';
            } else {
                //header('Location: welcome.php');
                $_SESSION['name'] = $_POST['name'];
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['class'] = $_POST['class'];
                $_SESSION['workshop'] = $_POST['workshop'];
                header('Location: welcome.php');
            }
        } else {
            echo 'niet alle velden zijn ingevuld';
        }
    } else {
        echo 'je bent er voor het eerst';
    }
?>

<form method="POST">
    <h1> Inschrijfformulier Workshop</h1>
    <label> Naam: </label>
    <input type="text" name="name" placeholder="type hier uw naam in"></br>
    <label> E-mail: </label>
    <input type="email" name="email" placeholder="typ hier uw email"></br>
    <label> Klas: </label>
    <input type="text" name="class" placeholder="typ hier uw klas"></br>
    <label> Workshops </label></br>
    <input type="radio" name="workshop" value="Drones"> Drones </br>
    <input type="radio" name="workshop" value="Rasberry PI"> Rasberry PI </br>
    <input type="radio" name="workshop" value="Security"> Security </br>
    <input type="checkbox" name="check"> ik ga akkoord met de voorwaarden </br>
    <input type="submit" name="send" value="inschrijven">
</form>

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
<h1> Bedankt voor het inschrijven <?php echo $_SESSION['name'] ?></h1>


</body>
</html>

// movie //

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
<h1> Keuze </h1>
<p>
        <?php
            session_start();
            echo "Beste " . $_SESSION['name']. ", uw keuze voor de film is geworden: ". $_SESSION['movie'];
        ?>
</p>
</body>
</html>

<?php
$melding = "";

if(isset($_POST['verzenden'])){
    //empty($_POST['name']) || empty($_POST['movie']))
    if($_POST['name']==NULL || $_POST['movie']==NULL){
        $melding = "Vul alle velden in!";
    }else {
        session_start();
        $name = $_POST['name'];
        $_SESSION['name'] = $name;
        $movie = $_POST['movie'];
        switch($movie){
                case "1": $_SESSION['movie'] = "Spider-Man: No Way Home"; break;
                case "2": $_SESSION['movie'] = "Doctor Strange in the Multiverse of Madness "; break;
                case "3": $_SESSION['movie'] = "Avatar"; break;
                case "4": $_SESSION['movie'] = "Don't look up "; break;
                case "5": $_SESSION['movie'] = "Jumanji: The Next Level"; break;
                default: $melding = "Er is niks ingevuld."; break;

        }
        header("Location: movie.php");
    }

}
?>

// cal //


<form method='post'>
    <label>Getal 1: </label>
    <input type='number' name='number1'> <br>

    <label>Getal 2: </label>
    <input type='number' name='number2'> <br>

    <br>
    <label>Wat wil je: </label> <br>
    <input type='radio' name='reken' value='op'> + <br>
    <input type='radio' name='reken' value='af'> - <br>
    <input type='radio' name='reken' value='keer'> * <br>
    <input type='radio' name='reken' value='delen'> / <br>


    <br>

    <input type='submit' name='verzenden' value='Uitrekenen'>
</form>



<?php
echo $melding;
?>


<?php
$melding = "";

if(isset($_POST['verzenden'])){
    //empty($_POST['number1']) || empty($_POST['number2']) || empty($_POST['reken']))
    if($_POST['number1']==NULL || $_POST['number2']==NULL || $_POST['reken']==NULL) {
        $melding = "Vul alle velden in!";
    }else {
        $number1 = filter_input(INPUT_POST, 'number1', FILTER_VALIDATE_FLOAT);
        $number2 = filter_input(INPUT_POST, 'number2', FILTER_VALIDATE_FLOAT);

        if(!$number1 || !$number2){
            $melding = "Vul een getal in!";
        }
        else{
            $reken = $_POST['reken'];
            switch($reken){
                case "op": $number = $number1 + $number2;
                    $melding = "$number1 + $number2 = $number"; break;
                case "af": $number = $number1 - $number2;
                    $melding = "$number1 - $number2 = $number"; break;
                case "keer": $number = $number1 * $number2;
                    $melding = "$number1 * $number2 = $number"; break;
                case "delen": $number = $number1 / $number2;
                    $number = number_format($number, 2);
                    $melding = "$number1 / $number2 = $number"; break;
                default: $melding = "Er is niks ingevuld."; break;

            }
        }
    }
}
?>
