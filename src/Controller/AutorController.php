<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Autor;

use App\Form\AutorType;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
* @Route("/autor")
*/

class AutorController extends Controller
{
    /**
    @Route("/lista", name="autor_lista")
    */

    public function listado(Request $request)
    {
     
        $autor = new Autor();
        $formu = $this->createForm(AutorType::class, $autor);
        //Para poder cogerlo despues
        $formu->handleRequest($request);
        if ($formu->isSubmitted()){
        dump($autor);
            //Esta primera es la que llamas a la base de datos Doctrine//
            $em = $this->getDoctrine()->getManager();
            //Esta es para persistir los datos que persisten ahi//
            $em->persist($autor);
            //El flush es como un commit ¿ya esta todo? pues ahora si coge todos los dias//
            $em->flush();
            //Esto es para que cuando se creen personas en el formulario los mande a la lista
        }
        $repo = $this->getDoctrine()->getRepository(Autor::class);
        // El findAll() es para que coga todos los datos. Esa linea donde pone el findAll() es la conexion a la base de datos//
        $vectorautores = $repo->findAll();
        return $this->render('autor/index.html.twig', [
        'vectorautores' => $vectorautores,
        'formulario'=>$formu->createView()
        ]);
    }

    /**
    * @Route("/nuevo", name="autor_nuevo")
    */

    public function index(Request $request)
    {
      $autor = new Autor();
      $formu = $this->createForm(AutorType::class, $autor);
        //Para poder cogerlo despues
      $formu->handleRequest($request);
        //El isSubmitted() es enviar algo en este caso un formulario

      if ($formu->isSubmitted()){
        dump($autor);
            //Esta primera es la que llamas a la base de datos Doctrine//
            $em = $this->getDoctrine()->getManager();
            //Esta es para persistir los datos que persisten ahi//
            $em->persist($autor);
            //El flush es como un commit ¿ya esta todo? pues ahora si coge todos los dias//
            $em->flush();
            //Esto es para que cuando se creen personas en el formulario los mande a la lista
        
      }
        return $this->render('autor/nuevo.html.twig', [
            'formulario' => $formu->createView(),
        ]);
    }
}