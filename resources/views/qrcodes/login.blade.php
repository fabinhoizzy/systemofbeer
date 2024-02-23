<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acesse Agora</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500">
    <div class="w-1/3 flex flex-col mx-auto p-8 gap-4 bg-gray-50 justify-center items-center mt-16 shadow-gray-500/40">
        <h1 class="text-3xl"> {{ config('app.name') }} </h1class></h1>
        <p class="-mt-4">Uma forma diferente de comprar bebidas</p>
            {{ $qrcode }}
        <a href="{{ route('filament.app.auth.login') }}" class="text-2xl">Acesse agora</a>
    </div>
</body>
</html>
