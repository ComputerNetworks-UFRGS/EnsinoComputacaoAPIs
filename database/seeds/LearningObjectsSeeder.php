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
            $learningObject->ref = $obj[2];
            $learningObject->name = $obj[3];
            $learningObject->save();

            echo "\tObject '{$learningObject->name}' created.\n";
        }
    }

    private function getObjects()
    {
        return [
            ['01', 'PC', '01PCALGO', 'Algoritmos: definição'],
            ['01', 'PC', '01PCORGA', 'Organização de objetos'],
            ['01', 'MD', '01MDCODI', 'Códigos'],
            ['01', 'MD', '01MDINFO', 'Informação'],
            ['01', 'MD', '01MDMAQU', 'Máquina: Terminologia & uso de dispositivos computacionais'],
            ['01', 'MD', '01MDPROT', 'Proteção de informação'],
            ['01', 'CD', '01CDINTR', 'Introdução à tecnologia digital'],
            ['02', 'PC', '02PCALGO', 'Algoritmos: construção e simulação'],
            ['02', 'PC', '02PCIDEN', 'Identificação de padrões de comportamento'],
            ['02', 'PC', '02PCMODE', 'Modelos de objetos'],
            ['02', 'MD', '02MDHARD', 'Hardware e software'],
            ['02', 'MD', '02MDNOCA', 'Noção de instrução de máquina'],
            ['02', 'CD', '02CDIMPA', 'Impacto de tecnologia digital no dia a dia'],
            ['02', 'CD', '02CDUSOB', 'Uso básico de tecnologia digital'],
            ['03', 'PC', '03PCALGO', 'Algoritmos: seleção'],
            ['03', 'PC', '03PCDEFI', 'Definição de problemas'],
            ['03', 'PC', '03PCINTR', 'Introdução à lógica'],
            ['03', 'MD', '03MDALGO', 'Algoritmos: entradas e saídas'],
            ['03', 'MD', '03MDDADO', 'Dado'],
            ['03', 'MD', '03MDINTE', 'Interface'],
            ['03', 'CD', '03CDFLUE', 'Fluência digital'],
            ['03', 'CD', '03CDRAST', 'Rastro digital'],
            ['03', 'CD', '03CDTECN', 'Tecnologia digital, economia e sociedade'],
            ['03', 'CD', '03CDUSOC', 'Uso crítico da internet'],
            ['04', 'PC', '04PCALGO', 'Algoritmos: repetição'],
            ['04', 'PC', '04PCESTR', 'Estruturas de dados estáticas: registros e matrizes'],
            ['04', 'MD', '04MDCODI', 'Codificação em formato digital'],
            ['04', 'CD', '04CDDIRE', 'Direitos autorais de dados online'],
            ['04', 'CD', '04CDLING', 'Linguagens midiáticas e tecnologias digitais'],
            ['05', 'PC', '05PCALGO', 'Algoritmos sobre estruturas dinâmicas'],
            ['05', 'PC', '05PCESTR', 'Estruturas de dados dinâmicas: listas & grafos'],
            ['05', 'MD', '05MDARQU', 'Arquitetura básica de computadores'],
            ['05', 'MD', '05MDSIST', 'Sistema operacional'],
            ['05', 'CD', '05CDIMPA', 'Impactos da tecnologia digital'],
            ['05', 'CD', '05CDINFO', 'Informação online e direitos autorais'],
            ['05', 'CD', '05CDMIDI', 'Mídias digitais'],
            ['05', 'CD', '05CDPROT', 'Proteção da informação em jogos online'],
            ['06', 'PC', '06PCINTR', 'Introdução à generalização'],
            ['06', 'PC', '06PCLING', 'Linguagem visual de programação'],
            ['06', 'PC', '06PCTECN', 'Técnicas de solução de problemas: decomposição'],
            ['06', 'PC', '06PCTIPO', 'Tipos de dados'],
            ['06', 'MD', '06MDFUND', 'Fundamentos de transmissão de dados'],
            ['06', 'MD', '06MDPROT', 'Proteção de dados'],
            ['06', 'CD', '06CDSEGU', 'Segurança em ambientes virtuais'],
            ['06', 'CD', '06CDSOCI', 'Tecnologia digital e sociedade'],
            ['06', 'CD', '06CDSUST', 'Tecnologia digital e sustentabilidade'],
            ['07', 'PC', '07PCAUTO', 'Automatização'],
            ['07', 'PC', '07PCESTR', 'Estruturas de dados: registros e vetores'],
            ['07', 'PC', '07PCPROG', 'Programação: decomposição e reuso'],
            ['07', 'PC', '07PCTECN', 'Técnicas de solução de problemas: decomposição e reuso'],
            ['07', 'MD', '07MDINTE', 'Internet'],
            ['07', 'MD', '07MDARMA', 'Armazenamento de dados'],
            ['07', 'CD', '07CDCYBE', 'Cyberbyllying'],
            ['07', 'CD', '07CDDOCU', 'Documentação de projetos'],
            ['07', 'CD', '07CDIMPA', 'Impactos da tecnologia digital'],
            ['08', 'PC', '08PCESTR', 'Estruturas de dados: listas'],
            ['08', 'PC', '08PCPARA', 'Paralelismo'],
            ['08', 'PC', '08PCPROG', 'Programação: listas e recursão'],
            ['08', 'PC', '08PCTECN', 'Técnicas de solução de problemas: recursão'],
            ['08', 'MD', '08MDFUND', 'Fundamentos de sistemas distribuídos'],
            ['08', 'CD', '08CDREDE', 'Redes sociais e segurança da informação'],
            ['09', 'PC', '09PCESTR', 'Estruturas de dados: grafos e árvores'],
            ['09', 'PC', '09PCPROG', 'Programação: generalização a grafos'],
            ['09', 'PC', '09PCTECN', 'Técnica de construção de algoritmos: Generalização'],
            ['09', 'MD', '09MDSEGU', 'Segurança digital'],
            ['09', 'CD', '09CDDOCU', 'Documentação'],
            ['09', 'CD', '09CDUSOC', 'Uso crítico de tecnologias digitais'],
            ['EM', 'PC', 'EMPCAVAL', 'Avaliação de algoritmos e programas'],
            ['EM', 'PC', 'EMPCINTE', 'Inteligência artificial e robótica'],
            ['EM', 'PC', 'EMPCLIMI', 'Limites da computação'],
            ['EM', 'PC', 'EMPCMETA', 'Metaprogramação'],
            ['EM', 'PC', 'EMPCMODE', 'Modelagem computacional'],
            ['EM', 'PC', 'EMPCTRAN', 'Técnica de solução de problemas: Transformação'],
            ['EM', 'PC', 'EMPCREFI', 'Técnica de solução de problemas: Refinamento'],
            ['EM', 'MD', 'EMMDREDE', 'Análise de redes'],
            ['EM', 'MD', 'EMMDDIGI', 'Análise de segurança digital'],
            ['EM', 'MD', 'EMMDBIGD', 'Big data'],
            ['EM', 'CD', 'EMCDDIRE', 'Direito digital'],
            ['EM', 'CD', 'EMCDIMPA', 'Impactos da tecnologia digital'],
            ['EM', 'CD', 'EMCDGERE', 'Gerência de projetos'],
            ['EM', 'MD', 'EMMDDESE', 'Desenvolvimento de sites'],
            ['EM', 'MD', 'EMMDANIM', 'Animação digital'],
            ['EM', 'PC', 'EMPCELAB', 'Elaboração de projetos'],
        ];
    }
}
