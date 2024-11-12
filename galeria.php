<?php
// Configuração da conexão com o banco de dados local
$servername = "localhost";
$username = "root";        // Nome do usuário padrão local
$password = "";            // Deixe em branco se estiver sem senha
$dbname = "meus_posts";    // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Lógica para inserir post no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    
    // Lógica para upload de imagem
    $imagem = $_FILES['imagem']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($imagem);
    
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
        // Salvar dados no banco de dados
        $sql = "INSERT INTO POST (titulo, path_imagem, descricao) VALUES ('$titulo', '$target_file', '$descricao')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Novo post adicionado com sucesso!";
        } else {
            echo "Erro ao inserir o post: " . $conn->error;
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria de Posts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Formulário para adicionar novos posts -->
    <form action="galeria.php" method="post" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required></textarea><br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem" required><br><br>

        <input type="submit" value="Adicionar Post">
    </form>

    <!-- Exibir posts salvos no banco de dados -->
    <?php
    // Consulta para exibir os posts da tabela POST
    $sql = "SELECT * FROM POST";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='galery_row'>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='galery_column'>";
            echo "<h3 class='titulo'>" . htmlspecialchars($row['titulo']) . "</h3>";
            echo "<img src='" . htmlspecialchars($row['path_imagem']) . "' alt='Imagem do Post' style='width:100%'>";
            echo "<p>" . htmlspecialchars($row['descricao']) . "</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "Nenhum post encontrado.";
    }

    $conn->close();
    ?>
</body>
</html>
