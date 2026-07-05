<?php
function listar_produtos()
{
    global $pdo;
    $params = [];

    try {
        if (isset($_GET['id_categoria']) && trim($_GET['id_categoria']) !== '') {
            $sql = "SELECT p.* FROM produto p
                    INNER JOIN produto_categorias pc ON p.id_produto = pc.fk_id_produto
                    WHERE pc.fk_id_categoria = :id_categoria
                    ORDER BY p.id_produto DESC";
            $params[':id_categoria'] = $_GET['id_categoria'];
        } else {
            $sql = "SELECT * FROM produto ORDER BY id_produto DESC";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["sucesso" => true, "resultado" => $resultado]);

    } catch (\PDOException $e) {
        echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
    }
}