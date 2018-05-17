<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Libro;

use App\Form\LibroType;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
* @Route("/libro")
*/
class LibroController extends Controller
{
    /**

     * @Route("/lista", name="libro_lista")

     */

    public function listado()
    {
    	//Conseguir desde la base de datos
        $repo = $this->getDoctrine()->getRepository(Libro::class);
        // El findAll() es para que coga todos los datos. Esa linea donde pone el findAll() es la conexion a la base de datos//
        $vectorlibros = $repo->findAll();
        dump ($vectorlibros);
        return $this->render('libro/index.html.twig', [
        'vectorlibros' => $vectorlibros,
        ]);
    }

	/**

     * @Route("/nuevo", name="libro_nuevo")

     */
    public function index(Request $request)
    {
    	$libro = new Libro();
    	$formu = $this->createForm(LibroType::class, $libro);
        //Para poder cogerlo despues
    	$formu->handleRequest($request);
        //El isSubmitted() es enviar algo en este caso un formulario
    	if ($formu->isSubmitted()){
    		dump($libro);
            //Esta primera es la que llamas a la base de datos Doctrine//
            $em = $this->getDoctrine()->getManager();
            //Esta es para persistir los datos que persisten ahi//
            $em->persist($libro);
            //El flush es como un commit ¿ya esta todo? pues ahora si coge todos los dias//
            $em->flush();
            //Esto es para que cuando se creen personas en el formulario los mande a la lista
    	   return $this->redirectToRoute('libro_lista');
    	}

        return $this->render('libro/nuevo.html.twig', [
            'formulario' => $formu->createView(),
        ]);
    }
}
