<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Repository\MaterielRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiMaterielController extends AbstractController
{
    /**
     * @Route("/api/materiels", name="api_materiels", methods={"GET"})
     */
    public function list(MaterielRepository $repo, SerializerInterface $serializer )
    {
        $materiels=$repo->findAll();
        $resultat=$serializer->serialize(
            $materiels,
            'json',
            [
                'groups'=>['listeMaterielSimple']
            ]
        );
        //return new JsonResponse($resultat,200,[],true);
        return $this->render('api_materiel/index.html.twig', [
            'results' => $materiels
        ]);
    }

    /**
     * @Route("/api/materiels/{id}", name="api_materiels_show", methods={"GET"})
     */
    public function show(Materiel $materiel, SerializerInterface $serializer )
    {
        $resultat=$serializer->serialize(
            $materiel,
            'json',
            [
                'groups'=>['listeMaterielSimple']
            ]
        );
        return new JsonResponse($resultat,200,[],true);
        //return $this->render('api_materiel/index.html.twig');
    }
}
