<?php

function login($dados)
{
    global $pdo;

    if ($dados) {
        $email = isset($dados['email']) ? trim($dados['email']) : '';
        $senha = isset($dados['senha']) ? trim($dados['senha']) : '';
        if (empty($email) || empty($senha)) {
            echo json_encode(["sucesso" => false, "erro" => "Preencha todos os campos."]);
            return;
        }
        try {
            $sql = "select * from usuario where email = :email;";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':email' => $email
            ]);

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                if (password_verify($senha, $resultado['senha'])) {
                    echo json_encode(["sucesso" => true, "id_usuario" => $resultado['id_usuario'], "nome_usuario" => $resultado['nome_usuario']]);
                } else {
                    echo json_encode(["sucesso" => false, "erro" => "Email ou senha incorretos."]);
                }
            } else {
                echo json_encode(["sucesso" => false, "erro" => "Email ou senha incorretos."]);
            }

        } catch (\PDOException $e) {
                echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["sucesso" => false]);
    }
}