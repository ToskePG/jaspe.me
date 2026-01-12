<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
        }

        /* Container */
        .coming-soon {
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Logo */
        .coming-soon img {
            width: 150px;
            margin-bottom: 30px;
            animation: logoBounce 2s infinite;
        }

        /* Heading */
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.8;
        }

        /* Countdown placeholder */
        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 1.2rem;
        }

        .countdown div {
            background: rgba(255,255,255,0.1);
            padding: 15px 20px;
            border-radius: 10px;
            min-width: 70px;
        }

        .countdown div span {
            display: block;
            font-size: 2rem;
            font-weight: bold;
        }

        /* Footer */
        footer {
            margin-top: 50px;
            font-size: 0.9rem;
            opacity: 0.6;
        }

        /* Animations */
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes logoBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <div class="coming-soon">
        <img src="assets/images/jaspe_logo.png" alt="Jaspe Logo">
        <h1>Coming Soon</h1>
        <p>We are working hard to launch our website. Stay tuned!</p>

        <!-- Optional Countdown -->
        <div class="countdown">
            <div>
                <span id="days">00</span>
                Days
            </div>
            <div>
                <span id="hours">00</span>
                Hours
            </div>
            <div>
                <span id="minutes">00</span>
                Minutes
            </div>
            <div>
                <span id="seconds">00</span>
                Seconds
            </div>
        </div>

        <footer>&copy; <?php echo date("Y"); ?> Jaspe. All rights reserved.</footer>
    </div>

    <script>
        // Simple countdown timer
        const launchDate = new Date("2026-03-01T00:00:00").getTime();

        const countdown = setInterval(() => {
            const now = new Date().getTime();
            const distance = launchDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = days.toString().padStart(2, '0');
            document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerText = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerText = seconds.toString().padStart(2, '0');

            if (distance < 0) {
                clearInterval(countdown);
                document.querySelector(".coming-soon").innerHTML = "<h1>We're Live!</h1><p>Welcome to our website.</p>";
            }
        }, 1000);
    </script>
</body>
</html>
