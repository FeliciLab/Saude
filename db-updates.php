<?php

use function MapasCulturais\__exec;

$app = MapasCulturais\App::i();
$em = $app->em;
$conn = $em->getConnection();

return array(
    'insert taxo agents saúde' => function () use($conn){
        
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_graus_academicos', 'Técnico');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_graus_academicos', 'Graduação');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_graus_academicos', 'Especialização');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_graus_academicos', 'MBA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_graus_academicos', 'Mestrado');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_graus_academicos', 'Doutorado');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_graus_academicos', 'Pós-doutorado');");

            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Assistência direta ao paciente');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Apoio diagnóstico ou terapêutico');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Apoio técnico');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Administração e gestão');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Pronto-socorro');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Ambulatório');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Centro cirúrgico');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Centro obstétrico');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Internação');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'UTI');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Outro setor ou serviço de assistência direta ao paciente');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Laboratório clínico');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Diagnóstico por imagem');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Hemodinâmica ou cardiologia intervencionista');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Nefrologia ou terapia renal substitutiva');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Outro setor ou serviço de apoio diagnóstico e terapêutico');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Triagem e acolhimento');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Acolhimento psicossocial');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Alimentação e assistência nutricional e dietética');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Farmácia e assistência farmacêutica');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Fisioterapia fonoaudiologia e terapia ocupacional');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Esterilização de materiais');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Arquivo médico e estatística');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Epidemiologia vigilância epidemiológica e registro de óbito');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Outro setor ou serviço de apoio técnico');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Gestão estratégica');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Regulação contas hospitalares e gestão de riscos');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Gestão de pessoas');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Formação ou qualificação profissional');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Estágio profissional');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Residência médica ou multiprofissional');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Saúde e segurança do trabalho');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Apoio administrativo');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Higiene e limpeza');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Transporte e segurança');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Materiais e suprimentos');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Manutenção e reparos');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_setor_atuacao', 'Outro setor ou serviço de apoio administrativo');");
    },

    'insert taxo spaces saúde' => function () use($conn){
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRAL DE ABASTECIMENTO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRAL DE GESTÃO EM SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRAL DE NOTIFICACÃO,CAPTACÃO E DISTRIB DE ORGÃOS ESTADUAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRAL DE REGULAÇÃO DE SERVIÇOS DE SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRAL DE REGULAÇÃO DO ACESSO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRAL DE REGULAÇÃO MEDICA DAS URGÊNCIAS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRO DE APOIO A SAÚDE DA FAMÍLIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRO DE ATENÇÃO HEMOTERAPIA E OU HEMATOLOGICA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRO DE ATENÇÃO PSICOSSOCIAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRO DE IMUNIZAÇÃO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRO DE PARTO NORMAL - ISOLADO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CENTRO DE SAÚDE/UNIDADE BÁSICA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CLINICA/CENTRO DE ESPECIALIDADE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'CONSULTÓRIO ISOLADO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'COOPERATIVA OU EMPRESA DE CESSAO DE TRABALHADORES NA SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'FARMÁCIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'HOSPITAL/DIA - ISOLADO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'HOSPITAL ESPECIALIZADO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'HOSPITAL GERAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'LABORATORIO CENTRAL DE SAÚDE PUBLICA LACEN');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'LABORATORIO DE SAÚDE PUBLICA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'OFICINA ORTOPEDICA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'POLICLINICA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'POLO ACADEMIA DA SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'POLO DE PREVENCAO DE DOENÇAS E AGRAVOS E PROMOCAO DA SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'POSTO DE SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'PRONTO ATENDIMENTO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'PRONTO SOCORRO ESPECIALIZADO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'PRONTO SOCORRO GERAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'SERVIÇO DE ATENÇÃO DOMICILIAR ISOLADO(HOME CARE)');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'TELESSAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'UNIDADE DE APOIO DIAGNOSE E TERAPIA (SADT ISOLADO)');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'UNIDADE DE ATENÇÃO A SAÚDE INDIGENA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'UNIDADE DE VIGILÂNCIA EM SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'UNIDADE MISTA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'UNIDADE MÓVEL DE NIVEL PRE-HOSPITALAR NA AREA DE URGÊNCIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_unidades', 'UNIDADE MÓVEL TERRESTRE');");

            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_gestao', 'DUPLA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_gestao', 'ESTADUAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_tipos_gestao', 'MUNICIPAL');");

            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ATENÇÃO A DOENÇA RENAL CRÔNICA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ATENÇÃO A SAÚDE DE POPULAÇÕES INDIGENAS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ATENÇÃO A SAÚDE NO SISTEMA PENITENCIARIO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ATENÇÃO AS PESSOAS EM SITUAÇÃO DE VIOLÊNCIA SEXUAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ATENÇÃO BÁSICA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ATENÇÃO EM UROLOGIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ATENDIMENTO ITINERANTE DE ASSISTÊNCIA E ENSINO EM SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'CIRURGIA VASCULAR');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'COMISSÕES E COMITÊS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'CONSULTÓRIO NA RUA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ESTRATÉGIA DE AGENTES COMUNITÁRIOS DE SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'ESTRATÉGIA DE SAÚDE DA FAMÍLIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'HOSPITAL DIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'IMUNIZAÇÃO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'LOGÍSTICA DE IMUNOBIOLÓGICOS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'MEDICINA NUCLEAR');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'REGULAÇÃO DO ACESSO A AÇÕES E SERVIÇOS DE SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE APOIO A SAÚDE DA FAMÍLIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO A DST/HIV/AIDS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO A OBESIDADE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO AO PACIENTE COM TUBERCULOSE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO AO PRÉ-NATAL, PARTO E NASCIMENTO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO A SAÚDE AUDITIVA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO A SAÚDE DOS ADOLESCENTES EM CONFLITO COM');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO A SAÚDE DO TRABALHADOR');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO A SAÚDE REPRODUTIVA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO CARDIOVASCULAR / CARDIOLOGIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO DOMICILIAR');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO EM NEUROLOGIA / NEUROCIRURGIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO EM SAÚDE BUCAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO INTEGRAL EM HANSENÍASE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENÇÃO PSICOSSOCIAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ATENDIMENTO MÓVEL DE URGÊNCIAS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE BANCO DE TECIDOS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE CIRURGIA REPARADORA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE CIRURGIA TORÁCICA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE CONTROLE DE TABAGISMO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE CUIDADOS INTERMEDIÁRIOS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE DIAGNOSTICO DE LABORATORIO CLINICO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE DIAGNOSTICO POR ANATOMIA PATOLÓGICA EOU CITOPATO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE DIAGNOSTICO POR IMAGEM');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE DIAGNOSTICO POR MÉTODOS GRÁFICOS DINÂMICOS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE DISPENSACAO DE ÓRTESES PRÓTESES E MATERIAIS ESPE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ENDOCRINOLOGIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ENDOSCOPIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE FARMÁCIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE FISIOTERAPIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE HEMOTERAPIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE LABORATORIO DE HISTOCOMPATIBILIDADE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE LABORATORIO DE PROTESE DENTARIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE OFTALMOLOGIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ONCOLOGIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE ÓRTESES, PRÓTESES E MAT ESPECIAIS EM REABILITAÇÃO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE PNEUMOLOGIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE PRÁTICAS INTEGRATIVAS E COMPLEMENTARES');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE REABILITAÇÃO');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE SUPORTE NUTRICIONAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE TERAPIA INTENSIVA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE TRAUMATOLOGIA E ORTOPEDIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE TRIAGEM NEONATAL');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE URGÊNCIA E EMERGÊNCIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE VIDEOLAPAROSCOPIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO DE VIGILÂNCIA EM SAÚDE');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'SERVIÇO POSTO DE COLETA DE MATERIAIS  BIOLÓGICOS');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'TELECONSULTORIA');");
            $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('instituicao_servicos', 'TRANSPLANTE');");
    },

    'insert taxo opportunity saúde' => function () use($conn){
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Concurso');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Conferência');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Congresso');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Convenção');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Curso');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Edital');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Encontro');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Exposição');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Feira');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Fórum');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Mostra');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Oficina');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Palestra');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Reunião');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Simpósio');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('opportunity_taxonomia', 'Workshop');");

    },
    
    'insert taxo project saúde' => function () use($conn){
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_taxonomia', 'Cezoa Davar');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_taxonomia', 'Lorem ipsum pulvinar');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_taxonomia', 'Lorem rutrum himenaeos');");
    },

    'insert taxo project_type saúde' => function () use($conn){
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Concurso');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Conferência');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Congresso');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Convenção');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Curso');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Edital');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Encontro');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Exposição');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Feira');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Fórum');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Mostra');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Oficina');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Palestra');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Reunião');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Simpósio');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('project_type', 'Workshop');");
    },

    'size type agent relation column' => function () use($conn){
        $conn->executeQuery("ALTER TABLE public.agent_relation ALTER COLUMN type TYPE varchar(200);");
    },

    'insert categorias profissionais para profissionais' => function () use($conn) {
        $conn->executeQuery("DELETE FROM public.term WHERE taxonomy = 'profissionais_categorias_profissionais';");

        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Administração');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Artes e Design');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Ciências Exatas e Informática');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Ciências Sociais e Humanas');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Comunicação e Informação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Engenharias');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Meio Ambiente');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Saúde e Bem-Estar');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_categorias_profissionais', 'Outra');");
    },

    'insert especialidades para profissionais' => function () use($conn) {
        $conn->executeQuery("DELETE FROM public.term WHERE taxonomy = 'profissionais_especialidades';");

        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Acupuntura');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Alergia e imunologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Anestesiologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Angiologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cardiologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia cardiovascular');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia da mão');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia de cabeça e pescoço');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia do aparelho digestivo');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia geral');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia oncológica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia pediátrica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia plástica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia torácica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cirurgia vascular');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Clínica médica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Coloproctologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Dermatologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Endocrinologia e metabologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Endoscopia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gastroenterologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Genética médica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Geriatria');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ginecologia e obstetrícia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Hematologia e hemoterapia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Homeopatia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Infectologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Mastologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina de emergência');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina de família e comunidade');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina do trabalho');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina de tráfego');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina esportiva');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina física e reabilitação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina intensiva');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina legal e perícia médica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina nuclear');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina preventiva e social');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Nefrologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Neurocirurgia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Neurologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Nutrologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Oftalmologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Oncologia clínica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ortopedia e traumatologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Otorrinolaringologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Patologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Patologia clínica/medicina laboratorial');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Pediatria');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Pneumologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Psiquiatria');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Radiologia e diagnóstico por imagem');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Radioterapia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Reumatologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Urologia');");

        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Auditoria');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Carreira Acadêmica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Comércio');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Comércio Exterior');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Consultoria');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Controladoria');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Controle de Produção');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão Ambiental');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão de Informações');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão de Marketing');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão de Processos');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão de Recursos Humanos');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão Financeira');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Logística');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Pesquisa de Mercado');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Planejamento Estratégico');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Arquitetura e Urbanismo');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Artes Cênicas');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Artes Plásticas');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Dança');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Desenho de Interiores');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Desenho Industrial');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Design de Experiência de Usuário');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Design Gráfico');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Fotografia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Moda');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Música');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Análise e Desenvolvimento de Sistemas');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Astronomia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciência da Computação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciência e Tecnologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciências Matemáticas e da Terra');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Computação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Estatística');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Física');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão da Tecnologia da Informação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Informática Biomédica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Matemática');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Nanotecnologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Química');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Redes de Computadores');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Sistemas de Informação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Sistemas para Internet');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Tecnologias da Informação e Comunicação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Arqueologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciências Sociais');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Direito');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Estudos Literários');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Filosofia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Geografia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'História');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Letras');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Pedagogia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Relações Internacionais');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Serviço Social');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Teologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Arquivologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Biblioteconomia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cinema e Audiovisual / Produção audiovisual');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Comunicação Assistiva');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Comunicação Institucional');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Educomunicação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Estudos de Mídia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Eventos');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão da Informação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Jornalismo');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Linguística');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Multimídia / Produção Multimídia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Museologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Produção Cultural');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Produção Editorial');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Produção Fonográfica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Publicidade e Propaganda / Produção Publicitária');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Rádio e TV');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Relações Públicas');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Secretariado Executivo / Secretariado');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Tradutor e Intérprete');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Acústica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Aeronáutica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Agrícola');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Ambiental');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Biomédica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Cartográfica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Civil');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia da Computação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Agrimensura');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Alimentos');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Aquicultura');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Controle e Automação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Energia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Horticultura');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Materiais');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Minas');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Pesca');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Petróleo e Gás');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Produção');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Segurança do Trabalho');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Telecomunicações');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Elétrica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia em Tecnologia Têxtil e Indumentária');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Física');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Industrial');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Mecatrônica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Mecânica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Metalúrgica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Naval');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Química');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Sanitária');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Agronomia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Aquicultura');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Biocombustíveis');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Bioquímica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciência e Tecnologia de Alimentos');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciências Agrárias');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciências Biológicas');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciências Naturais');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ecologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Ambiental e Sanitária');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Biossistemas');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia de Pesca e Aquicultura');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Florestal');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Engenharia Hídrica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Geofísica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Geologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Irrigação e Drenagem');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Meteorologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Oceanografia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Produção Sucroalcooleira');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Saneamento Ambiental');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Silvicultura');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Biologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Biologia Marinha');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Biomedicina');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Botânica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciências Ambientais');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciências da Saúde');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciências do Meio Aquático');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Educação Física');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Enfermagem');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Fisioterapia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Fonoaudiologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gerontologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Medicina Veterinária');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Microbiologia e Imunologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Naturologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Neurociência');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Nutrição');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Odontologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Quiropraxia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Psicologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Saúde Coletiva');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Terapia ocupacional');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Zootecnia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Biotecnologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Ciência dos Alimentos');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Cosmetologia');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Drenagem e Irrigação');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Estética');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão Desportiva e de Lazer');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Gestão Hospitalar');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Oftálmica');");
        $conn->executeQuery("INSERT INTO public.term (taxonomy, term) VALUES('profissionais_especialidades', 'Sistemas Biomédicos');");
    },

    'add preliminary registration' => function () use($conn) {
        //
        $conn->executeQuery("ALTER TABLE public.registration ADD preliminary_result character varying(255)");
     },

    'migra preliminary_result para metadado da inscricao'=> function () use($conn) {
        $registrations = $conn->query("SELECT id, preliminary_result FROM registration WHERE preliminary_result IS NOT NULL")->fetchAll(PDO::FETCH_OBJ);
        
        foreach($registrations as $reg) {
            $reg = (object) $reg;
            $next_id = $conn->query("select nextval('registration_meta_id_seq')")->fetch();
            __exec("INSERT INTO registration_meta (id, object_id, key, value) VALUES ({$next_id['nextval']}, {$reg->id}, 'preliminaryResult', {$reg->preliminary_result})");
        }

        __exec("ALTER TABLE public.registration DROP preliminary_result");
     },

     'create table resources' => function () use($conn) {
        //
        $conn->executeQuery("CREATE TABLE public.resources (
            id INT NOT NULL CONSTRAINT firstkey PRIMARY KEY,
            resource_text TEXT NOT NULL, 
            resource_send timestamp,
            resource_status varchar (25) DEFAULT 'Aguardando',
            resource_reply TEXT DEFAULT NULL,
            resource_date_reply timestamp,
            registration_id INT NOT NULL,
            opportunity_id INT NOT NULL,
            agent_id INT NOT NULL,
            reply_agent_id INT DEFAULT NULL
        )");

        $conn->executeQuery("ALTER TABLE ONLY resources
        ADD CONSTRAINT registration_id_fk FOREIGN KEY (registration_id) REFERENCES registration (id);
        ");

        $conn->executeQuery("ALTER TABLE ONLY resources
        ADD CONSTRAINT opportunity_id_fk FOREIGN KEY (opportunity_id) REFERENCES opportunity (id);
        ");

        $conn->executeQuery("ALTER TABLE ONLY resources
        ADD CONSTRAINT agent_id_fk FOREIGN KEY (agent_id) REFERENCES agent (id);
        ");
     },

    'create sequence resources' => function () use($conn) {
        $conn->executeQuery("CREATE SEQUENCE resources_id_seq INCREMENT BY 1 MINVALUE 1 START 1;");
    },

    'add file resources' => function () use($conn) {
        $conn->executeQuery("ALTER TABLE public.resources ADD resources_file character varying(255)");
    },

    'add resources_reply_publish' => function () use($conn) {
        $conn->executeQuery("ALTER TABLE public.resources  ADD resources_reply_publish boolean ");
    },

    'create table examination_room' => function () use($conn) {
        //
        $conn->executeQuery("CREATE TABLE public.examination_room (
            registration_id INT NOT NULL,
            agent_cpf TEXT NOT NULL,
            room_number TEXT NOT NULL, 
            room_link TEXT NOT NULL, 
            meet_link TEXT NOT NULL, 
            examination_date DATE DEFAULT NULL,
            initial_hour TEXT DEFAULT NULL,
            final_hour DATE DEFAULT NULL
        )");

    },

    'create table professional_category' => function () use($conn) {
        //
        $conn->executeQuery("CREATE TABLE public.professional_category (
            id INT NOT NULL,
            name TEXT NOT NULL,
            create_timestamp timestamp NULL,
            update_timestamp timestamp NULL
        )");
    },

    'create sequence professional_category' => function () use($conn) {
        $conn->executeQuery("CREATE SEQUENCE professional_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1;");
    },

    'create table category_meta' => function () use($conn) {
        //
        $conn->executeQuery("CREATE TABLE public.category_meta (
            id INT NOT NULL,
            object_id integer NOT NULL,
            key VARCHAR(255) NOT NULL,
            value text,
            create_timestamp timestamp NULL,
            update_timestamp timestamp NULL
        )");
    },

    'create sequence category_meta' => function () use($conn) {
        $conn->executeQuery("CREATE SEQUENCE category_meta_id_seq INCREMENT BY 1 MINVALUE 1 START 1;");
    },

    //NOVO CAMPO DA TABELA RECURSO PARA SITUACAO DO CANDIDATO
    'add decisao_recurso' => function () use($conn) {
        $conn->executeQuery("ALTER TABLE public.resources ADD decisao_recurso INT");
    },

    'insert mask into document key value in agent_meta' => function() use ($conn) {
        $conn->executeQuery(
            "UPDATE public.agent_meta
            SET value = CASE
                            WHEN LENGTH(REGEXP_REPLACE(value, '\D','','g')) <= 11 AND LENGTH(REGEXP_REPLACE(value, '\D','','g')) <> 0 THEN
                                CONCAT(SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),1,3),'.',SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),4,3),'.',SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),7,3),'-',SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),10,2))
                            WHEN LENGTH(REGEXP_REPLACE(value, '\D','','g')) > 11 AND LENGTH(REGEXP_REPLACE(value, '\D','','g')) <> 0 THEN
                                CONCAT(SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),1,2),'.',SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),3,3),'.',SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),6,3),'/',SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),9,4),'-',SUBSTRING(REGEXP_REPLACE(value, '\D','','g'),13,2))
                        END
            WHERE key = 'documento';"
        );
    },
);
