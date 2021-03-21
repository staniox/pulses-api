<?php
declare(strict_types=1);

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use App\Entities\{TaskTypes, Tasks};




    $app->get('/', function ( $request,  $response, $args) {
        $response->getBody()->write("Hello world!");
        return $response;
    });

    $app->get('/task-types', function (Request $request,ResponseInterface $response, $args) {
        $tasksRepository = $this->get('em')->getRepository(TaskTypes::class);
        $tasks = $tasksRepository->findBy([], ['name' => 'ASC']);

        $response->getBody()->write(json_encode($tasks));
        return $response;
    });
    $app->get('/task-type/{id}', function ( $request, $response, $args) {
        $id = $request->getAttribute('id');
        $tasksRepository = $this->get('em')->getRepository(TaskTypes::class);
        $type = $tasksRepository->find(intval($id));

        $response->getBody()->write(json_encode($type));
        return $response;
    });
    $app->post('/task-type', function (Request $request, ResponseInterface $response) use ($app) {

        $params = (object) $request->getParsedBody();
        if(!$params->name)
            return $response->withStatus(404);

        $type = new TaskTypes((string)$params->name);

        $this->get('em')->persist($type);
        $this->get('em')->flush();

        return $response;
    });
    $app->put('/task-type/{id}', function (Request $request, ResponseInterface $response) use ($app) {

        $id = $request->getAttribute('id');
        $data = (object) $request->getQueryParams();

        if(!$data->name)
            return $response->withStatus(404);

        $typesRepository = $this->get('em')->getRepository(TaskTypes::class);
        $type = $typesRepository->find($id);

        if (!$type)
            return $response->withStatus(404);

        $type->setName((string) $data->name)  ;
        //return $response->getBody()->write(json_encode($type));
        $this->get('em')->flush();

        return $response;
    });
    $app->delete('/task-type/{id}', function (Request $request, ResponseInterface $response) use ($app) {

        $id = $request->getAttribute('id');

        $typesRepository = $this->get('em')->getRepository(TaskTypes::class);
        $type = $typesRepository->find($id);

        if (!$type)
            return $response->withStatus(404);

        $this->get('em')->remove($type);
        $this->get('em')->flush();

        return $response;
    });
    $app->get('/tasks', function ( $request, $response, $args) {
        $tasksRepository = $this->get('em')->getRepository(Tasks::class);
        $tasks = $tasksRepository->findBy([], ['deadline' => 'ASC']);

        $response->getBody()->write(json_encode($tasks));
        return $response;
    });
    $app->get('/task/{id}', function ( $request, $response, $args) {
        $id = $request->getAttribute('id');
        $tasksRepository = $this->get('em')->getRepository(Tasks::class);
        $tasks = $tasksRepository->find(intval($id));

        $response->getBody()->write(json_encode($tasks));
        return $response;
    });

    $app->post('/task', function (Request $request, ResponseInterface $response) use ($app) {

        $params = (object) $request->getParsedBody();
        if(!$params->description)
            return $response->withStatus(404);

        $taskRepository = $this->get('em')->getRepository(TaskTypes::class);
        $type = $taskRepository->find(intval($params->type_id));


        $task = new Tasks((string)$params->description,$type,(string) $params->deadline, $params->is_done || false);

        $this->get('em')->persist($task);
        $this->get('em')->flush();

        return $response;
    });
    $app->put('/task/{id}', function (Request $request, ResponseInterface $response) use ($app) {

        $id = $request->getAttribute('id');
        $data = (object) $request->getQueryParams();

        if(!$data->description)
            return $response->withStatus(404);

        $tasksRepository = $this->get('em')->getRepository(Tasks::class);
        $task = $tasksRepository->find($id);

        if (!$task)
            return $response->withStatus(404);

        $typesRepository = $this->get('em')->getRepository(TaskTypes::class);
        $type = $typesRepository->find(intval($data->type_id));

        $task->setDescription((string) $data->description);
        $task->setType($type);
        $task->setDeadline((string) $data->deadline);
        //return $response->getBody()->write(json_encode($task));
        $this->get('em')->flush();

        return $response;
    });
    $app->delete('/task/{id}', function (Request $request, ResponseInterface $response) use ($app) {

        $id = $request->getAttribute('id');

        $tasksRepository = $this->get('em')->getRepository(Tasks::class);
        $task = $tasksRepository->find($id);

        if (!$task)
            return $response->withStatus(404);

        $this->get('em')->remove($task);
        $this->get('em')->flush();
    
        return $response;
    });

    $app->put('/task/{id}/is-done', function (Request $request, ResponseInterface $response) use ($app) {
        $id = $request->getAttribute('id');
        $taskRepository = $this->get('em')->getRepository(Tasks::class);
        $task = $taskRepository->find($id);
        $task->setIsDone(!$task->isDone());
        $this->get('em')->flush();

        return $response;
    });

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
