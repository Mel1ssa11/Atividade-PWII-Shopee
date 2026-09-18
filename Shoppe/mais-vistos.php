<?php
require_once 'config.php';
try {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY preco DESC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Mais Vistos - Shopee</title>
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
        <h2>Popularidade: Produtos Mais Clicados do Dia</h2>
        <p class="subtitle">Métricas simuladas de visualizações e interesse dos compradores na plataforma.</p>
        
        <?php if (empty($produtos)): ?>
            <div class="empty-state"><p>Nenhum produto cadastrado para gerar estatísticas.</p></div>
        <?php else: ?>
            <table>
                <thead><tr><th>Nome</th><th>Preço</th><th>Tendência</th><th>Cliques Estimados</th></tr></thead>
                <tbody>
                    <?php foreach ($produtos as $index => $p): 
                        $views = ($p['id'] * 147) % 850 + 50; 
                    ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                            <td><span class="price-tag">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span></td>
                            <td>
                                <?php if($index == 0): ?>
                                    <span style="color:#d32f2f; font-weight:bold;">#1 Em Alta</span>
                                <?php else: ?>
                                    <span style="color:#2e7d32;">Relevante</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $views ?> acessos</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
