<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Unirest;

class AdminController extends BaseAdminController
{
    public function createNewUserEntity()    
    {    	
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function persistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::updateEntity($user);
    }
    /**
     * @Route(path = "/admin/game/getinfo", name = "game_getinfo")
     * @Security("has_role('ROLE_APP_ADMIN')")
     */
    public function getinfoAction(Request $request)
    {        

        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $game = $em->getRepository('AppBundle:Game')->find($id);

        
        

        $headers = array('Accept' => 'application/json');
        $query = null;
        $response = Unirest\Request::post('http://store.steampowered.com/api/appdetails?appids='.$game->GetSteamlink(), $headers, $query);
         
        $obj = json_decode($response->raw_body, true);

        $game->setGameDescription($obj[$game->GetSteamlink()]["data"]["detailed_description"]);
        $game->setHeaderImage($obj[$game->GetSteamlink()]["data"]["header_image"]);
        if(array_key_exists("movies",$obj[$game->GetSteamlink()]["data"]))
        {
            $game->setGameMovies(serialize($obj[$game->GetSteamlink()]["data"]["movies"]));    
        }
        
        $game->setGameImages(serialize($obj[$game->GetSteamlink()]["data"]["screenshots"]));
        $game->setCategoriesArray(serialize($obj[$game->GetSteamlink()]["data"]["genres"]));

        
        $em->persist($game);
        $em->flush();


        // redirect to the 'list' view of the given entity
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $request->query->get('entity'),
        ));

        // redirect to the 'edit' view of the given entity item
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'edit',
            'id' => $id,
            'entity' => $request->query->get('entity'),
        ));
    }
}