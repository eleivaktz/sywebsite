<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Schudle;
use AppBundle\Entity\Schudlevotation;
use AppBundle\Entity\Schudlepool;
use AppBundle\Entity\Game;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerBuilder;

class VotationController extends Controller
{

    /**
     * @Route("/poollist", name="poollist")
     */
    public function poollistAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $pools = $em->getRepository('AppBundle:Pool')->createQueryBuilder('p')
            ->join('p.votations','pv')
            ->Where('p.enable = true')
            ->orderBy('pv.votes', 'DESC')
            ->getQuery()
            ->getResult();
        // replace this example code with whatever you need
        return $this->render('votacion/poollist.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'pools' => $pools,
        ]);
    }
    /**
    * @Route("/votation", name="votacion")
    */
    public function votacionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $gameslist = $em->getRepository('AppBundle:Game')->createQueryBuilder('g')
                    ->orderBy('g.name', 'ASC')
                    ->getQuery()
                    ->getResult();

        foreach ($gameslist as $game) {
            $game->setCategoriesArray(unserialize($game->getCategoriesArray()[0]));
        }

       // replace this example code with whatever you need
        return $this->render('votacion/votacion.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
               'gamelist' => $gameslist,
           ]);
    }

    /**
     * @Route("/ajax/votestatus",name="ajax_votestatus", options={"expose"=true} ,)
     * @Method({"POST"})
     */
    public function votestatusAction(Request $request)
   {
           if($request->isXmlHttpRequest())
           {
                $em = $this->getDoctrine()->getManager();

                $encoders = array(new JsonEncoder());
                //$normalizers = array(new ObjectNormalizer());
                //$normalizers->setCircularReferenceLimit(2);

                $serializer = SerializerBuilder::create()->build();
                // $serializer = new Serializer($normalizers, $encoders);

                    $poolsupdate = $em->getRepository('AppBundle:Pool')->createQueryBuilder('p')
                            ->join('p.votations','pv')
                            ->Where('p.enable = true')
                            ->orderBy('pv.votes', 'DESC')
                            ->getQuery()
                            ->getResult();

                    $response = new JsonResponse();

            $response->setData(array(
                    'response' => 'success',
                    'poolsupdate' => $serializer->serialize($poolsupdate, 'json')
                       ));
            return $response;
        }
    }


}
