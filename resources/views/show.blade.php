<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $post->title }} - Obryl Tech</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="fonts.bunny.net" rel="stylesheet" />

       
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Placeholder for inline Tailwind styles provided previously -->
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* ... Vos styles Tailwind CSS minimisés ici ... */
            </style>
        @endif
    </head>
    <body class="antialiased bg-white font-sans text-gray-800">

        {{-- Barre de navigation simple et minimaliste --}}
        <header class="border-b border-gray-100">
            <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-900">
                    Obryl Tech
                </div>
                <div>
                    <a href="#" class="text-gray-600 hover:text-gray-900 mx-4">Portfolio</a>
                    <a href="/" class="text-gray-900 font-semibold mx-4">Blog</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 mx-4">Contact</a>
                </div>
            </nav>
        </header>

        {{-- Contenu principal de l'article --}}
        <main class="pt-12 pb-20">
            <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                {{-- Bouton retour --}}
                <div class="mb-8">
                    <a href="/" class="text-gray-500 hover:text-gray-700 flex items-center transition duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="www.w3.org"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Retour aux articles
                    </a>
                </div>

                {{-- Image de couverture --}}
                @if($post->image)
                    <div class="mb-10 rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
                    </div>
                @endif

                {{-- Header de l'article --}}
                <header class="mb-10 border-b pb-8">
                    <h1 class="text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                        {{ $post->title }}
                    </h1>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>Publié le {{ $post->published_at->format('d M Y') }}</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full" style="background-color: {{ $post->color ?? '#e5e7eb' }}; color: black;">
                            {{ $post->category->name ?? 'Non classé' }}
                        </span>
                    </div>
                </header>

                {{-- Contenu de l'article --}}
                <div class="prose lg:prose-lg max-w-none text-gray-700 leading-relaxed space-y-6">
                    {{-- Si vous utilisez @tailwindcss/typography, le rendu sera automatique et stylisé. --}}
                    {!! nl2br(e($post->body)) !!} 
                </div>

                {{-- Tags --}}
                @if($post->tags)
                    <div class="mt-12 pt-6 border-t flex flex-wrap gap-3">
                        @foreach($post->tags as $tag)
                            <span class="text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-full">#{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

            </article>
        </main>
        
        {{-- Footer minimaliste --}}
        <footer class="mt-12 pt-10 border-t border-gray-100">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-400 text-sm pb-8">
                <p>&copy; {{ date('Y') }} Obryl Tech. Tous droits réservés.</p>
            </div>
        </footer>

    </body>
</html>
