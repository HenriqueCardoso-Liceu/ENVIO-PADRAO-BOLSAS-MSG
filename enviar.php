<?php

require 'conexao.php';

// ========== LISTA DE CURSOS ==========

$cursos = [
    1  => ['id' => '01k054ry7n9ykv01z8se76z5cw', 'name' => 'Ingles'],
    2  => ['id' => '01k054s7920k06symkzy0vd3jk', 'name' => 'Logistica'],
    3  => ['id' => '01k054sgmnmdv0zcdqzqn1b3hw', 'name' => 'Informatica Kids'],
    4  => ['id' => '01k054szmyk5wrnkapjysnmjte', 'name' => 'Desenho'],
    5  => ['id' => '01k054t7xav7xj1ham1nh6atxj', 'name' => 'Marketing Digital'],
    6  => ['id' => '01k054tg65fxqew8yqtk9twajw', 'name' => 'Auxiliar Administrativo'],
    7  => ['id' => '01k054tq8wv8n8mm9md0c1gq5n', 'name' => 'Libras'],
    8  => ['id' => '01k054v1rdyaz1cnx5wg8pk0aq', 'name' => 'Recursos Humanos'],
    9  => ['id' => '01k054vc7ngz4xqax8xkkjfr6p', 'name' => 'Administracao de Negocios'],
    10 => ['id' => '01k054vmafkpd9a1kq67bp0v5g', 'name' => 'Atendimento ao Cliente'],
    11 => ['id' => '01k054vyr3tk7wxkkv6wgz4m8w', 'name' => 'Manicure e Pedicure'],
    12 => ['id' => '01k054w6gt3cm1dawn8d2ca6ek', 'name' => 'Corte Masculino Basico'],
    13 => ['id' => '01k054wf3v6qww5bm9y4977rfm', 'name' => 'Corte Feminino Basico - Escova'],
    14 => ['id' => '01k054x3g62c2tqcbpanydqvh0', 'name' => 'Design de Sobrancelhas'],
    15 => ['id' => '01k054xrwj676a9pbz8shmdawb', 'name' => 'Automaquiagem para o Dia'],
    16 => ['id' => '01k054y4g6agr7hgnkqhryqxnh', 'name' => 'Massagem Relaxante'],
    17 => ['id' => '01k054yevgfgang3gfw3fayhcb', 'name' => 'Gel na Tips'],
    18 => ['id' => '01k054ypghg8nfn8w9raffmd6x', 'name' => 'Extensao de Cilios'],
    19 => ['id' => '01k07tvf515r0xw8kdvpye51wd', 'name' => 'Informatica Melhor Idade'],
    20 => ['id' => '01k0by316tt7wfr5zcv59ev16a', 'name' => 'Massagem Classica'],
    21 => ['id' => '01k0wbq2c105ys7ter0e7kcf6m', 'name' => 'Eletrica'],
    22 => ['id' => '01k0yryg0ebh640kytxnkrjrvb', 'name' => 'Jovem Aprendiz'],
];

// ========== MENU INTERATIVO ==========

echo "============================================\n";
echo "   ENVIO PADRAO - PRIMEIRA MENSAGEM\n";
echo "============================================\n\n";

// 1. Escolher escola
echo "Escolha a escola:\n";
echo "  [1] Liceu - Itaquaquecetuba (Brasil + Beleza)\n";
echo "  [2] Liceu - Aruja\n";
echo "  [3] Liceu - Suzano\n";
echo "\nDigite o numero da escola: ";
$escolha_escola = trim(fgets(STDIN));

if (!in_array($escolha_escola, ['1', '2', '3'])) {
    echo "Opcao invalida. Encerrando.\n";
    exit(1);
}

// 2. Escolher cursos
echo "\nEscolha os cursos (separados por virgula, ou 0 para TODOS):\n";
foreach ($cursos as $num => $curso) {
    echo "  [{$num}] {$curso['name']}\n";
}
echo "\nDigite os numeros (ex: 1,3,17 ou 0 para todos): ";
$escolha_cursos = trim(fgets(STDIN));

