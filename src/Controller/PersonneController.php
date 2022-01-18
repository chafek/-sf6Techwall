<?php

namespace App\Controller;

use DateTime;
use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use App\Repository\PersonneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/personne')]
class PersonneController extends AbstractController
{

  #[Route('/','list_personne')]
    public function index(ManagerRegistry $doctrine):Response{
     
      $repository=$doctrine->getRepository(Personne::class);
      $listPersonne=$repository->findAll();
      return $this->render('personne/index.html.twig',[
        'personnes'=>$listPersonne
      ]);
    }

    
    #[Route('/alls/age/{ageMin}/{ageMax}')]
    public function personByAge(ManagerRegistry $doctrine,$ageMin,$ageMax):Response{
      
      $repository=$doctrine->getRepository(Personne::class);
      $personne=$repository->findPersonByAgeInterval($ageMin,$ageMax);
      return $this->render('personne/index.html.twig',[
        'personnes'=>$personne
      ]);
    }
    #[Route('/alls/stat/{ageMin}/{ageMax}')]
    public function statPersonByAge(ManagerRegistry $doctrine,$ageMin,$ageMax):Response{
      
      $repository=$doctrine->getRepository(Personne::class);
      $stats=$repository->statPersonByAgeInterval($ageMin,$ageMax);
      // dd($personne);
      return $this->render('personne/stat.html.twig',[
        'stats'=>$stats,
        'ageMin'=>$ageMin,
        'ageMax'=>$ageMax
      ]);
    }
  #[Route('/alls/{page?1}/{nbre?12}','list_personne_alls')]
    public function indexAlls(ManagerRegistry $doctrine,$page,$nbre):Response{
     
      $repository=$doctrine->getRepository(Personne::class); 
      
      $nbrePersonnes=$repository->count([]);
      $nbrePages=ceil($nbrePersonnes/$nbre);
      
      $listPersonne=$repository->findby([],[],$nbre,($page-1)*$nbre);
      
      
      return $this->render('personne/index.html.twig',[
        'personnes'=>$listPersonne,
        'isPaginated'=>true,
        'nbrePages'=>$nbrePages,
        'page'=>$page,
        'nbre'=>$nbre
      ]);
    }


  #[Route('/{id<\d+>}','detail_personne')]
    public function detail(ManagerRegistry $doctrine,$id):Response{
     
      $repository=$doctrine->getRepository(Personne::class);
      $personne=$repository->find($id);
      if (!$personne) {
          $this->addFlash('error',"la personne avec l'id $id n'existe pas");
          return $this->redirectToRoute('list_personne');
      }
      
      return $this->render('personne/details.html.twig',[
        'personne'=>$personne
      ]);

    }

