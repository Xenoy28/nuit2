<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Village Numérique Résistant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
     <nav>
        <div class="logo">
            <a href="index.php" title="image">
                <img src="nird.png" alt="nird" width="100" height="100">
            </a>
        </div>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="solution.html">Solutions</a></li>
            <li><a href="probleme.html">Problèmes</a></li>
            <li><a href="quiz.php">Quiz NIRD</a></li>
            <li><a href="Retro_2000/Retro_page_1.html">Défis</a></li>
            <li><a href="snake.html">Snake</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="hero">
    <img src="nird.png" alt="nird" width="400" height="400">
        <p>Pourquoi la fin de Windows&nbsp;10 pose problème ? Que sont les logiciels libres ?</p>
    </div>

    <section class="grid">
        <article class="card">
            <h3>Problèmes</h3>
            <p>Pourquoi la fin de Windows&nbsp;10 pose problème ? Que sont les logiciels libres ?</p>
            <span class="tag">Info rapide</span><br>
            <a class="button card-btn" href="comprendre.php">Résoudre les probèmes</a>
        </article>

        <article class="card">
            <h3>Jouer</h3>
            <p>Un quiz rapide pour tester tes réflexes NIRD et un générateur de défis pour ton établissement.</p>
            <span class="tag">Ludique</span><br>
            <a class="button card-btn" href="quiz.php">Je joue</a>
        </article>

        <article class="card">
            <h3>Agir</h3>
            <p>À la fin, tu repars avec une petite liste d’actions concrètes pour ton lycée.</p>
            <span class="tag">Concret</span><br>
            <a class="button card-btn" href="agir.php">Je passe à l'action</a>
        </article>
        <article class="card">
            <h3>solutions</h3>
            <p>À la fin, tu repars avec une petite liste d’actions concrètes pour ton lycée.</p>
            <span class="tag">Concret</span><br>
            <a class="button card-btn" href="agir.php">Accèder aux solutions</a>
        </article>
    </section>

</main>

<footer>
    Site créé pendant la Nuit de l'Info 2025 – contenu simplifié autour de la démarche NIRD.
</footer>
</body>
</html>
