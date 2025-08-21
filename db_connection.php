<?php
/**
 * 🔌 Arquivo de Conexão com o Banco de Dados MySQL
 * Arquivo: db_connection.php
 */

// Configurações do banco de dados
$host = 'localhost';        // Geralmente 'localhost' no XAMPP/WAMP
$username = 'root';         // Usuário padrão do MySQL
$password = '';             // Senha (vazia por padrão no XAMPP)
$database = 'relacoes_respeitosas';

// Criar conexão
$conn = new mysqli($host, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Definir charset para evitar problemas de acentuação
$conn->set_charset("utf8mb4");

// Função para fechar conexão (opcional)
function closeConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}

// Função para executar queries com segurança
function executeQuery($query, $params = [], $types = '') {
    global $conn;
    
    try {
        $stmt = $conn->prepare($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt;
        
    } catch (Exception $e) {
        error_log("Erro na query: " . $e->getMessage());
        return false;
    }
}

// Função para validar e limpar dados
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Headers para CORS (se necessário)
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

?>