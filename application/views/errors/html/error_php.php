<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Error</title>
    <style>
        body { background-color: #0a0a0a; color: #ccc; font-family: 'Courier New', monospace; padding: 40px; }
        h1 { color: #E23636; font-size: 24px; }
        p { color: #999; }
        .error-box { background: #111; border: 1px solid #333; border-left: 4px solid #E23636; padding: 20px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>⚠ Application Error</h1>
    <div class="error-box">
        <p><?php echo $message; ?></p>
    </div>
</body>
</html>
