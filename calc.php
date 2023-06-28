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



 #[Route('//', name: 'app_champions_league')]
    public function index( GroupRepository $groupRepository): Response
    {
        $group = $groupRepository->findAll();
        return $this->render('champions_league/index.html.twig', [
            'groups'=>$group
        ]);
    }

//// index.twig /////

{% block body %}
    <h4>  Group name </h4>
    <table class="table">

        {% for group in groups %}
        <tbody>
        <tr>

            <td>{{ group.name }}</td>
            <td>{{ group.description }}</td>
            <td > <a class="btn btn-primary" href="{{ path('app_teams', {id: group.id}) }}">Details</a></td>
            <td><a class="btn btn-warning" href="{{ path('app_update', {id: group.id}) }}">update</a></td>
        </tr>


        {% endfor %}

    </table>
    <a href="/insert">insert</a>

{% endblock %}

     //// insert/update /////

    #[Route('/insert', name: 'app_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {

        $add = new Teams();

        $form = $this->createForm(AddTeamType::class, $add);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();
            return $this->redirectToRoute('app_champions_league');
        }

        return $this->renderForm('champions_league/insert.html.twig', [
            'form' => $form,
        ]);
    }

#[Route('/update/{id}', name: 'app_update')]
    public function update(Group $group, Request $request, EntityManagerInterface $entityManager): Response
    {
        $TeamId = $group->getId();
        $group = $entityManager->getRepository(Group::class)->find($TeamId);

        $form = $this->createForm(AddGroupType::class, $group);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();

            $entityManager->persist($add);
            $entityManager->flush();

            return $this->redirectToRoute('app_champions_league');
        }

        return $this->renderForm('champions_league/update.html.twig', [
            'form' => $form,
        ]);
    }

    //// insert/update.twig /////

{%extends 'base.html.twig' %}
{% block body %}
<div class="container">
    {{ form(form) }}
</div>
{% endblock %}



///// delete ////


    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {

        $delete = $entityManager->getRepository(Teams::class)->find($id);
        if (!$delete) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        $entityManager->remove($delete);
        $entityManager->flush();

        return $this->redirectToRoute('app_champions_league');

    }


//// details ///
 #[Route('/teams/{id}', name: 'app_teams')]
    public function details(int $id,TeamsRepository $teamsRepository): Response
    {
        $team = $teamsRepository->findBy(['team'=>$id]);
        return $this->render('champions_league/details.html.twig', [
            'teams' => $team,
        ]);
    }

//// details.twig ///

{% block body %}
    <table class="table">

        {% for team in teams %}
        <tbody>
        <tr>
            <td>{{ team.name }}</td>
            <td > <a class="btn btn-danger" href="{{ path('app_delete', {id: team.id}) }}">delete</a></td>
        </tr>
        {% endfor %}

    </table>
    <a class="btn btn-dark mt-5" href="/home">back</a>
{% endblock %}

/// notable shit ///
{{ teams would be the _link}}
   ->add('team', EntityType::class,[
                'class' => 'App\Entity\Group',
                'choice_label' => 'name',
            ])

            ->add('save', SubmitType::class)




//// update/insert.twig////

{%extends 'base.html.twig' %}
{% block body %}
<div class="container">
    {{ form(form) }}
</div>
{% endblock %}