if ($escolha_cursos === '0') {
    $cursos_selecionados = $cursos;
} else {
    $numeros = array_map('trim', explode(',', $escolha_cursos));
    $cursos_selecionados = [];
    foreach ($numeros as $num) {
        $num = (int) $num;
        if (isset($cursos[$num])) {
            $cursos_selecionados[$num] = $cursos[$num];
        }
    }
}

if (empty($cursos_selecionados)) {
    echo "Nenhum curso valido selecionado. Encerrando.\n";
    exit(1);
}

// Montar lista de IDs para a query
$cursos_ids = array_column($cursos_selecionados, 'id');
$cursos_nomes = array_column($cursos_selecionados, 'name');
$placeholders = implode(',', array_map(fn($id) => "'{$id}'", $cursos_ids));

// 3. Aluno?
echo "\nFiltrar por aluno:\n";
echo "  [0] Tanto faz (Ambos os casos)\n";
echo "  [1] Nunca estudou no Liceu\n";
echo "  [2] Já estudou no Liceu\n";
echo "Escolha: ";
$escolha_aluno = trim(fgets(STDIN));

if (!in_array($escolha_aluno, ['0', '1', '2'])) {
    echo "Opcao invalida. Encerrando.\n";
    exit(1);
}

$filtro_aluno_label = match($escolha_aluno) {
    '0' => 'Tanto faz (Ambos os casos)',
    '1' => 'Nunca estudou no Liceu',
    '2' => 'Já estudou no Liceu',
};

// 4. Campanha
$campanhas = [
    1 => ['id' => '01ket499tcmk6v3898qbn9b9jv', 'name' => 'Bolsas 2025-08'],
    2 => ['id' => '01ket4q6j8069xqpq8fq6q12rg', 'name' => 'Bolsas 2026-01'],
];

echo "\nEscolha a campanha:\n";
foreach ($campanhas as $num => $camp) {
    echo "  [{$num}] {$camp['name']}\n";
}
echo "Escolha: ";
$escolha_campanha = trim(fgets(STDIN));
$escolha_campanha = (int) $escolha_campanha;

if (!isset($campanhas[$escolha_campanha])) {
    echo "Opcao invalida. Encerrando.\n";
    exit(1);
}

$campanha = $campanhas[$escolha_campanha];
$campanha_id = $campanha['id'];
$campanha_nome = $campanha['name'];

// ========== CONFIGURACAO POR ESCOLA ==========

$escolas = [
    '1' => [
        'nome'    => 'Liceu - Itaquaquecetuba',
        'webhook' => 'https://webhook.sellflux.app/v2/webhook/custom/242e49ca5f33ec4749170479537fa1b3',
    ],
    '2' => [
        'nome'    => 'Liceu - Aruja',
        'webhook' => 'https://webhook.sellflux.app/v2/webhook/custom/a36522593f7b72642f71dd99c59c52d6',
    ],
    '3' => [
        'nome'    => 'Liceu - Suzano',
        'webhook' => 'https://webhook.sellflux.app/v2/webhook/custom/5d53a0e1aa4306599945c7175c4eb263',
    ],
];

$escola  = $escolas[$escolha_escola];
$webhook = $escola['webhook'];

// ========== MONTAR FILTRO ALUNO ==========

$filtro_aluno_sql = match($escolha_aluno) {
    '0' => "",
    '1' => "AND contacts.is_student = 0",
    '2' => "AND contacts.is_student = 1",
};

// ========== CONTAR TOTAL SEM LIMIT ==========

