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
