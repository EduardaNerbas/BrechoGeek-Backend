<?php

function listar_produtos_usuario()
{
    global $pdo;
    if (isset($_GET['id_usuario']) && trim($_GET['id_usuario']) !== '') {
        $id_usuario = trim($_GET['id_usuario']);

        try {
            $sql = "SELECT * FROM produto 
                    WHERE fk_id_usuario = :id_usuario 
                    ORDER BY id_produto DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_usuario' => $id_usuario
            ]);

            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["sucesso" => true, "resultado" => $resultado]);

        } catch (\PDOException $e) {
            echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["sucesso" => false, "erro" => "ID do usuário não informado."]);
    }
}