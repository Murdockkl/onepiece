CREATE DATABASE meus_posts;

USE meus_posts;

CREATE TABLE POST (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    path_imagem VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Exemplo de dados de post
INSERT INTO POST (titulo, path_imagem, descricao) VALUES
('Exemplo de Post 1', 'uploads/exemplo1.jpg', 'Descrição do primeiro post.'),
('Exemplo de Post 2', 'uploads/exemplo2.jpg', 'Descrição do segundo post.');