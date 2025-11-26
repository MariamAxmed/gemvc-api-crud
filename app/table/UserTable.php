<?php
namespace App\Table;

use Gemvc\Database\Table;
use Gemvc\Database\Schema;

class UserTable extends Table
{
    // SÜTUNLAR
    public int $id;
    public string $name;
    public string $username;
    public ?string $description;
    public string $email;
    public string $password;
    public ?string $created_at;
    public ?string $updated_at;

    public function __construct()
    {
        parent::__construct();
    }

    public function getTable(): string
    {
        return 'users';
    }

    // type map – yalnız həqiqi sütunlar
    protected array $_type_map = [
        'id'          => 'int',
        'name'        => 'string',
        'username'        => 'string',
        'description' => 'string',
        'email'       => 'string',
        'password'    => 'string',
        'created_at'  => 'string',
        'updated_at'  => 'string',
    ];

    public function defineSchema(): array
    {
        return [
            Schema::primary('id'),
            Schema::autoIncrement('id'),
            Schema::index('name'),
            Schema::unique('name'),
            Schema::index('description'),
        ];
    }

    public function selectById(int $id): null|static
    {
        $result = $this->select()->where('id', $id)->limit(1)->run();
        return $result[0] ?? null;
    }

    public function selectByName(string $name): null|array
    {
        return $this->select()->whereLike('name', $name)->run();
    }
}
