??db?? DATABASE_URL="mysql://root:@127.0.0.1:3306/Cars?serverVersion=mariadb-10.5.8" 

or

DATABASE_URL="mysql://root:@127.0.0.1:3306/Films?serverVersion=10.4.24-MariaDB"





use App\Entity\Genre;

///controller//

    #[Route('/', name: 'app_home')]
    public function home(GenreRepository $genreRepository): Response
    {
        $genres = $genreRepository->findAll();
        return $this->render('film/index.html.twig', [
            'genres' => $genres,

        ]);
    }

    #[Route('/film/{id}', name: 'app_film')]
    public function films(Genre $genre, FilmRepository $filmRepository): Response
    {
        $genreName = $genre->getName();
        $films = $filmRepository->findBy(['genre'=>$genre]);
        return $this->render('film/films.html.twig', [
            'films' => $films,
            'name' => $genreName

        ]);
    }



\\index/home\\



    <h1>Genres</h1>
    {% for genre in genres %}
        <a href="{{ path('app_film', {id: genre.id}) }}">{{ genre.name }}</a>
    {% endfor %}


\\film/whatever\\

    <h1>{{ name }}</h1>

    {% for film in films %}
    <table class="table">
        <tr>
            <td>
                film name:
                <a>{{ film.title }}</a>
            </td>

            <td>
                film description:
                <a>{{ film.description }}</a>
            </td>

            <td>
                film budget:
                <a>{{ film.budget }}</a>
            </td>

        </tr>

        {% endfor %}
    </table>




<table class="table">
<tr>
    <th>Model</th>
    <th>type</th>
    <th>price</th>
</tr>

{% for auto in autos %}
       <tr>
           <td>{{ auto.model }}</td>
           <td>{{ auto.type }}</td>
           <td>{{ auto.prijs }}</td>
           <td> <a class="btn btn-primary" href="{{ path('app_details',{id: auto.id}) }}">details</a>  </td>

       </tr>


    {% endfor %}
    </table>




    #[Route('/', name: 'app_home')]
    public function home(AutosRepository $autosRepository): Response
    {
        $autos = $autosRepository->findAll();
        return $this->render('autos/index.html.twig', [
            'autos' => $autos,
        ]);
    }

    #[Route('/details/{id}', name: 'app_details')]
    public function details( Autos $auto, AutosRepository $autosRepository): Response
    {
        return $this->render('autos/details.html.twig', [
            'auto' => $auto,
        ]);
    }


















































































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
