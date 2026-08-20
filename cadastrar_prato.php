<?php
require_once 'conexao.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $usuario_id = $_POST['usuario_id'];

    if ($nome != '' && $preco != '' && $categoria != '' && $usuario_id != '') {
        $sql = "INSERT INTO pratos (nome, descricao, preco, categoria, usuario_id) VALUES (:nome, :descricao, :preco, :categoria, :usuario_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nome' => $nome,
            'descricao' => $descricao,
            'preco' => $preco,
            'categoria' => $categoria,
            'usuario_id' => $usuario_id
        ]);

        header('Location: index.php');
        exit;
    } else {
        $mensagem = "Preencha os campos obrigatórios!";
    }
}

$stmt_usuarios = $pdo->prepare("SELECT * FROM usuarios");
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->fetchAll();
?>