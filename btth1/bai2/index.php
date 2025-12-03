 <?php
session_start();

// Đọc file quiz.txt và parse thành mảng câu hỏi
function loadQuestions() {
    $file = 'quiz.txt';
    if (!file_exists($file)) die('Không tìm thấy file quiz.txt');

    $content = file_get_contents($file);
    $blocks = array_filter(array_map('trim', preg_split('/\R{2,}/', $content)));
    $questions = [];

    foreach ($blocks as $block) {
        $lines = array_filter(array_map('trim', explode("\n", $block)));
        $q = ['question' => '', 'options' => [], 'answer' => ''];

        foreach ($lines as $line) {
            if (strpos($line, 'ANSWER:') === 0) {
                $q['answer'] = trim(substr($line, 7));
            } elseif (preg_match('/^[ABCD]\.\s/', $line)) {
                $q['options'][] = $line;
            } elseif ($q['question'] === '') {
                $q['question'] = $line;
            }
        }
        if ($q['question'] && count($q['options']) >= 4) {
            $questions[] = $q;
        }
    }
    return $questions;
}

$questions = loadQuestions();
$total = count($questions);

// Xử lý nộp bài
if ($_POST['action'] ?? '' === 'submit') {
    $score = 0;
    $results = [];
    foreach ($_POST['ans'] ?? [] as $idx => $userAns) {
        $correct = $questions[$idx]['answer'];
        $results[$idx] = [
            'user' => $userAns,
            'correct' => $correct,
            'right' => ($userAns === $correct)
        ];
        if ($userAns === $correct) $score++;
    }
    $showResult = true;
} else {
    // Khởi tạo session lần đầu
    if (!isset($_SESSION['start_time'])) {
        $_SESSION['start_time'] = time();
    }
    $showResult = false;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thi Trắc Nghiệm Android - 15 Phút</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; padding:20px; background:#f0f8ff; }
        .container { max-width:900px; margin:auto; background:white; padding:30px; border-radius:15px; box-shadow:0 10px 30px rgba(0,0,0,0.1); }
        h1 { text-align:center; color:#2c3e50; }
        .timer { text-align:center; font-size: bold 28px Arial; color:#e74c3c; margin:20px 0; }
        .question { background:#f8f9fa; padding:20px; margin:25px 0; border-radius:10px; border-left:5px solid #3498db; }
        .options label { display:block; margin:12px 0; font-size:18px; cursor:pointer; }
        .options input[type="radio"] { transform: scale(1.4); margin-right:10px; }
        .submit-btn { display:block; width:300px; margin:30px auto; padding:15px; font-size:20px; background:#27ae60; color:white; border:none; border-radius:8px; cursor:pointer; }
        .submit-btn:hover { background:#219a52; }
        .result { text-align:center; font-size:24px; margin:30px 0; }
        .correct { color:green; font-weight:bold; }
        .wrong { color:red; font-weight:bold; }
        .answer-show { color:#8e44ad; font-weight:bold; }
    </style>
</head>
<body>

<div class="container">
    <h1>THI TRẮC NGHIỆM ANDROID</h1>
    <p style="text-align:center;">Số câu: <?php echo $total; ?> | Thời gian: 15 phút</p>

    <?php if (!$showResult): ?>
        <div class="timer" id="timer">15:00</div>

        <form method="post" id="quizForm">
            <?php foreach ($questions as $i => $q): ?>
                <div class="question">
                    <p><strong>Câu <?php echo $i+1; ?>:</strong> <?php echo htmlspecialchars($q['question']); ?></p>
                    <div class="options">
                        <?php foreach ($q['options'] as $opt): ?>
                            <label>
                                <input type="radio" name="ans[<?php echo $i; ?>]" value="<?php echo substr($opt, 0, 1); ?>" required>
                                <?php echo htmlspecialchars($opt); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" name="action" value="submit" class="submit-btn">NỘP BÀI</button>
        </form>

    <?php else: ?>
        <div class="result">
            <h2>KẾT QUẢ THI</h2>
            <p>Bạn trả lời đúng: <span class="correct"><?php echo $score; ?>/<?php echo $total; ?></span> câu</p>
            <p>Điểm: <b><?php echo number_format($score / $total * 10, 1); ?>/10</b></p>
        </div>

        <?php foreach ($results as $i => $res): ?>
            <div class="question">
                <p><strong>Câu <?php echo $i+1; ?>:</strong> <?php echo htmlspecialchars($questions[$i]['question']); ?></p>
                <p>
                    Bạn chọn: <span class="<?php echo $res['right']?'correct':'wrong'; ?>">
                        <?php echo $res['user'] ?: 'Chưa chọn'; ?>
                    </span>
                    <?php if (!$res['right']): ?>
                         → Đáp án đúng: <span class="answer-show"><?php echo $res['correct']; ?></span>
                    <?php endif; ?>
                </p>
            </div>
        <?php endforeach; ?>

        <div style="text-align:center;margin-top:40px;">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="color:#3498db;font-size:18px;">Thi lại từ đầu</a>
        </div>
    <?php endif; ?>
</div>

<?php if (!$showResult): ?>
<script>
// Đếm ngược 15 phút = 900 giây
let timeLeft = 900;
const timerElement = document.getElementById('timer');

const countdown = setInterval(() => {
    timeLeft--;
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

    if (timeLeft <= 0) {
        clearInterval(countdown);
        document.getElementById('quizForm').submit(); // tự động nộp bài
    }
}, 1000);
</script>
<?php endif; ?>

</body>
</html>