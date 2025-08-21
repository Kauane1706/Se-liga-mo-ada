<?php
/**
 * 🏆 Arquivo para Recuperar Ranking de Jogadores
 * Arquivo: get_ranking.php
 */

require_once 'db_connection.php';

try {
    // Parâmetros opcionais
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;  // Padrão: top 10
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0; // Para paginação
    
    // Validar limite (máximo 50 para evitar sobrecarga)
    if ($limit > 50) {
        $limit = 50;
    }
    
    // Query para buscar ranking ordenado por pontuação
    $rankingQuery = "SELECT 
                        name,
                        total_score,
                        quiz_completed,
                        scenarios_completed,
                        created_at,
                        updated_at
                     FROM players 
                     ORDER BY total_score DESC, updated_at ASC 
                     LIMIT ? OFFSET ?";
    
    $stmt = executeQuery($rankingQuery, [$limit, $offset], 'ii');
    
    if (!$stmt) {
        throw new Exception('Erro ao buscar ranking');
    }
    
    $result = $stmt->get_result();
    $players = [];
    $position = $offset + 1;
    
    while ($row = $result->fetch_assoc()) {
        $players[] = [
            'position' => $position,
            'name' => $row['name'],
            'total_score' => (int)$row['total_score'],
            'quiz_completed' => (int)$row['quiz_completed'],
            'scenarios_completed' => (int)$row['scenarios_completed'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];
        $position++;
    }
    
    // Buscar estatísticas globais
    $statsQuery = "SELECT 
                      COUNT(*) as total_players,
                      AVG(total_score) as average_score,
                      MAX(total_score) as highest_score,
                      SUM(quiz_completed) as total_quizzes,
                      SUM(scenarios_completed) as total_scenarios
                   FROM players";
    
    $statsStmt = executeQuery($statsQuery);
    $stats = ['total_players' => 0, 'average_score' => 0, 'highest_score' => 0];
    
    if ($statsStmt) {
        $statsResult = $statsStmt->get_result();
        if ($statsRow = $statsResult->fetch_assoc()) {
            $stats = [
                'total_players' => (int)$statsRow['total_players'],
                'average_score' => round((float)$statsRow['average_score'], 1),
                'highest_score' => (int)$statsRow['highest_score'],
                'total_quizzes' => (int)$statsRow['total_quizzes'],
                'total_scenarios' => (int)$statsRow['total_scenarios']
            ];
        }
    }
    
    // Resposta de sucesso
    echo json_encode([
        'success' => true,
        'ranking' => $players,
        'stats' => $stats,
        'pagination' => [
            'limit' => $limit,
            'offset' => $offset,
            'count' => count($players)
        ],
        'timestamp' => date('Y-m-d H:i:s')
    ]);

} catch (Exception $e) {
    // Resposta de erro
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'ranking' => [],
        'stats' => ['total_players' => 0, 'average_score' => 0, 'highest_score' => 0],
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
    // Log do erro
    error_log("Erro em get_ranking.php: " . $e->getMessage());
}

// Fechar conexão
closeConnection();
?>