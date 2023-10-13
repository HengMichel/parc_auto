<?php

namespace App\Controller;

use App\Repository\VoitureRepository;
use App\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // Architecture MVC
    // 1- Envoyer une requete http en saisisant les données à partir de l'URL d'un navigateur 
    // 2- Récupérer la requete http par le 'controleur' (controller) 
    // 3- si besoin le controleur appelle le 'model' et envoi la requete vers le model afin d'interagir avec la bdd
    // 4- Le model envoie la reponse au controleur
    // 5-Controleur récupère la réponse du model et il l'envoie vers la 'vue'(view)


    // #[Route('/home', name: 'app_home')] => vu navigateur http://127.0.0.1:8000/home
    //  '/home' est le nom du chemin qui peut etre modifie 
    // exemple #[Route('/moi', name: 'app_home')] => vu navigateur http://127.0.0.1:8000/moi
    // les routes doivent etre unique

    //name: 'app_home' est le nom de la route pour un lien => a href="{{ path('app_moi')}}"

    #[Route('/home', name: 'app_home')]
    
    public function index(VoitureRepository $voitureRepository): Response
    {
        $voitures = $voitureRepository->findAll();

        return $this->render('home/home.html.twig', [
            
            'voitures'=>$voitures,
        ]);
    }

    #[Route('/show_voit/{id}', name: 'show_voit')]
    
    public function show(VoitureRepository $voitureRepository,$id): Response
    {
        $voiture = $voitureRepository->find($id);

        return $this->render('home/show_voit.html.twig', [
            'voiture'=>$voiture,
        ]);
    }
}
