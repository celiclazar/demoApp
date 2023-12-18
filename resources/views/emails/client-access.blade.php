<!DOCTYPE html>
<html>
<head>
    <title>Client Access</title>
</head>
<body>
<h1>Access Your Portal</h1>
<p>Click on the link below to access your portal:</p>
<a href="{{ url('/client-portal/' . $accessToken) }}">Access Portal</a>
</body>
</html>
