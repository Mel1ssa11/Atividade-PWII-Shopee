// Função para confirmar a exclusão de um produto
function confirmarExclusao(event, nomeProduto) {
    // Exibe a caixinha de confirmação nativa do navegador
    const confirmou = confirm("Tem certeza que deseja excluir o produto \"" + nomeProduto + "\" permanentemente?");
    
    // Se o usuário clicar em "Cancelar", impede o redirecionamento do link PHP
    if (!confirmou) {
        event.preventDefault();
        return false;
    }
    
    return true;
}
