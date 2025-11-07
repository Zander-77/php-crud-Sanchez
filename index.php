<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Branch Directory System</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 50px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        
        h1 {
            color: #333;
            margin-bottom: 15px;
            font-size: 2.5em;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 40px;
            font-size: 1.1em;
        }
        
        .menu {
            display: grid;
            gap: 15px;
        }
        
        .menu-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 20px;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: bold;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .icon {
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 Student Branch Directory</h1>
        <p class="subtitle">Manage your student records efficiently</p>
        
        <div class="menu">
            <a href="create.php" class="menu-item">
                <span class="icon">➕</span>
                <span>Add New Student</span>
            </a>
            
            <a href="read.php" class="menu-item">
                <span class="icon">📋</span>
                <span>View All Students</span>
            </a>
            
            <a href="read.php" class="menu-item">
                <span class="icon">✏️</span>
                <span>Update Student</span>
            </a>
            
            <a href="read.php" class="menu-item">
                <span class="icon">🗑️</span>
                <span>Delete Student</span>
            </a>
        </div>
    </div>
</body>
</html>