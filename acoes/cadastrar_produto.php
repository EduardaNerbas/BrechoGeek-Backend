<?php

function cadastrar_produto()
{
    include_once("validar_descricao.php");
    global $pdo;

    $nome_produto = isset($_POST['nome_produto']) ? trim($_POST['nome_produto']) : '';
    $preco = isset($_POST['preco']) ? trim($_POST['preco']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $fk_id_usuario = isset($_POST['id_usuario']) ? trim($_POST['id_usuario']) : '';

    $categoria_1 = isset($_POST['categoria_1']) ? trim($_POST['categoria_1']) : '';
    $categoria_2 = isset($_POST['categoria_2']) ? trim($_POST['categoria_2']) : '';


    if (empty($nome_produto) || empty($preco) || empty($fk_id_usuario) || empty($categoria_1)) {
        echo json_encode(["sucesso" => false, "erro" => "Preencha os campos obrigatórios, incluindo a categoria principal."]);
        return;
    }

    if (!isset($_FILES['imagem_produto']) || $_FILES['imagem_produto']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["sucesso" => false, "erro" => "A imagem do produto é obrigatória."]);
        return;
    }

    $arquivo_tmp = $_FILES['imagem_produto']['tmp_name'];
    $nome_original = $_FILES['imagem_produto']['name'];
    $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($extensao, $extensoes_permitidas)) {
        echo json_encode(["sucesso" => false, "erro" => "Formato de imagem inválido. JPG, PNG ou WEBP."]);
        return;
    }

    $nome_final_imagem = "prod_" . uniqid() . "." . $extensao;
    $pasta_destino = "uploads/" . $nome_final_imagem;

    if (!move_uploaded_file($arquivo_tmp, $pasta_destino)) {
        echo json_encode(["sucesso" => false, "erro" => "Falha ao salvar a imagem no servidor."]);
        return;
    }

    if (!validar_descricao($descricao)) {
        if (file_exists($pasta_destino)) {
            unlink($pasta_destino);
        }
        echo json_encode(["sucesso" => false, "erro" => "Essa descrição não passou nas nossas verificações de segurança."]);
        return;
    }

    try {
        $pdo->beginTransaction();

        $sqlProduto = "INSERT INTO produto (nome_produto, preco, descricao, imagem_produto, fk_id_usuario) 
                       VALUES (:nome_produto, :preco, :descricao, :imagem_produto, :fk_id_usuario)";

        $stmtProduto = $pdo->prepare($sqlProduto);
        $stmtProduto->execute([
            ':nome_produto' => $nome_produto,
            ':preco' => $preco,
            ':descricao' => $descricao,
            ':imagem_produto' => $nome_final_imagem,
            ':fk_id_usuario' => $fk_id_usuario
        ]);

        $id_produto_criado = $pdo->lastInsertId();

        $sqlCategoria = "INSERT INTO produto_categorias (fk_id_produto, fk_id_categoria) 
                         VALUES (:fk_id_produto, :fk_id_categoria)";
        $stmtCategoria = $pdo->prepare($sqlCategoria);

        $stmtCategoria->execute([
            ':fk_id_produto' => $id_produto_criado,
            ':fk_id_categoria' => intval($categoria_1)
        ]);

        if (!empty($categoria_2) && $categoria_2 !== "nenhuma" && $categoria_2 !== $categoria_1) {
            $stmtCategoria->execute([
                ':fk_id_produto' => $id_produto_criado,
                ':fk_id_categoria' => intval($categoria_2)
            ]);
        }

        $pdo->commit();
        echo json_encode(["sucesso" => true, "id_produto" => $id_produto_criado]);

    } catch (\PDOException $e) {
        $pdo->rollBack();
        if (file_exists($pasta_destino)) {
            unlink($pasta_destino);
        }
        echo json_encode(["sucesso" => false, "erro" => "Erro ao salvar no banco: " . $e->getMessage()]);
    }
}