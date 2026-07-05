<?php

function adicionar_carrinho($dados)
{
    global $pdo;

    if ($dados) {
        $fk_id_usuario = $dados['id_usuario'];
        $fk_id_produto = $dados['id_produto'];
        try {
            $sql = "insert into carrinho (fk_id_usuario, fk_id_produto) values (:fk_id_usuario, :fk_id_produto)";
            $stmt = $pdo->prepare($sql);

            $x = $stmt->execute([
                ':fk_id_usuario' => $fk_id_usuario,
                ':fk_id_produto' => $fk_id_produto
            ]);

            if ($x) {
                echo json_encode(["sucesso" => true, "id" => $pdo->lastInsertId()]);
            } else {
                echo json_encode(["sucesso" => false, "erro" => "Não foi possível adicionar ao carrinho."]);
            }

        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                echo json_encode(["sucesso" => false, "erro" => "Este produto já está no seu carrinho!"]);
            } else {
                echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(["sucesso" => false]);
    }
}