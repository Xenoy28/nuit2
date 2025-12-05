<?php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz NIRD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav>
        <div class="logo">NIRD Village</div>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="solution.html">Solutions</a></li>
            <li><a href="probleme.html">Problèmes</a></li>
            <li><a href="quiz.php">Quiz NIRD</a></li>
            <li><a href="Retro_2000/Retro_page_1.html">Défis</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="hero">
        <div>
            <span class="badge">Jouer</span>
            <h1>Teste tes réflexes NIRD</h1>
            <p>Réponds aux questions et découvre si ton village numérique est prêt à résister aux Big Tech.</p>
            <a href="index.php" class="button">Retour à l'accueil</a>
        </div>
        <div class="hero-card">
            <h3>But du quiz</h3>
            <p>Apprendre en quelques minutes des gestes simples pour un numérique plus responsable.</p>
            <p class="tag">5 questions, pas de pression.</p>
        </div>
    </section>

    <section class="quiz-section">
        <h2>Quiz NIRD</h2>
        <p class="quiz-intro">Clique sur la réponse qui te semble la plus NIRD.</p>

        <div class="quiz-container">
            <h3 id="question"></h3>
            <div id="choices"></div>
            <p id="feedback"></p>
            <button class="button" id="nextBtn" style="display:none;">Question suivante</button>
            <p id="scoreDisplay" class="quiz-score"></p>
        </div>
    </section>
</main>

<footer>
    Site créé pendant la Nuit de l'Info 2025 – Quiz NIRD.
</footer>

<script>

    const questions = [
        {
            text: "Ton lycée doit renouveler des ordinateurs. Quelle option est la plus responsable ?",
            choices: [
                "Acheter uniquement des PC neufs très puissants",
                "Reconditionner des PC existants et installer Linux + logiciels libres",
                "Jeter tous les vieux PC et tout racheter",
                "Ne rien faire et attendre qu’ils cassent"
            ],
            correctIndex: 1
        },
        {
            text: "Tu dois partager un document avec toute la classe. Que fais-tu ?",
            choices: [
                "Tu l’imprimes pour tout le monde",
                "Tu l’envoies en pièce jointe à 80 personnes",
                "Tu le mets dans un espace partagé et tu envoies juste le lien",
                "Tu le postes sur toutes les applis possibles"
            ],
            correctIndex: 2
        },
        {
            text: "Qu’est-ce qu’un logiciel libre ?",
            choices: [
                "Un logiciel toujours gratuit",
                "Un logiciel qu’on peut utiliser, étudier, modifier et partager",
                "Un logiciel réservé aux hackers",
                "Un logiciel qui ne marche que sur Windows"
            ],
            correctIndex: 1
        },
        {
            text: "Pour limiter l’impact de la vidéo au lycée, tu peux :",
            choices: [
                "Laisser tourner des vidéos en boucle en HD",
                "Toujours mettre les vidéos en 4K",
                "Télécharger la vidéo utile et la projeter en classe",
                "Ouvrir la même vidéo sur plusieurs onglets"
            ],
            correctIndex: 2
        },
        {
            text: "Le NIRD, c’est surtout :",
            choices: [
                "Acheter toujours plus d’objets connectés",
                "Dépendre d’une seule grosse plateforme",
                "Utiliser le numérique de manière plus sobre, inclusive et durable",
                "Supprimer complètement le numérique de l’école"
            ],
            correctIndex: 2
        }
    ];

    let current = 0;
    let score = 0;
    let answered = false;

    const questionEl = document.getElementById("question");
    const choicesEl = document.getElementById("choices");
    const feedbackEl = document.getElementById("feedback");
    const nextBtn = document.getElementById("nextBtn");
    const scoreDisplay = document.getElementById("scoreDisplay");

    function showQuestion() {
        const q = questions[current];
        questionEl.textContent = "Question " + (current + 1) + " / " + questions.length + " : " + q.text;
        choicesEl.innerHTML = "";
        feedbackEl.textContent = "";
        answered = false;
        nextBtn.style.display = "none";

        q.choices.forEach((choice, index) => {
            const div = document.createElement("div");
            div.className = "choice";
            div.textContent = choice;
            div.addEventListener("click", () => handleAnswer(index));
            choicesEl.appendChild(div);
        });
    }

    function handleAnswer(index) {
        if (answered) return;
        answered = true;

        const q = questions[current];
        const choiceDivs = document.querySelectorAll(".choice");

        choiceDivs.forEach((div, i) => {
            if (i === q.correctIndex) {
                div.classList.add("correct");
            } else if (i === index) {
                div.classList.add("wrong");
            }
        });

        if (index === q.correctIndex) {
            feedbackEl.textContent = " Bien joué, c’est la bonne réponse !";
            score++;
        } else {
            feedbackEl.textContent = "Raté, regarde la réponse en vert pour apprendre.";
        }

        nextBtn.style.display = "inline-block";
        scoreDisplay.textContent = "Score : " + score + " / " + questions.length;
    }

    nextBtn.addEventListener("click", () => {
        current++;
        if (current < questions.length) {
            showQuestion();
        } else {
            questionEl.textContent = "Quiz terminé !";
            choicesEl.innerHTML = "";
            feedbackEl.textContent = score >= 4
                ? "Tu as de très bons réflexes numériques responsables 👏"
                : "Tu peux rejouer pour progresser, chaque essai te fait avancer.";
            nextBtn.style.display = "none";
        }
    });

    showQuestion();
</script>
</body>
</html>