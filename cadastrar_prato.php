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
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Prato</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Prato</h1>

        <?php if ($mensagem != ''): ?>
            <p class="msg"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form method="POST" action="cadastrar_prato.php">
            <div class="form-group">
                <label>Nome do Prato:</label>
                <input type="text" name="nome" required>
            </div>

            <div class="form-group">
                <label>Descrição:</label>
                <textarea name="descricao" required></textarea>
            </div>

            <div class="form-group">
                <label>Preço:</label>
                <input type="number" step="0.01" name="preco" required>
            </div>

            <div class="form-group">
                <label>Categoria:</label>
                <input type="text" name="categoria" required>
            </div>

            <div class="form-group">
                <label>Usuário Responsável:</label>
                <select name="usuario_id" required>
                    <option value="">Selecione um usuário...</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?php echo $u['id']; ?>">
                            <?php echo $u['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Salvar Prato</button>
            <a href="index.php" class="btn-clear">Voltar</a>
        </form>
    </div>
</body>
</html>