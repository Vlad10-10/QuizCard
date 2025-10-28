<?php
include './components/server/server.php';

$toast = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update':
                $id = $_POST['id'];
                $question = $_POST['question'];
                $answer = $_POST['answer'];
                $sql = "UPDATE eng SET question = ?, answer = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $question, $answer, $id);
                $stmt->execute();
                $toast = "✅ Card saved!";
                break;
            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM eng WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $toast = "🗑️ Card deleted!";
                break;
        }
        header('Location: manage.php?toast=' . urlencode($toast));
        exit();
    }
}

$sql = "SELECT * FROM eng ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Cards</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <nav class="nav-menu">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">📚 FlashCards</a>
            <div class="nav-links">
                <a href="components/Eng.php">English</a>
                <a href="components/Insert.php">Add Questions</a>
                <a href="manage.php">Manage Cards</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Manage Cards</h1>
        <a href="index.php" class="btn">Back to Cards</a>
        <div class="cards-list">
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="card-item">
                <form method="POST" class="edit-form">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="question" value="<?php echo htmlspecialchars($row['question']); ?>" class="edit-input" placeholder="Question">
                    <input type="text" name="answer" value="<?php echo htmlspecialchars($row['answer']); ?>" class="edit-input" placeholder="Answer">
                    <button type="submit" class="btn-save">Save</button>
                </form>
                <form method="POST" class="delete-form">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn-delete">Delete</button>
                </form>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
    // Show toast if redirected with toast message
    if (isset($_GET['toast'])):
        $msg = $_GET['toast'];
        $type = (strpos($msg, 'deleted') !== false) ? 'delete' : ((strpos($msg, 'saved') !== false) ? 'save' : 'success');
    ?>
    <div id="toast" class="toast <?php echo $type; ?>">
        <?php echo htmlspecialchars($msg); ?>
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
