<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        die("Erro ao excluir produto: " . $e->getMessage());
    }
}

header('Location: index.php');
exit;
