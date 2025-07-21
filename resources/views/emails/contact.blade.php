<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nouveau message de contact</title>
</head>
<body>
    <h2>Message de {{ $data['nom'] }}</h2>
    <p><strong>Email :</strong> {{ $data['email'] }}</p>
    <p><strong>Message :</strong><br>{{ $data['message'] }}</p>
</body>
</html>
