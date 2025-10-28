<?php
include './server/server.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>English Flashcards</title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
<nav class="nav-menu">
    <div class="nav-container">
        <a href="../index.php" class="nav-logo">📚 FlashCards</a>
        <div class="nav-links">
            <a href="EngTest.php">🧠 Start Test</a>
            <a href="Insert.php">➕ Add Questions</a>
        </div>
    </div>
</nav>

<div class="card">
    <h2>English Flashcards</h2>
    <ul class="themes">
        <li>
            <a href="EngTest.php" class="btn btn-primary">
                Practice & Test Your Knowledge
            </a>
        </li>
        <li>
            <a href="Insert.php" class="btn btn-success">
                Add New Flashcard
            </a>
        </li>
    </ul>
</div>
</body>
</html>
