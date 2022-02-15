<!DOCTYPE html>
<html lang="en-US">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>{{config("app.name")}}</title>
</head>
<body>
@include("nav.nav")
<div class="container">
    @yield("content")
</div>
<script src="/js/app.js"></script>
</body>
</html>
