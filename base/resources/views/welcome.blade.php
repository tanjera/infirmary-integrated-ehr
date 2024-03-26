<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Infirmary Integrated: Electronic Health Record</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="" />

            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-3xl px-6 lg:max-w-7xl">
                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-1 lg:gap-8 flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">

                                <div class="relative flex w-full flex-1">
                                    <img
                                        src="{{asset('main.banner_ecg.svg')}}"
                                        alt="Infirmary Integrated EHR Banner Logo"
                                        class="h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)] dark:hidden"
                                    />
                                </div>

                                <div class="relative flex flex-col items-center justify-center ">

                                <h2 class="text-xl font-semibold text-black dark:text-white">Infirmary Integrated: Electronic Health Record</h2>

                                </div>

                                @if (Route::has('login'))
                                    @auth {{-- Already authenticated? --}}
                                        <div class="relative flex flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                                            <div class="relative max-w-sm px-3 items-center justify-center text-center gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                                            <a href="{{ url('/dashboard') }}" class="rounded-md py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white" style="font-weight: 700">
                                                Already Logged In<br>
                                                Proceed to the Dashboard
                                            </a>
                                        </div>
                                        </div>
                                    @else
                                        <div class="relative flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                                            <div class="relative max-w-sm justify-center gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                                                @include('auth/login-snippet')
                                            </div>
                                        </div>
                                    @endauth
                                @endif

                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">

                                        <div class="pt-3 sm:pt-5 lg:pt-0">


                                            <p class="mt-4 text-sm/relaxed">
                                            Infirmary Integrated is free and open-source software suite consisting of the Infirmary Integrated Simulator, Electronic Health Record, Scenario Editor, and Development Tools designed to advance healthcare education for medical and nursing professionals and students. Developed as in-depth, accurate, and accessible educational tools, Infirmary Integrated can meet the needs of clinical simulators in emergency, critical care, obstetric, and many other medical and nursing specialties.
                                            </p>

                                            <p class="mt-4 text-sm/relaxed">
                                            Infirmary Integrated contains a free simulator for healthcare devices to aide in medical and nursing education. By simulating medical devices such as a defibrillator or external fetal monitor, students can practice reading tracings, interpreting waveforms, and starting interventions. Educators can use Infirmary Integrated to enhance simulations in a lifelike environment similar to patient care areas, allowing educators to simulate patient presentations and hemodynamic states ranging from simple simulations to extremely complex scenarios. Infirmary Integrated is developed to be clinically accurate and contain relevant content. Additionally, Infirmary Integrated is free and open source software in order to be accessible for healthcare professionals around the world.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        (c) 2024, Ibi Keller (tanjera)
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
