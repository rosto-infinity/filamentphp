<?php

use Illuminate\Support\Facades\Route;

use App\Models\Post; // Assurez-vous d'importer votre modèle Post


Route::get('/', function () {
    // Récupère uniquement les articles publiés, triés par date de publication récente
    $posts = Post::where('published', true)
                 ->orderByDesc('published_at')
                 ->get(); // Récupère tous les résultats

    // Passe les articles à la vue 'welcome'
    return view('welcome', compact('posts'));
});

// Route pour afficher un article spécifique par son slug
// {slug} est un paramètre dynamique
Route::get('/blog/{slug}', function ($slug) {
    // Tente de trouver l'article publié avec ce slug précis
    $post = Post::where('slug', $slug)
                ->where('published', true)
                ->firstOrFail(); // Si non trouvé, Laravel renvoie automatiquement une erreur 404

    // Passe l'article unique à la nouvelle vue 'show'
    return view('show', compact('post'));
})->name('posts.show'); // Nomme la route pour y faire référence facilement
