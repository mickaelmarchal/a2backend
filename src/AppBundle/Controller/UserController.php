<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();

        $data = ['getUsersAction' => $users];
        $view = $this->view($data, Response::HTTP_OK);

        return $view;

    }

    /**
     * @Rest\Get("/users/{userId}")
     */
    public function getUsersByIdAction(Request $request)
    {
        $userId = $request->get('userId');
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->find($userId);

        if ($user) {
            $data = ['getUsersByIdAction' => $user];
            $view = $this->view($data, Response::HTTP_OK);
        } else {
            $data = ['getUsersByIdAction' => null];
            $view = $this->view($data, Response::HTTP_NOT_FOUND);
        }

        return $view;
    }

    /**
     * @Rest\Post("/users")
     */
    public function postUsersAction(Request $request)
    {
        $data = ['postUsersAction' => 'not implemented yet'];
        $view = $this->view($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        return $view;
    }

    /**
     * @Rest\Put("/users/{userId}")
     */
    public function putUsersByIdAction(Request $request)
    {
        $userId = $request->get('userId');
        $data = ['putUsersByIdAction' => 'not implemented yet'];
        $view = $this->view($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        return $view;
    }

    /**
     * @Rest\Delete("/users/{userId}")
     */
    public function deleteUsersByIdAction(Request $request)
    {
        $userId = $request->get('userId');
        $data = ['deleteUsersByIdAction' => 'not implemented yet'];
        $view = $this->view($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        return $view;
    }



    /****************

    /**
     * @Route("/user", name="user", type="rest")
     *
    public function getUserAction($id)
    {
        return $this->container->get('doctrine.entity_manager')->getRepository('User')->find($id);
    }


    public function getUsersAction()
    {
        $data = $this->container->get('doctrine.entity_manager')->getRepository('User')->findAll(); // get data, in this case list of users.
        $view = $this->view($data, 200)
            ->setTemplate("MyBundle:Users:getUsers.html.twig")
            ->setTemplateVar('users')
        ;

        return $this->handleView($view);
    }
*/

}
