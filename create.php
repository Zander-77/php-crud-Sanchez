<?php
require_once 'db.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_no = trim($_POST['student_no']);
    $fullname = trim($_POST['fullname']);
    $branch = $_POST['branch'];
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    
    if (empty($student_no) || empty($fullname) || empty($branch) || empty($email)) {
        $message = 'Please fill in all required fields!';
        $messageType = 'error';
    } else {
        try {
            $sql = "INSERT INTO students (student_no, fullname, branch, email, contact) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$student_no, $fullname, $branch, $email, $contact]);
            
            $message = 'Student added successfully!';
            $messageType = 'success';
            
            $_POST = array();
        } catch(PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $messageType = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .required {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Add New Student</h1>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Student Number <span class="required">*</span></label>
                <input type="text" name="student_no" required placeholder="e.g., 2024-00001">
            </div>
            
            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="fullname" required placeholder="e.g., Juan Dela Cruz">
            </div>
            
            <div class="form-group">
                <label>Branch <span class="required">*</span></label>
                <select name="branch" required>
                    <option value="">-- Select Branch --</option>
                    <option value="Manila">Manila</option>
                    <option value="Quezon City">Quezon City</option>
                    <option value="Makati">Makati</option>
                    <option value="Pasig">Pasig</option>
                    <option value="Taguig">Taguig</option>
                    <option value="Cebu">Cebu</option>
                    <option value="Davao">Davao</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" required placeholder="e.g., juan@email.com">
            </div>
            
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact" placeholder="e.g., 09123456789">
            </div>
            
            <button type="submit" class="btn btn-primary">Add Student</button>
            <a href="index.php" class="btn btn-secondary" style="text-decoration: none; display: block; text-align: center;">Back to Home</a>
        </form>
    </div>
</body>
</html>