if ($escolha_escola === '1') {
    $sql_count = "
        SELECT COUNT(*) AS total FROM (
            SELECT contacts.mobile_phone
            FROM contacts
            INNER JOIN course_student ON course_student.student_id = contacts.id
            INNER JOIN courses ON courses.id = course_student.course_id
            INNER JOIN schools ON schools.id = course_student.school_id
            INNER JOIN campaign_contact ON campaign_contact.contact_id = contacts.id
            INNER JOIN campaigns ON campaigns.id = campaign_contact.campaign_id
            WHERE
                course_student.order = 1
                AND (schools.name = 'Liceu Brasil - Itaquaquecetuba' OR schools.name = 'Liceu Beleza - Itaquaquecetuba')
                {$filtro_aluno_sql}
                AND campaigns.id = '{$campanha_id}'
                AND contacts.status IS NULL
                AND courses.id IN ({$placeholders})
            GROUP BY contacts.mobile_phone
        ) t
    ";
} elseif ($escolha_escola === '2') {
    $sql_count = "
        SELECT COUNT(*) AS total FROM (
            SELECT contacts.mobile_phone
            FROM contacts
            INNER JOIN course_student ON course_student.student_id = contacts.id
            INNER JOIN courses ON courses.id = course_student.course_id
            INNER JOIN schools ON schools.id = course_student.school_id
            INNER JOIN campaign_contact ON campaign_contact.contact_id = contacts.id
            INNER JOIN campaigns ON campaigns.id = campaign_contact.campaign_id
            WHERE
                course_student.order = 1
                AND schools.name = 'Liceu - Arujá'
                {$filtro_aluno_sql}
                AND campaigns.id = '{$campanha_id}'
                AND contacts.status IS NULL
                AND courses.id IN ({$placeholders})
            GROUP BY contacts.mobile_phone
        ) t
    ";
} elseif ($escolha_escola === '3') {
    $sql_count = "
        SELECT COUNT(*) AS total FROM (
            SELECT contacts.mobile_phone
            FROM contacts
            INNER JOIN course_student ON course_student.student_id = contacts.id
            INNER JOIN courses ON courses.id = course_student.course_id
            INNER JOIN schools ON schools.id = course_student.school_id
            INNER JOIN campaign_contact ON campaign_contact.contact_id = contacts.id
            INNER JOIN campaigns ON campaigns.id = campaign_contact.campaign_id
            WHERE
                course_student.order = 1
                AND schools.id = '01k054qcbjkzjegxxas3jwr538'
                {$filtro_aluno_sql}
                AND campaigns.id = '{$campanha_id}'
                AND contacts.status IS NULL
                AND courses.id IN ({$placeholders})
            GROUP BY contacts.mobile_phone
        ) t
    ";
}

$total_disponivel = $pdo->query($sql_count)->fetch()['total'];

echo "\n>> Total de contatos disponiveis: {$total_disponivel}\n";

if ($total_disponivel == 0) {
    echo "Nenhum contato encontrado com esses filtros. Encerrando.\n";
    exit(0);
}

// 4. Quantidade (LIMIT)
echo "Quantidade para enviar (ou 0 para todos): ";
$limite_input = trim(fgets(STDIN));
$limite = (int) $limite_input;

if ($limite <= 0) {
    $limite = $total_disponivel;
    echo "Selecionado: todos ({$total_disponivel})\n";
}

// 5. Modo dry run?
echo "\nModo de execucao:\n";
echo "  [1] ENVIAR (webhook + atualiza status)\n";
echo "  [2] SIMULAR (apenas gera CSV, nao envia nada)\n";
echo "Escolha: ";
$modo = trim(fgets(STDIN));

if (!in_array($modo, ['1', '2'])) {
    echo "Opcao invalida. Encerrando.\n";
    exit(1);
}

$dry_run = ($modo === '2');

// Se for dry run, forca salvar CSV
$salvar_csv = true;
if (!$dry_run) {
    // 6. Salvar CSV?
    echo "Deseja salvar os contatos em CSV? (s/n): ";
    $salvar_csv = strtolower(trim(fgets(STDIN))) === 's';
}

echo "\n--------------------------------------------\n";
echo "Modo:       " . ($dry_run ? "** SIMULACAO (sem envio) **" : "ENVIO REAL") . "\n";
echo "Escola:     {$escola['nome']}\n";
echo "Campanha:   {$campanha_nome}\n";
echo "Cursos:     " . implode(', ', $cursos_nomes) . "\n";
echo "Aluno:      {$filtro_aluno_label}\n";
echo "Total disp: {$total_disponivel}\n";
echo "Quantidade: {$limite}\n";
echo "Salvar CSV: " . ($salvar_csv ? "Sim" : "Nao") . "\n";
echo "--------------------------------------------\n";
echo "Confirma? (s/n): ";
$confirma = strtolower(trim(fgets(STDIN)));

