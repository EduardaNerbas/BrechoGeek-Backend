<?php

function listar_carrinho()
{
    global $pdo;

    if (isset($_GET['id_usuario']) && trim($_GET['id_usuario']) !== '') {
        $id_usuario = trim($_GET['id_usuario']);

        try {
            $sql = "SELECT p.*, c.fk_id_usuario FROM produto p
                    INNER JOIN carrinho c ON p.id_produto = c.fk_id_produto
                    WHERE c.fk_id_usuario = :id_usuario
                    ORDER BY p.id_produto DESC";
            
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