<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Painel Admin | Time To Choose</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-brand { background: linear-gradient(135deg, #FF6B00 0%, #CC4400 100%); }
    </style>
</head>
<body class="min-h-screen bg-[#0F0F0F] flex">

    <!-- Left panel - brand -->
    <div class="hidden lg:flex flex-col justify-between w-1/2 gradient-brand p-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10"
             style="background-image: url('{{ asset('assets/An_ultra-realistic_luxury_real_estate_202607021617.jpeg') }}'); background-size:cover; background-position:center;"></div>
        <div class="relative z-10">
            <img src="{{ asset('assets/Logo_Time.png') }}" alt="Logo" class="h-10 brightness-0 invert">
        </div>
        <div class="relative z-10">
            <h1 class="text-white text-4xl font-bold leading-tight mb-4">
                Gerir os seus imóveis<br>nunca foi tão simples.
            </h1>
            <p class="text-orange-100 text-lg leading-relaxed">
                Painel de controlo completo para gerir o seu portefólio imobiliário, analisar leads e controlar todas as propriedades em tempo real.
            </p>
        </div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="flex -space-x-2">
                <div class="w-8 h-8 rounded-full bg-white/30 border-2 border-white flex items-center justify-center text-white text-xs font-bold">A</div>
                <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-white flex items-center justify-center text-white text-xs font-bold">M</div>
            </div>
            <p class="text-orange-100 text-sm">Time To Choose © 2026</p>
        </div>
    </div>

    <!-- Right panel - form -->
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <!-- Mobile logo -->
            <div class="lg:hidden mb-10 flex items-center gap-3">
                <img src="{{ asset('assets/Logo_Time.png') }}" alt="Logo" class="h-8 brightness-0 invert">
            </div>

            <div class="mb-10">
                <h2 class="text-white text-3xl font-bold mb-2">Bem-vindo de volta</h2>
                <p class="text-gray-400">Entre com as suas credenciais de administrador.</p>
            </div>

            @if($errors->any())
            <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation"></i>
                {{ $errors->first('email') }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="admin@timetochoose.ao"
                               class="w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-11 pr-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF6B00] focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Senha</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-11 pr-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#FF6B00] focus:border-transparent transition">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded accent-[#FF6B00]">
                    <label for="remember" class="text-gray-400 text-sm">Lembrar-me</label>
                </div>

                <button type="submit"
                        class="w-full gradient-brand text-white font-bold py-4 rounded-xl text-sm hover:opacity-90 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Entrar no Painel
                </button>
            </form>

            <p class="text-center text-gray-600 text-xs mt-8">
                Time To Choose © 2026 — Painel de Administração
            </p>
        </div>
    </div>

</body>
</html>
