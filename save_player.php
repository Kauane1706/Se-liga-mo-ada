<?php
/**
 * 💾 Arquivo para Salvar Dados do Jogador
 * Arquivo: save_player.php
 */

require_once 'db_connection.php';

// Verificar se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

try {
    // Receber e validar dados
    $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
    $total_score = isset($_POST['total_score']) ? (int)$_POST['total_score'] : 0;
    $quiz_completed = isset($_POST['quiz_completed']) ? (int)$_POST['quiz_completed'] : 0;
    $scenarios_completed = isset($_POST['scenarios_completed']) ? (int)$_POST['scenarios_completed'] : 0;
    $completed_questions = isset($_POST['completed_questions']) ? $_POST['completed_questions'] : '';
    $completed_scenarios = isset($_POST['completed_scenarios']) ? $_POST['completed_scenarios'] : '';

    // Validar nome (obrigatório)
    if (empty($name)) {
        throw new Exception('Nome é obrigatório');
    }

    // Validar tamanho do nome
    if (strlen($name) > 100) {
        throw new Exception('Nome muito longo (máximo 100 caracteres)');
    }

    // Verificar se o jogador já existe
    $checkQuery = "SELECT id, total_score FROM players WHERE name = ?";
    $checkStmt = executeQuery($checkQuery, [$name], 's');
    
    if (!$checkStmt) {
        throw new Exception('Erro ao verificar jogador existente');
    }

    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        // Jogador existe - ATUALIZAR dados
        $existingPlayer = $result->fetch_assoc();
        
        // Só atualizar se a nova pontuação for maior ou igual (evitar regressão)
        if ($total_score >= $existingPlayer['total_score']) {
            $updateQuery = "UPDATE players SET 
                           total_score = ?, 
                           quiz_completed = ?, 
                           scenarios_completed = ?,
                           completed_questions = ?,
                           completed_scenarios = ?,
                           updated_at = CURRENT_TIMESTAMP 
                           WHERE name = ?";
            
            $updateStmt = executeQuery($updateQuery, [
                $total_score, 
                $quiz_completed, 
                $scenarios_completed,
                $completed_questions,
                $completed_scenarios,
                $name
            ], 'iiisss');
            
            if (!$updateStmt) {
                throw new Exception('Erro ao atualizar dados do jogador');
            }
            
            $message = 'Dados atualizados com sucesso!';
            $action = 'updated';
        } else {
            $message = 'Dados não atualizados (pontuação menor que a atual)';
            $action = 'skipped';
        }
        
    } else {
        // Jogador não existe - INSERIR novo
        $insertQuery = "INSERT INTO players (name, total_score, quiz_completed, scenarios_completed, completed_questions, completed_scenarios) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        
        $insertStmt = executeQuery($insertQuery, [
            $name, 
            $total_score, 
            $quiz_completed, 
            $scenarios_completed,
            $completed_questions,
            $completed_scenarios
        ], 'siisss');
        
        if (!$insertStmt) {
            throw new Exception('Erro ao inserir novo jogador');
        }
        
        $message = 'Jogador cadastrado com sucesso!';
        $action = 'inserted';
    }

    // Resposta de sucesso
    echo json_encode([
        'success' => true,
        'message' => $message,
        'action' => $action,
        'data' => [
            'name' => $name,
            'total_score' => $total_score,
            'quiz_completed' => $quiz_completed,
            'scenarios_completed' => $scenarios_completed
        ]
    ]);

} catch (Exception $e) {
    // Resposta de erro
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
    // Log do erro (opcional)
    error_log("Erro em save_player.php: " . $e->getMessage());
}

// Fechar conexão
closeConnection();
?>