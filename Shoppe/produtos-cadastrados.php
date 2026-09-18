<?php
require_once 'config.php';
try {
    $stmt = $pdo->query("SELECT * FROM produtos WHERE estoque > 0 ORDER BY estoque DESC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos Disponíveis - Shopee</title>
    <link rel="stylesheet" href="style.css">
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
        <h2>Produtos Prontos para Envio (Em Estoque)</h2>
        <p class="subtitle">Itens com unidades disponíveis no depósito e ativos para compra.</p>
        <table>
            <thead><tr><th>Nome</th><th>Categoria</th><th>Preço</th><th>Estoque Disponível</th></tr></thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                        <td><span class="badge-categoria"><?= htmlspecialchars($p['categoria']) ?></span></td>
                        <td><span class="price-tag">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span></td>
                        <td style="color:#2e7d32; font-weight:bold;"><?= $p['estoque'] ?> unidades</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
