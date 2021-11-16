<?php

namespace App\Controller;

use App\Entity\Marcador;
use App\Form\MarcadorType;
use App\Repository\MarcadorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etiqueta;
use App\Form\EtiquetaType;
/**
 * @Route("/marcador")
 */
class MarcadorController extends AbstractController
{
    

    /**
     * @Route("/new", name="marcador_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $marcador = new Marcador();
        $form = $this->createForm(MarcadorType::class, $marcador);
        $form->handleRequest($request);
        
        $etiquetum = new Etiqueta();
            $formEtiqueta = $this->createForm(EtiquetaType::class, $etiquetum,
                ['action'=>$this->generateUrl('nueva_etiqueta_ajax')]
                                
         );
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marcador);
            $entityManager->flush();

            $this->addFlash("success", "Marcador creado correctamente");
            
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marcador/new.html.twig', [
            'marcador' => $marcador,
            'form' => $form,
            'form_etiqueta'=>$formEtiqueta
        ]);
    }

    

    /**
     * @Route("/{id}/edit", name="marcador_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Marcador $marcador): Response
    {
        $form = $this->createForm(MarcadorType::class, $marcador);
        $form->handleRequest($request);

        $etiquetum = new Etiqueta();
            $formEtiqueta = $this->createForm(EtiquetaType::class, $etiquetum,[
                'action'=>$this->generateUrl('nueva_etiqueta_ajax')
                                
         ]);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Marcador editado correctamente");
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marcador/edit.html.twig', [
            'marcador' => $marcador,
            'form' => $form,
            'form_etiqueta'=> $formEtiqueta
        ]);
    }

    /**
     * @Route("/{id}", name="marcador_delete", methods={"POST"})
     */
    public function delete(Request $request, Marcador $marcador): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marcador->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marcador);
            $entityManager->flush();
            $this->addFlash("success", "Marcador borrado correctamente");
        }

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
