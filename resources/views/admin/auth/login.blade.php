<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login — SK Rentals</title>
    <meta name="description" content="SK Rentals Admin Portal — Secure Access" />
    <meta name="robots" content="noindex, nofollow" />

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Page root ── */
        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fdfaf5;
            color: #1a1612;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ── Animated background ── */
        .login-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: #fdfaf5;
        }

        .login-bg-overlay {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 10% 10%, rgba(200, 144, 58, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(200, 144, 58, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.9) 0%, transparent 100%);
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.12;
            animation: orb-float 15s ease-in-out infinite;
        }
        .orb-1 { width: 500px; height: 500px; background: #c8903a; top: -100px; left: -100px; }
        .orb-2 { width: 400px; height: 400px; background: #e8b96c; bottom: -80px; right: -80px; animation-delay: -7.5s; }

        @keyframes orb-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(40px, 30px) scale(1.1); }
            66%       { transform: translate(-20px, 50px) scale(0.95); }
        }

        /* ── Login Card Container ── */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 32px;
            padding: 2.5rem 2.25rem;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(200, 144, 58, 0.05);
        }

        /* ── Logo & Heading ── */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            display: inline-flex;
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #c8903a, #8b5e1c);
            border-radius: 16px;
            align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 10px 25px rgba(200, 144, 58, 0.3);
        }

        .login-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1612;
            margin-bottom: 0.5rem;
        }

        .login-subheading {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* ── Google Button ── */
        .btn-google {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            color: #1a1612;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .btn-google:hover {
            transform: translateY(-2px);
            border-color: #c8903a;
            box-shadow: 0 10px 20px rgba(200, 144, 58, 0.1);
        }

        /* ── Alert ── */
        .alert {
            padding: 0.875rem 1rem;
            border-radius: 16px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 0.625rem;
            border: 1px solid transparent;
        }
        .alert-error { background: #fff5f5; border-color: #feb2b2; color: #c53030; }
        .alert-success { background: #f0fff4; border-color: #9ae6b4; color: #276749; }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin: 2rem 0;
            color: #e2e8f0;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* ── Footer ── */
        .login-footer {
            margin-top: 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            color: #adb5bd;
            font-size: 0.8rem;
        }

        .login-footer a {
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }
        .login-footer a:hover { color: #c8903a; }

        /* Mobile Adjustments */
        @media (max-width: 480px) {
            .login-container { padding: 1rem; }
            .login-card { padding: 2rem 1.5rem; border-radius: 28px; }
            .login-heading { font-size: 1.5rem; }
            .divider { margin: 1.5rem 0; }
            .login-footer { margin-top: 1.5rem; }
        }
    </style>
</head>

<body>

<div class="login-bg">
    <div class="login-bg-overlay"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
</div>

<div class="login-container">
    <div class="login-card">

        <div class="login-header">
            <div class="login-logo">
                <span style="font-family:'Playfair Display',serif; font-weight:700; color:#fff; font-size:1.5rem;">SK</span>
            </div>
            <h1 class="login-heading">Admin Portal</h1>
            <p class="login-subheading">Secure access for SK Rentals authorized personnel.</p>
        </div>

        @if (session('error'))
            <div class="alert alert-error">
                <svg style="width:20px;height:20px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <svg style="width:20px;height:20px;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <a href="{{ route('admin.auth.google') }}" class="btn-google" id="google-login-btn">
            <svg width="24" height="24" viewBox="0 0 48 48">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
            </svg>
            <span>Continue with Google</span>
            <svg style="width:18px;height:18px;margin-left:auto;color:#cbd5e0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        <div class="divider">
            <span>Secure Verification</span>
        </div>

        <div style="background: rgba(200,144,58,0.05); border: 1px solid rgba(200,144,58,0.1); border-radius: 18px; padding: 1.25rem; display: flex; gap: 1rem; align-items: flex-start;">
            <div style="width:36px; height:36px; background:rgba(200,144,58,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#c8903a;">
                <svg style="width:20px; height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <p style="font-size:0.875rem; font-weight:700; color:#1a1612; margin-bottom:0.25rem;">Admin Access Only</p>
                <p style="font-size:0.8rem; color:#6c757d; line-height:1.5;">This area is restricted. Only pre-approved Google accounts can sign in.</p>
            </div>
        </div>

        <div class="login-footer">
            <a href="{{ route('home') }}">
                <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Return to homepage
            </a>
            <span style="font-size: 0.75rem; color: #cbd5e0;">© {{ date('Y') }} SK Rentals — Management Portal</span>
        </div>
    </div>
</div>

<script>
    document.getElementById('google-login-btn').addEventListener('click', function() {
        const btn = this;
        btn.style.opacity = '0.6';
        btn.style.pointerEvents = 'none';
        btn.querySelector('span').textContent = 'Connecting...';
    });
</script>

</body>
</html>
