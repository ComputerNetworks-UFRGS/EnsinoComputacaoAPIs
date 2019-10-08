<?php

use App\Models\AgeGroup;
use App\Models\LearningAxis;
use App\Models\LearningObject;
use Illuminate\Database\Seeder;

class LearningObjectsSeeder extends Seeder
{

    private $axis = [];
    private $ages = [];

    public function run()
    {
        $this->clear();
        $this->init();
        $this->seed();
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();

        echo "\tErasing learning_objects\n";
        DB::table('learning_objects')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function init()
    {
        $this->axis = [
            'PC' => LearningAxis::where('name', 'like', '%ensamento%')->first()->id,
            'MD' => LearningAxis::where('name', 'like', '%undo%')->first()->id,
            'CD' => LearningAxis::where('name', 'like', '%ultura%')->first()->id,
        ];
        $this->ages = AgeGroup::all()->keyBy('code')->map(function ($age) {
            return $age->id;
        });
    }

    private function seed()
    {
        $objects = $this->getObjects();
        foreach ($objects as $obj) {
            $learningObject = new LearningObject();
            $learningObject->age_group_id = $this->ages[$obj[0]];
            $learningObject->learning_axis_id = $this->axis[$obj[1]];
            $learningObject->name = $obj[2];
            $learningObject->save();

            echo "\tObject '{$learningObject->name}' created.\n";
        }
    }

    private function getObjects()
    {
        return [
            ['01', 'PC', 'Algoritmos: definição'],
            ['01', 'PC', 'Organização de objetos'],
            ['01', 'MD', 'Códigos'],
            ['01', 'MD', 'Informação'],
            ['01', 'MD', 'Máquina: Terminologia & uso de dispositivos computacionais'],
            ['01', 'MD', 'Proteção de informação'],
            ['01', 'CD', 'Introdução à tecnologia digital'],
            ['02', 'PC', 'Algoritmos: construção e simulação'],
            ['02', 'PC', 'Identificação de padrões de comportamento'],
            ['02', 'PC', 'Modelos de objetos'],
            ['02', 'MD', 'Hardware e software'],
            ['02', 'MD', 'Noção de instrução de máquina'],
            ['02', 'CD', 'Impacto de tecnologia digital no dia a dia'],
            ['02', 'CD', 'Uso básico de tecnologia digital'],
            ['03', 'PC', 'Algoritmos: seleção'],
            ['03', 'PC', 'Definição de problemas'],
            ['03', 'PC', 'Introdução à lógica'],
            ['03', 'MD', 'Algoritmos: entradas e saídas'],
            ['03', 'MD', 'Dado'],
            ['03', 'MD', 'Interface'],
            ['03', 'CD', 'Fluência digital'],
            ['03', 'CD', 'Rastro digital'],
            ['03', 'CD', 'Tecnologia digital, economia e sociedade'],
            ['03', 'CD', 'Uso crítico da internet'],
            ['04', 'PC', 'Algoritmos: repetição'],
            ['04', 'PC', 'Estruturas de dados estáticas: registros e vetores'],
            ['04', 'MD', 'Codificação em formato digital'],
            ['04', 'CD', 'Direitos autorais de dados online'],
            ['04', 'CD', 'Linguagens midiáticas e tecnologias digitais'],
            ['05', 'PC', 'Algoritmos sobre estruturas dinâmicas'],
            ['05', 'PC', 'Estruturas de dados dinâmicas: listas & grafos'],
            ['05', 'MD', 'Arquitetura básica de computadores'],
            ['05', 'MD', 'Sistema operacional'],
            ['05', 'CD', 'Impactos da tecnologia digital'],
            ['05', 'CD', 'Informação online e direitos autorais'],
            ['05', 'CD', 'Mídias digitais'],
            ['05', 'CD', 'Proteção da informação em jogos online'],
            ['06', 'PC', 'Introdução à generalização'],
            ['06', 'PC', 'Linguagem visual de programação'],
            ['06', 'PC', 'Técnicas de solução de problemas: decomposição'],
            ['06', 'PC', 'Tipos de dados'],
            ['06', 'MD', 'Fundamentos de transmissão de dados'],
            ['06', 'MD', 'Proteção de dados'],
            ['06', 'CD', 'Segurança em ambientes virtuais'],
            ['06', 'CD', 'Tecnologia digital e sociedade'],
            ['06', 'CD', 'Tecnologia digital e sustentabilidade'],
            ['07', 'PC', 'Automatização'],
            ['07', 'PC', 'Estruturas de dados: registros e vetores'],
            ['07', 'PC', 'Programação: decomposição e reuso'],
            ['07', 'PC', 'Técnicas de solução de problemas: decomposição e reuso'],
            ['07', 'MD', 'Internet'],
            ['07', 'MD', 'Armazenamento de dados'],
            ['07', 'CD', 'Cyberbyllying'],
            ['07', 'CD', 'Documentação de projetos'],
            ['07', 'CD', 'Impactos da tecnologia digital'],
            ['08', 'PC', 'Estruturas de dados: listas'],
            ['08', 'PC', 'Paralelismo'],
            ['08', 'PC', 'Programação: listas e recursão'],
            ['08', 'PC', 'Técnicas de solução de problemas: recursão'],
            ['08', 'MD', 'Fundamentos de sistemas distribuídos'],
            ['08', 'CD', 'Redes sociais e segurança da informação'],
            ['09', 'PC', 'Estruturas de dados: grafos e árvores'],
            ['09', 'PC', 'Programação: generalização a grafos'],
            ['09', 'PC', 'Técnica de construção de algoritmos: Generalização'],
            ['09', 'MD', 'Segurança digital'],
            ['09', 'CD', 'Documentação'],
            ['09', 'CD', 'Uso crítico de tecnologias digitais'],
            ['EM', 'PC', 'Avaliação de algoritmos e programas'],
            ['EM', 'PC', 'Inteligência artificial e robótica'],
            ['EM', 'PC', 'Limites da computação'],
            ['EM', 'PC', 'Metaprogramação'],
            ['EM', 'PC', 'Modelagem computacional'],
            ['EM', 'PC', 'Técnica de solução de problemas: Transformação'],
            ['EM', 'PC', 'Técnica de solução de problemas: Refinamento'],
            ['EM', 'MD', 'Análise de redes'],
            ['EM', 'MD', 'Análise de segurança digital'],
            ['EM', 'MD', 'Big data'],
            ['EM', 'CD', 'Direito digital'],
            ['EM', 'CD', 'Impactos da tecnologia digital'],
            ['EM', 'CD', 'Gerência de projetos'],
            ['EM', 'MD', 'Desenvolvimento de sites'],
            ['EM', 'MD', 'Animação digital'],
            ['EM', 'PC', 'Elaboração de projetos'],
        ];
    }
}
