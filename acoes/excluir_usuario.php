<?php

function excluir_usuario($dados)
{
    global $pdo;

    if ($dados && isset($dados['id_usuario'])) {
        $id2 = $dados['id_usuario']; 
        try {
            $sql = "DELETE FROM usuario WHERE id_usuario = :id";
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