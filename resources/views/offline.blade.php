<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hors ligne - Lumo Core Platform</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; display: flex; align-items: center; justify-content: center; min-height: 100vh; text-align: center; padding: 2rem; }
        .icon { font-size: 5rem; margin-bottom: 1.5rem; }
        h1 { font-size: 2rem; font-weight: 700; color: #6366f1; margin-bottom: 1rem; }
        p { font-size: 1.1rem; color: #94a3b8; margin-bottom: 2rem; }
        button { background: #6366f1; color: white; border: none; padding: 0.75rem 2rem; border-radius: 0.5rem; font-size: 1rem; cursor: pointer; transition: background 0.2s; }
        button:hover { background: #4f46e5; }
    </style>
</head>
<body>
    <div>
        <div class="icon">📡</div>
        <h1>Vous êtes hors ligne</h1>
        <p>Vérifiez votre connexion internet et réessayez.</p>
        <button onclick="window.location.reload()">Réessayer</button>
    </div>
</body>
</html>
