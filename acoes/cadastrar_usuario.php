<?php

function cadastrar_usuario($dados)
{
    global $pdo;

    if ($dados) {
        $nome_usuario = isset($dados['nome_usuario']) ? trim($dados['nome_usuario']) : '';
        $email = isset($dados['email']) ? trim($dados['email']) : '';
        $senha = isset($dados['senha']) ? trim($dados['senha']) : '';
        if (empty($nome_usuario) || empty($email) || empty($senha)) {
            echo json_encode(["sucesso" => false, "erro" => "Preencha todos os campos."]);
            return;
        }
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["sucesso" => false, "erro" => "O formato do e-mail informado é inválido."]);
            return;
        }
        try {
            $sql = "insert into usuario (nome_usuario, email, senha) values (:nome_usuario, :email, :senha)";
            $stmt = $pdo->prepare($sql);

            $x = $stmt->execute([
                ':nome_usuario' => $nome_usuario,
                ':email' => $email,
                ':senha' => $senha
            ]);

            if ($x) {
                echo json_encode(["sucesso" => true, "id" => $pdo->lastInsertId()]);
            } else {
                echo json_encode(["sucesso" => false, "erro" => "Não foi possível inserir no banco."]);
            }

        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                echo json_encode(["sucesso" => false, "erro" => "Este e-mail já está cadastrado."]);
            } else {
                echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(["sucesso" => false]);
    }
}