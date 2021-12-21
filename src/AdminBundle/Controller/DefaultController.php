<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AnnonceBundle\Entity\Trajet;
use AnnonceBundle\Entity\Coli;
use AnnonceBundle\Entity\Signaler;
use AppBundle\Entity\User;
use AppBundle\Entity\Adminpay;
use AppBundle\Entity\Vote;
use AppBundle\Entity\Transaction;
use AnnonceBundle\Entity\Favoris;
use AppBundle\Entity\Message;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Mgilet\NotificationBundle\Entity\Notification;
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends Controller
{

    /**
     * @Route("/Admin12ikj", name="Admin")
     */
    public function indexAction()
    {
        //users
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->getDoctrine()->getRepository(User::class)->findAll();
    	$nb_users = 0;
    	foreach ($user as $user) {$nb_users +=1;}
    	//trajets
    	$trajet = $this->getDoctrine()->getRepository(Trajet::class)->findAll();
    	$nb_trajets=0;
    	foreach ($trajet as $trajet ) {$nb_trajets +=1;}
    	//colis
    	$coli = $this->getDoctrine()->getRepository(Coli::class)->findAll();
    	$nb_colis=0;
    	foreach ($coli as $coli ) {$nb_colis +=1;}

        $p_vote=$this->CalculVote();
        $p_vote=($p_vote*100)/$nb_users;
        $p_sig=$this->CalculSignaler();
        $p_sig=($p_sig*100)/$nb_users;
        $p_Fav=$this->CalculFavoris();
        $p_Fav=($p_Fav*100)/$nb_users;
        $p_msg=$this->CalculMessage();
        $p_msg=($p_msg*100)/$nb_users;
        return $this->render('AdminBundle:Default:index.html.twig', array('nb_users'=>$nb_users,'nb_trajets'=>$nb_trajets,'nb_colis'=>$nb_colis,'p_vote'=>$p_vote,'p_sig'=>$p_sig,'p_Fav'=>$p_Fav,'p_msg'=>$p_msg));
    }
    /**
    * @Route("/AdminSignaler", name="/AdminSignaler")
    */
    public function adminSignalerAction()
    {
        $sig= $this->getDoctrine()->getRepository(Signaler::class)->findAll();
        $nb_sg=0;
          foreach ($sig as $sg) { $nb_sg +=1; } 
        return $this->render('AdminBundle:Default:ListeSignaler.html.twig', array('sig'=>$sig,'nb_sg'=>$nb_sg));  
    }

    /**
    * @Route("/SupprimerSig/{id}", name="/SupprimerSig")
    */
    public function suppSignalerAction($id)
    {
      $em = $this->getDoctrine()->getManager(); 
      $sig= $this->getDoctrine()->getRepository(Signaler::class)->find($id);
      $em->remove($sig);
      $em->flush();
       return $this->redirect($this->generateUrl('/AdminSignaler'));
    }
    /**
    * @Route("/AdminUsers", name="/AdminUsers");
    */
    public function allUsersAction(){
        $em = $this->getDoctrine()->getManager();
    	$user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('AdminBundle:Default:ListeUsers.html.twig', array('user'=>$user));
    }
    /**
    * @Route("/AdminTrajet", name="/AdminTrajet")
    */
    public function allTrajetAction(){
    	$em = $this->getDoctrine()->getManager();
    	$trajet = $this->getDoctrine()->getRepository(Trajet::class)->findAll();
    	$nb_tra=0;
    	foreach ($trajet as $Tra ) {$nb_tra +=1;}
        return $this->render('AdminBundle:Default:ListeTrajet.html.twig', array('trajet'=>$trajet,'Tra'=>$Tra,'nb_tra'=>$nb_tra));
    }
    /**
    * @Route("/AdminColis", name="/AdminColis")
    */
    public function allColisAction(){
    	$em = $this->getDoctrine()->getManager();
    	$coli = $this->getDoctrine()->getRepository(Coli::class)->findAll();
    	$nb_col=0;
    	foreach ($coli as $col ) {$nb_col +=1;}
        return $this->render('AdminBundle:Default:ListeColis.html.twig', array('coli'=>$coli,'col'=>$col,'nb_col'=>$nb_col));
    }
     
    
    /**
    * @Route("/AdminUsersDetails{id}", name="/AdminUsersDetails");
    */
    public function oneUsersAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->findby(array('id' => $id ));
        return $this->render('AdminBundle:Default:OneUsers.html.twig', array('user'=>$user));
    }
    /**
    * @Route("/AdminTrajetFind{id}",name="/AdminTrajetFind")
    */
    public function findTrajetsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->findby(array('id' => $id ));
        $trajet = $this->getDoctrine()->getRepository(Trajet::class)->findby(array('idannonceur' => $user ));
        $nb_tra=0;
        foreach ($trajet as $tra) {
            $nb_tra +=1;
        }
         return $this->render('AdminBundle:Default:OneUsers.html.twig', array('user'=>$user,'trajet'=>$trajet,'nb_tra'=>$nb_tra));
    }
    /**
    * @Route("/AdminColisFind{id}",name="/AdminColisFind")
    */
    public function findColisAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->findby(array('id' => $id ));
        $coli = $this->getDoctrine()->getRepository(Coli::class)->findby(array('idannonceur' => $user ));
        $nb_col=0;
        foreach ($coli as $col) {
            $nb_col +=1;
        }
         return $this->render('AdminBundle:Default:OneUsers.html.twig', array('user'=>$user,'coli'=>$coli,'nb_col'=>$nb_col));
    }

    /**
    * @Route("/AdminMessage",name="/AdminMessage")
    */
    public function messageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $mesg = $this->getDoctrine()->getRepository(Message::class)->findAll();
        $nb_mg=0;
        foreach ($mesg as $mg) {
            $nb_mg +=1;
        }
        return $this->render('AdminBundle:Default:ListeMessage.html.twig', array('mesg'=>$mesg,'nb_mg'=>$nb_mg));
    }
    /**
    * @Route("/AdminTransaction",name="/AdminTransaction")
    */
    public function TransactAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tran = $this->getDoctrine()->getRepository(Transaction::class)->findAll();
        $adpay = $this->getDoctrine()->getRepository(Adminpay::class)->findAll();
        $nb_tran=0;
        foreach ($tran as $tr) {
            $nb_tran +=1;
        }
        return $this->render('AdminBundle:Default:Transaction.html.twig', array('adpay'=>$adpay,'tran'=>$tran,'nb_tran'=>$nb_tran));
    }

    /**
    * @Route("/ConfirmPay_{id}_{idd}",name="ConfirmPay")
    */
    public function confirmPayAction($id,$idd)
    {
       $em = $this->getDoctrine()->getManager();
       $adpay = $this->getDoctrine()->getRepository(Adminpay::class)->find($id);
       $tran = $this->getDoctrine()->getRepository(Transaction::class)->find($id);
       $adpay->setPaiement(1);
       $tran->setIsOk(1);
       $msg="suppression terminé aves succés";
       dump($msg);
       sleep(3);
       //$em->flush();
       return $this->redirect($this->generateUrl('/AdminTransaction'));
    }
     
     public function CalculVote()
    {
      $em = $this->getDoctrine()->getManager(); 
      $vot= $this->getDoctrine()->getRepository(Vote::class)->findAll();
      $user= $this->getDoctrine()->getRepository(User::class)->findAll();  
      $nb_user=0;
      foreach ($user as $u){
            $test = 0;
            foreach ($vot as $v) {
                if($v->getIduser()->getId() == $u->getId())
                {
                  $nb_user++;
                  $test++;
                }
                if($test > 0){break;}
            }
       } 
       return $nb_user;
    }
    //signaler
    public function CalculSignaler()
    {
      $em = $this->getDoctrine()->getManager(); 
      $sig= $this->getDoctrine()->getRepository(Signaler::class)->findAll();
      $user= $this->getDoctrine()->getRepository(User::class)->findAll();  
      $nb_user=0;
      foreach ($user as $u){
            $test = 0;
            foreach ($sig as $s) {
                if($s->getIdannonceur()->getId() == $u->getId())
                {
                  $nb_user++;
                  $test++;
                }
                if($test > 0){break;}
            }
       } 
       return $nb_user;
    }
    //Favoris
    public function CalculFavoris()
    {
      $em = $this->getDoctrine()->getManager(); 
      $fav= $this->getDoctrine()->getRepository(Favoris::class)->findAll();
      $user= $this->getDoctrine()->getRepository(User::class)->findAll();  
      $nb_user=0;
      foreach ($user as $u){
            $test = 0;
            foreach ($fav as $f) {
                if($f->getIdannonceur()->getId() == $u->getId())
                {
                  $nb_user++;
                  $test++;
                }
                if($test > 0){break;}
            }
       } 
       return $nb_user;
    }
    //Message
    public function CalculMessage()
    {
      $em = $this->getDoctrine()->getManager(); 
      $msg= $this->getDoctrine()->getRepository(Message::class)->findAll();
      $user= $this->getDoctrine()->getRepository(User::class)->findAll();  
      $nb_user=0;
      foreach ($user as $u){
            $test = 0;
            foreach ($msg as $m) {
                if($m->getSender()->getId() == $u->getId())
                {
                  $nb_user++;
                  $test++;
                }
                if($test > 0){break;}
            }
       } 
       return $nb_user;
    }
    /**
     * @Route("/Admin/users/sup/{id}", name="/Admin/users/sup")
     */
    public function deleteUsersAction($id){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setEnabled(0);
        $em->flush();
       return $this->redirect($this->generateUrl('/AdminUsers'));
      
    }
}
