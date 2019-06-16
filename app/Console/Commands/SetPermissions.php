<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SetPermissions extends Command
{
    protected $signature = 'local:permissions {--clear}';
    protected $description = 'Cria permissões, categorias de permissões e perfis de usuário.';

    public function handle()
    {
        if($this->option('clear')) {
            $this->resetAll();
        }

        $permissionsCreated = [];

        $categories = $this->getCategories();
        foreach($categories as $category) {
            $newCategory = new PermissionCategory();
            $newCategory->title = $category['title'];
            $newCategory->save();
            echo "Category '{$newCategory->title}' created\n";

            foreach($category['permissions'] as $permission) {

                $code = $permission[0];
                $description = $permission[1];

                $newPermission = new Permission();
                $newPermission->code = $code;
                $newPermission->description = $description;
                $newPermission->category_id = $newCategory->id;
                $newPermission->save();

                echo " - Permission '{$newPermission->code}' created\n";

                $permissionsCreated[$code] = $newPermission->id;

            }
        }

        echo "Done creating categories.\n\n";

        $roles = $this->getRoles();
        foreach($roles as $role) {
            $newRole = new Role();
            $newRole->title = $role['title'];
            $newRole->description = $role['description'];
            $newRole->save();

            $ids = [];

            $addAllPermissions = $role['permissions'] === '*';
            if($addAllPermissions) {
                $ids = array_values($permissionsCreated);
            } else {
                foreach($role['permissions'] as $code) {
                    $ids[] = $permissionsCreated[$code];
                }
            }

            $newRole->permissions()->sync($ids);

            echo "Role '{$newRole->title}' created with " . count($ids) . " permissions\n";

        }


    }

    private function getCategories()
    {
        return [
            [
                'title' => 'Atividades',
                'permissions' => [
                    ['task.list', 'Ver'],
                    ['task.detail', 'Ver detalhes'],
                    ['task.create', 'Criar'],
                    ['task.edit', 'Editar'],
                    ['task.delete', 'Excluir'],
                    ['task.no_review', 'Publicar sem revisão']
                ]
            ],
            [
                'title' => 'Revisão de publicação',
                'permissions' => [
                    ['review.list', 'Ver'],
                    ['review.detail', 'Ver detalhes'],
                    ['review.evaluate', 'Avaliar'],
                ]
            ],
            [
                'title' => 'Permissões',
                'permissions' => [
                    ['role.list', 'Ver'],
                    ['role.detail', 'Ver detalhes'],
                    ['role.create', 'Criar'],
                    ['role.edit', 'Editar'],
                    ['role.delete', 'Excluir'],
                ]
            ],
            [
                'title' => 'Usuários',
                'permissions' => [
                    ['users.list', 'Ver'],
                    ['users.edit', 'Editar'],
                ]
            ],
            [
                'title' => 'Objetos de ensino',
                'permissions' => [
                    ['topics.list', 'Ver'],
                    ['topics.add', 'Adicionar'],
                    ['topics.delete', 'Remover'],
                ]
            ],
        ];
    }

    private function getRoles()
    {
        return [
            [
                'title' => 'Administrador',
                'description' => 'Acesso a todas as funcionalidades inclusive a gerência de permissões de usuários.',
                'permissions' => '*'
            ],
            [
                'title' => 'Gestor',
                'description' => 'Acesso a todas as funcionalidades exceto a gerência de permissões de usuários.',
                'permissions' => [
                    'task.list',
                    'task.detail',
                    'task.create',
                    'task.edit',
                    'task.delete',
                    'task.no_review',
                    'role.list',
                    'role.detail',
                    'review.list',
                    'review.detail',
                    'review.evaluate',
                    'topics.list',
                    'topics.add',
                    'topics.delete',
                ]
            ],
            [
                'title' => 'Curador',
                'description' => 'Criação e curadoria de conteúdo',
                'permissions' => [
                    'task.list',
                    'task.detail',
                    'task.create',
                    'task.edit',
                    'task.delete',
                    'task.no_review',
                    'review.list',
                    'review.detail',
                    'review.evaluate',
                ]
            ],
            [
                'title' => 'Criador',
                'description' => 'Acesso as funcionalidades de criação de conteúdo.',
                'permissions' => [
                    'task.list',
                    'task.detail',
                    'task.create',
                    'task.edit',
                    'task.delete',
                ]
            ],
        ];
    }

    private function resetAll()
    {

        Schema::disableForeignKeyConstraints();
        echo "Removing roles of all users.\n";
        User::where('id', '>', 0)->update(['role_id' => null]);

        echo "Erasing role_permissions\n";
        DB::table('role_permissions')->truncate();

        echo "Erasing permissions\n";
        DB::table('permissions')->truncate();

        echo "Erasing role\n";
        DB::table('roles')->truncate();

        echo "Erasing permission_categories\n";
        DB::table('permission_categories')->truncate();
        Schema::enableForeignKeyConstraints();

        echo "\n";
    }

}
