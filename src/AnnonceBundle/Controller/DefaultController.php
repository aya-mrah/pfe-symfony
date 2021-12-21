<?php

namespace AnnonceBundle\Controller;

use AnnonceBundle\Entity\Trajet;
use AnnonceBundle\Entity\Signaler;
use AnnonceBundle\Entity\Coli;
use AppBundle\Entity\User;
use AppBundle\Entity\Vote;
use AnnonceBundle\Entity\Favoris;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/create",name="Create_Trajet_Route")
     */
    public function indexAction(request $request)
    {  

    $user  = new User();
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
    $notif=$notiRepo->findAll(); 

    $user  = new User();
    $Trajet = new Trajet();
    $m = $this->getDoctrine()->getManager();
    $favRepository = $m->getRepository('AnnonceBundle:Favoris');
    $fav =$favRepository->findAll();
    $comp = 0;
    foreach($fav as $f){
     $comp += 1;
       }
           $form = $this->createFormBuilder([])
           ->add('dateDebut', DateType::class,['label' => 'dateDebut','widget' => 'single_text', 'required' => true])
           ->add('dateFin', DateType::class,['label' => 'dateFin','widget' => 'single_text', 'required' => true])
           ->add('villeEtape', TextType::class,['label' => 'villeEtape', 'required' => true])
           ->add('paysDepart', TextType::class,['label' => 'paysDepart', 'required' => true])
            ->add('paysDestination', TextType::class,['label' => 'paysDestination', 'required' => true])
           ->add('titre', TextType::class,['label' => 'titre', 'required' => false])
           ->add('type',ChoiceType::class,array('choices'=>array('Envellope'=>'Envellope','Colis'=>'Colis','Autre'=>'Autre'),'attr'=>array('class'=>'form-control col-md-6','style'=>'margin-bottom:15px')))
           //->add('type', TextType::class,['label' => 'type', 'required' => false])
           //->add('mode', TextType::class,['label' => 'mode', 'required' => false])
           ->add('mode',ChoiceType::class,array('choices'=>array('Aérienne'=>'Aérienne','Routier'=>'Routier','Maritime'=>'Maritime','Autre'=>'Autre'),'attr'=>array('class'=>'form-control col-md-6','style'=>'margin-bottom:15px')))
           ->add('poidsAtransporter', TextType::class,['label' => 'poids', 'required' => false])
           ->add('prixKg', TextType::class,['label' => 'prixKg', 'required' => false])
           ->add('details', TextType::class,['label' => 'details', 'required' => false])
            //->add('save', SubmitType::class,['label' => 'Save data'])
           ->getForm();
           $user = $this->get('security.token_storage')->getToken()->getUser();
           $form->handleRequest($request);
            if ($form->isSubmitted() and $form->isValid()) {
                 $em = $this->getDoctrine()->getManager();
                // $Trajet->setDatePublication($form->get('datepublication')->getData());
                // $Trajet->setDatePublication(new \DateTime('now'));
                 $Trajet->setDateDebut($form->get('dateDebut')->getData());
                 if($form->get('dateDebut')->getData()->getTimestamp() < $form->get('dateFin')->getData()->getTimestamp()){
                 $Trajet->setDateFin($form->get('dateFin')->getData());                 
                 $Trajet->setVilleEtape($form->get('villeEtape')->getData());
                 $Trajet->setPaysDepart($form->get('paysDepart')->getData());
                  $Trajet->setPaysDestination($form->get('paysDestination')->getData());
                 $Trajet->setTitre($form->get('titre')->getData());
                 $Trajet->setType($form->get('type')->getData());
                 $Trajet->setMode($form->get('mode')->getData());
                 $Trajet->setPoidsAtransporter($form->get('poidsAtransporter')->getData());
                 $Trajet->setPrixKg($form->get('prixKg')->getData());
                 $Trajet->setDetails($form->get('details')->getData());
                 $Trajet->setIdannonceur($user);
                 $em->persist($Trajet);
                 $em->flush();
                   $this->addFlash('success', 'Trajet Ajouter avec succès!');
                 }
                elseif($form->get('dateDebut')->getData()->getTimestamp() > $form->get('dateFin')->getData()->getTimestamp()){
                  $this->addFlash('error', 'Date fin est < Date début');
                 }

                


            }

        
        return $this->render('AnnonceBundle:Default:index.html.twig', ["fav"=>$fav,"notif"=>$notif,"comp"=>$comp,'form' => $form->createView()]);
    }
    /**
     * @Route("/show" , name="affi")
     */
    public function showAction()
    {  $vote= new Vote();
       $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
       $notif=$notiRepo->findAll(); 
       $em = $this->getDoctrine()->getManager();
        $TraRepository = $em->getRepository('AnnonceBundle:Trajet');
        $Trajet =$TraRepository->findAll();
          $compteur = 0;
          foreach($Trajet as $Tra){
             $compteur += 1;
            }

        if(is_null($Trajet)){
            throw $this->createNotFoundException('aucun article trouvé ');
        } 
        $voterep= $em->getRepository('AppBundle:Vote');
        $vote =$voterep->findAll();
        $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
        $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            }

        return $this->render('AnnonceBundle:Default:show.html.twig',array("compteur"=>$compteur,"notif"=>$notif,"Trajet"=>$Trajet,"Tra"=>$Tra,"fav"=>$fav,"vote"=>$vote,"comp"=>$comp));       
    }
    
    /**
    * @Route("/mestrajet",name="mestrajet")
    */
    public function mesTrajetAction(){
       $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
       $notif=$notiRepo->findAll(); 
       $em = $this->getDoctrine()->getManager();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $mesRepository = $em->getRepository('AnnonceBundle:Trajet');
       $Trajet =$mesRepository->findby( array('idannonceur' => $user));

         $compteur = 0;
          foreach($Trajet as $Tra){
             $compteur += 1;
            }
        $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
        $voteRepository = $em->getRepository('AppBundle:Vote');
        $vote =$voteRepository->findAll();
        

      
          
        return $this->render('AnnonceBundle:Default:show.html.twig',array("compteur"=>$compteur,"notif"=>$notif,"Trajet"=>$Trajet,"Tra"=>$Tra, "fav"=>$fav, "vote"=>$vote));
       }

     /**
     * @Route("/supprimer{id}", name="supprimer")
     */
  
    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();
        $trajet = $em->getRepository('AnnonceBundle:Trajet')->find($id);
        $em->remove($trajet);
        $em->flush();
       return $this->redirect($this->generateUrl('affi'));
      
    }
     
    /**
     * @Route("/search",name="app_rech_route")
     */
    public function rechercherAction(request $request)
    {  $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
       $notif=$notiRepo->findAll(); 
      $em = $this->getDoctrine()->getManager();
       $rechRepository = $em->getRepository('AnnonceBundle:Trajet');
       $rech =$rechRepository->findAll();
       $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
         $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            } 
       if($request->isMethod('POST')) {
        $paysDepart=$request->get('paysDepart');
        $paysDestination=$request->get('paysDestination');
        $rech=$em->getRepository('AnnonceBundle:Trajet')->findby( array('paysDepart' => $paysDepart ,'paysDestination' => $paysDestination));
       }
      return $this->render('AnnonceBundle:Default:rech.html.twig',array("rech"=>$rech,"notif"=>$notif,"fav"=>$fav,"comp"=>$comp));

    }

    /**
     * @Route("/upd{id}", name="updat")

     */
    public function updatAction($id,Request $request)
    {  $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
       $notif=$notiRepo->findAll();
        $em = $this->getDoctrine()->getEntityManager();
        $Trajet = $em->getRepository('AnnonceBundle:Trajet')->find($id);
        $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
         $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            } 
        $form = $this->createFormBuilder($Trajet)
        ->add('dateDebut', DateType::class,['label' => 'dateDebut','widget' => 'single_text', 'required' => true])
           ->add('dateFin', DateType::class,['label' => 'dateFin','widget' => 'single_text', 'required' => true])
           ->add('villeEtape', TextType::class,['label' => 'villeEtape', 'required' => true])
           ->add('paysDepart', TextType::class,['label' => 'paysDepart', 'required' => true])
            ->add('paysDestination', TextType::class,['label' => 'paysDestination', 'required' => true])
           ->add('titre', TextType::class,['label' => 'titre', 'required' => false])
                      ->add('type',ChoiceType::class,array('choices'=>array('Envellope'=>'Envellope','Colis'=>'Colis','Autre'=>'Autre'),'attr'=>array('class'=>'form-control col-md-6','style'=>'margin-bottom:15px')))
           ->add('mode',ChoiceType::class,array('choices'=>array('Aérienne'=>'Aérienne','Routier'=>'Routier','Maritime'=>'Maritime','Autre'=>'Autre'),'attr'=>array('class'=>'form-control col-md-6','style'=>'margin-bottom:15px')))
           ->add('poidsAtransporter', TextType::class,['label' => 'poids', 'required' => false])
           ->add('prixKg', TextType::class,['label' => 'prixKg', 'required' => false])
           ->add('details', TextType::class,['label' => 'details', 'required' => false])
           ->getForm();
        $form->handleRequest($request);
        

        if(  $form->isValid() && $form->isSubmitted()){

               $Trajet->setDateDebut($form->get('dateDebut')->getData());
              if($form->get('dateDebut')->getData()->getTimestamp() < $form->get('dateFin')->getData()->getTimestamp()){
                 $Trajet->setDateFin($form->get('dateFin')->getData());
                 $Trajet->setVilleEtape($form->get('villeEtape')->getData());
                 $Trajet->setPaysDepart($form->get('paysDepart')->getData());
                 $Trajet->setPaysDestination($form->get('paysDestination')->getData());
                 $Trajet->setTitre($form->get('titre')->getData());
                 $Trajet->setType($form->get('type')->getData());
                 $Trajet->setMode($form->get('mode')->getData());
                 $Trajet->setPoidsAtransporter($form->get('poidsAtransporter')->getData());
                 $Trajet->setPrixKg($form->get('prixKg')->getData());
                 $Trajet->setDetails($form->get('details')->getData());
               $em->persist($Trajet);
               $em->flush();
                 $this->addFlash('success', 'Trajet Modifier avec succès!');
               }elseif($form->get('dateDebut')->getData()->getTimestamp() > $form->get('dateFin')->getData()->getTimestamp()){
                  $this->addFlash('error', 'Date fin est < Date début');
                 }
                

            return $this->render('AnnonceBundle:Default:upd.html.twig',array("comp"=>$comp,"notif"=>$notif,"fav"=>$fav,
            'form' => $form->createView()
        ));
                  }
                   
            return $this->render('AnnonceBundle:Default:upd.html.twig',array("comp"=>$comp,"notif"=>$notif,"fav"=>$fav,
            'form' => $form->createView()
        ));
       


        
  
    }
    /**
    *@Route("/recherche",name="rech_trajet")
    */
    public function rechAction(request $request){
       $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
       $notif=$notiRepo->findAll();
       $em = $this->getDoctrine()->getManager();
       $rechRepository = $em->getRepository('AnnonceBundle:Trajet');
       $Trajet =$rechRepository->findAll(); 
         $compteur = 0;
          foreach($Trajet as $Tra){
             $compteur += 1;
            }
        $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
        $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            }    
       if($request->isMethod('POST')) {
        $paysDepart=$request->get('paysDepart');
        $paysDestination=$request->get('paysDestination');
        $Trajet=$em->getRepository('AnnonceBundle:Trajet')->findby( array('paysDepart' => $paysDepart ,'paysDestination' => $paysDestination));
       }
      
          
        return $this->render('AnnonceBundle:Default:show.html.twig',array("compteur"=>$compteur,"notif"=>$notif,"Trajet"=>$Trajet,"Tra"=>$Tra,"comp"=>$comp,"fav"=>$fav));
       }

    //------------favoriser--------------------------------------
    // ---------------------Ajouter à la liste de favoris ---------------------------------   
    /**
     * @Route("/favt{id}", name="favt")
     */

    public function favAction($id){

     $user = new User();    
     $trajet =new Trajet();
     $coli = new Coli();
     $fav = new Favoris();
     $em = $this->getDoctrine()->getManager();
     $user = $this->get('security.token_storage')->getToken()->getUser();
     $trajet = $em->getRepository('AnnonceBundle:Trajet')->find($id);
     $fav->setIdannonceur($user);
     $fav->setIdtrajet($trajet);
     $em->persist($fav);
     $em->flush();
     
     return $this->redirect($this->generateUrl('affi'));
      
    }
    //----------------------Supprimer de la liste favoris-------------------
    /**
     * @Route("/supFav{id}/{page}", name="supfav")
     */
  
    public function supFavAction($id,$page){

        $em = $this->getDoctrine()->getManager();
        $fav = $em->getRepository('AnnonceBundle:Favoris')->find($id);
        $em->remove($fav);
        $em->flush();

        if($page == 2 ){
          return $this->redirect($this->generateUrl('showTraFav'));
         }
         else
         {
          return $this->redirect($this->generateUrl('affi'));
         }
      
    }
    //---------------------Liste favoris----------------------------
    /**
     * @Route("/showTraFav/", name="showTraFav")
     */
  
    public function showTraFavAction(){
      $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
       $notif=$notiRepo->findAll();
     $user = new User();    
     $trajet =new Trajet();
     $fav = new Favoris();
     $vote =new Vote();
      $m = $this->getDoctrine()->getManager();
      $vote=$m->getRepository('AppBundle:Vote')->findAll();
     $user = $this->get('security.token_storage')->getToken()->getUser();
     $em = $this->getDoctrine()->getManager();
     $fav=$em->getRepository('AnnonceBundle:Favoris')->findby( array('idannonceur' => $user));

    return $this->render('AnnonceBundle:Default:listeTraFav.html.twig',array("fav"=>$fav,"vote"=>$vote,"notif"=>$notif));
      
    }
  /**
     * @Route("/signaler/Trajet{id}",name="signalerTarjet")
     */
    public function signalerTrajetAction(request $request,$id)
    {
      $user = new User();  
      $sig = new Signaler();   
      $trajet =new Trajet();
      $em = $this->getDoctrine()->getManager();
      $sigRepository = $em->getRepository('AnnonceBundle:Signaler');
      $user = $this->get('security.token_storage')->getToken()->getUser();
      $trajet = $em->getRepository('AnnonceBundle:Trajet')->find($id);
       if($request->isMethod('POST')) {
        $raison=$request->get('raison');
         $sig->setIdannonceur($user);
         $sig->setIdtrajet($trajet);
         $sig->setRaison($raison);
         $em->persist($sig);
         $em->flush();

      }
  
       return $this->redirect($this->generateUrl('affi'));
    }
    /**
     * @Route("/Trajet{id}" , name="voteTarjet")
     */
    public function voterTrajetAction(request $request,$id)
    {
       $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
       $notif=$notiRepo->findAll();
        $em = $this->getDoctrine()->getEntityManager();
        $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
         $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            }   
     $trajet =new Trajet();
        $em = $this->getDoctrine()->getManager();
         $Tra = $em->getRepository('AnnonceBundle:Trajet')->find($id);
       
      
  
      return $this->render('AnnonceBundle:Default:vote.html.twig',array("fav"=>$fav,"notif"=>$notif,"Tra"=>$Tra));

    }
    /**
    * @Route("/test",name="test")
    */
    public function testAction()
    {
      return $this->render('AnnonceBundle:Default:test.html.twig');
    }
}
