<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;
    $descricao = $_POST['descricao'] ?? '';

    if ($preco >= 0 && $estoque >= 0) {
        try {
            $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, categoria = ?, preco = ?, estoque = ?, descricao = ? WHERE id = ?");
            $stmt->execute([$nome, $categoria, $preco, $estoque, $descricao, $id]);
            $mensagem = "<p style='color: #2e7d32; font-weight: bold;'>Alterações salvas com sucesso!</p>";
        } catch (PDOException $e) {
            $mensagem = "<p style='color: #d32f2f; font-weight: bold;'>Erro ao atualizar: " . $e->getMessage() . "</p>";
        }
    } else {
        $mensagem = "<p style='color: #d32f2f; font-weight: bold;'>Erro: Valores de preço ou estoque inválidos.</p>";
    }
}

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto - Shopee Vendedor</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <style>
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        textarea.form-control { height: 100px; resize: vertical; }
    </style>
</head>
<body>
    <nav>
        <div class="logo"><a href="index.php">Shopee <span>Vendedor</span></a></div>
        <div class="menu-links">
            <a href="index.php">Início</a>
            <a href="biblioteca.php">Todos Produtos</a>
            <a href="criar.php">Novo Produto</a>
            <a href="produtos-cadastrados.php">Em Estoque</a>
            <a href="produtos-esgotados.php">Esgotados</a>
            <a href="mais-vistos.php">Mais Vistos</a>
            <a href="estatisticas.php">Relatórios</a>
        </div>
    </nav>

    <div class="container">
        <h1>Editar Produto #<?= $produto['id'] ?></h1>
        <p class="subtitle">Modifique as informações necessárias nos campos abaixo.</p>

        <?= $mensagem ?>

        <form action="editar.php?id=<?= $produto['id'] ?>" method="POST" style="max-width: 600px; margin-top: 20px;">
            <div class="form-group">
                <label for="nome">Nome do Produto *</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($produto['nome']) ?>" required>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" class="form-control">
                        <option value="Eletrônicos" <?= $produto['categoria'] == 'Eletrônicos' ? 'selected' : '' ?>>Eletrônicos</option>
                        <option value="Moda" <?= $produto['categoria'] == 'Moda' ? 'selected' : '' ?>>Moda</option>
                        <option value="Áudio" <?= $produto['categoria'] == 'Áudio' ? 'selected' : '' ?>>Áudio</option>
                        <option value="Casa e Cozinha" <?= $produto['categoria'] == 'Casa e Cozinha' ? 'selected' : '' ?>>Casa e Cozinha</option>
                        <option value="Beleza" <?= $produto['categoria'] == 'Beleza' ? 'selected' : '' ?>>Beleza</option>
                    </select>
                </div>
                <div>
                    <label for="preco">Preço (R$) *</label>
                    <input type="number" id="preco" name="preco" step="0.01" min="0" class="form-control" value="<?= $produto['preco'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="estoque">Quantidade em Estoque</label>
                <input type="number" id="estoque" name="estoque" class="form-control" value="<?= $produto['estoque'] ?>" min="0">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição Detalhada</label>
                <textarea id="descricao" name="descricao" class="form-control"><?= htmlspecialchars($produto['descricao']) ?></textarea>
            </div>
            <div style="margin-top: 25px;">
                <button type="submit" class="btn">Atualizar Dados</button>
                <a href="index.php" class="btn btn-secondary" style="margin-left: 10px;">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
