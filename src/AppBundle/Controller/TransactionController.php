<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Transaction;
use AnnonceBundle\Entity\Coli;
use Beelab\PaypalBundle\Paypal\Exception;
use Beelab\PaypalBundle\Paypal\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use Mgilet\NotificationBundle\Entity\Notification;
use Mgilet\NotificationBundle\Entity\NotifiableNotification;

class TransactionController extends Controller
{
    /**
    * @Route("payroute/{id}/{idss}", name="payroute")
    * 
    */
     public function payment($id,$idss)
    {   $em=$this->getDoctrine()->getManager();
        $coli = $em->getRepository('AnnonceBundle:Coli')->find($id);

        
        $amount = ($coli->getPrixColis());
        $co = $em->getRepository('AppBundle:User')->find($idss);
        $transaction = new Transaction(200);
        try {

        
         $response = $this->get('beelab_paypal.service')->setTransaction($transaction, ['noShipping' => 2])->start();
             $transaction->setIdcoli($coli);
             $transaction->setIdsrc($co);
            $this->getDoctrine()->getManager()->persist($transaction);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($response->getRedirectUrl('homepage'));
        } catch (Exception $e) {
            throw new HttpExceptin(503, 'Payment error', $e);
        }
    }

    /**
    * @Route("cancelroute", name="cancelroute")
    * 
    */
    public function canceledPayment(Request $request)
    {
        $token = $request->query->get('token');
        $transaction = $this->getDoctrine()->getRepository('AppBundle:Transaction')->findOneByToken($token);
        if (null === $transaction) {
            throw $this->createNotFoundException(sprintf('Transaction with token %s not found.', $token));
        }
        $transaction->cancel(null);
        $this->getDoctrine()->getManager()->flush();

       return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("returnroute", name="returnroute") 
     */
    public function completedPayment(Service $service, Request $request)
    {
        $token = $request->query->get('token');
        $transaction = $this->getDoctrine()->getRepository('AppBundle:Transaction')->findOneByToken($token);
        if (null === $transaction) {
            throw $this->createNotFoundException(sprintf('Transaction with token %s not found.', $token));
        }
        $service->setTransaction($transaction)->complete();
        $this->getDoctrine()->getManager()->flush();
        if (!$transaction->isOk()) {
            return $this->redirect($this->generateUrl('homepage'));

        }else{
        $this->deleteNotificationPay();
      return $this->redirect($this->generateUrl('homepage'));
         }
    }

    public function deleteNotificationPay()
    {
        $em=$this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $tran = $this->getDoctrine()->getRepository(Transaction::class)->findAll();
        $tr=0;
        foreach ($tran as $t) {
            $tr++;
        }
         $noti = $this->getDoctrine()->getRepository(Notification::class)->findby(array('idcoli' => $t->getIdcoli(),'subject'=>'system','idDes'=>$user));
         foreach ($noti as $t) {
          
          $not = $em->getRepository(NotifiableNotification::class)->find($t->getId());
          $em->remove($t);
          $not->setSeen(true);
          $em->remove($not);
           
         }
         sleep(2);
         $em->flush();
         
    } 
}