<?php

namespace AppBundle\Controller;


use AppBundle\Entity\ProjectComment;
use AppBundle\Form\ProjectCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectCommentController extends Controller
{
    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Du må være logget inn for å skrive en kommentar.');
        }
       
        $em = $this->getDoctrine()->getManager();
        $project = $em->find('AppBundle:Project', $request->get('project_id'));
        $comment = new ProjectComment();
        $form = $this->createForm(ProjectCommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Set date and other values
            $comment->setDate(new \DateTime());
            $comment->setUser($this->getUser());
            $comment->setPoints(1);
            $project->addComment($comment);
            $em->persist($comment);
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute('project', array( 'id' => $project->getId() ));
        }
        return $this->redirectToRoute('projectlist');
    }

    public function editAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Du må være logget inn for å skrive en kommentar.');
        }
        $em = $this->getDoctrine()->getManager();
        $project = $em->find('AppBundle:Project', $request->get('project_id'));
        $comment = $em->find('AppBundle:ProjectComment', $request->get('comment_id'));
        if (!$this->userCanEditComment($comment)) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til dette prosjektet");
        }
        // Below here: Also todo
        $form = $this->createForm(ProjectCommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Set edited
            $comment->setEdited(true);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('project', array( 'id' => $project->getId() ));
        }
        return $this->render('comment/edit.html.twig', array(
            'project' => $project,
            'commentForm' => $form->createView()
        ));
    }

    public function deleteAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $project = $em->find('AppBundle:Project', $request->get('project_id'));
        $comment = $em->find('AppBundle:Comment', $request->get('comment_id'));
        // TODO: If not can edit comment: throw something
        if (!$this->getUser()->canEditProject($project) && !$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til dette prosjektet");
        }
        // Below here: Also todo

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('project', array( 'id' => $project->getId() ));
    }

    private function userCanEditComment($comment) {
        if (    $this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')
             || $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')
             && $comment->getUser() == $this->getUser()) {
            return true;
        }
        return false;
    }

    private function createDeleteForm($project, $comment) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_comment', array(
                'comment_id' => $measure->getId(),
                'project_id' => $project->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}