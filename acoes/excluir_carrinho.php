<?php

function excluir_carrinho($dados)
{
    global $pdo;

    if ($dados) {
        $fk_id_usuario = $dados['id_usuario'];
        $fk_id_produto = $dados['id_produto'];
        try {
            $sql = "DELETE FROM carrinho WHERE fk_id_usuario = :fk_id_usuario and fk_id_produto = :fk_id_produto";
            $stmt = $pdo->prepare($sql);

            $x = $stmt->execute([
                ':fk_id_usuario' => $fk_id_usuario,
                ':fk_id_produto' => $fk_id_produto
            ]);
            if ($x) {
                echo json_encode(["sucesso" => true]);
            } else {
                echo json_encode(["sucesso" => false, "erro" => "Não foi possível remover do carrinho."]);
            }
        } catch (\PDOException $e) {
            echo json_encode(["sucesso" => false]);
        }
    } else {
        echo json_encode(["sucesso" => false]);
    }
}