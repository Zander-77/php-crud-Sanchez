<?php
require_once 'db.php';

$student = null;
$deleted = false;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: read.php');
    exit();
}

$id = $_GET['id'];

try {
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $student = $stmt->fetch();
    
    if (!$student) {
        header('Location: read.php');
        exit();
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        $deleted = true;
        
        header("refresh:2;url=read.php");
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
        }
        
        h1 {
            color: #dc3545;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .warning-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .warning-icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .warning-text {
            color: #856404;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .warning-details {
            color: #856404;
            text-align: center;
            font-size: 14px;
        }
        
        .student-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: bold;
            color: #495057;
        }
        
        .detail-value {
            color: #212529;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .success-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($deleted): ?>
            <div class="success-message">
                <div class="success-icon">✅</div>
                <h2>Student Deleted Successfully!</h2>
                <p>Redirecting to student list...</p>
            </div>
            <a href="read.php" class="btn btn-secondary">Go to Student List</a>
        <?php else: ?>
            <h1>🗑️ Delete Student</h1>
            
            <div class="warning-box">
                <div class="warning-icon">⚠️</div>
                <div class="warning-text">WARNING: This action cannot be undone!</div>
                <div class="warning-details">
                    You are about to permanently delete this student record from the database.
                </div>
            </div>
            
            <div class="student-details">
                <h3 style="margin-bottom: 15px; color: #dc3545;">Student Information to be Deleted:</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Student ID:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($student['id']); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Student Number:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($student['student_no']); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Full Name:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($student['fullname']); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Branch:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($student['branch']); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($student['email']); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Contact:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($student['contact']); ?></span>
                </div>
            </div>
            
            <form method="POST" action="">
                <div class="button-group">
                    <button type="submit" name="confirm_delete" class="btn btn-danger" onclick="return confirm('Are you absolutely sure you want to delete this student?');">
                        🗑️ Confirm Delete
                    </button>
                    <a href="read.php" class="btn btn-secondary">
                        ↩️ Cancel
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>