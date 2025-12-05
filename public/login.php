<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Connexion</title>
    <style>
        :root{
            --bg: #fff8f3;
            --card: #ffffff;
            --accent: #f28c38;
            --accent-hover: #d9731f;
            --text: #3a2f2f;
            --muted: #7a6a6a;
            --error: #c0392b;
            --radius: 10px;
            --shadow: 0 4px 12px rgba(0,0,0,.08);
        }

        body{
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: var(--bg);
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            color: var(--text);
            padding: 20px;
        }

        .card{
            width: 100%;
            max-width: 400px;
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        header{
            padding: 24px;
            border-bottom: 1px solid #f0d9c7;
            background: #fff3e6;
            text-align: center;
        }

        .title{
            margin: 0;
            font-size: 1.4rem;
            color: var(--text);
        }

        form{
            padding: 24px;
            display: grid;
            gap: 18px;
        }

        .field{
            display: grid;
            gap: 8px;
        }

        label{
            font-size: .9rem;
            color: var(--muted);
        }

        .input{
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e0c9b9;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .input:focus{
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(242,140,56,.25);
        }

        .btn{
            border: none;
            cursor: pointer;
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 600;
            background: var(--accent);
            color: white;
            transition: background .2s ease, transform .05s ease;
        }

        .btn:hover{ background: var(--accent-hover); }
        .btn:active{ transform: scale(.98); }

        .error{
            font-size: .85rem;
            color: var(--error);
            display: none;
        }

        .global-error{
            font-size: .85rem;
            color: var(--error);
            text-align: center;
            margin-top: -10px;
        }
    </style>
</head>
<body>
<main class="card">
    <header>
        <h1 class="title">Connexion</h1>
    </header>

    <form id="login-form" action="Retro_2000/Retro_page_1.html" method="post" novalidate>
        <?php if (isset($_GET['error'])): ?>
            <div class="global-error">Pseudo ou code PIN incorrect.</div>
        <?php endif; ?>
        <div class="field">
            <label for="pseudo">Pseudo</label>
            <input id="pseudo" name="pseudo" class="input" type="text" placeholder="Votre pseudo" required />
            <div class="error" id="pseudo-error">Veuillez entrer votre pseudo.</div>
        </div>

        <div class="field">
            <label for="code_pin">Code PIN</label>
            <input id="code_pin" name="code_pin" class="input" type="password" placeholder="Votre code PIN (4 chiffres)" required />
            <div class="error" id="code_pin-error">Veuillez entrer votre code PIN.</div>
        </div>

        <button class="btn" type="submit">Se connecter</button>
    </form>
</main>

<script>
    const form = document.getElementById('login-form');
    const pseudo = document.getElementById('pseudo');
    const codePin = document.getElementById('code_pin');
    const pseudoError = document.getElementById('pseudo-error');
    const codePinError = document.getElementById('code_pin-error');

    form.addEventListener('submit', (e) => {
        let valid = true;

        // Validation front-end
        if (!pseudo.value.trim()) {
            pseudoError.style.display = 'block';
            valid = false;
        } else {
            pseudoError.style.display = 'none';
        }

        if (!codePin.value.trim()) {
            codePinError.style.display = 'block';
            valid = false;
        } else {
            codePinError.style.display = 'none';
        }

        if (!valid) {
            e.preventDefault();
        }
    });
</script>
</body>
</html>