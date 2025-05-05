const express = require('express');
const nodemailer = require('nodemailer');
const app = express();
app.use(express.json());

const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: 'sajatemailed@gmail.com',
        pass: 'jelszavad'
    }
});

app.post('/send-verification-email', (req, res) => {
    const { email, code } = req.body;
    const mailOptions = {
        from: 'sajatemailed@gmail.com',
        to: email,
        subject: 'Ellenőrző kód - DriveUs',
        text: `Az ellenőrző kódod: ${code}`
    };
    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            return res.status(500).send('Hiba az email küldésekor');
        }
        res.status(200).send('Email elküldve');
    });
});

app.listen(3000, () => console.log('Szerver fut a 3000-es porton'));