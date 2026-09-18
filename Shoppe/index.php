<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC LIMIT 5");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_produtos = $pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
    $total_estoque = $pdo->query("SELECT SUM(estoque) FROM produtos")->fetchColumn() ?? 0;
    $esgotados = $pdo->query("SELECT COUNT(*) FROM produtos WHERE estoque = 0")->fetchColumn();
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Vendedor - Shopee Clone</title>
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
        <h1>Bem-vindo de volta, Vendedor!</h1>
        <p class="subtitle">Gerencie suas mercadorias e acompanhe seus estoques aqui no painel de controle.</p>

        <div class="dashboard-grid">
            <div class="card card-produtos">
                <div>
                    <h3>Produtos Cadastrados</h3>
                    <p class="number"><?= $total_produtos ?></p>
                </div>
            </div>

            <div class="card card-estoque">
                <div>
                    <h3>Total em Estoque</h3>
                    <p class="number"><?= $total_estoque ?> un.</p>
                </div>
            </div>

            <div class="card card-esgotados">
                <div>
                    <h3>Produtos Esgotados</h3>
                    <p class="number"><?= $esgotados ?></p>
                </div>
            </div>
        </div>

        <div class="table-header-row">
            <h2>Adicionados Recentemente</h2>
            <a href="criar.php" class="btn">Novo Produto</a>
        </div>

        <?php if (empty($produtos)): ?>
            <div class="empty-state">
                <p>Nenhum produto cadastrado ainda. Que tal criar o primeiro?</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Produto</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td>#<?= $produto['id'] ?></td>
                            <td style="font-weight: bold;"><?= htmlspecialchars($produto['nome']) ?></td>
                            <td><span class="badge-categoria"><?= htmlspecialchars($produto['categoria']) ?></span></td>
                            <td><span class="price-tag">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span></td>
                            <td>
                                <?php if ($produto['estoque'] == 0): ?>
                                    <span class="status-esgotado">Esgotado</span>
                                <?php else: ?>
                                    <?= $produto['estoque'] ?> un.
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="editar.php?id=<?= $produto['id'] ?>" class="btn btn-secondary btn-table" title="Editar">Editar</a>
                                <a href="excluir.php?id=<?= $produto['id'] ?>" class="btn btn-danger btn-table" title="Excluir" onclick="confirmarExclusao(event, '<?= htmlspecialchars($produto['nome'], ENT_QUOTES) ?>')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <a href="biblioteca.php" class="view-all-link">Ver todos os produtos</a>
        <?php endif; ?>
    </div>
</body>
</html>
