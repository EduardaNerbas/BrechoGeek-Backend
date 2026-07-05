<?php

function excluir_produto($dados)
{
    global $pdo;

    if ($dados && isset($dados['id_produto'])) {
        $id2 = $dados['id_produto']; 
        try {
            $sql = "DELETE FROM produto WHERE id_produto = :id";
            $stmt = $pdo->prepare($sql);

            $x = $stmt->execute([
                ':id' => $id2,
            ]);
            echo json_encode(["sucesso" => $x]);
        } catch (\PDOException $e) {
            echo json_encode(["sucesso" => false]);
        }
    } else {
        echo json_encode(["sucesso" => false]);
    }
}