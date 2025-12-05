<!DOCTYPE html>
<html>
<body>
<form id="registerForm">
    <input type="email" id="email" placeholder="Votre email" required>
    <button type="submit">S'inscrire</button>
</form>
<script>
    document.getElementById("registerForm").addEventListener("submit", async e => {
        e.preventDefault()
        const email = document.getElementById("email").value
        await fetch("http://localhost:3000/register", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email })
        })
        alert("Vérifiez vos mails pour confirmer")
    })
</script>
</body>
</html>