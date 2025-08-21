<?php
/**
 * 👤 Arquivo para Recuperar Dados de um Jogador Específico
 * Arquivo: get_player.php
 */

require_once 'db_connection.php';

try {
    // Verificar se o nome foi fornecido
    $name = isset($_GET['name']) ? sanitizeInput($_GET['name']) : '';
    
    if (empty($name)) {
        throw new Exception('Nome do jogador é obrigatório');
    }
    
    // Buscar dados do jogador
    $playerQuery = "SELECT 
                       name,
                       total_score,
                       quiz_completed,
                       scenarios_completed,
                       completed_questions,
                       completed_scenarios,
                       created_at,
                       updated_at
                    FROM players 
                    WHERE name = ?";
    
    $stmt = executeQuery($playerQuery, [$name], 's');
    
    if (!$stmt) {
        throw new Exception('Erro ao buscar dados do jogador');
    }
    
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // Jogador não encontrado - retornar dados padrão
        echo json_encode([
            'success' => true,
            'found' => false,
            'player' => [
                'name' => $name,
                'total_score' => 0,
                'quiz_completed' => 0,
                'scenarios_completed' => 0,
                'completed_questions' => '',
                'completed_scenarios' => '',
                'position' => null
            ],
            'message' => 'Jogador não encontrado - dados padrão retornados'
        ]);
    } else {
        // Jogador encontrado
        $player = $result->fetch_assoc();
        
        // Buscar posição no ranking
        $positionQuery = "SELECT COUNT(*) + 1 as position 
                         FROM players 
                         WHERE total_score > ? 
                         OR (total_score = ? AND updated_at < ?)";
        
        $posStmt = executeQuery($positionQuery, [
            $player['total_score'], 
            $player['total_score'], 
            $player['updated_at']
        ], 'iis');
        
        $position = 1;
        if ($posStmt) {
            $posResult = $posStmt->get_result();
            if ($posRow = $posResult->fetch_assoc()) {
                $position = (int)$posRow['position'];
            }
        }
        
        echo json_encode([
            'success' => true,
            'found' => true,
            'player' => [
                'name' => $player['name'],
                'total_score' => (int)$player['total_score'],
                'quiz_completed' => (int)$player['quiz_completed'],
                'scenarios_completed' => (int)$player['scenarios_completed'],
                'completed_questions' => $player['completed_questions'],
                'completed_scenarios' => $player['completed_scenarios'],
                'position' => $position,
                'created_at' => $player['created_at'],
                'updated_at' => $player['updated_at']
            ],
            'message' => 'Dados do jogador carregados com sucesso'
        ]);
    }

} catch (Exception $e) {
    // Resposta de erro
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'found' => false,
        'error' => $e->getMessage(),
        'player' => null,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
    // Log do erro
    error_log("Erro em get_player.php: " . $e->getMessage());
}

// Fechar conexão
closeConnection();
?>