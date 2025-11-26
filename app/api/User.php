<?php
namespace App\Api;

use App\Controller\UserController;
use Gemvc\Core\ApiService;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class User extends ApiService
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Create new User
     *
     * @return JsonResponse
     * @http POST
     * @description Create new User in database
     * @example /api/User/create
     */
    public function create(): JsonResponse
    {
        if (!$this->request->definePostSchema([
            'username'    => 'string',
            'email'       => 'string',
            'password'    => 'string',
            '?name'       => 'string',
            '?description'=> 'string',
        ])) {
            return $this->request->returnResponse();
        }

        return (new UserController($this->request))->create();
    }

    /**
     * Read User by ID
     *
     * @return JsonResponse
     * @http GET
     * @description Get User by id from database
     * @example /api/User/read/?id=1
     */
    public function read(): JsonResponse
    {
        // 1) GET parametrlərini validasiya et
        if (!$this->request->defineGetSchema(["id" => "int"])) {
            return $this->request->returnResponse();
        }

        // 2) id-ni URL-dən götür
        $id = $this->request->intValueGet("id");
        if (!$id) {
            return $this->request->returnResponse();
        }

        // 3) Controller mapPostToObject istifadə etdiyi üçün id-ni POST-a köçür
        $this->request->post['id'] = $id;

        // 4) Controller-ə ötür
        return (new UserController($this->request))->read();
    }

    /**
     * Update User
     *
     * @return JsonResponse
     * @http POST
     * @description Update existing User in database
     * @example /api/User/update
     */
    public function update(): JsonResponse
    {
        if (!$this->request->definePostSchema([
            'id'           => 'int',
            '?username'    => 'string',
            '?email'       => 'string',
            '?password'    => 'string',
            '?name'        => 'string',
            '?description' => 'string',
        ])) {
            return $this->request->returnResponse();
        }

        return (new UserController($this->request))->update();
    }

    /**
     * Delete User
     *
     * @return JsonResponse
     * @http POST
     * @description Delete User from database
     * @example /api/User/delete
     */
    public function delete(): JsonResponse
    {
        if (!$this->request->definePostSchema([
            'id' => 'int',
        ])) {
            return $this->request->returnResponse();
        }

        return (new UserController($this->request))->delete();
    }

    /**
     * List all Users
     *
     * @return JsonResponse
     * @http GET
     * @description Get list of all Users with filtering and sorting
     * @example /api/User/list/?sort_by=id&find_like=username=test
     */
    public function list(): JsonResponse
    {
        $this->request->findable([
            'username' => 'string',
            'email'    => 'string',
            'name'     => 'string',
        ]);

        $this->request->findable([
            'id',
            'username',
            'email',
            'name',
        ]);

        return (new UserController($this->request))->list();
    }
}
