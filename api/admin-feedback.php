<?php
header('Content-Type: application/json');
require_once '../config/db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';
$conn = getDB();

// Get all feedback
if ($action === 'list') {
    $sql = "SELECT id, nama, email, pesan, dibalas, created_at FROM feedback ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $feedbacks = [];
    
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $feedbacks]);
    $conn->close();
    exit;
}

// Get single feedback with replies
if ($action === 'detail' && isset($_GET['id'])) {
    $feedback_id = (int)$_GET['id'];
    
    // Get feedback
    $stmt = $conn->prepare("SELECT id, nama, email, pesan, dibalas, created_at FROM feedback WHERE id = ?");
    $stmt->bind_param('i', $feedback_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $feedback = $result->fetch_assoc();
    
    if (!$feedback) {
        echo json_encode(['success' => false, 'message' => 'Feedback not found']);
        $conn->close();
        exit;
    }
    
    // Get replies
    $stmt = $conn->prepare("SELECT id, admin_reply, created_at FROM feedback_replies WHERE feedback_id = ? ORDER BY created_at ASC");
    $stmt->bind_param('i', $feedback_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $replies = [];
    
    while ($row = $result->fetch_assoc()) {
        $replies[] = $row;
    }
    
    $feedback['replies'] = $replies;
    
    echo json_encode(['success' => true, 'data' => $feedback]);
    $stmt->close();
    $conn->close();
    exit;
}

// Add reply
if ($action === 'reply' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_id = (int)$_POST['feedback_id'] ?? 0;
    $admin_reply = trim($_POST['admin_reply'] ?? '');
    
    if (!$feedback_id || empty($admin_reply)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        $conn->close();
        exit;
    }
    
    // Insert reply
    $stmt = $conn->prepare("INSERT INTO feedback_replies (feedback_id, admin_reply) VALUES (?, ?)");
    $stmt->bind_param('is', $feedback_id, $admin_reply);
    
    if ($stmt->execute()) {
        // Mark feedback as replied
        $stmt = $conn->prepare("UPDATE feedback SET dibalas = 1 WHERE id = ?");
        $stmt->bind_param('i', $feedback_id);
        $stmt->execute();
        
        // Get the user email to compose reply message
        $stmt = $conn->prepare("SELECT email, nama FROM feedback WHERE id = ?");
        $stmt->bind_param('i', $feedback_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $feedback = $result->fetch_assoc();
        
        $replyEmail = "mailto:" . $feedback['email'] . "?subject=Balasan dari BENGPUSKOMLEKAD";
        
        echo json_encode([
            'success' => true, 
            'message' => 'Reply added successfully',
            'reply_email' => $replyEmail
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add reply']);
    }
    
    $stmt->close();
    $conn->close();
    exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid action']);
$conn->close();
?>
