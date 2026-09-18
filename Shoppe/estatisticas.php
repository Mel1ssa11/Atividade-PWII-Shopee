<?php
require_once 'config.php';
try {
    // Conta a variedade de produtos
    $total_itens = $pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
    
    // Soma a quantidade física de todos os itens no estoque
    $total_estoque = $pdo->query("SELECT SUM(estoque) FROM produtos")->fetchColumn() ?? 0;
    
    // Calcula o valor total financeiro em mercadoria (Preço * Estoque)
    $valor_total_estoque = $pdo->query("SELECT SUM(preco * estoque) FROM produtos")->fetchColumn() ?? 0;
    
    // Média de preço dos itens cadastrados
    $preco_medio = $pdo->query("SELECT AVG(preco) FROM produtos")->fetchColumn() ?? 0;
} catch (PDOException $e) { 
    die("Erro ao carregar relatório: " . $e->getMessage()); 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios - Shopee Vendedor</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
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
        <h2>Relatório de Patrimônio do Estoque</h2>
        <p class="subtitle">Estatísticas calculadas em tempo real com base no inventário.</p>
        
        <div style="background: #fafafa; padding: 25px; border-radius: 4px; border: 1px solid #ddd; max-width: 500px;">
            <p style="font-size: 16px; margin-bottom: 10px;">Variedade de Modelos: <strong><?= $total_itens ?> itens cadastrados</strong></p>
            <p style="font-size: 16px; margin-bottom: 10px;">Volume Físico no Depósito: <strong><?= $total_estoque ?> unidades totais</strong></p>
            <p style="font-size: 16px; margin-bottom: 10px;">Preço Médio dos Produtos: <strong style="color: var(--shopee-orange);">R$ <?= number_format($preco_medio, 2, ',', '.') ?></strong></p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            <p style="font-size: 18px; font-weight: bold; color: #2e7d32;">Valor Total de Mercado Em Stock:<br>R$ <?= number_format($valor_total_estoque, 2, ',', '.') ?></p>
        </div>
    </div>
</body>
</html>
