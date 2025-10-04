<?php
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sayfa Bulunamadı - 404</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #f8fafc;
            --text: #1e293b;
            --text-light: #64748b;
            --error: #ef4444;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 60px 40px;
            text-align: center;
            max-width: 480px;
            width: 100%;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .floating-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        .floating-icon i {
            font-size: 50px;
            color: white;
        }

        .error-code {
            font-size: 100px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 10px;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 15px;
        }

        .error-description {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 40px;
            font-size: 16px;
        }

        .action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .action-btn {
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5);
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--text);
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: white;
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .quick-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
        }

        .quick-link {
            color: var(--text-light);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .quick-link:hover {
            color: var(--primary);
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(60px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Particle Background */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatParticle 20s infinite linear;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) rotate(0deg);
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .glass-container {
                padding: 40px 25px;
            }

            .action-grid {
                grid-template-columns: 1fr;
            }

            .error-code {
                font-size: 80px;
            }

            .floating-icon {
                width: 100px;
                height: 100px;
            }

            .floating-icon i {
                font-size: 40px;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .glass-container {
                background: rgba(15, 23, 42, 0.95);
                color: white;
            }

            .error-title {
                color: white;
            }

            .error-description {
                color: #94a3b8;
            }

            .btn-secondary {
                background: #1e293b;
                border-color: #334155;
                color: white;
            }
        }
    </style>
</head>

<body>
    <!-- Particle Background -->
    <div class="particles" id="particles"></div>

    <div class="glass-container">
        <div class="floating-icon">
            <i class="fas fa-compass"></i>
        </div>

        <div class="error-code">404</div>

        <h1 class="error-title">Yolunu mu Kaybettin?</h1>

        <p class="error-description">
            Aradığınız sayfa artık burada değil. Belki taşındı,
            belki de hiç var olmadı. Hadi sizi güvenli sulara geri götürelim.
        </p>



    </div>

    <script>
        // Particle effect
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 15;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Random properties
                const size = Math.random() * 60 + 10;
                const left = Math.random() * 100;
                const animationDuration = Math.random() * 30 + 20;
                const animationDelay = Math.random() * 5;

                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${left}%`;
                particle.style.animationDuration = `${animationDuration}s`;
                particle.style.animationDelay = `${animationDelay}s`;
                particle.style.opacity = Math.random() * 0.3 + 0.1;

                particlesContainer.appendChild(particle);
            }
        }

        // Add click effect
        document.addEventListener('click', function (e) {
            const ripple = document.createElement('div');
            ripple.style.position = 'fixed';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255, 255, 255, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s linear';
            ripple.style.pointerEvents = 'none';

            const size = Math.max(e.clientX, e.clientY);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = e.clientX - size / 2 + 'px';
            ripple.style.top = e.clientY - size / 2 + 'px';

            document.body.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            createParticles();

            // Add ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>

<?php
$content = ob_get_clean();
echo $content;
?>