<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json; charset=UTF-8");

include_once("conexao.php");

$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
$dados = json_decode((file_get_contents("php://input")), true);
switch ($acao) {

    case '1':
        require_once 'acoes/cadastrar_usuario.php';
        cadastrar_usuario($dados);
        break;
    case '2':
        require_once 'acoes/excluir_usuario.php';
        excluir_usuario($dados);
        break;
    case '3':
        require_once 'acoes/update_usuario.php';
        update_usuario($dados);
        break;
    case '4':
        require_once 'acoes/login.php';
        login($dados);
        break;
    case '5':
        require_once 'acoes/cadastrar_produto.php';
        cadastrar_produto();
        break;
    case '6':
        require_once 'acoes/excluir_produto.php';
        excluir_produto($dados);
        break;
    case '7':
        require_once 'acoes/update_produto.php';
        update_produto($dados);
        break;
    case '8':
        require_once 'acoes/listar_produtos.php';
        listar_produtos();
        break;
    case '9':
        require_once 'acoes/adicionar_carrinho.php';
        adicionar_carrinho($dados);
        break;

    case '10':
        require_once 'acoes/excluir_carrinho.php';
        excluir_carrinho($dados);
        break;
    case '11':
        require_once 'acoes/listar_carrinho.php';
        listar_carrinho();
        break;
    case '12':
        require_once 'acoes/enviar_contato.php';
        enviar_contato($dados);
        break;
    case '13':
        require_once 'acoes/pegar_por_id.php';
        pegar_por_id();
        break;
    case '14':
        require_once 'acoes/listar_produtos_usuario.php';
        listar_produtos_usuario();
        break;
    default:
        echo json_encode(["erro" => "Ação inválida ou não informada."]);
        break;
}
?>