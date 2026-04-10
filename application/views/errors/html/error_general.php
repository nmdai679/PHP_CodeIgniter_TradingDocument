<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $heading; ?></title>
    <style>
        body { background-color: #0a0a0a; color: #ccc; font-family: 'Courier New', monospace; padding: 40px; }
        h1 { color: #E23636; }
        .error-box { background: #111; border: 1px solid #333; border-left: 4px solid #E67E22; padding: 20px; border-radius: 4px; }
        pre { white-space: pre-wrap; word-wrap: break-word; font-size: 13px; color: #aaa; }
    </style>
</head>
<body>
    <h1>⚠ <?php echo $heading; ?></h1>
    <div class="error-box">
        <pre><?php echo $message; ?></pre>
    </div>
</body>
</html>
