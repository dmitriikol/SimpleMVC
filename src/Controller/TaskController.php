<?php


namespace App\Controller;


use App\Config;
use App\Model\Task;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TaskController implements Controller
{

    private Request $request;
    private Environment $env;
    private array $param;

    public function __construct(Request $request, Environment $env, array $param)
    {
        $this->request = $request;
        $this->env = $env;
        $this->param = $param;
    }

    public function route(): void
    {
        $uri = array_pop($this->param);
        if ($this->request->getMethod() === Request::METHOD_GET) {
            switch ($uri) {
                case 'edit':
                    $this->editGet();
                    break;
                case 'delete':
                    $this->deleteGet($this->request->query->get('task_id'));
                    break;
            }
        } else {
            $this->editPost();
        }
    }

    public function editGet(): void
    {
        $user = null;
        if ($_ENV['user'] === Config::ADMIN_LOGIN) {
            $user = Config::ADMIN_LOGIN;
        }

        $param = $this->request->query->get('task_id');
        $task = Task::get($param);

        $response = new Response($this->env->render('task.html', [
            'id'        => $task['id'],
            'username' => $task['username'],
            'text' => $task['text'],
            'email' => $task['email'],
            'user'  => $user
        ]));
        $response->send();
    }

    public function editPost(): void
    {
        $settings = $this->request->get('settings');
        $id = $settings['id'];
        $username = $settings['name'];
        $email = $settings['email'];
        $text = $settings['text'];
        if ($settings['complete'] === 'on') {
            $status = true;
        } else {
            $status = false;
        }

        Task::updateTask($id, $username, $email, $text, $status);

        $response = new RedirectResponse('/');
        $response->send();
    }

    public function deleteGet(string $id): void
    {
        Task::delete($id);

        $response = new RedirectResponse('/');
        $response->send();
    }
}