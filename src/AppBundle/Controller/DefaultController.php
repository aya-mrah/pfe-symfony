<?php
namespace AppBundle\Controller;
use AnnonceBundle\Entity\Trajet;
use AnnonceBundle\Entity\Coli;
use AppBundle\Entity\User;
use AppBundle\Entity\Vote;
use AnnonceBundle\Entity\Favoris;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Mgilet\NotificationBundle\Entity\Notification;
use Mgilet\NotificationBundle\Entity\NotifiableNotification;
use Mgilet\NotificationBundle\NotifiableInterface;
use App\Entity\Transaction;
use Beelab\PaypalBundle\Paypal\Exception;
use Beelab\PaypalBundle\Paypal\Service;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Cookie;  
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
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
         $me = $this->getDoctrine()->getManager();
         $col = $me->getRepository('AnnonceBundle:Coli')->findAll();

         $m = $this->getDoctrine()->getManager();
         $rechRepository = $m->getRepository('AnnonceBundle:Trajet');
         $rech=$rechRepository->findAll(); 
         $e = $this->getDoctrine()->getManager();
         $voterep = $e->getRepository('AppBundle:Vote');
         $vote=$voterep->findAll(); 
         if($request->isMethod('POST')) {
        $paysDepart=$request->get('paysDepart');
        $paysDestination=$request->get('paysDestination');
        $rech=$m->getRepository('AnnonceBundle:Trajet')->findby( array('paysDepart' => $paysDepart,'paysDestination' => $paysDestination));
          return $this->redirectToRoute("app_rech_route");
          }

         $f = $this->getDoctrine()->getManager();
         $FavRepository = $f->getRepository('AnnonceBundle:Favoris');
         $fav=$FavRepository->findAll(); 
      
        $user = new User();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
          $notif = $notiRepo->findby(array('idDes' => $user), array('id'=>'DESC'));
          //------------------------------//
         if (empty($Tra)){$Tra=null;}
        return $this->render('AnnonceBundle:Default:Home.html.twig',array("compteur"=>$compteur,"Trajet"=>$Trajet,"Tra"=>$Tra,"col"=>$col,"rech"=>$rech,"notif"=> $notif,"fav"=>$fav,"Vote"=>$vote));
        // replace this example code with whatever you need
       /* return $this->render('AnnonceBundle:Default:index2.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);*/
    }
    
    
     
   
    /**
     * @Route("/send-notification{id}/{idd}/{type}", name="send_notification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendNotification(Request $request,$id,$idd,$type)
    {  
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $u = $this->getDoctrine()->getManager();
        $userRepository = $u->getRepository('AppBundle:User');
        $col = $em->getRepository('AnnonceBundle:Coli')->find($idd);
        $trajet = $em->getRepository('AnnonceBundle:Trajet')->find($idd);
        $usersrc=$userRepository->find($id);         
        $manager = $this->get('mgilet.notification');
        //test de existance
        $noRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
        $no = $noRepo->findby(array('idcoli' =>$idd)); 
        if ($no == null){
        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        $notif->setIdDes($usersrc);
        $notif->setIdSrc($user);
        $notif->setIsdeleted('0');
        if($type == 1)
        {
         $notif->setIdtrajet($trajet);
        }
        else{
         $notif->setIdcoli($col);
        }
       
        $manager->addNotification(array($this->getUser()), $notif, true);
        $this->addFlash('success', 'Colis Profiter avec succès!!'); 
        return $this->redirectToRoute('hagep');
        }else {
            $this->addFlash('error', 'Colis Déja Profite !!'); 
         return $this->redirectToRoute('hagep');
        }
    }
   
    /**
     * @Route("confirmer/{id}/{idd}", name="confirm_yes")
     * 
     */
    public function confirmeryesNotification(Request $request, $id,$idd, NotifiableNotification $not)
    {  
        
     $not->setSeen(true);
     $em =$this ->getDoctrine()->getManager();
     $noti = $em->getRepository('MgiletNotificationBundle:Notification')->find($id);
     $col = $em->getRepository('AnnonceBundle:Coli')->find($idd);
     $col->setEtat('Accepter');
     $noti->setIsdeleted('1'); 
     $this->getDoctrine()->getManager()->flush();
      return $this->redirectToRoute('homepage' ); 
    }
    
    
   
    //Refuser notification
     /**
     * @Route("confirmnot/{id}", name="confirm_not")
     * 
     */
    public function confirmerNotification(Request $request, $id, NotifiableNotification $not)
    {   
        
         $not->setSeen(true);
         $em = $this->getDoctrine()->getManager();
         $noti = $em->getRepository('MgiletNotificationBundle:Notification')->find($id);
         $em->remove($noti);
         $not = $em->getRepository('MgiletNotificationBundle:NotifiableNotification')->find($id);
         $em->remove($not);
       //  $noti->setIsdeleted('1');
         $this->getDoctrine()->getManager()->flush();
         return $this->redirectToRoute('homepage' );
    }

     /**
     * @Route("detail/{id}/{idd}", name="detail")
     * 
     */
    public function detailAction($id,$idd){ 

    $f = $this->getDoctrine()->getManager();
    $FavRepository = $f->getRepository('AnnonceBundle:Favoris');
    $fav=$FavRepository->findAll();  
    $user = new User();
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $notiRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification');
    $notif = $notiRepo->findby(array('idDes' => $user));
    //------------------------------------------
    $u = $this->getDoctrine()->getManager();
    $userRepository = $u->getRepository('AppBundle:User');
    $per=$userRepository->find($id);  

    return $this->render('AnnonceBundle:colis:detail.html.twig',array("per"=>$per, "notif"=> $notif, "fav"=>$fav ,"idd"=>$idd ));
     }
    /**
     * @Route("vote/{note}/{id}/{idt}", name="vote")
     * 
     */
      public function voteAction($note,$id,$idt)
      { 
        $vote = new Vote();
        $vote->setNote($note);
       // $vote = $em->getRepository('AppBundle:Vote')->findby(array('idtrajet'=>$idt));
       // $vote->setNote($note);
        $user_vote = $this->get('security.token_storage')->getToken()->getUser();
        $vote->setIdv($user_vote);
        
          $m = $this->getDoctrine()->getManager();
        $trajet = $m->getRepository('AnnonceBundle:Trajet')->find($idt);
        $vote->setIdtrajet($trajet);
        $e = $this->getDoctrine()->getManager();
        $user = $e->getRepository('AppBundle:User')->find($id);
         $vote->setIduser($user);
        
       
        
       //  $vote->setMoyenne('50');
           $em = $this->getDoctrine()->getManager();
       $voterep= $em->getRepository('AppBundle:Vote');
       $v = $voterep->findby(array('idtrajet'=>$idt)); 
       
        $nb =1;
        $some=0;
        foreach ($v as $vt ) {
              $nb++;
              $some=$some+$vt->getNote();
          }
        $vote->setMoyenne(($some+$note)/$nb);
         $em->persist($vote);
        $em->flush();

         return $this->redirectToRoute('affi' ); 
    }
   /**
   * @Route("/testone", name="testone")
   */
   public function testOneAction()
   {
    return $this->redirectToRoute('Create_Trajet_Route');
   }
    
 }