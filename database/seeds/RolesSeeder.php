<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $this->clear();
        $this->seed();
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();

        echo "\tErasing role_permissions\n";
        DB::table('role_permissions')->truncate();

        echo "\tErasing role\n";
        DB::table('roles')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function seed()
    {
        $permissions = Permission::all()->keyBy('code')->map(function ($permission) {
            return $permission->id;
        })->toArray();

        $roles = $this->getRoles();
        foreach ($roles as $role) {

            $newRole = new Role();
            $newRole->title = $role['title'];
            $newRole->description = $role['description'];
            $newRole->default = isset($role['default']) && $role['default'];
            $newRole->save();

            $ids = [];

            $addAllPermissions = $role['permissions'] === '*';
            if ($addAllPermissions) {
                $ids = array_values($permissions);
            } else {
                foreach ($role['permissions'] as $code) {
                    $ids[] = $permissions[$code];
                }
            }

            $newRole->permissions()->sync($ids);

            echo "\tRole '{$newRole->title}' created with " . count($ids) . " permissions\n";
        }
    }

    private function getRoles()
    {
        return [
            [
                'title' => 'Administrador',
                'description' => 'Acesso a todas as funcionalidades.',
                'permissions' => '*'
            ],
            [
                'title' => 'Revisor',
                'description' => 'Criação e revisão de conteúdo',
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
                'title' => 'Parceiro',
                'description' => 'Criador que pode publicar sem necessidade de revisão.',
                'permissions' => [
                    'task.list',
                    'task.detail',
                    'task.create',
                    'task.edit',
                    'task.delete',
                    'task.no_review',
                ],
                'default' => true,
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
                ],
                'default' => true,
            ],
        ];
    }
}
