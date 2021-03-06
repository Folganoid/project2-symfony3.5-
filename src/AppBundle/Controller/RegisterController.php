<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegisterController
 * @package AppBundle\Controller
 */
class RegisterController extends Controller
{
    /**
     * @Route("/register", name="register")
     * users registration
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        /**
         * create user form submit
         */
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user->setRole(1);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('AppBundle:Register:register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