if ($confirma !== 's') {
    echo "Cancelado.\n";
    exit(0);
}

// ========== MONTAR QUERY ==========

if ($escolha_escola === '1') {
    // Itaquaquecetuba
    $sql = "
        SELECT name, phone, email, protocolo_inscricao, nome_curso_1, codigo_agendamento, name_school, status, created_at
        FROM (
            SELECT
                contacts.name          AS name,
                contacts.mobile_phone  AS phone,
                contacts.email         AS email,
                contacts.reference     AS protocolo_inscricao,
                courses.name           AS nome_curso_1,
                contacts.id            AS codigo_agendamento,
                schools.name           AS name_school,
                contacts.status        AS status,
                contacts.created_at    AS created_at,
                ROW_NUMBER() OVER (
                    PARTITION BY contacts.mobile_phone
                    ORDER BY contacts.created_at DESC, contacts.id DESC
                ) AS row_number_by_phone
            FROM contacts
            INNER JOIN course_student ON course_student.student_id = contacts.id
            INNER JOIN courses ON courses.id = course_student.course_id
            INNER JOIN schools ON schools.id = course_student.school_id
            INNER JOIN campaign_contact ON campaign_contact.contact_id = contacts.id
            INNER JOIN campaigns ON campaigns.id = campaign_contact.campaign_id
            WHERE
                course_student.order = 1
                AND (schools.name = 'Liceu Brasil - Itaquaquecetuba' OR schools.name = 'Liceu Beleza - Itaquaquecetuba')
                {$filtro_aluno_sql}
                AND campaigns.id = '{$campanha_id}'
                AND contacts.status IS NULL
                AND courses.id IN ({$placeholders})
        ) ranked
        WHERE ranked.row_number_by_phone = 1
        LIMIT {$limite}
    ";

} elseif ($escolha_escola === '2') {
    // Aruja
    $sql = "
        SELECT name, phone, email, protocolo_inscricao, nome_curso_1, codigo_agendamento, name_school, status, created_at
        FROM (
            SELECT
                contacts.name          AS name,
                contacts.mobile_phone  AS phone,
                contacts.email         AS email,
                contacts.reference     AS protocolo_inscricao,
                courses.name           AS nome_curso_1,
                contacts.id            AS codigo_agendamento,
                schools.name           AS name_school,
                contacts.status        AS status,
                contacts.created_at    AS created_at,
                ROW_NUMBER() OVER (
                    PARTITION BY contacts.mobile_phone
                    ORDER BY contacts.created_at DESC, contacts.id DESC
                ) AS row_number_by_phone
            FROM contacts
            INNER JOIN course_student ON course_student.student_id = contacts.id
            INNER JOIN courses ON courses.id = course_student.course_id
            INNER JOIN schools ON schools.id = course_student.school_id
            INNER JOIN campaign_contact ON campaign_contact.contact_id = contacts.id
            INNER JOIN campaigns ON campaigns.id = campaign_contact.campaign_id
            WHERE
                course_student.order = 1
                AND schools.name = 'Liceu - Arujá'
                {$filtro_aluno_sql}
                AND campaigns.id = '{$campanha_id}'
                AND contacts.status IS NULL
                AND courses.id IN ({$placeholders})
        ) ranked
        WHERE ranked.row_number_by_phone = 1
        LIMIT {$limite}
    ";

} elseif ($escolha_escola === '3') {
    // Suzano
    $sql = "
        SELECT name, phone, email, protocolo_inscricao, nome_curso_1, codigo_agendamento, name_school, status, created_at
        FROM (
            SELECT
                contacts.name          AS name,
                contacts.mobile_phone  AS phone,
                contacts.email         AS email,
                contacts.reference     AS protocolo_inscricao,
                courses.name           AS nome_curso_1,
                contacts.id            AS codigo_agendamento,
                schools.name           AS name_school,
                contacts.status        AS status,
                contacts.created_at    AS created_at,
                ROW_NUMBER() OVER (
                    PARTITION BY contacts.mobile_phone
                    ORDER BY contacts.created_at DESC, contacts.id DESC
                ) AS row_number_by_phone
            FROM contacts
            INNER JOIN course_student ON course_student.student_id = contacts.id
            INNER JOIN courses ON courses.id = course_student.course_id
            INNER JOIN schools ON schools.id = course_student.school_id
            INNER JOIN campaign_contact ON campaign_contact.contact_id = contacts.id
            INNER JOIN campaigns ON campaigns.id = campaign_contact.campaign_id
            WHERE
                course_student.order = 1
                AND schools.id = '01k054qcbjkzjegxxas3jwr538'
                {$filtro_aluno_sql}
                AND campaigns.id = '{$campanha_id}'
                AND contacts.status IS NULL
                AND courses.id IN ({$placeholders})
        ) ranked
        WHERE ranked.row_number_by_phone = 1
        LIMIT {$limite}
    ";
}

