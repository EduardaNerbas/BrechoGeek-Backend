<?php

function update_usuario($dados)
{
    global $pdo;

    if ($dados) {
        $id_usuario = $dados['id_usuario'];
        $nome_usuario = isset($dados['nome_usuario']) ? trim($dados['nome_usuario']) : '';
        $senha = isset($dados['senha']) ? trim($dados['senha']) : '';
        if (empty($nome_usuario) && empty($senha)) {
            echo json_encode(["sucesso" => false, "erro" => "Preencha ao menos um dos campos."]);
            return;
        }

        try {
            if (empty($senha)) {
                $sql = "update usuario set nome_usuario = :nome_usuario where id_usuario =:id_usuario";
                $stmt = $pdo->prepare($sql);

                $x = $stmt->execute([
                    ':nome_usuario' => $nome_usuario,
                    ':id_usuario' => $id_usuario
                ]);
            } else if (empty($nome_usuario)) {
                $senha = password_hash($senha, PASSWORD_DEFAULT);
                $sql = "update usuario set senha = :senha where id_usuario =:id_usuario";
                $stmt = $pdo->prepare($sql);

                $x = $stmt->execute([
                    ':senha' => $senha,
                    ':id_usuario' => $id_usuario
                ]);
            } else {
                $senha = password_hash($senha, PASSWORD_DEFAULT);
                $sql = "update usuario set nome_usuario = :nome_usuario, senha = :senha where id_usuario =:id_usuario";
                $stmt = $pdo->prepare($sql);

                $x = $stmt->execute([
                    ':nome_usuario' => $nome_usuario,
                    ':senha' => $senha,
                    ':id_usuario' => $id_usuario
                ]);
            }
            if ($x) {
                echo json_encode(["sucesso" => true]);
            } else {
                echo json_encode(["sucesso" => false, "erro" => "Não foi possível atualizar do banco."]);
            }
        } catch (\PDOException $e) {

            echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["sucesso" => false]);
    }
}