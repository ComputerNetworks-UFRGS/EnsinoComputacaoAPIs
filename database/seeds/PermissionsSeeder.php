<?php

use App\Models\Permission;
use App\Models\PermissionCategory;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $this->clear();
        $this->seed();
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();

        echo "\tErasing permissions\n";
        DB::table('permissions')->truncate();

        echo "\tErasing permission_categories\n";
        DB::table('permission_categories')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function seed()
    {
        $categories = $this->getCategories();
        foreach ($categories as $category) {
            $newCategory = new PermissionCategory();
            $newCategory->title = $category['title'];
            $newCategory->save();
            echo "\tCategory '{$newCategory->title}' created\n";

            foreach ($category['permissions'] as $permission) {

                $code = $permission[0];
                $description = $permission[1];

                $newPermission = new Permission();
                $newPermission->code = $code;
                $newPermission->description = $description;
                $newPermission->category_id = $newCategory->id;
                $newPermission->save();

                echo "\t - Permission '{$newPermission->code}' created\n";

            }
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
                    ['topics.detail', 'Detalhes'],
                    ['topics.add', 'Adicionar'],
                    ['topics.edit', 'Editar'],
                    ['topics.delete', 'Remover'],
                ]
            ],
            [
                'title' => 'Habilidades',
                'permissions' => [
                    ['skill.list', 'Ver'],
                    ['skill.detail', 'Ver detalhes'],
                    ['skill.create', 'Criar'],
                    ['skill.edit', 'Editar'],
                    ['skill.delete', 'Excluir'],
                ]
            ],
            [
                'title' => 'Currículos',
                'permissions' => [
                    ['curri.list', 'Ver'],
                    ['curri.detail', 'Ver detalhes'],
                    ['curri.create', 'Criar'],
                    ['curri.edit', 'Editar'],
                    ['curri.delete', 'Excluir'],
                ]
            ],
        ];
    }
}
