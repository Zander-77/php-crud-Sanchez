<?php
require_once 'db.php';

$message = '';
$messageType = '';
$student = null;

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
            $sql = "UPDATE students SET student_no = ?, fullname = ?, branch = ?, email = ?, contact = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$student_no, $fullname, $branch, $email, $contact, $id]);
            
            $message = 'Student updated successfully!';
            $messageType = 'success';
             
            $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
            $stmt->execute([$id]);
            $student = $stmt->fetch();
            
            header("refresh:2;url=read.php");
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
    <title>Update Student</title>
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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
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
        
        .student-info {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Update Student Information</h1>
        
        <div class="student-info">
            Editing: <strong><?php echo htmlspecialchars($student['fullname']); ?></strong> (ID: <?php echo $student['id']; ?>)
        </div>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
                <?php if ($messageType == 'success'): ?>
                    <br><small>Redirecting to student list...</small>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Student Number <span class="required">*</span></label>
                <input type="text" name="student_no" required value="<?php echo htmlspecialchars($student['student_no']); ?>">
            </div>
            
            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="fullname" required value="<?php echo htmlspecialchars($student['fullname']); ?>">
            </div>
            
            <div class="form-group">
                <label>Branch <span class="required">*</span></label>
                <select name="branch" required>
                    <option value="">-- Select Branch --</option>
                    <option value="Manila" <?php echo ($student['branch'] == 'Manila') ? 'selected' : ''; ?>>Manila</option>
                    <option value="Quezon City" <?php echo ($student['branch'] == 'Quezon City') ? 'selected' : ''; ?>>Quezon City</option>
                    <option value="Makati" <?php echo ($student['branch'] == 'Makati') ? 'selected' : ''; ?>>Makati</option>
                    <option value="Pasig" <?php echo ($student['branch'] == 'Pasig') ? 'selected' : ''; ?>>Pasig</option>
                    <option value="Taguig" <?php echo ($student['branch'] == 'Taguig') ? 'selected' : ''; ?>>Taguig</option>
                    <option value="Cebu" <?php echo ($student['branch'] == 'Cebu') ? 'selected' : ''; ?>>Cebu</option>
                    <option value="Davao" <?php echo ($student['branch'] == 'Davao') ? 'selected' : ''; ?>>Davao</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" required value="<?php echo htmlspecialchars($student['email']); ?>">
            </div>
            
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact" value="<?php echo htmlspecialchars($student['contact']); ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">Update Student</button>
            <a href="read.php" class="btn btn-secondary" style="text-decoration: none; display: block; text-align: center;">Cancel</a>
        </form>
    </div>
</body>
</html>