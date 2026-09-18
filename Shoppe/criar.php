<?php
require_once 'config.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;
    $descricao = $_POST['descricao'] ?? '';

    if (!empty($nome) && $preco >= 0 && $estoque >= 0) {
        try {
            $stmt = $pdo->prepare("INSERT INTO produtos (nome, categoria, preco, estoque, descricao) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $categoria, $preco, $estoque, $descricao]);
            $mensagem = "<p style='color: #2e7d32; font-weight: bold;'>Produto cadastrado com sucesso na Shopee!</p>";
        } catch (PDOException $e) {
            $mensagem = "<p style='color: #d32f2f; font-weight: bold;'>Erro ao cadastrar: " . $e->getMessage() . "</p>";
        }
    } else {
        $mensagem = "<p style='color: #d32f2f; font-weight: bold;'>Por favor, preencha os campos corretamente com valores maiores ou iguais a zero.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Produto - Shopee Vendedor</title>
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
        <h1>Cadastrar Novo Produto</h1>
        <p class="subtitle">Insira as informações da mercadoria para publicar na plataforma.</p>

        <?= $mensagem ?>

        <form action="criar.php" method="POST" style="max-width: 600px; margin-top: 20px;">
            <div class="form-group">
                <label for="nome">Nome do Produto *</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Mini Lanterna Tática LED" required autofocus>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" class="form-control">
                        <option value="Eletrônicos">Eletrônicos</option>
                        <option value="Moda">Moda</option>
                        <option value="Áudio">Áudio</option>
                        <option value="Casa e Cozinha">Casa e Cozinha</option>
                        <option value="Beleza">Beleza</option>
                    </select>
                </div>
                <div>
                    <label for="preco">Preço (R$) *</label>
                    <input type="number" id="preco" name="preco" step="0.01" min="0" class="form-control" placeholder="0.00" required>
                </div>
            </div>
            <div class="form-group">
                <label for="estoque">Quantidade em Estoque</label>
                <input type="number" id="estoque" name="estoque" class="form-control" value="0" min="0">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição Detalhada</label>
                <textarea id="descricao" name="descricao" class="form-control" placeholder="Escreva sobre os benefícios do produto..."></textarea>
            </div>
            <div style="margin-top: 25px;">
                <button type="submit" class="btn">Salvar Produto</button>
                <a href="index.php" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
