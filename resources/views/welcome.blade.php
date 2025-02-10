<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Voch TECH Teste</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            {{-- <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" /> --}}
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <img src="https://vochtech.com.br/img/logo-voch.svg" alt="Logo C2i">
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="flex flex-wrap w-full justify-center sm:flex-col md:flex-row md:justify-center items-center gap-2">
                            <div class="flex flex-col justify-start items-start w-80 h-40 gap-2 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] dark:bg-zinc-900 dark:ring-zinc-800 rounded-lg p-4">
                                <div class="flex justify-start items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f7d06b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-fuel">
                                        <line x1="3" x2="15" y1="22" y2="22"/>
                                        <line x1="4" x2="14" y1="9" y2="9"/>
                                        <path d="M14 22V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v18"/>
                                        <path d="M14 13h2a2 2 0 0 1 2 2v2a2 2 0 0 0 2 2a2 2 0 0 0 2-2V9.83a2 2 0 0 0-.59-1.42L18 5"/>
                                    </svg>
                                    <h3 class="leading-4 text-base">
                                        Gerencie seus postos
                                    </h3>
                                </div>
                                    <p class="leading-5 text-sm">
                                        Agora você podera visualizar todos os componentes de sua(s) empresa(s), desde colaboradores até filtros como grupos econômicos e tipos de bandeiras
                                    </p>
                            </div>
                            <div class="flex flex-col justify-start items-start w-80 h-40 gap-2 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] dark:bg-zinc-900 dark:ring-zinc-800 rounded-lg p-4">
                                <div class="flex justify-start items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f7d06b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-user">
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                                        <path d="M15 18a3 3 0 1 0-6 0"/>
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/>
                                        <circle cx="12" cy="13" r="2"/>
                                    </svg>
                                    <h3 class="leading-4 text-base">
                                        Exporte relatórios de colaboradores
                                    </h3>
                                </div>
                                    <p class="leading-5 text-sm">
                                        Imprima documentos detalhados sobre os funcionários em sua gestão: filtrados por unidade, pela bandeiro, por grupo ou pela seleção individual
                                    </p>
                            </div>
                            <div class="flex flex-col justify-start items-start w-80 h-40 gap-2 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] dark:bg-zinc-900 dark:ring-zinc-800 rounded-lg p-4">
                                <div class="flex justify-start items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f7d06b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-pen-line">
                                        <rect width="8" height="4" x="8" y="2" rx="1"/>
                                        <path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.5"/>
                                        <path d="M16 4h2a2 2 0 0 1 1.73 1"/>
                                        <path d="M8 18h1"/>
                                        <path d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/>
                                    </svg>
                                    <h3 class="leading-4 text-base">
                                        Realize a auditoria dos eventos
                                    </h3>
                                </div>
                                    <p class="leading-5 text-sm">
                                        Verifique todas criações, atualizações e remoções dos registros dos seus registros dentro do aplicativo, desde quem fez até o que fez.
                                    </p>
                            </div>
                        </div>
                    </main>

                    <footer class="pt-24 pb-8 text-center text-sm text-black dark:text-white/70">
                        Teste técnico para vaga de <strong><i>desenvolvedor Laravel Júnior</i></strong>
                        da empresa <strong><i>VOCH Tech</i></strong><br>
                        feito por <strong><i>Brayan Wilis</i></strong>, em Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
