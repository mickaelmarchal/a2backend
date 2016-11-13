<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"user"})
     * @Rest\Get("/api/users")
     */
    public function getUsersAction()
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"user"})
     * @Rest\Get("/api/users/{userId}")
     */
    public function getUsersByIdAction(Request $request)
    {
        $userId = (int) $request->get('userId');
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->find($userId);

        if ($user) {
            return $user;
        } else {
            return $this->userNotFound();
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"user"})
     * @Rest\Post("/api/users")
     */
    public function postUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['validation_groups' => ['Default', 'New']]);

        //throw new \Exception(print_r($request, true));

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            // le mot de passe en clair est encodé avant la sauvegarde
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);

            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"user"})
     * @Rest\Delete("/api/users/{userId}")
     */
    public function deleteUserAction(Request $request)
    {
        $userId = (int) $request->get('userId');
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->find($userId);

        if ($user) {
            $this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();
            return null;
        } else {
            return $this->userNotFound();
        }
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Put("/api/users/{id}")
     */
    public function updateUserAction(Request $request)
    {
        return $this->updateUser($request, true);
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Patch("/api/users/{id}")
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    private function updateUser(Request $request, $clearMissing)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user User */

        if (empty($user)) {
            return $this->userNotFound();
        }

        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }

        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

}
