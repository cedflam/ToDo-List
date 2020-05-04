<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskController extends AbstractController
{
    /**
     * Permet de récupérer toutes les tâches actives
     *
     * @Route("/tasks", name="task_list")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
     *
     *
     * @param TaskRepository $repo
     * @return Response
     */
    public function taskAll(TaskRepository $repo)
    {
        return $this->render('task/task-list.html.twig',[
            'tasks'=> $repo->findBy(['isDone'=> false], ['createdAt'=>'DESC'])
        ]);
    }

    /**
     * Permet de récupérer la liste des tâches appartenant un à user
     *
     * @Route("/tasks/user", name="task_user_list")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
     *
     * @param TaskRepository $repo
     * @return Response
     */
    public function taskUser(TaskRepository $repo)
    {
        return $this->render('task/task-user-list.html.twig',[
            'tasks'=> $repo->findBy(['user'=> $this->getUser()], ['createdAt'=>'DESC'])
        ]);

    }

    /**
     * Permet de récupérer les tâches terminées
     *
     * @Route("/tasks/done", name="task_done_list")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
     *
     * @param TaskRepository $repo
     * @return Response
     */
    public function taskDone(TaskRepository $repo)
    {
        return $this->render('task/task-done-list.html.twig',[
            'tasks'=> $repo->findBy(['isDone'=> true], ['createdAt'=>'DESC'])
        ]);
    }

    /**
     * Permet de créer une nouvelle tâche
     *
     * @Route("/tasks/new", name="task_new")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
     *
     * @param EntityManagerInterface $manager
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function taskNew(EntityManagerInterface $manager, SerializerInterface $serializer, Request $request, ValidatorInterface $validator)
    {
        $data = $request->getContent();
        $task = $serializer->deserialize($data, Task::class, 'json');
        $task->setUser($this->getUser())
             ->setCreatedAt(new \DateTime())
             ->setIsDone(false)
        ;

        $violations = $validator->validate($task);
        if(count($violations) > 0){
            $error = $serializer->serialize($violations, 'json');
            return JsonResponse::fromJsonString($error, Response::HTTP_BAD_REQUEST);
        }

        $manager->persist($task);
        $manager->flush();

        return new Response('created', Response::HTTP_CREATED);
    }

    /**
     * Permet de modifier une tâche
     *
     * @Route("/tasks/edit/{id}", name="task_edit")
     * @Security("is_granted('ROLE_USER') and user === task.user  or is_granted('ROLE_ADMIN')")
     *
     * @param ValidatorInterface $validator
     * @param Task $task
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function taskEdit(ValidatorInterface $validator, Task $task, EntityManagerInterface $manager, Request $request, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $data = $serializer->decode($data, 'json');

        $task->setCreatedAt(new \DateTime())
             ->setTitle($data['title'])
             ->setContent($data['content'])
        ;

        //Je gère les erreurs
        $violations = $validator->validate($task);
        if (count($violations) > 0) {
            $error = $serializer->serialize($violations, 'json');
            return JsonResponse::fromJsonString($error, Response::HTTP_BAD_REQUEST);
        }

        $manager->persist($task);
        $manager->flush();

        return new Response('modified', Response::HTTP_OK);

    }

    /**
     * Permet de valider ou d'invalider une tâche
     *
     * @Route("/tasks/isDone/{id}")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
     *
     * @param Task $task
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function isDone(Task $task, EntityManagerInterface $manager)
    {
        if($task->getIsDone() === false){
            $task->setIsDone(true);
        }else{
            $task->setIsDone(false);
        }

        $manager->persist($task);
        $manager->flush();

        return new Response('ok', Response::HTTP_OK);
    }

    /**
     * Permet de supprimer une tâche
     *
     * @Route("/tasks/delete/{id}")
     * @Security("is_granted('ROLE_USER') and user === task.user  or is_granted('ROLE_ADMIN')")
     *
     * @param EntityManagerInterface $manager
     * @param Task $task
     * @return Response
     */
    public function taskDelete(EntityManagerInterface $manager, Task $task)
    {
        $manager->remove($task);
        $manager->flush();

        return new Response('deleted', Response::HTTP_NO_CONTENT);
    }

    /**
     * Permet de récupérer toutes les tâches pour le dashboard
     *
     * @Route("/dashboard/findAllTasks")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
     *
     * @param TaskRepository $repo
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function dashboardAllTasks(TaskRepository $repo, SerializerInterface $serializer)
    {
        $tasks = $repo->findAll();
        $data = $serializer->serialize($tasks, 'json', [
            'groups'=>"dashboard"
        ]);

        return new Response($data, Response::HTTP_OK);
    }

    /**
     * Permet de récupérer toutes les tâches pour le dashboard
     *
     * @Route("/dashboard/findUserTasks")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
     *
     * @param TaskRepository $repo
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function dashboardFindUserTasks(TaskRepository $repo, SerializerInterface $serializer)
    {
        $tasks = $repo->findBy(['user'=>$this->getUser()]);
        $data = $serializer->serialize($tasks, 'json', [
            'groups'=>"dashboard"
        ]);

        return new Response($data, Response::HTTP_OK);
    }


}
