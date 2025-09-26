<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to EasyPaisa...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .redirect-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .easypaisa-logo {
            color: #2ecc71;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="redirect-container">
        <div class="easypaisa-logo">EasyPaisa</div>
        <h3>Redirecting to EasyPaisa Payment...</h3>
        <div class="spinner"></div>
        <p>Please wait while we redirect you to complete your payment.</p>
        
        <form id="easypaisaForm" action="{{ $form_action }}" method="POST" style="display: none;">
            @foreach($post_data as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>
    </div>

    <script>
        // Auto-submit the form after a short delay
        setTimeout(function() {
            document.getElementById('easypaisaForm').submit();
        }, 2000);
    </script>
</body>
</html>