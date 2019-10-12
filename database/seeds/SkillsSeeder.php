<?php

use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Models\LearningObject;

class SkillsSeeder extends Seeder
{

    private $objetcs = [];

    public function run()
    {
        $this->clear();
        $this->init();
        $this->seed();
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();

        echo "\tErasing skills\n";
        DB::table('skills')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function init()
    {
        $this->objetcs = LearningObject::all()->keyBy('ref');
    }

    private function seed()
    {
        $skills = $this->getSkills();
        $sequential = 0;
        foreach ($skills as $s) {

            $object = $this->objetcs[$s[0]];
            $sequential++;

            $skill = new Skill();
            $skill->code = $object->ref . str_pad($sequential, 3, '0', STR_PAD_LEFT);
            $skill->name = $s[1];
            $skill->sequential_number = $sequential;
            $skill->age_group_id = $object->age_group_id;
            $skill->learning_object_id = $object->id;
            $skill->save();


            echo "\tSkill '{$skill->code}' created.\n";
        }
    }

    private function getSkills()
    {
        return [
            ['01PCORGA', "Organizar objetos concretos de maneira lógica utilizando diferentes atributos gor exemglo: cor, tamanho, forma, texturas, detalhes, etc.)."],
            ['01PCALGO', "Compreender a necessidade de algortimos para resolver problemas"],
            ['01PCALGO', "Compreender a definição de algoritmos resolvendo problemas passo-a-passo (exemplos: construção de origamis, orientação espacial, execução de uma receita, etc.)."],
            ['01MDMAQU', "Nomear dispositivos capazes de computar (desktop, notebook, tablet, smartphone, drone, etc.) e identificar e descrever a função de dispositivos de entrada e saída (monitor, teclado, mouse, impressora, microfone, etc.)."],
            ['01MDINFO', "Compreender o conceito de informação, a importância da descrição da informação (usando linguagem oral, textos, imagens, sons, números, etc) e a necessidade de armazená-Ia e transmiti-la para a comunicação."],
            ['01MDCODI', "Representar informação usando símbolos ou códigos escolhidos"],
            ['01MDPROT', "Compreender a necessidade de proteção da informação. Por exemplo, usar senhas adequadas para proteger apareihos e informações de acessos indevidos"],
            ['02PCIDEN', "Identificar padrões de comportamento (exemplos: jogar jogos, rotinas do dia-a-dia, etc.)."],
            ['02PCALGO', "Definir e simular algoritmos (descritos em linguagem natural ou pictográfica) construidos como sequências e repetições simples de um conjunto de instruções básicas (avance, vire à direita, vire à esquerda, etc.)."],
            ['02PCALGO', "Elaborar e escrever histórias a partir de um conjunto de cenas."],
            ['02PCMODE', "Criar e comparar modelos de objetos identificando padrões e atributos essenciais (exemplos: veiculos terrestres, construções habitacionais, etc.)."],
            ['02MDNOCA', "Compreender que maquinas executam instruções, crlar arte-rentes conjuntos de instruções e construir programas simples com elas."],
            ['02MDHARD', "Diferenciar hardware (componentes físicos) e software (programas que fomecem as instruções para o hardware)"],
            ['03PCDEFI', "Identificar problemas cuja solução é um processo (algoritmo), deﬁnindo os através de suas entradas (recursos/insumos) e saídas esperadas."],
            ['03PCINTR', "Compreender o conjunto dos valores verdade e as operações básicas sobre eles (operações lógicas)."],
            ['03PCALGO', "Definir e executar algoritmos que incluam sequências, repetições simples (iteração deﬁnida) e seleções (descritos em linguagem natural e/ou pictografica) para realizar uma tarefa, de forma independente e em colaboração."],
            ['03MDDADO', "Relacionar o conceito de informação com o de dado (dado é a informação armazenada em um dispositivo capaz de computar)"],
            ['03MDALGO', "Reconhecer o espaço de dados de um indivíduo, organização ou estado e que este espaço pode estar em diversas mídias"],
            ['03MDALGO', "Compreender que existem formatos específicos para armazenar diferentes tipos de informação (textos, figuras, sons, números, etc.)"],
            ['03MDINTE', "Compreender que para se comunicar e realizar tarefas o computador utiliza uma interface física: o computador reage a estímulos do mund exterior enviados através de seus dispositivos de entrada (teclado, mouse, microfone, sensores, antena, etc.) e comunica as reações através de dispositivos de saída (monitor, alto-falante, antena, etc.)"],
            ['04PCESTR', "Compreender que a organização dos dados facilita a sua manipulação (exemplo: verificar que um baralho está completo dividindo por naipes, e seguida ordenando)"],
            ['04PCESTR', "Dominar o conceito de estruturas de dados estáticos homogêneos (vetores) através da realização de experiências com materiais concretos (por exemplo, jogo da senha para vetores unidimensionais, batalha naval para matrizes)"],
            ['04PCESTR', "Dominar o conceito de estruturas de dados estáticos heterogêneos (registros) através da realização de experiências com materiais concretos."],
            ['04PCESTR', "Utilizar uma representação visual para as abstrações computacionais estáticas (registros e vetores)."],
            ['04PCALGO', "Definir e executar algoritmos que incluem sequências e repetições (iterações definidas e indefinidas, simples e aninhadas) para realizar uma tarefa, de forma independente e em colaboração."],
            ['04PCALGO', "Simular, analisar e depurar algoritmos incluindo sequências, seleções 9 repetições, e também algoritmos utilizando estruturas de dados asiáticas"],
            ['04MDCODI', "Compreender que para guardar, manipular e transmitir dados precisamos codifica-los de alguma forma que seja compreendida pela máquina (formato digital)"],
            ['04MDCODI', "Codificar diferentes informações para representação em computador (binária, ASCII, atributos de pixel, como RGB, etc.). Em particular, na representação de números discutir representação decimal, binária, etc."],
            ['05PCESTR', "Entender o que são estruturas dinâmicas e sua utilidade pararepresentar informação."],
            ['05PCESTR', "Conhecer o conceito de listas, sendo capaz de Identificar instâncias do mundo real e digital que possam ser representadas por listas (por exemplo, lista de chamada, ﬁla, pilha de canas, lista de supermercado, etc)"],
            ['05PCESTR', "Conhecer o conceito de grafo, sendo capaz de identificar instâncias do mundo real e digital que possam ser representadas por grafos (por exemplo, redes sociais, mapas, etc)"],
            ['05PCESTR', "Utilizar uma representação visual para as abstrações computacionais dinâmicas (listas e grafos)."],
            ['05PCALGO', "Executar e analisar algoritmos simples usando listas / grafos, de forma independente e em colaboração."],
            ['05PCALGO', "Identificar, compreender e comparar diferentes métodos (algoritmos) de busca de dados em listas (sequencial, binária, hashing, etc.)."],
            ['05MDARQU', "Identificar os componentes básicos de um computador (dispositivos de entrada! saída, processadores e armazenamento)."],
            ['05MDSIST', "Compreender relação entre hardware e software (camadas/sistema operacional) em um nível elementar."],
            ['06PCTIPO', "Reconhecer que entradas e saídas de algoritmos são elementos de tipos de dados."],
            ['06PCTIPO', "Formalizar o conceito de tipos de dados como conjuntos."],
            ['06PCINTR', "Identificar que um algoritmo pode ser uma solução genérica para um conjunto de instâncias de um mesmo problema, e usar variáveis (no sentido de parâmetros) para descrever soluções genéricas"],
            ['06PCLING', "Compreender a definição de problema como uma relação entre entrada (insumos) e saída (resultado), identificando seus tipos (tipos de dados, por exemplo, número, string, etc)."],
            ['06PCLING', "Utilizar uma linguagem visual para descrever soluções de problemas envolvendo instruções básicas de processos (composição, repetição e seleção)."],
            ['06PCLING', "Relacionar programas descritos em linguagem visual com textos precisos em português."],
            ['06PCTECN', "Identificar problemas de diversas áreas do conhecimento e criar soluções usando a técnica de decomposição de problemas."],
            ['06MDFUND', "Entender o processo de transmissão de dados: a informação é quebrada em pedaços, transmitida em pacotes através de múltiplos equipamentos, e reconstruída no destino."],
            ['06MDPROT', "Atribuir propriedade (direito sobre) aos dados de uma pessoa ou organização."],
            ['06MDPROT', "Identificar problemas de segurança de dados do mundo real e sugerir formas de proteger dados (criar senhas fortes, não compartilhar senhas, fazer backup, usar anti-virus, etc)."],
            ['07PCAUTO', "Compreender que automatizar a solução de um problema envolve tanto a definição de dados (representações abstratas da realidade) quanto do processo (algoritmo)"],
            ['07PCESTR', "Formalizar o conceito de registros e vetores"],
            ['07PCTECN', "Criar soluções para problemas envolvendo a definição de dados usando estruturas estáticas (registros e vetores) e algoritmos e sua implementação em uma linguagem de programação"],
            ['07PCTECN', "Depurar a solução de um problema para detectar possíveis erros e garantir sua corretude."],
            ['07PCPROG', "Identificar subproblemas comuns em problemas maiores e a possibilidade do reuso de soluções."],
            ['07PCPROG', "Colaborar e cooperar na proposta e execução de soluções algorítmicas utilizando decomposição e reuso no processo de solução."],
            ['07MDINTE', "Entender como é a estrutura e funcionamento da intemet"],
            ['07MDINTE', "Compreender a passagem da sociedade de um modelo de poucas fontes de informação acreditadas para um modelo de fragmentação de fontes e desconhecimento de sua qualidade"],
            ['07MDINTE', "Analisar fontes de informação e a existência de conteúdos inadequados"],
            ['07MDARMA', "Compreender e utilizar diferentes formas de armazenamento de dados (sistemas de arquivos, nuvens de dados, etc.)."],
            ['08PCESTR', "Formalizar o conceito de listas de tamanho indeterminado (listas dinâmicas)."],
            ['08PCESTR', "Conhecer algoritmos de manipulação e pesquisa sobre listas."],
            ['08PCTECN', "Identificar o conceito de recursão em diversas áreas (Artes, Literatura, Matemática, etc.)."],
            ['08PCTECN', "Empregar o conceito de recursão, para a compreensão mais profunda da técnica de solução através de decomposição de problemas."],
            ['08PCPROG', "Identificar problemas de diversas áreas e criar soluções, de forma individual e colaborativa, usando algoritmos sobre listas e recursão"],
            ['08PCPARA', "Compreender o conceito de paralelismo, identificando partes de uma tarefa que podem ser realizadas concomitantemente."],
            ['08MDFUND', "Compreender os conceitos de armazenamento e processamento distribuídos, e suas vantagens."],
            ['08MDFUND', "Compreender o papel de protocolos para a transmissão de dados"],
            ['09PCESTR', "Formalizar os conceitos de grafo e árvore."],
            ['09PCESTR', "Conhecer algoritmos básicos de tratamento das estruturas árvores e grafos."],
            ['09PCTECN', "Identificar problemas similares e a possibilidade do reuso de soluções, usando a técnica de generalização."],
            ['09PCPROG', "Construir soluções de problemas usando a técnica de generalização, permitindo o reuso de soluções de problemas em outros contextos, aperfeiçoando e articulando saberes escolares."],
            ['09PCPROG', "Identificar problemas de diversas áreas do conhecimento e criar soluções, de forma individual e colaborativa, através de programas de computador usando grafos e árvores."],
            ['09MDSEGU', "Compreender o funcionamento de vírus, malware e outros ataques a dados"],
            ['09MDSEGU', "Analisar técnicas de criptografia para transmissão de dados segura"],
            ['EMPCTRAN', "Compreender a técnica de solução de problemas através de transformações: comparar problemas para reusar soluções."],
            ['EMPCREFI', "Compreender a técnica de solução de problemas através de refinamentos: utiliza diversos níveis de abstração no processo de construção de soluções."],
            ['EMPCAVAL', "Analisar algoritmos quanto ao seu custo (tempo, espaço, energia, ...) para justificar a adequação das soluções a requisitos e escolhas entre diferentes soluções."],
            ['EMPCAVAL', "Argumentar sobre a correção de algoritmos, permitindo justiﬁcar que uma solução de fato resolve o problema proposto"],
            ['EMPCAVAL', "Avaliar programas e projetos feitos por outras equipes com relação a qualidade, usabilidade, facilidade de leitura, questões éticas, etc."],
            ['EMPCMETA', "Reconhecer o conceito de metaprogramação como uma forma de generalização, que permite que algoritmos tenham como entrada (ou saída) outros algoritmos."],
            ['EMPCLIMI', "Entender os limites da Computação para diferenciar o que pode ou não ser mecanizado, buscando uma compreensão mais ampla dos processos mentais envolvidos na resolução de problemas."],
            ['EMPCMODE', "Criar modelos computacionais para simular e fazer predições sobre diferentes fenômenos e processos."],
            ['EMPCINTE', "Compreender os fundamentos da inteligência artificial e da robótica"],
            ['EMMDREDE', "Avaliar a escalabilidade e confiabilidade de redes, compreendendo as noções dos diferentes equipamentos envolvidos (como roteadores, switchs, etc) bem como de topologia, endereçamento, latência, banda, carga, delay"],
            ['EMMDDIGI', "Comparar medidas de segurança digital, considerando o equilíbrio entre usabilidade e segurança"],
            ['EMMDBIG',  "Entender o conceito de Big Data e utilizar ferramentas para representar, manipular e visualizar dados massivos"],
            ['EMMDDESE', "Criar e manter sites e blogs com conteúdo individual e/ou coletivo"],
            ['EMMDANIM', "Produzir animações digitais"],
            ['EMCDIMPA', "Analisar e refletir sobre o tempo de vivencia on-line, em jogos, em redes sociais, dentre outros"],
            ['EMCDIMPA', "Reconhecer a influência dos avanços tecnológicos no surgimento de novas  atividades profissionais"],
            ['EMCDDIRE', "Compreender o direito digital e suas relações com o cotidiano do universo digital"],
            ['EMCDGERE', "Gerenciar projetos digitais colaborativos usando computação em nuvem "],
            ['EMPCELAB', "Elaborar e executar projetos integrados às áreas de conhecimento curriculares, em equipes, solucionando problemas, usando computadores, celulares, e outras máquinas processadoras de instruções."],
            ['01CDINTR', "Reconhecer e explorar tecnologias digitais"],
            ['01CDINTR', "Reconhecer a relação entre idades e usos em meio digital"],
            ['01CDINTR', "Identificar a presença de tecnologia digital no cotidiano"],
            ['02CDUSO',  "Interagir com as diferentes mídias"],
            ['02CDUSO',  "Produzir textos curtos em meio digital"],
            ['02CDUSO',  "Realizar pesquisas na internet"],
            ['02CDIMPA', "Reconhecer e analisar a apropriação da tecnologia digital pela família e  pelos alunos no dia a dia"],
            ['02CDIMPA', "Analisar e refletir sobre as trilhas de impressões no meio digital"],
            ['03CDFLUE', "Investigar e experimentar novos formatos de leitura da realidade"],
            ['03CDFLUE', "Pesquisar, acessar e reter informações de diferentes fontes digitais para  autoria de documentos"],
            ['03CDFLUE', "Usar software educacional"],
            ['03CDUSO',  "Apresentar julgamento apropriado quando da navegação em sites  diversos"],
            ['03CDRAST', "Compreender trilhas de impressões em meio digital deixadas pelas  pessoas em jogos on-line, bem como a presença de pessoas de  várias  idades no mesmo ambiente"],
            ['03CDTECN', "Relacionar o uso da tecnologia digital com as questões socioeconômicas  locais e regionais"],
            ['04CDLING', "Expressar-se usando tecnologias digitais"],
            ['04CDLING', "Agregar diferentes conhecimentos para explorar linguagens midiáticas"],
            ['04CDLING', "Usar recursos midiáticos para agrupar informações para apresentações"],
            ['04CDLING', "Usar simuladores educacionais"],
            ['04CDDIRE', "Reconhecer e refletir sobre direitos autorais"],
            ['04CDDIRE', "Demonstrar postura apropriada nas atividades de coleta, transferência, guarda e uso de dados, considerando suas fontes"],
            ['05CDMIDI', "Utilizar compactadores de arquivos"],
            ['05CDMIDI', "Integrar os diferentes formatos de arquivos"],
            ['05CDMIDI', "Experimentar as mídias digitais e suas convergências"],
            ['05CDINFO', "Distinguir informações verdadeiras das falsas, conteúdos bons dos prejudiciais, e conteúdos confiáveis"],
            ['05CDINFO', "Citar fonte e materiais utilizados, levando em consideração o respeito à privacidade dos usuários e as restrições pertinentes"],
            ['05CDPROT', "Reconhecer e refletir sobre os jogos on-line e as informações do usuário"],
            ['05CDIMPA', "Expressar-se critica e criativamente na compreensão das mudanças tecnológicas no mundo do trabalho e sobre a evolução da sociedade"],
            ['06CDSEGU', "Aplicar protocolos de segurança e privacidade em ambientes virtuais"],
            ['06CDSOCI', "Apresentar conduta e linguagem apropriadas ao se comunicar em  ambiente digital, considerando a ética e o respeito"],
            ['06CDSOCI', "Analisar problemas sociais de sua cidade e estado a partir de ambientes  digitais, propondo soluções"],
            ['06CDSUST', "Analisar as tomadas de decisão sobre usos da tecnologia digital e suas  relações com a sustentabilidade"],
            ['06CDSUST', "Comparar sistemas de informação do passado e do presente,  considerando questões de sustentabilidade econômica, política e social"],
            ['07CDDOCU', "Documentar e sequenciar tarefas em uma atividade ou projeto"],
            ['07CDCYBE', "Demonstrar empatia sobre opiniões divergentes na web"],
            ['07CDCYBE', "Identificar e refletir sobre cyberbullying, propondo ações"],
            ['07CDIMPA', "Compreender os impactos ambientais do descarte de peças de computadores e eletrônicos, bem como sua relação com a sustentabilidade de forma mais ampla"],
            ['07CDIMPA', "Analisar o papel da industrialização e dos avanços da tecnologia digital e sua relação com as mudanças na sociedade"],
            ['08CDREDE', "Compartilhar informações por meio de redes sociais"],
            ['08CDREDE', "Compreender e analisar a vivencia em redes sociais, em especial sobre as responsabilidades e os perigos dos ambientes virtuais"],
            ['08CDREDE', "Distinguir os tipos de dados pessoais que são solicitados em espaços digitais e os riscos associados"],
            ['08CDREDE', "Reconhecer e analisar os problemas de segurança de dados pessoais"],
            ['08CDREDE', "Analisar e refletir sobre as políticas de termos de uso das redes sociais"],
            ['09CDDOCU', "Criar documentação, conteúdo e propaganda de uma solução digital"],
            ['09CDUSO',  "Avaliar a escolha e o uso de tecnologias digitais pelo ser humano em seu cotidiano"],
        ];
    }
}
