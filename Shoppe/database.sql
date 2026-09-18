CREATE DATABASE IF NOT EXISTS shopee_clone;
USE shopee_clone;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    categoria VARCHAR(50),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO produtos (nome, descricao, preco, estoque, categoria) VALUES
('Mini Umidificador Portátil', 'Umidificador de ar ultrassônico com LED colorido USB.', 19.99, 150, 'Eletrônicos'),
('Fone Bluetooth de Gatinho', 'Fone de ouvido sem fio com orelhas de gato que acendem.', 45.50, 80, 'Áudio'),
('Kit 12 Pares de Meia Social', 'Meias confortáveis masculinas/femininas atacado.', 29.90, 500, 'Moda');
