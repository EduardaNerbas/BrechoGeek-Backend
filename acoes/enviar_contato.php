<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../vendor/autoload.php';
function enviar_contato($dados)
{

    if ($dados) {
        $nome = isset($dados['nome']) ? trim($dados['nome']) : '';
        $email_cliente = isset($dados['email']) ? trim($dados['email']) : '';
        $assunto = isset($dados['assunto']) ? trim($dados['assunto']) : '';
        $mensagem = isset($dados['mensagem']) ? trim($dados['mensagem']) : '';

        if (empty($nome) || empty($email_cliente) || empty($assunto) || empty($mensagem)) {
            echo json_encode(["sucesso" => false, "erro" => "Por favor, preencha todos os campos."]);
            return;
        }

        if (!filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["sucesso" => false, "erro" => "O formato do e-mail informado é inválido."]);
            return;
        }

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();

            $mail->SMTPAuth = true;

            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];

            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;

            $mail->setFrom($_ENV['SMTP_USER'], 'Brechó Geek');
            $mail->addAddress($_ENV['SMTP_USER'], 'Brechó Geek');

            $mail->isHTML(true);

            $mail->Subject = $assunto;

            $mail->Body = "Enviado por: " . $nome . " Email: " . $email_cliente . " Mensagem: " . $mensagem;

            $mail->send();

            echo json_encode(["sucesso" => true, "mensagem" => "E-mail enviado com sucesso!"]);
        } catch (Exception $e) {
            echo json_encode(["sucesso" => false, "erro" => "Falha interna do servidor ao tentar enviar o e-mail."]);
        }

    } else {
        echo json_encode(["sucesso" => false]);
    }
}