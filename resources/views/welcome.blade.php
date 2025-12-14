<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
                /* Assurez-vous que votre setup Tailwind fonctionne correctement pour un rendu optimal */
            </style>
        @endif
    </head>
    <body class="antialiased bg-white font-sans text-gray-800">

        {{-- Barre de navigation simple et minimaliste --}}
        <header class="border-b border-gray-100 sticky top-0 bg-white/95 backdrop-blur-sm">
            <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="text-2xl font-bold text-gray-900">
                    Obryl Tech
                </div>
                <div>
                  
                   
                   
                </div>
            </nav>
        </header>

        {{-- Contenu principal --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
           
            <header class="text-center mb-16">
                <h1 class="text-6xl font-extrabold text-gray-900">
                    Dernières Actualités & Expertise
                </h1>
                <p class="mt-4 text-xl text-gray-500">
                    Découvrez nos projets, astuces techniques et études de cas.
                </p>
            </header>

            <main>
                @if($posts->count())
                    {{-- Grille d'articles avec un design de carte professionnel --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        
                        @foreach ($posts as $post)
                            <article class="group relative">
                                
                                {{-- Image (aspect ratio pro) --}}
                                @if($post->image)
                                    <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden shadow-sm">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300 ease-in-out">
                                    </div>
                                @endif

                                <div class="mt-6">
                                    {{-- Métadonnées (Date et Catégorie) --}}
                                    <div class="flex items-center justify-between text-sm mb-3">
                                        <span class="text-gray-500">
                                            {{ $post->published_at->format('d M Y') }}
                                        </span>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full" style="background-color: {{ $post->color ?? '#e5e7eb' }}; color: black;">
                                            {{ $post->category->name ?? 'Non classé' }}
                                        </span>
                                    </div>
                                    
                                    {{-- Titre (lien caché pour toute la carte) --}}
                                    <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition duration-150">
                                        <a href="{{ route('posts.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h2>
                                    
                                    {{-- Extrait --}}
                                    <p class="text-gray-500 mb-4 leading-relaxed">
                                        {{ Str::limit($post->body, 150) }}
                                    </p>
                                    
                                    {{-- Tags --}}
                                    @if($post->tags)
                                   {{-- {{ $post->tags->name }} --}}
                                        <div class="flex flex-wrap gap-2 text-xs">
                                            @foreach($post->tags as $tag)
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">#{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 text-xl py-12">
                        Aucun article publié pour le moment.
                    </p>
                @endif
            </main>

            {{-- Footer minimaliste --}}
            <footer class="mt-24 pt-10 border-t border-gray-100">
                <div class="text-center text-gray-400 text-sm">
                    <p>&copy; {{ date('Y') }} Obryl Tech. Développé avec Laravel & Tailwind CSS.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
