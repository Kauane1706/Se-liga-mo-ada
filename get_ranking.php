<?php
$servername = "localhost";
$username = "root"; // Substitua pelo seu usuário do MySQL
$password = ""; // Substitua pela sua senha do MySQL
$dbname = "relacoes_respeitosas";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recuperar os 10 melhores jogadores
$sql = "SELECT name, total_score FROM players ORDER BY total_score DESC LIMIT 10";
$result = $conn->query($sql);

$ranking = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ranking[] = $row;
    }
}

// Retornar os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($ranking);

$conn->close();
?>
