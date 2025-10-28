<?php
include './server/server.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $quest = mysqli_real_escape_string($conn, $_POST['question']);
    $answ = mysqli_real_escape_string($conn, $_POST['answer']);
    $sql = "INSERT INTO eng (question, answer) VALUES ('$quest', '$answ')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $toast = "✅ Question added successfully!";
    } else {
        $toast = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Question</title>
<link rel="stylesheet" href="../styles/main.css">
<style>
/* Toast styles */
    .toast {
        position: fixed;
        top: 24px;
        right: 24px;
        min-width: 220px;
        background: #fff;
        color: #232946;
        border-radius: 8px;
        box-shadow: 0 4px 24px rgba(44,62,80,0.13);
        padding: 1rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transform: translateY(-20px);
        transition: opacity 0.4s, transform 0.4s;
    }
    .toast.show {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }
    .toast.success { border-left: 6px solid #10b981; }
    .toast.error { border-left: 6px solid #ef4444; }
    </style>
</head>
<body>

<nav class="nav-menu">
    <div class="nav-container">
        <a href="../index.php" class="nav-logo">📚 FlashCards</a>
        <div class="nav-links">
            <a href="Eng.php">English</a>
            <a href="EngTest.php">Start Test</a>
            <a href="Insert.php">Add Questions</a>
        </div>
    </div>
</nav>

<div class="form-container">
    <h2>Add New Question</h2>
    <form method="POST">
        <div class="form-group">
            <input type="text" name="question" id="question" class="form-input" placeholder=" " required>
            <label for="question" class="form-label">Question</label>
        </div>
        <div class="form-group">
            <input type="text" name="answer" id="answer" class="form-input" placeholder=" " required>
            <label for="answer" class="form-label">Answer</label>
        </div>
        <button type="submit" name="submit" class="btn btn-success">Add Question</button>
    </form>
</div>
<?php if(isset($toast)): ?>
    <div id="toast" class="toast <?php echo (strpos($toast, 'successfully') !== false) ? 'success' : 'error'; ?>">
        <?php echo $toast; ?>
    </div>
    <script>
    setTimeout(function(){
        document.getElementById('toast').classList.add('show');
        setTimeout(function(){
            document.getElementById('toast').classList.remove('show');
        }, 2500);
    }, 200);
    </script>
<?php endif; ?>

</body>
</html>
