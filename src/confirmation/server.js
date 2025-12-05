const express = require("express")
const nodemailer = require("nodemailer")
const crypto = require("crypto")
const path = require("path")

const app = express()
app.use(express.json())

let users = {}

const transporter = nodemailer.createTransport({
    service: "gmail",
    auth: {
        user: "tonmail@gmail.com",
        pass: "tonmotdepasse"
    }
})

app.post("/register", (req, res) => {
    const { email } = req.body
    const token = crypto.randomBytes(20).toString("hex")
    users[token] = { email, confirmed: false }
    const mailOptions = {
        from: "tonmail@gmail.com",
        to: email,
        subject: "Confirmation de compte",
        text: `Clique sur ce lien pour confirmer: http://localhost:3000/confirm/${token}`
    }
    transporter.sendMail(mailOptions, err => {
        if (err) return res.status(500).send("Erreur envoi mail")
        res.send("Mail envoyé")
    })
})

app.get("/confirm/:token", (req, res) => {
    const { token } = req.params
    if (users[token]) {
        users[token].confirmed = true
        res.sendFile(path.join(__dirname, "confirmed.html"))
    } else {
        res.sendFile(path.join(__dirname, "error.html"))
    }
})

app.listen(3000, () => console.log("Serveur lancé sur http://localhost:3000"))