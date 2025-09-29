<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> - Test Vocacional</title>
    <link rel="stylesheet" href="/test-vocacional/assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">🎯 Test Vocacional</div>
        <div class="nav-menu">
            <span>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="/test-vocacional/logout" class="btn btn-sm btn-outline">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="test-header">
        <h1>Test de Orientación Vocacional</h1>
        <p>Responde cada pregunta según tus intereses, habilidades y valores personales</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
    </div>

    <div class="progress-container">
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
        <span class="progress-text" id="progressText">0% completado</span>
    </div>

    <form method="POST" action="/test-vocacional/test/submit" id="testForm">
        <?php
        $questionCount = 0;
        $totalQuestions = 0;
        foreach ($questions as $categoryQuestions) {
            foreach ($categoryQuestions as $typeQuestions) {
                $totalQuestions += count($typeQuestions);
            }
        }
        ?>

        <?php foreach ($questions as $category => $categoryQuestions): ?>
            <div class="category-section">
                <h2><?= ucfirst($category) ?></h2>
                <?php foreach ($categoryQuestions as $type => $typeQuestions): ?>
                    <div class="type-subsection">
                        <h3><?= ucfirst($type) ?></h3>
                        <?php foreach ($typeQuestions as $question): ?>
                            <?php $questionCount++; ?>
                            <div class="question-card" data-question="<?= $questionCount ?>">
                                <p class="question-text"><?= htmlspecialchars($question['pregunta']) ?></p>

                                <div class="likert-scale">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <label class="likert-option">
                                            <input type="radio"
                                                   name="respuestas[<?= $question['id'] ?>]"
                                                   value="<?= $i ?>"
                                                   required
                                                   onchange="updateProgress()">
                                            <span class="likert-label"><?= $i ?></span>
                                        </label>
                                    <?php endfor; ?>
                                </div>

                                <div class="likert-labels">
                                    <span>Totalmente en desacuerdo</span>
                                    <span>Totalmente de acuerdo</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-lg">Finalizar Test y Ver Resultados</button>
        </div>
    </form>
</div>

<script>
    function updateProgress() {
        const total = <?= $totalQuestions ?>;
        const answered = document.querySelectorAll('input[type="radio"]:checked').length;
        const percent = Math.round((answered / total) * 100);
        document.getElementById('progressFill').style.width = percent + '%';
        document.getElementById('progressText').textContent = percent + '% completado';
    }

    // Guardar progreso en localStorage
    function saveProgress() {
        const formData = new FormData(document.getElementById('testForm'));
        const responses = {};
        for (let [key, value] of formData.entries()) responses[key] = value;
        localStorage.setItem('testProgress', JSON.stringify(responses));
    }

    function restoreProgress() {
        const saved = localStorage.getItem('testProgress');
        if (saved) {
            const responses = JSON.parse(saved);
            for (let key in responses) {
                const input = document.querySelector(`input[name="${key}"][value="${responses[key]}"]`);
                if (input) input.checked = true;
            }
            updateProgress();
        }
    }

    // Validación antes de enviar
    document.getElementById('testForm').addEventListener('submit', function (e) {
        const total = <?= $totalQuestions ?>;
        const answered = document.querySelectorAll('input[type="radio"]:checked').length;
        if (answered < total) {
            e.preventDefault();
            alert('Por favor responde todas las preguntas antes de continuar.');
        } else {
            localStorage.removeItem('testForm');
        }
    });

    // Auto-guardado cada 10 segundos
    setInterval(saveProgress, 10000);

    // Inicializar
    restoreProgress();
    updateProgress();
</script>
</body>
</html>