    #[Route('/add', name: 'add_personne')]
    public function addPersonne(SluggerInterface $slugger,Request $request,ManagerRegistry $doctrine): Response
    {
            $repository=$doctrine->getRepository(Personne::class);
              $page=ceil($repository->count([])/12);

              
            $entityManager=$doctrine->getManager();
            $personne=new Personne();
            $form=$this->createForm(PersonneType::class,$personne);
            $form->remove('created_at');
            $form->remove('update_at');
            $form->handleRequest($request);
            //est ce que le formulaire a été soumis?
              //si oui, on va ajouter l'objet Personne a la base de donnée
                //rediriger vers la liste des personnes
                //afficher un message de succes
              //sinon, on affiche le formulaire

              if ($form->isSubmitted() && $form->isValid()) {
                
                           /** @var UploadedFile $photo */
            $photo = $form->get('photo')->getData();
 
                           
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo ) {
              
                $originalFilename = pathinfo($photo ->getClientOriginalName(), PATHINFO_FILENAME);
                
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
                
                // Move the file to the directory where images are stored
                try {
                  $photo ->move(
                        $this->getParameter('personne_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $personne->setImage($newFilename);
              
            }
                $entityManager->persist($personne);
                $entityManager->flush();
                $this->addFlash('success',$personne->getFirstname() ." a bien été ajouté! ");
               return $this->redirectToRoute('list_personne_alls',[
                  'page'=>$page
               ]);
              }            

                return $this->render('personne/add-personne.html.twig',[
                  'form'=>$form->createView()
              ]);

              
       
    }

    #[Route('/edit/{id<\d+>?0}', name: 'edit_personne')]
    public function editPersonne(SluggerInterface $slugger, Request $request,ManagerRegistry $doctrine,$id): Response
    {
            $repository=$doctrine->getRepository(Personne::class);
            $personne=$repository->find($id);
            
              // $page=ceil($repository->count([])/12);
            $entityManager=$doctrine->getManager();
            // $personne=new Personne();
            $form=$this->createForm(PersonneType::class,$personne);
            $form->remove('created_at');
            $form->remove('update_at');
            $form->handleRequest($request);
            //est ce que le formulaire a été soumis?
              //si oui, on va ajouter l'objet Personne a la base de donnée
                //rediriger vers la liste des personnes
                //afficher un message de succes
              //sinon, on affiche le formulaire
          
              if ($form->isSubmitted() && $form->isValid()) {
                dd($personne);
                $photo = $form->get('photo')->getData();
                if ($photo ) {
              
                  $originalFilename = pathinfo($photo ->getClientOriginalName(), PATHINFO_FILENAME);
                  
                  // this is needed to safely include the file name as part of the URL
                  $safeFilename = $slugger->slug($originalFilename);
                  
                  $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
                  
                  // Move the file to the directory where images are stored
                  try {
                    $photo ->move(
                          $this->getParameter('personne_directory'),
                          $newFilename
                      );
                  } catch (FileException $e) {
                      // ... handle exception if something happens during file upload
                  }
  
                  // updates the 'brochureFilename' property to store the PDF file name
                  // instead of its contents
                  $personne->setImage($newFilename);
                
              }
                $personne->setImage($newFilename);
           
                $entityManager->persist($personne);
                $entityManager->flush();
                $this->addFlash('success',$personne->getFirstname() ." a bien été modifié! ");
               return $this->redirectToRoute('detail_personne',[
                  'id'=>$id
               ]);
              }            

                return $this->render('personne/add-personne.html.twig',[
                  'form'=>$form->createView()
              ]);

              
       
    }

    #[Route('/delete/{id<\d+>}','delete_personne')]
    public function delete(ManagerRegistry $doctrine,$id) {

        $repository=$doctrine->getRepository(Personne::class);
        $personne=$repository->find($id);
        if ($personne) {
            # code...
      
            $entityManager=$doctrine->getManager();
            
            $entityManager->remove($personne);
            $entityManager->flush();
            $name=$personne->getName();
            $this->addFlash('success', "$name a bien été supprimé!");
        }else{
            $this->addFlash('error', "cette personne n'existe pas");
        }
      
        return $this->redirectToRoute('list_personne_alls',[
          'personne'=>$personne
        ]);

    }

    #[Route('/update/{id<\d+>}/{name}/{firstName}/{age}','update_personne')]
    public function update(Personne $personne=null,$name,$firstName,$age,ManagerRegistry $doctrine,$id){
      $repository=$doctrine->getRepository(Personne::class);
      $personne=$repository->find($id);
    
      if($personne) {
        $entityManager=$doctrine->getManager();
        $personne->setName($name);
        $personne->setFirstname($firstName);
        $personne->setAge($age);
        $entityManager->persist($personne);
        $entityManager->flush();
        $this->addFlash('success','Modification réussie');
      }else{
        $this->addFlash('error','Personne introuvable!');
      }
      
      return $this->redirectToRoute('list_personne_alls');

        //si non, on affiche un message d'erreur

      //ON redirige vers la page personnes
      

    }
}
