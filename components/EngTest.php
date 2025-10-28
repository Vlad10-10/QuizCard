<?php
include './server/server.php';

// Если engtest пустая, копируем все вопросы из eng
$check = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM engtest");
$row = mysqli_fetch_assoc($check);
if($row['cnt'] == 0){
    mysqli_query($conn, "INSERT INTO engtest (question, answer) SELECT question, answer FROM eng");
}

// Получаем все вопросы из engtest
$result = mysqli_query($conn, "SELECT * FROM engtest");
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
$questions_json = json_encode($questions);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>English Test</title>
<link rel="stylesheet" href="../styles/main.css">
<style>
/* Add flashcard feedback colors */
.flashcard.correct {
    background: #10b981 !important;
    color: #fff !important;
    transition: background 0.3s;
}
.flashcard.wrong {
    background: #ef4444 !important;
    color: #fff !important;
    transition: background 0.3s;
}
/* Overlay for feedback */
body.bg-correct::before,
body.bg-wrong::before {
    content: "";
    position: fixed;
    inset: 0;
    z-index: 9998;
    pointer-events: none;
    opacity: 0.4;
}
body.bg-correct::before {
    background: #10b981;
}
body.bg-wrong::before {
    background: #ef4444;
}
</style>
</head>
<body>

<!-- Навигация -->
<nav class="nav-menu">
    <div class="nav-container">
        <a href="../index.php" class="nav-logo">📚 FlashCards</a>
        <div class="nav-links">
            <a href="Eng.php">English</a>
            <a href="Insert.php">Add Questions</a>
            <a href="EngTest.php">Start Test</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 style="text-align:center; margin-bottom:2rem; color:var(--primary); font-size:2rem;">English Flashcard Test</h2>
    <div class="flashcard-container">
        <button class="btn btn-danger" id="wrong" title="Skip">✗</button>
        <div class="flashcard" id="card">
            <div class="flashcard-inner">
                <div class="flashcard-front" id="card-front"></div>
                <div class="flashcard-back" id="card-back"></div>
            </div>
        </div>
        <button class="btn btn-success" id="correct" title="Mark as Correct">✓</button>
    </div>
    <div class="end-msg" id="end-msg" style="display:none;">
        🎉 Test finished! All answers correct.<br>
        <a href="Eng.php">Return to Home</a>
    </div>
</div>

<script>
let questions = <?= $questions_json ?>;
let index = 0;

const card = document.getElementById('card');
const cardFront = document.getElementById('card-front');
const cardBack = document.getElementById('card-back');
const endMsg = document.getElementById('end-msg');
const wrongBtn = document.getElementById('wrong');
const correctBtn = document.getElementById('correct');

function showQuestion() {
    if(questions.length === 0){
        document.querySelector('.container').style.display = 'none';
        endMsg.style.display = 'block';
        return;
    }
    if(index >= questions.length) index = 0;
    cardFront.textContent = questions[index].question;
    cardBack.textContent = questions[index].answer;
    card.classList.remove('flipped');
}

showQuestion();

card.addEventListener('click', ()=>{
    card.classList.toggle('flipped');
});

wrongBtn.addEventListener('click', ()=>{
    document.body.classList.add('bg-wrong');
    setTimeout(()=>{
        document.body.classList.remove('bg-wrong');
        index++;
        showQuestion();
    }, 1000);
});

correctBtn.addEventListener('click', ()=>{
    document.body.classList.add('bg-correct');
    const id = questions[index].id;

    fetch('delete_question.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id='+id
    }).then(()=>{
        setTimeout(()=>{
            document.body.classList.remove('bg-correct');
            questions.splice(index,1);
            showQuestion();
        }, 1000);
    });
});

</script>

</body>
</html>
