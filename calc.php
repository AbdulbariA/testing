<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calc</title>
</head>
<body>
    <form method="POST">
    <label>Getal1</label>    
    <input type="text" name="getal1"> <br>
    <label>Getal2</label>    
    <input type="text" name="getal2"> <br>
    <label></label>  
    <input type="radio" name="calc" value="Optellen" >Optellen  
    <input type="radio" name="calc" value="Aftrekken" >Aftrekken  
    <input type="radio" name="calc" value="Delen" >Delen  
    <input type="radio" name="calc" value="Vermenigvuldigen" >Vermenigvuldigen <br> 
    <input type="submit" name="submit">
    </form>

    <?php
    $getal1 = filter_input(INPUT_POST, "getal1", FILTER_VALIDATE_FLOAT);
    $getal2 = filter_input(INPUT_POST, "getal2", FILTER_VALIDATE_FLOAT);
    $operator = filter_input(INPUT_POST, "calc");

   
    if(isset($_POST['submit'])) {
        if (!$getal2 || !$getal2) {
        echo "Vul ee getal in!";
        } else if (empty($operator)){
            echo "Vul een operator in!";
        } else {
            switch ($operator) {
                case 'Optellen':
                    $result = $getal1 + $getal2;
                    echo "$getal1 + $getal2 = $result";
                    break;
                case 'Aftrekken':
                    $result = $getal1 - $getal2;
                    echo "$getal1 - $getal2 = $result";
                    break;
                case 'Delen':
                    $result = $getal1 / $getal2;
                    echo "$getal1 / $getal2 = $result";
                    break;
                case 'Vermenigvuldigen':
                    $result = $getal1 * $getal2;
                    echo "$getal1 * $getal2 = $result";
                    break;
                default:
                    echo "Er is een fout opgetreden";
                    break;
            }
        }
    }
    ?>
</body>
</html>