// ========== EXECUTAR QUERY ==========

$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll();

$total = count($usuarios);
echo "\nContatos encontrados: {$total}\n";

if ($total === 0) {
    echo "Nenhum contato encontrado. Encerrando.\n";
    exit(0);
}

// ========== SALVAR CSV ==========

if ($salvar_csv) {
    $nomeEscola = str_replace(' ', '_', $escola['nome']);
    $dataHora = date('Y-m-d_H-i-s');
    $nomeArquivo = "contatos_{$nomeEscola}_{$dataHora}.csv";

    $fp = fopen($nomeArquivo, 'w');

    // BOM para Excel reconhecer UTF-8
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));

    // Cabecalho
    fputcsv($fp, ['Nome', 'Telefone', 'Email', 'Protocolo Inscricao', 'Curso', 'Codigo Agendamento', 'Escola', 'Status'], ';');

    foreach ($usuarios as $u) {
        fputcsv($fp, [
            $u['name'],
            $u['phone'],
            $u['email'],
            $u['protocolo_inscricao'],
            $u['nome_curso_1'],
            $u['codigo_agendamento'],
            $u['name_school'],
            $u['status'],
        ], ';');
    }

    fclose($fp);
    echo "CSV salvo em: {$nomeArquivo}\n";
}

if ($dry_run) {
    echo "\n============================================\n";
    echo "Simulacao finalizada! {$total} contatos encontrados.\n";
    echo "Nenhum envio foi realizado.\n";
    echo "============================================\n";
} else {
    echo "Iniciando envio...\n\n";

    // ========== ENVIAR ==========

    $count = 0;

    foreach ($usuarios as $usuario) {

        $ch = curl_init($webhook);

        $data = [
            'name'                 => $usuario['name'],
            'phone'                => '+55' . $usuario['phone'],
            'email'                => $usuario['email'],
            'protocolo_inscricao'  => $usuario['protocolo_inscricao'],
            'nome_curso_1'         => $usuario['nome_curso_1'],
            'codigo_agendamento'   => $usuario['codigo_agendamento'],
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $resposta = curl_exec($ch);

        $count++;

        if ($resposta === false) {
            echo "ERRO ao enviar: {$usuario['phone']} - " . curl_error($ch) . "\n";
        } else {
            echo "[{$count}/{$total}] Enviado com sucesso: {$usuario['phone']}\n";

            $update = $pdo->prepare("
                UPDATE sgf_redeliceu_com_br.contacts
                SET status = 'selected',
                    status_two = 'selected'
                WHERE id = :id
            ");
            $update->execute([':id' => $usuario['codigo_agendamento']]);
        }

        curl_close($ch);

        sleep(1);
    }

    echo "\n============================================\n";
    echo "Envio finalizado! Total enviados: {$count}/{$total}\n";
    echo "============================================\n";
}
