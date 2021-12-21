<?php

namespace AnnonceBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Entity\Adminpay;
use AnnonceBundle\Entity\Favoris;
use AnnonceBundle\Entity\Trajet;
use Mgilet\NotificationBundle\Entity\NotifiableNotification;
use AnnonceBundle\Entity\Signaler;
use AnnonceBundle\Entity\Coli;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;

class ColisController extends Controller
{   // create coli
    /**
     * @Route("/colis", name="affichage")
     */
    public function indexAction(Request $request)
    {
    $user  = new User();
    $user = $this->get('security.token_storage')->getToken()->getUser();
        $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
         $notif=$notiRepo->findAll(); 
    $coli =new Coli();
    $m = $this->getDoctrine()->getManager();
       $favRepository = $m->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
        $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            }
    $coli->setEtat('encours');
    $random = $this->randomString(8);
    $coli->setCodeLivraison($random);
    $form = $this->createFormBuilder($coli)
          
                    ->add('dateDebut', DateType::class,['label' => 'dateDebut','widget' => 'single_text', 'required' => true])
                    ->add('dateFin', DateType::class,['label' => 'dateFin','widget' => 'single_text', 'required' => true])
                    ->add('paysDepart', TextType::class,['label' => 'paysDepart', 'required' => true])
                    ->add('paysDestination', TextType::class,['label' => 'paysDestination', 'required' => true])
                    ->add('nomreceiver', TextType::class,['label' => 'nomreceiver', 'required' => true])
                    ->add('prenomreceiver', TextType::class,['label' => 'prenomreceiver', 'required' => true])
                    ->add('cinreceiver', TextType::class,['label' => 'cinreceiver', 'required' => true])

                    ->add('emailreceiver', TextType::class,['label' => 'emailreceiver', 'required' => false])
                    ->add('telreceiver', TextType::class,['label' => 'telreceiver', 'required' => true])
                    ->add('titre', TextType::class,['label' => 'titre', 'required' => true])
                    ->add('dimensionColi',ChoiceType::class,array('choices'=>array('Petit'=>'Petit','Moyen'=>'Moyen','Grand'=>'Grand','Trés Grand'=>'Trés Grand'),'attr'=>array('class'=>'form-control col-md-6','style'=>'margin-bottom:15px')))
                    ->add('poidsColis', TextType::class,['label' => 'poidsColis', 'required' => false])

                     ->add('prixColis', TextType::class,['label' => 'prixColis', 'required' => false])
                     ->add('description', TextType::class,['label' => 'description', 'required' => false])
                     ->add('path', FileType::class,['label' => 'path', 'required' => false])

                     ->add('type',ChoiceType::class,array('choices'=>array('Envellope'=>'Envellope','Colis'=>'Colis','Autre'=>'Autre'),'attr'=>array('class'=>'form-control col-md-6','style'=>'margin-bottom:15px')))
                    
                     ->getForm();
                   $user = $this->get('security.token_storage')->getToken()->getUser();
                   $form->handleRequest($request);
                       if ($form->isSubmitted() && $form->isValid()) {
                        $coli->setDateDebut($form['dateDebut']->getData());
                        if($form->get('dateDebut')->getData()->getTimestamp() < $form->get('dateFin')->getData()->getTimestamp()){
                        $coli->setDateFin($form['dateFin']->getData());
                        $coli->setPaysDepart($form['paysDepart']->getData());
                        $coli->setPaysDestination($form['paysDestination']->getData());
                        $coli->setType($form['type']->getData());
                        $coli->setNomReceiver($form['nomreceiver']->getData());
                        $coli->setPrenomReceiver($form['prenomreceiver']->getData());
                        $coli->setCinReceiver($form['cinreceiver']->getData());
                        $coli->setEmailReceiver($form['emailreceiver']->getData());
                        $coli->setTelReceiver($form['telreceiver']->getData());
                        $coli->setTitre($form['titre']->getData());
                        $coli->setDimensionColi($form['dimensionColi']->getData());
                        $coli->setPoidsColis($form['poidsColis']->getData());
                        $coli->setPrixColis($form['prixColis']->getData());
                        $coli->setIdannonceur($user);
                        $em = $this->getDoctrine()->getEntityManager();
                        $file = $form->get('path')->getData();
                        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                          
                        try {
                          $file->move(
                              $this->getParameter('images_directory'),
                              $fileName);
                            } 
                        catch (FileException $e) {
                  
                            }
                        $coli->setPath($fileName);

                        $em->persist($coli);
                        $em->flush();
                         $this->addFlash('success', 'Coli créer avec succès!');
                    }elseif($form->get('dateDebut')->getData()->getTimestamp() > $form->get('dateFin')->getData()->getTimestamp()){
   
          $this->addFlash('error', 'Date fin est < Date début');
           }
                    
            return $this->render('AnnonceBundle:colis:coli-create.html.twig',array("fav"=>$fav,"notif"=> $notif,"comp"=>$comp,
            'form'=>$form->createview()));
                     }
                   // $this->addFlash('error', 'verifier les donnés saisi!');

