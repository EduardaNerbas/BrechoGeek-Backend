<?php

function update_produto($dados)
{
    include_once("validar_descricao.php");
    global $pdo;

    if ($dados) {
        $id_produto = isset($dados['id_produto']) ? $dados['id_produto'] : '';
        $nome_produto = isset($dados['nome_produto']) ? trim($dados['nome_produto']) : '';
        $preco = isset($dados['preco']) ? trim($dados['preco']) : '';
        $descricao = isset($dados['descricao']) ? trim($dados['descricao']) : '';
        
        $categoria_1 = isset($dados['categoria_1']) ? $dados['categoria_1'] : null;
        $categoria_2 = isset($dados['categoria_2']) ? $dados['categoria_2'] : null;

        if (empty($id_produto)) {
            echo json_encode(["sucesso" => false, "erro" => "ID do produto é obrigatório."]);
            return;
        }

        if (empty($nome_produto) && empty($preco) && empty($descricao) && $categoria_1 === null && $categoria_2 === null) {
            echo json_encode(["sucesso" => false, "erro" => "Preencha ao menos um dos campos para atualizar."]);
            return;
        }
        if (!empty($descricao)) {
            if (!validar_descricao($descricao)) {
                echo json_encode([
                    "sucesso" => false, 
                    "erro" => "A nova descrição não passou nas nossas verificações de segurança e foi considerada inadequada."
                ]);
                return;
            }
        }
        try {
            $pdo->beginTransaction();
            $executouCamposNormais = true;
            if (!empty($nome_produto)) {
                $sql = "update produto set nome_produto = :nome_produto ";
                if (!empty($preco)) {
                    $sql = $sql . ", preco = :preco ";
                    if (!empty($descricao)) {
                        $sql = $sql . ", descricao = :descricao where id_produto = :id_produto";
                        $stmt = $pdo->prepare($sql);
                        $executouCamposNormais = $stmt->execute([
                            ':nome_produto' => $nome_produto,
                            ':preco' => $preco,
                            ':descricao' => $descricao,
                            ':id_produto' => $id_produto
                        ]);
                    } else {
                        $sql = $sql . " where id_produto = :id_produto";
                        $stmt = $pdo->prepare($sql);
                        $executouCamposNormais = $stmt->execute([
                            ':nome_produto' => $nome_produto,
                            ':preco' => $preco,
                            ':id_produto' => $id_produto
                        ]);
                    }
                } else if (!empty($descricao)) {
                    $sql = $sql . ", descricao = :descricao where id_produto = :id_produto";
                    $stmt = $pdo->prepare($sql);
                    $executouCamposNormais = $stmt->execute([
                        ':nome_produto' => $nome_produto,
                        ':descricao' => $descricao,
                        ':id_produto' => $id_produto
                    ]);
                } else {
                    $sql = $sql . " where id_produto = :id_produto";
                    $stmt = $pdo->prepare($sql);
                    $executouCamposNormais = $stmt->execute([
                        ':nome_produto' => $nome_produto,
                        ':id_produto' => $id_produto
                    ]);
                }
            } else if (!empty($preco)) {
                $sql = "update produto set preco = :preco ";
                if (!empty($descricao)) {
                    $sql = $sql . ", descricao = :descricao where id_produto = :id_produto";
                    $stmt = $pdo->prepare($sql);
                    $executouCamposNormais = $stmt->execute([
                        ':preco' => $preco,
                        ':descricao' => $descricao,
                        ':id_produto' => $id_produto
                    ]);
                } else {
                    $sql = $sql . " where id_produto = :id_produto";
                    $stmt = $pdo->prepare($sql);
                    $executouCamposNormais = $stmt->execute([
                        ':preco' => $preco,
                        ':id_produto' => $id_produto
                    ]);
                }
            } else if (!empty($descricao)) {
                $sql = "update produto set descricao = :descricao where id_produto = :id_produto";
                $stmt = $pdo->prepare($sql);
                $executouCamposNormais = $stmt->execute([
                    ':descricao' => $descricao,
                    ':id_produto' => $id_produto
                ]);
            }

            if ($categoria_1 !== null) {
                $sqlLimpar = "DELETE FROM produto_categorias WHERE fk_id_produto = :id_produto";
                $stmtLimpar = $pdo->prepare($sqlLimpar);
                $stmtLimpar->execute([':id_produto' => $id_produto]);

                $sqlInsere = "INSERT INTO produto_categorias (fk_id_produto, fk_id_categoria) VALUES (:id_produto, :id_categoria)";
                $stmtInsere = $pdo->prepare($sqlInsere);

                if (!empty($categoria_1)) {
                    $stmtInsere->execute([
                        ':id_produto' => $id_produto,
                        ':id_categoria' => intval($categoria_1)
                    ]);
                }

                if (!empty($categoria_2) && $categoria_2 !== "nenhuma" && $categoria_2 !== $categoria_1) {
                    $stmtInsere->execute([
                        ':id_produto' => $id_produto,
                        ':id_categoria' => intval($categoria_2)
                    ]);
                }
            }

            if ($executouCamposNormais) {
                $pdo->commit();
                echo json_encode(["sucesso" => true]);
            } else {
                $pdo->rollBack();
                echo json_encode(["sucesso" => false, "erro" => "Não foi possível atualizar o produto."]);
            }

        } catch (\PDOException $e) {
            $pdo->rollBack();
            echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["sucesso" => false]);
    }
}