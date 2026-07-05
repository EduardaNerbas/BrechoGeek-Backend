<?php

function pegar_por_id()
{
    global $pdo;
    if (isset($_GET['id_produto']) && trim($_GET['id_produto']) !== '') {
        try {
            $sql = "select * from produto where id_produto = :id_produto;";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_produto' => $_GET['id_produto']
            ]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                $sqlCategorias = "SELECT pc.fk_id_categoria 
                                  FROM produto_categorias pc
                                  WHERE pc.fk_id_produto = :id_produto";
                
                $stmtCats = $pdo->prepare($sqlCategorias);
                $stmtCats->execute([
                    ':id_produto' => $_GET['id_produto']
                ]);
                $categorias = $stmtCats->fetchAll(PDO::FETCH_COLUMN);
                $resultado['categorias'] = $categorias ? $categorias : [];
            }

        } catch (\PDOException $e) {
            echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
            return;
        }

        if ($resultado) {
            echo json_encode(["sucesso" => true, "resultado" => $resultado]);
        } else {
            echo json_encode(["sucesso" => true, "resultado" => []]);
        }

    } else {
        echo json_encode(["sucesso" => false]);
    }
}