<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TaskController extends AbstractController
{
    /**
     * Permet de récupérer toutesles tâches
     *
     * @Route("/tasks", name="task_list")
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
     * @param TaskRepository $repo
     * @return Response
     */
    public function taskUser(TaskRepository $repo)
    {
        return $this->render('task/task-user-list.html.twig',[
            'tasks'=> $repo->findBy(['user'=> $this->getUser()])
        ]);

    }

    /**
     * Permet de récupérer les tâches terminées
     *
     * @Route("/tasks/done", name="task_done_list")
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
     * @Route("/task/new", name="task_new")
     *
     * @param Task $task
     * @param EntityManagerInterface $manager
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function taskNew(Task $task, EntityManagerInterface $manager, SerializerInterface $serializer)
    {
        $task = new Task();
        $data = $serializer->deserialize($task, Task::class, 'json');
        $task->setUser($this->getUser());

        $manager->persist($task);
        $manager->flush();

        return new Response('ok', Response::HTTP_OK);
    }


}
