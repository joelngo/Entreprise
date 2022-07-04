<?php

namespace App\Controller;




use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController

{
    /**

     * @Route("/ajouter-un-employe.html", name="employe_create", methods={"GET|POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response

    {   
        #variabilisation d'un nouvel de type Employe
        $employe =new Employe();


        $form =$this->createForm(EmployeFormType::class, $employe);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            #dump($employe);
            
            #dd($form);
            //$form->get('salary')->getData();
            $entityManager->persist($employe);
            $entityManager->flush();

            return $this->redirectToRoute('default_home');
        
        }   return $this->render("form/employe.html.twig",[
            "form_employe" => $form->createView()

        ]);

        
        

    } # end fucntion create() 
    
          
           /**
            * @Route("/modifier-un-employe-{id}", name="employe_update", methods={"GET|POST"})
            */
        public function update(Employe $employe, Request $request, EntityManagerInterface $entityManager): Response
       { 
            
            $form = $this->createForm(EmployeFormType::class,$employe)
                 ->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                 $entityManager->persist($employe);
                 $entityManager->flush();

                 return $this->redirectToRoute('default_home');

             } // end if()

          return $this->render("form/employe.html.twig", [
                "employe" => $employe,
                "form_employe" => $form->createView()
          ]);

        }  # end function update

    


                /**
                 * @Route("/supprimer-un-employe-{id}",name="employe_delete", methods={"GET"})
                 */
            public function delete(Employe $employe, EntityManagerInterface $entityManager): RedirectResponse
         {
        
                $entityManager->remove($employe);
                $entityManager->flush();
         
            return $this->redirectToRoute('default_home');
           
     
        
    } #end function delete()
}# end class
    




    