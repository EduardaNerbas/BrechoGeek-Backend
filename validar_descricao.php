<?php

function validar_descricao($descricao) {
    $apiKey = $_ENV['GEMINI_API_KEY'];
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

    $prompt = "Você é um moderador de segurança automatizado para um Brechó Virtual de artigos Geek, Nerd e Pop Culture.
    Sua tarefa é analisar descrições de produtos e identificar APENAS violações graves como: discursos de ódio, ofensas pesadas, pornografia, golpes/fraudes explícitas ou drogas de verdade.
    
    ATENÇÃO: É um site Geek! Termos como 'machado do Thor', 'espada de anime', 'arma de brinquedo', 'varinha de Harry Potter' ou 'action figure' referem-se a COLECIONÁVEIS, RÉPLICAS DE DECORAÇÃO ou BRINQUEDOS, e são 100% PERMITIDOS e APROVADOS.

    Descrição a ser analisada: \"" . $descricao . "\". Fim da descrição.
    
    Responda estritamente com apenas uma palavra: 'APROVADO' se a descrição for segura para um e-commerce geek, ou 'REPROVADO' se contiver discursos de ódio, ofensas reais, pornografia ou golpes. Não escreva nenhuma outra palavra, saudação ou pontuação.";

    $payload = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        curl_close($ch);
        return true; 
    }
    curl_close($ch);
    $data = json_decode($response, true);
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        $resultadoAI = trim($data['candidates'][0]['content']['parts'][0]['text']);
        if ($resultadoAI === 'REPROVADO') {
            return false;
        }
    }
    return true;
}