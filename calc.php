//// main controller ///

    #[Route('/', name: 'app_auto')]
    public function index(): Response
    {
        return $this->render('auto/index.html.twig', [
            'controller_name' => 'AutoController',
        ]);
    }


    #[Route('/display', name:'display')]
    public function display(EntityManagerInterface $entityManager):Response
    {
        $autos=$entityManager->getRepository(Auto::class)->findAll();
        //dd($autos);
        return $this->render('auto/display.html.twig',[
            'autos'=>$autos,
            'opdracht'=>'Toets CRUD'
        ]);
    }
    #[Route('/update/{id}',name:'update')]
    public function update(Request $request,EntityManagerInterface $entityManager, int $id)
    {
        $auto=$entityManager->getRepository(Auto::class)->find($id);

        $form=$this->createForm(AutoType::class,$auto);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $auto=$form->getData();
            $entityManager->persist($auto);
            $entityManager->flush();
            return $this->redirectToRoute('display');
        }
        return $this->renderForm('auto/insert.html.twig', [
            'auto_form'=>$form
        ]);
    }

    #[Route('/insert', name:'insert')]
    public function insert(Request $request,EntityManagerInterface $entityManager):Response
    {
        $auto=new auto();
        $form=$this->createForm(autoType::class,$auto);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $auto=$form->getData();
            $entityManager->persist($auto);
            $entityManager->flush();
            return $this->redirectToRoute('display');
        }
        return $this->renderForm('auto/insert.html.twig', [
            'auto_form'=>$form
        ]);
    }
    #[Route('/details/{id}', name: 'app_data')]
    public function details(auto $autos, autoRepository $autosRepository): Response
    {
        $details =$autosRepository->findBy( ['id'=>$autos]);
        return $this->render('auto/details.html.twig', [
            'id' => $autos,
            'data' => $details,
        ]);
    }
    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(EntityManagerInterface $entityManager ,int $id): Response
    {
        $deleteAuto= $entityManager->getRepository(auto::class)->find($id);
        if (!$deleteAuto){
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $entityManager->remove($deleteAuto);
        $entityManager->flush();

        return $this->redirectToRoute('display');

    }


//// insert.twig///

{% extends 'base.html.twig' %}

{% block body %}
    <div class="container">
        {{ form(auto_form) }}
    </div>
{% endblock %}


//// details.twig ////

{% extends 'base.html.twig' %}
{% block body %}
    <div class="hero-image">
        <div class="hero-text">
            <h1>Welcome to ,<span class="text-warning">Golans' Cars </span></h1>
            <p>the best and the only</p>
            <a href="#" class="btn btn-outline-dark"><span class="text-light">lets start it</span> </a>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Number</th>
            <th scope="col">Model</th>
            <th scope="col">type</th>
            <th scope="col">gewicht</th>
            <th scope="col">prijs</th>
            <th scope="col">kleur</th>
            <th scope="col">voorraad</th>
        </tr>
        </thead>
        <tbody>


        {% for Autos in data %}

        <tr>
            <th scope="row"> {{ Autos.id }}</th>
            <td>{{ Autos.model }}</td>
            <td>{{ Autos.type }}</td>
            <td>{{ Autos.gewicht }}</td>
            <td>{{ Autos.prijs }}</td>
            <td>{{ Autos.kleur }}</td>
            <td>{{ Autos.voorraad }}</td>


            {% endfor %}
        </tbody>

        </thead>
    </table>
    <a href="/home" class="btn btn-info ms-2">back</a>


{% endblock %}


/// display ///

{% extends 'base.html.twig' %}

{% block body %}
    <div class="container">
        <h1>{{ opdracht }}</h1>

        <table class="table">
            <thead>
            <tr>
                <th>Model</th>
                <th>Type</th>
                <th>prijs</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {% for auto in autos %}
                <tr>
                    <td>{{  auto.model}}</td>
                    <td>{{ auto.type }}</td>
                    <td>{{ auto.prijs }}</td>
                    <td><a href="{{ path ('app_data',{id: auto.id})  }}">details</a></td>
                    <td><a href="{{ path ('update',{id: auto.id})  }}">update</a></td>
                    <td><a href="{{ path ('app_delete',{id: auto.id})  }}">delete</a></td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
        <a href="/insert">insert</a>
    </div>
{% endblock %}





///ali///



 #[Route('/', name: 'app_countries')]
    public function showContinent(ContinentRepository $continentRepository): Response
    {
        $showContinent = $continentRepository->findAll();
        return $this->render('countries/index.html.twig', [
            'showre' => $showContinent,
        ]);
    }

    #[Route('/landen/{id}', name: 'app_landen')]
    public function details(int $id,CountryRepository $countryRepository): Response
    {
        $showlanden = $countryRepository->findBy(['continent'=>$id]);
        return $this->render('countries/landen.html.twig', [
            'landen' => $showlanden,
        ]);
    }

    #[Route('/insert', name: 'app_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {

        $add = new Country();

        $form = $this->createForm(LandType::class, $add);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();
            return $this->redirectToRoute('app_countries');
        }

        return $this->renderForm('countries/insert.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/update/{id}', name: 'app_update')]
    public function update(Continent $continent, Request $request, EntityManagerInterface $entityManager): Response
    {
        $LandId = $continent->getId();
        $landd = $entityManager->getRepository(Continent::class)->find($LandId);

        $form = $this->createForm(ContinentType::class, $landd);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('app_countries');
        }

        return $this->renderForm('countries/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {

        $delete = $entityManager->getRepository(Country::class)->find($id);
        if (!$delete) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        $entityManager->remove($delete);
        $entityManager->flush();

        return $this->redirectToRoute('app_countries');

    }

////index.twig///

{% extends 'base.html.twig' %}

{% block title %}Hello CountriesController!{% endblock %}

{% block body %}
    <h4>  Continent naam</h4>
    <table class="table">

        {% for Continent in showre %}
        <tbody>
        <tr>

            <td>{{ Continent.name }}</td>
            <td > <a class="btn btn-primary" href="{{ path('app_landen', {id: Continent.id}) }}">landen</a></td>
            <td><a class="btn btn-warning" href="{{ path('app_update', {id: Continent.id}) }}">update</a></td>
        </tr>


        {% endfor %}

    </table>
    <a href="/insert">insert</a>

{% endblock %}


//// land.twig/// 

{% extends 'base.html.twig' %}

{% block title %}Hello CountriesController!{% endblock %}

{% block body %}
    <table class="table">

        {% for showlanden in landen %}
        <tbody>
        <tr>

            <td>{{ showlanden.name }}</td>
            <td > <a class="btn btn-danger" href="{{ path('app_delete', {id: showlanden.id}) }}">delete</a></td>
{#            <td><a class="btn btn-warning" href="{{ path('app_updatecon') }}">update</a></td>#}

        </tr>
        {% endfor %}

    </table>
{#    <a class="btn btn-success" href="/insert">insert</a> <br>#}
    <a class="btn btn-dark mt-5" href="/home">back</a>

{% endblock %}



//// update/insert.twig////

{%extends 'base.html.twig' %}
{% block body %}
<div class="container">
    {{ form(form) }}
</div>
{% endblock %}
