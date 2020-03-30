<?php
/**
 * Created by PhpStorm.
 * User: GHOUFA Zouhayer Amine
 * Date: 29/03/20
 * Time: 01:19
 */

namespace App\Controller\Back;


use App\Entity\User;
use App\Repository\SubscriberRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;


class AjaxController extends AbstractController
{

    /**
     * @var TranslatorInterface $translator
     */
    protected $translator;

    /**
     * MessageController constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/user/list", name="user_list_ajax", options={"expose"=true})
     * @return Response List of blaclist in json format
     */
    public function userlist(Request $request,UserRepository $user): Response
    {
        $get            = $request->query->all();
        $columns        = ['id', 'username', 'email'];
        $get['columns'] = &$columns;
        $em             = $this->getDoctrine()->getManager();
        $entities       = $user->ajaxTableuserlist($get, true)
        ;
        $totalRecords        = $user->getCountBlacklist();
        $totalDisplayRecords = $user->ajaxTableuserlist($get, false);
        $output              = [
            "sEcho"                => intval($get['sEcho']),
            "iTotalRecords"        => (int)$totalRecords,
            "iTotalDisplayRecords" => (int)$totalDisplayRecords->getSingleScalarResult(),
            "aaData"               => [],
        ];
        $rResult             = $entities->getResult();
        foreach ($rResult as $aRow) {
            $row   = [];
            $row[] = '<a href="'.$this->generateUrl('user_index', ['id' => $aRow->getId()])
                     .'">'.$aRow->getId().'</a>';
            $row[] = $this->translator->trans($aRow->getUsername());
            $row[] = $this->translator->trans($aRow->getEmail());

                $row[] = '';
            $output['aaData'][] = $row;
        }
        unset($rResult);
        $response = new Response(json_encode($output));
        return $response;
    }
    /**
     * @Route("/subscriber/list", name="subscriber_list_ajax", options={"expose"=true})
     * @return Response List of blaclist in json format
     */
    public function subscriberlist(Request $request,SubscriberRepository $subscriber): Response
    {
        $get            = $request->query->all();
        $columns        = ['numero', 'message', 'isSuspended', 'preferedNumber', 'createdAt'];
        $get['columns'] = &$columns;
        $entities       = $subscriber->ajaxTablesubscriberlist($get, true)
        ;
        $totalRecords        = $subscriber->getCountBlacklist();
        $totalDisplayRecords = $subscriber->ajaxTablesubscriberlist($get, false);
        $output              = [
            "sEcho"                => intval($get['sEcho']),
            "iTotalRecords"        => (int)$totalRecords,
            "iTotalDisplayRecords" => (int)$totalDisplayRecords->getSingleScalarResult(),
            "aaData"               => [],
        ];
        $rResult             = $entities->getResult();
        foreach ($rResult as $aRow) {
            $row   = [];
            $row[] = $aRow->getNumero();
            $row[] = $aRow->getMessage() ? $aRow->getMessage()->getBody(): 'NULL';
            $class = 'badge badge-success';
            $IsSuspended = 'NON';
            if ($aRow->IsSuspended() == 1) {
                $class = 'badge badge-danger';
                $IsSuspended = 'OUI';
            }
            $row[] = '<span class="label '.$class.'">'.$IsSuspended.'</span>';
            $row[] = $aRow->getPreferedNumber();
            $row[] = $aRow->getCreatedAt() ? $aRow->getCreatedAt()->format('d-m-Y H:i:s') : "";
            $row[] = '';
            $output['aaData'][] = $row;
        }
        unset($rResult);
        $response = new Response(json_encode($output));
        return $response;
    }
}