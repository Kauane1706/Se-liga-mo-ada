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

// Receber dados do jogador via POST
$name = $_POST['name'];
$total_score = $_POST['total_score'];
$quiz_completed = $_POST['quiz_completed'];
$scenarios_completed = $_POST['scenarios_completed'];

// Inserir ou atualizar os dados do jogador
$sql = "INSERT INTO players (name, total_score, quiz_completed, scenarios_completed)
        VALUES ('$name', $total_score, $quiz_completed, $scenarios_completed)
        ON DUPLICATE KEY UPDATE
        total_score = $total_score,
        quiz_completed = $quiz_completed,
        scenarios_completed = $scenarios_completed";

if ($conn->query($sql) === TRUE) {
    echo "Dados salvos com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
