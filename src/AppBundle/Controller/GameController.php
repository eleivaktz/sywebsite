<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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


use AppBundle\Entity\Schudle;
use AppBundle\Entity\Game;
use AppBundle\Entity\Schudlevotation;
use AppBundle\Entity\Schudlepool;
use AppBundle\Entity\Schudlegameday;




class GameController extends Controller
{
    /**
     * @Route("/ajax/savegame", options={"expose"=true} , name="ajax_savegame")
     * @Method({"POST"})
     */
    public function savegameAction(Request $request)
    {

        if($request->isXmlHttpRequest())
        {            
            $em = $this->getDoctrine()->getManager();    

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
 
            $serializer = new Serializer($normalizers, $encoders);        
                
            $result = $em->getRepository('AppBundle:Game')->createQueryBuilder('g')
           ->where('g.name LIKE :email')           
           ->setParameter('email', $request->get("game_name"))
           ->getQuery()
           ->getResult();
            $response = new JsonResponse();

            if(sizeof($result) == 0)
            {
                $game = new Game();
                $game->SetName($request->get("game_name"));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($game);
                $entityManager->flush(); 

                $gameslist = $this->getDoctrine()
                    ->getRepository(Game::class)
                    ->findAll();

                foreach ($gameslist as $game) {
                    $game->setCategoriesArray(unserialize($game->getCategoriesArray()[0]));
                }     

                $response->setData(array(
                'response' => 'success',
                'gamelist' => $serializer->serialize($gameslist, 'json')
                ));
            }
            else
            {   
                $response->setData(array(
                'response' => 'fail',
                'error' => $serializer->serialize('Ya exite el juego.', 'json')
                ));
            }            
            
            return $response;
        }

        $gameslist = $this->getDoctrine()
                    ->getRepository(Game::class)
                    ->findAll();
        $game = new Game();    

        $form = $this->createFormBuilder($game)
            ->add('name', TextType::class)            
            ->add('save', SubmitType::class, array('label' => 'Añadir Juego'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $game = $form->getData();

            
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($game);
             $entityManager->flush();            
        }

       // replace this example code with whatever you need
        return $this->render('votacion/votacion.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'gamelist' => $gameslist,
        ]);
    }


    /**
     * @Route("/ajax/votegame", options={"expose"=true}, name="ajax_votegame")
     * @Method({"POST"})
     */
    public function votegameAction(Request $request)
    {

        if($request->isXmlHttpRequest())
        {            

            $em = $this->getDoctrine()->getManager();
            
            $game_id = $request->get("game_id");
            $pool_id = $request->get("pool_id");
            $user = $this->getUser();            
            if(is_null($user))
            {
                $response = new JsonResponse();
                $encoders = array(new JsonEncoder());
                $normalizers = array(new ObjectNormalizer()); 
                $serializer = new Serializer($normalizers, $encoders);

                $response->setData(array(
                    'response' => 'fail',
                    'error' => $serializer->serialize("Necesitas estar Logeado", 'json')                
                ));
                return $response;
            }

             $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($game_id);
            

            $pool = $this->getDoctrine()
                    ->getRepository(Pool::class)
                    ->findOne($pool_id);                
            
            $query = $em->createQuery('SELECT v FROM AppBundle:Votation v 
                                                        JOIN  v.pool p 
                                                        JOIN  v.game pg
                                                        where p.id = '.$pool->GetId().' 
                                                            and pg.id = '.$game_id)
                                                        ->setMaxResults(1);   
            $votationresult = $query->getResult();

            if(sizeof($votationresult) == 0)
            {
                $votation = new Votation();

                $schudlevotation->SetSchudlepool($schudlepool);
                $schudlevotation->SetGame($game);
                $schudlevotation->SetVotes(1);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($schudlevotation);

                $entityManager->flush();      
            }
            else
            {
                $votation = $votationresult[0];

                $votation->SetVotes($votation->GetVotes()+1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($votation);

                $entityManager->flush();
            }



                    
                
            $poolupdate = $em->getRepository('AppBundle:Votation')->createQueryBuilder('v')                    
                    ->join('v.pool','p')                                        
                    ->Where('p.id = :poolid')           
                    ->setParameter('poolid', $pool_id)                    
                    ->setMaxResults(5)
                    ->orderBy('v.votes', 'DESC')
                    ->getQuery()
                    ->getResult();
            
            $response = new JsonResponse();            

            $serializer = SerializerBuilder::create()->build();

            $response->setData(array(
                'response' => 'success',
                'schudlepoolupdate' => $serializer->serialize($poolupdate, 'json')                
                ));
            

            
            return $response;
        }
    }

    /**
     * @Route("/ajax/getinfogame", options={"expose"=true}, name="ajax_getinfogame")
     * @Method({"POST"})
    */
    public function gameinfoAction(Request $request)
    {
        $game_id = $request->get("game_id");

        $game = $this->getDoctrine()
            ->getRepository(Game::class)
            ->find($game_id);

        $response = new JsonResponse();
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer()); 
        $serializer = new Serializer($normalizers, $encoders);

        $response->setData(array(
            'response' => 'success',
            'game' => $serializer->serialize($game, 'json'),
            'gamesteamid' => $game->GetSteamlink()   
        ));

        return $response;
    }

    /**
     * @Route("/ajax/schudlegameday", options={"expose"=true}, name="ajax_schudlegameday")
     * @Method({"GET"})
    */
    public function getschudlegamedayAction()
    {
        $em = $this->getDoctrine()->getManager();
        $schudlegameday = $em->getRepository('AppBundle:Schudlegameday')->createQueryBuilder('sgd')                    
                    ->join('sgd.game','g')
                    ->join('sgd.schudle','s')                                                           
                    ->where('s.ano = :ano')           
                    ->andWhere('s.mes = :mes')           
                    ->setParameter('mes', date("n"))
                    ->setParameter('ano', date("o"))                    
                    ->getQuery()
                    ->getResult();

        $lunes = null;
        $martes = null;
        $miercoles = null;
        $jueves = null;
        $viernes = null;
        $sabado = null;
        $domingo = null;

        $response = new JsonResponse();
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer()); 
        $serializer = new Serializer($normalizers, $encoders);

        foreach ($schudlegameday as $schudlegd) {

            switch ($schudlegd->GetDay()) {
                case 'lunes':
                    
                    $lunes["game"] = $serializer->serialize($schudlegd->GetGame(), 'json');                    
                    break;
                case 'martes':
                    
                    $martes["game"] = $serializer->serialize($schudlegd->GetGame(), 'json');
                    break;
                case 'miercoles':
                    
                    $miercoles["game"] = $serializer->serialize($schudlegd->GetGame(), 'json');
                    break;
                case 'jueves':
                    
                    $jueves["game"] = $serializer->serialize($schudlegd->GetGame(), 'json');
                    break;
                case 'viernes':
                    
                    $viernes["game"] = $serializer->serialize($schudlegd->GetGame(), 'json');
                    break;
                case 'sabado':
                    
                    $sabado["game"] = $serializer->serialize($schudlegd->GetGame(), 'json');
                    break;
                case 'domingo':                    
                    $domingo["game"] = $serializer->serialize($schudlegd->GetGame(), 'json');
                    break;
                default:
                    # code...
                    break;
            }
        }
     

        $response->setData(array(
            'response' => 'success',
            'lunes' => $lunes,             
            'martes' => $martes,
            'miercoles' => $miercoles,
            'jueves' => $jueves,
            'sabado' => $sabado,
            'domingo' => $domingo
        ));

        return $response;
    }
}
