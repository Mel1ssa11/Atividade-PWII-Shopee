<?php
require_once 'config.php';
try {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY nome ASC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista Geral - Shopee Vendedor</title>
    <link rel="stylesheet" href="style.css">
    <!-- Vinculo com o script de exclusao externa -->
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
        <div class="table-header-row">
            <h2>Catálogo Completo de Mercadorias</h2>
            <a href="criar.php" class="btn">Adicionar</a>
        </div>

        <?php if (empty($produtos)): ?>
            <div class="empty-state"><p>Nenhum produto cadastrado.</p></div>
        <?php else: ?>
            <table>
                <thead>
                    <tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th style="text-align:center;">Ações</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td>#<?= $p['id'] ?></td>
                            <td><strong><?= htmlspecialchars($p['nome']) ?></strong><br><small style="color:#777;"><?= htmlspecialchars($p['descricao'] ?? '') ?></small></td>
                            <td><span class="badge-categoria"><?= htmlspecialchars($p['categoria']) ?></span></td>
                            <td><span class="price-tag">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span></td>
                            <td><?= $p['estoque'] == 0 ? '<span class="status-esgotado">Esgotado</span>' : $p['estoque'].' un.' ?></td>
                            <td style="text-align:center;">
                                <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-secondary btn-table">Editar</a>
                                <a href="excluir.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-table" onclick="confirmarExclusao(event, '<?= htmlspecialchars($p['nome'], ENT_QUOTES) ?>')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