            return $this->render('AnnonceBundle:colis:coli-create.html.twig',array("fav"=>$fav,"notif"=> $notif,"comp"=>$comp,
            'form'=>$form->createview()));
    }
    /**
     * @Route("/affichcolis" , name="hagep")
     */
    public function affichAction()
    {
      $em = $this->getDoctrine()->getManager();
      $col = $em->getRepository('AnnonceBundle:Coli')->findAll();
      $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
        $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
         $notif=$notiRepo->findAll(); 
      return $this->render('AnnonceBundle:colis:affichage-colis.html.twig',array('col' =>$col,"notif"=> $notif,'fav'=>$fav,'comp'=>$comp));
 
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
     * @Route("/donner{id}" , name="donner")
     */
    public function infocolisAction(request $request,$id)
    {
      $em = $this->getDoctrine()->getManager();
      $col = $em->getRepository('AnnonceBundle:Coli')->findby(array('id' =>$id));
      $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
        $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
         $notif=$notiRepo->findALL(); 
      return $this->render('AnnonceBundle:colis:info-colis.html.twig',array('col' =>$col,"notif"=> $notif,'fav'=>$fav,'comp'=>$comp));
 
    }
 private function randomString($length)
    {
        $possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnoprstuvwz}]{[":<>?/0123456789';
        $string = "";
        for($i=0;$i<$length;$i++)
        {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            $string .= $char;
        }
 
        return $string;
    }

    /**
     * @Route("/delete{id}", name="deletecoli")
      */
  
    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();
        $col= $em->getRepository('AnnonceBundle:Coli')->find($id);
        $em->remove($col);
        $em->flush();
       return $this->redirect($this->generateUrl('hagep'));
      
    }

    /**
     * @Route("/update{id}", name="updatecoli")

     */
    public function updateAction($id,Request $request)
    {
        $user  = new User();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
         $notif=$notiRepo->findAll();  
        $em = $this->getDoctrine()->getEntityManager();
         $coli= $em->getRepository('AnnonceBundle:Coli')->find($id);
          $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
         $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            } 
        $form = $this->createFormBuilder($coli)
                    ->add('dateDebut', DateType::class,['label' => 'dateDebut','widget' => 'single_text', 'required' => true])

                    ->add('dateFin', DateType::class,['label' => 'dateFin','widget' => 'single_text', 'required' => true])
                    ->add('paysDepart', TextType::class,['label' => 'paysDepart', 'required' => true])
                    ->add('paysDestination', TextType::class,['label' => 'paysDestination', 'required' => true])
                    ->add('nomreceiver', TextType::class,['label' => 'nomreceiver', 'required' => true])
                    ->add('prenomreceiver', TextType::class,['label' => 'prenomreceiver', 'required' => true])
                    ->add('cinreceiver', TextType::class,['label' => 'cinreceiver', 'required' => true])

                    ->add('emailreceiver', TextType::class,['label' => 'emailreceiver', 'required' => false])
                    ->add('telreceiver', TextType::class,['label' => 'telreceiver', 'required' => true])
                    ->add('titre', TextType::class,['label' => 'titre', 'required' => true])
                    ->add('dimensionColi',ChoiceType::class,array('choices'=>array('Petit'=>'Petit','Moyen'=>'Moyen','Grand'=>'Grand','Trés Grand'=>'Trés Grand'),'attr'=>array('class'=>'form-control col-md-6','style'=>'margin-bottom:15px')))
                    ->add('poidsColis', TextType::class,['label' => 'poidsColis', 'required' => false])

                    ->add('prixColis', TextType::class,['label' => 'prixColis', 'required' => false])
                    ->add('description', TextType::class,['label' => 'description', 'required' => false])
                    ->add('etat', TextType::class,array('label' => 'codelivraison','disabled' => 'true'))
                    ->add('path', FileType::class,['label' => 'path', 'required' => false,'data_class' => null,])
                    ->add('codelivraison', TextType::class, array('label' => 'codelivraison','disabled' => 'true'))

                    ->add('type',ChoiceType::class,array('choices'=>array('Envellope'=>'Envellope','Colis'=>'Colis','Autre'=>'Autre'),'attr'=>array('class'=>'form-control col-md-6','style'=>'margin-bottom:15px')))
                    ->getForm();
                 $form->handleRequest($request);
                 if($form->isSubmitted() ){
                    if($form->get('dateDebut')->getData()->getTimestamp() < $form->get('dateFin')->getData()->getTimestamp()){
                    if( $form->isValid()){
            
                        $coli->setDateDebut($form['dateDebut']->getData());
                        
                          
                        $coli->setDateFin($form['dateFin']->getData());
                        $coli->setPaysDepart($form['paysDepart']->getData());
                        $coli->setPaysDestination($form['paysDestination']->getData());
                        $coli->setType($form['type']->getData());
                        $coli->setNomReceiver($form['nomreceiver']->getData());
                        $coli->setPrenomReceiver($form['prenomreceiver']->getData());
                        $coli->setCinReceiver($form['cinreceiver']->getData());
                        $coli->setEmailReceiver($form['emailreceiver']->getData());
                        $coli->setTelReceiver($form['telreceiver']->getData());
                        $coli->setTitre($form['titre']->getData());
                        $coli->setDimensionColi($form['dimensionColi']->getData());
                        $coli->setPoidsColis($form['poidsColis']->getData());
                        $coli->setPrixColis($form['prixColis']->getData());
                        $coli->setEtat($form['etat']->getData());
                        $coli->setCodeLivraison($form['codelivraison']->getData());
                         $em = $this->getDoctrine()->getEntityManager();
                        }
                        $file = $form->get('path')->getData();
                          if(isset($file)){

                        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                        try {
                          $file->move(
                              $this->getParameter('images_directory'),
                              $fileName);
                            } 
                        catch (FileException $e) {
                  
                            }
                        $coli->setPath($fileName);
                         $em->persist($coli);
                       $em->flush();}
                      $this->addFlash('success', 'Colis Modifier avec succès!');
               }elseif($form->get('dateDebut')->getData()->getTimestamp() > $form->get('dateFin')->getData()->getTimestamp()){
                  $this->addFlash('error', 'Date fin est < Date début');
                 }
            
                
        return $this->render('AnnonceBundle:colis:update.html.twig',array("comp"=>$comp,"notif"=>$notif,"fav"=>$fav,
            'form' => $form->createView()
        )); 
        }
             // $this->addFlash('error', 'verifier les donnés saisi!'); 
        return $this->render('AnnonceBundle:colis:update.html.twig',array("comp"=>$comp,"notif"=>$notif,"fav"=>$fav,
            'form' => $form->createView()
        ));
    }
          
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }  
    /**
    * @Route("/rech_col",name="coli_rech")
    */
    public function colnAction(request $request){
       $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
       $notif=$notiRepo->findAll(); 
       $em = $this->getDoctrine()->getManager();
       $recRepository = $em->getRepository('AnnonceBundle:Coli');
       $col =$recRepository->findAll(); 

       if($request->isMethod('POST')) {
        $paysDep=$request->get('pointdept');
        $paysDes=$request->get('pointarrivee');

        $col=$em->getRepository('AnnonceBundle:Coli')->findby( array('paysDepart' => $paysDep ,'paysDestination' => $paysDes));
         }
      
          
        return $this->render('AnnonceBundle:colis:affichage-colis.html.twig',array("col"=>$col,"notif"=>$notif));
       }

    /**
    * @Route("/rech_col",name="coli_rech")
    */
    public function colAction(request $request){
       $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
        $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
         $notif=$notiRepo->findAll(); 
       $em = $this->getDoctrine()->getManager();
       $recRepository = $em->getRepository('AnnonceBundle:Coli');
       $col =$recRepository->findAll(); 
       $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
         $comp = 0;
          foreach($fav as $f){
             $comp += 1;
            }
       if($request->isMethod('POST')) {
        $paysDep=$request->get('pointdept');
        $paysDes=$request->get('pointarrivee');

        $col=$em->getRepository('AnnonceBundle:Coli')->findby( array('paysDepart' => $paysDep ,'paysDestination' => $paysDes));
         }
      
          
        return $this->render('AnnonceBundle:colis:affichage-colis.html.twig',array("col"=>$col,"notif"=>$notif,"fav"=>$fav,"comp"=>$comp));
       } 
    // -----------------Favoris coli           -----------------------    
    /**
     * @Route("/favt/coli{id}", name="favtcoli")
     */

    public function favColiAction($id){

     $user = new User();    
     $trajet =new Trajet();
     $coli = new Coli();
     $fav = new Favoris();
     $em = $this->getDoctrine()->getManager();
     $user = $this->get('security.token_storage')->getToken()->getUser();
     $coli = $em->getRepository('AnnonceBundle:Coli')->find($id);
     $fav->setIdannonceur($user);
     $fav->setIdcoli($coli);
     $em->persist($fav);
     $em->flush();
     
     return $this->redirect($this->generateUrl('hagep'));
      
    }

    /**
     * @Route("/supFavcoli{id}/{page}", name="supfavcoli")
     */
  
    public function supFavAction($id,$page){

        $em = $this->getDoctrine()->getManager();
        $fav = $em->getRepository('AnnonceBundle:Favoris')->find($id);
        $em->remove($fav);
        $em->flush();
         if($page == 1 ){
          return $this->redirect($this->generateUrl('affcolfav'));
         }
         else
         {
          return $this->redirect($this->generateUrl('hagep'));
         }
    }
    //------------------------Liste favoris colis---------------------------
    /**
     * @Route("/affcolfav" , name="affcolfav")
     */
    public function affiColFavAction()
    { 
     $user  = new User();
     $user = $this->get('security.token_storage')->getToken()->getUser();
     $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
     $notif=$notiRepo->findAll(); 
     $user = new User();    
     $trajet =new Trajet();
     $fav = new Favoris();
     $user = $this->get('security.token_storage')->getToken()->getUser();
     $em = $this->getDoctrine()->getManager();
     $fav=$em->getRepository('AnnonceBundle:Favoris')->findby( array('idannonceur' => $user));

    return $this->render('AnnonceBundle:colis:listColFav.html.twig',array('fav'=>$fav,"notif"=>$notif));
 
    }
      /**
    * @Route("/mescolis",name="mescolis")
    */
    public function mesColiisAction(){
       $user  = new User();
       $user = $this->get('security.token_storage')->getToken()->getUser();
        $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
         $notif=$notiRepo->findAll(); 
       $em = $this->getDoctrine()->getManager();
       $user = $this->get('security.token_storage')->getToken()->getUser();
       $mesRepository = $em->getRepository('AnnonceBundle:Coli');
       $col =$mesRepository->findby( array('idannonceur' => $user));
 

        $favRepository = $em->getRepository('AnnonceBundle:Favoris');
        $fav =$favRepository->findAll();
        $voteRepository = $em->getRepository('AppBundle:Vote');
        $vote =$voteRepository->findAll();
        
       return $this->render('AnnonceBundle:Colis:affichage-colis.html.twig',array("col"=>$col,"notif"=>$notif, "fav"=>$fav,'vote'=>$vote));
       }
    // --------------------Signaler coli-----------------   
    /**
     * @Route("/signaler/Coli{id}",name="signalerColi")
     */
    public function signalerColiAction(request $request,$id)
    {
      $user = new User();  
      $sig = new Signaler();   
      $coli =new Coli();
      $em = $this->getDoctrine()->getManager();
      $sigRepository = $em->getRepository('AnnonceBundle:Signaler');
      $user = $this->get('security.token_storage')->getToken()->getUser();
      $coli = $em->getRepository('AnnonceBundle:Coli')->find($id);
       if($request->isMethod('POST')) {
        $raison=$request->get('raison');
         $sig->setIdannonceur($user);
         $sig->setIdcoli($coli);
         $sig->setRaison($raison);
         $em->persist($sig);
         $em->flush();


      }
  
       return $this->redirect($this->generateUrl('hagep'));

    }
    //-------------------------Verifier code colis---------------------

  
    /**
    * @Route("/transporteur", name="transporteur")
    *
    */
    public function aTransporterAction()
    {
     $em = $this->getDoctrine()->getManager();
     $user = $this->get('security.token_storage')->getToken()->getUser();
     $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
     $notif = $notiRepo->findAll();  
     $noti = $notiRepo->findby(array('idSrc' => $user ,'idtrajet'=> null));  
     $col = $em->getRepository('AnnonceBundle:Coli')->findAll();
     $nb_col=0;
     foreach ($col as $c) {
        $nb_col +=1;
     }
     $favRepository = $em->getRepository('AnnonceBundle:Favoris');
     $fav =$favRepository->findAll();
        
    return $this->render('AnnonceBundle:colis:transp.html.twig',array('notif' => $notif,'col'=>$col,'fav'=>$fav,'nb_col'=>$nb_col,'noti'=>$noti));
    }
    
     /**
     * @Route("/codecolis/Coli{id}/{idd}" , name="CodeColi")
     */
     public function verifiercodeColiAction(Request $request ,$id,$idd)
    {
    
     $em = $this->getDoctrine()->getManager();
     if($request->isMethod('POST')) {
      $codelivraison=$request->get('codelivraison');
      $co=$em->getRepository('AnnonceBundle:Coli')->findby( array('codelivraison'=>$codelivraison));
    
     if(!empty($co)){
    $col = $em->getRepository('AnnonceBundle:Coli')->find($id);
    $col->setEtat('Colis Arriver');
    $em->flush();
    $this->addFlash('success', 'Code Colis Entrer avec succès!');
    $this->setArrNotification($id,$idd);
    $this->setArrpaiementNotification($id);
      }

   else{
    $this->addFlash('error', 'Code Colis Entrer non valide !!'); 
     }}
  
      return $this->redirect($this->generateUrl('transporteur'));
    }
    
    public function setArrNotification($id,$idd)
    {  
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userRepository = $em->getRepository('AppBundle:User');
        $usersrc=$userRepository->find($idd); 
        $col = $em->getRepository('AnnonceBundle:Coli')->find($id);
        $manager = $this->get('mgilet.notification');
        $noRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
        $no = $noRepo->findby(array('idcoli' =>$id,'idSrc'=>$user,'subject'=>'system')); 
        if ($no == null){
        $notif = $manager->createNotification('system');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        $notif->setIdDes($usersrc);
        $notif->setIdSrc($user);
        $notif->setIsdeleted('0');
        $notif->setIdcoli($col);
        $manager->addNotification(array($this->getUser()), $notif, true);
         $this->addFlash('succes3', 'Code bien confirmer'); 
        }
       
        else{
            $this->addFlash('error3', 'Colis Déja Profite !!'); 
        }
        return $this->redirectToRoute('transporteur'); 
        }
         public function setArrpaiementNotification($id)
       {  
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $col = $em->getRepository('AnnonceBundle:Coli')->find($id);
        $manager = $this->get('mgilet.notification');
        $noRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
        $no = $noRepo->findby(array('idcoli' =>$id,'idDes'=>$user,'idSrc'=>'idDes','subject'=>'system')); 
        if ($no == null){
        $notif = $manager->createNotification('paiement');
        $notif->setMessage('Entrer le mail Paypal');
        $notif->setLink('http://symfony.com/');
        $notif->setIdDes($user);
        $notif->setIdSrc($user);
        $notif->setIsdeleted('0');
        $notif->setIdcoli($col);
        $manager->addNotification(array($this->getUser()), $notif, true);
         $this->addFlash('succes3', 'Code bien confirmer'); 
        }
        else{
            $this->addFlash('error3', 'Colis Déja Profite !!'); 
        }
        return $this->redirectToRoute('transporteur'); 
        }

     /**
     * @Route("paypalmail/{id}/{idd}", name="paypalmail")
     * 
     */
    public function pAction($id ,$idd){ 

    $em = $this->getDoctrine()->getManager();
    $FavRepository = $em->getRepository('AnnonceBundle:Favoris');
    $fav=$FavRepository->findAll();  
    $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
    $noti = $notiRepo->find($id);
      $notif=$notiRepo->findAll(); 

    return $this->render('AnnonceBundle:colis:mail.html.twig',array("idd"=>$idd ,"notif"=> $notif,"noti"=> $noti, "fav"=>$fav ,"id"=>$id ));
     }

    /**
     * @Route("/mailpayy/{id}" , name="mailpayy")
    */
    public function setmailpaypalNotification(request $request ,$id)
       {  
        $pay = new Adminpay();
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $manager = $this->get('mgilet.notification');
        $noti = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification')->find($id);
         if($request->isMethod('POST')) {
             $mail=$request->get('mailpay');
              $pay->setMail($mail);
              $pay->setIduser($user);
              $pay->setIdcoli($noti->getIdcoli());
            $em->persist($pay);
            $em->flush();
             }
            $this->deleteNotification($id);
         return $this->redirect($this->generateUrl('homepage'));
        }

        public function deleteNotification($id)
        {
         $em = $this->getDoctrine()->getManager();
         $noti = $em->getRepository('MgiletNotificationBundle:Notification')->find($id);
         $em->remove($noti);
         $not = $em->getRepository('MgiletNotificationBundle:NotifiableNotification')->find($id);
         $em->remove($not);
         $not->setSeen(true);
         $this->getDoctrine()->getManager()->flush();
         return $this->redirectToRoute('homepage' );
        }
}