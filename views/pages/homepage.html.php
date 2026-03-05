<?php
$search       = $search       ?? '';
$type         = $type         ?? '';
$etat         = $etat         ?? '';
$localisation = $localisation ?? '';
$sort         = $sort         ?? 'desc';
?>

<!--
    ✅ Sémantique HTML5 :
    - <header> pour l'accroche principale
    - <section> pour les zones de contenu distinctes
    - <article> pour chaque offre
    - aria-* pour l'accessibilité
-->

<header class="hero-section">
    <h1 class="hero-title">L'avenir du partage commence ici</h1>
    <p class="hero-subtitle">Découvrez une plateforme moderne de partage et d'échange.</p>
</header>

<!-- ✅ Section de recherche avec rôle search -->
<section aria-labelledby="recherche-titre">
    <h2 id="recherche-titre" class="sr-only">Rechercher une offre</h2>

    <form method="GET" class="recherche" role="search" aria-label="Recherche d'offres">
        <div class="recherche-grid">
            <div class="form-group">
                <!-- ✅ label explicite lié à l'input par for/id -->
                <label for="search" class="form-label">Titre</label>
                <input
                    type="search"
                    name="search"
                    id="search"
                    placeholder="Rechercher une offre..."
                    value="<?= htmlspecialchars($search) ?>"
                    class="form-input"
                    autocomplete="off"
                >
            </div>

            <div class="form-group">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="">Tous les types</option>
                    <option value="don"      <?= ($type === 'don')      ? 'selected' : '' ?>>Don</option>
                    <option value="location" <?= ($type === 'location') ? 'selected' : '' ?>>Location</option>
                    <option value="pret"     <?= ($type === 'pret')     ? 'selected' : '' ?>>Prêt</option>
                </select>
            </div>

            <div class="form-group form-group--action">
                <button type="submit" class="btn btn-primary">
                    <!-- ✅ SVG décoratif aria-hidden -->
                    <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    Rechercher
                </button>
            </div>
        </div>
    </form>
</section>

<!-- ✅ Section principale des offres -->
<section class="offres-wrapper" aria-labelledby="offres-titre">
    <div class="offres-header">
        <h2 id="offres-titre">Dernières offres</h2>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/offers/addOffer" class="btn btn-primary">
                <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Ajouter une offre
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($offers)): ?>
        <p class="request-alert" role="status">Aucune offre disponible pour le moment.</p>
    <?php else: ?>
        <!-- ✅ <ul> sémantique pour une liste d'éléments -->
        <ul class="offers-list" role="list">
            <?php foreach ($offers as $offer): ?>
                <!-- ✅ <article> pour contenu autonome -->
                <li>
                    <article class="card" aria-label="Offre : <?= htmlspecialchars($offer['titre']) ?>">

                        <a href="/offers/detail/<?= urlencode($offer['id']) ?>" class="card-img-link"
                           aria-label="Voir le détail de l'offre <?= htmlspecialchars($offer['titre']) ?>">
                            <img
                                class="card-img-top"
                                src="<?= htmlspecialchars($offer['photo']) ?>"
                                alt="Photo de l'offre : <?= htmlspecialchars($offer['titre']) ?>"
                                loading="lazy"
                                width="400" height="224"
                            >
                        </a>

                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($offer['titre']) ?></h3>

                            <dl class="card-meta">
                                <dt class="sr-only">Type</dt>
                                <dd><span class="badge-type"><?= htmlspecialchars($offer['type']) ?></span></dd>
                                <dt class="sr-only">Ville</dt>
                                <dd class="card-location">
                                    <svg aria-hidden="true" width="14" height="14" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    <?= htmlspecialchars($offer['localisation']) ?>
                                </dd>
                            </dl>

                            <div class="card-actions">
                                <a href="/offers/detail/<?= urlencode($offer['id']) ?>"
                                   class="btn btn-outline-primary btn-sm">Voir détail</a>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <!-- ✅ Requête asynchrone fetch API — pas de rechargement de page -->
                                    <button
                                        type="button"
                                        class="btn btn-sm fav-btn <?= ($offer['is_favori'] ?? false) ? 'btn-danger' : 'btn-outline-danger' ?>"
                                        data-offer-id="<?= (int)$offer['id'] ?>"
                                        data-favori="<?= ($offer['is_favori'] ?? false) ? '1' : '0' ?>"
                                        aria-label="<?= ($offer['is_favori'] ?? false) ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>"
                                        aria-pressed="<?= ($offer['is_favori'] ?? false) ? 'true' : 'false' ?>"
                                    >
                                        <i class="bi <?= ($offer['is_favori'] ?? false) ? 'bi-heart-fill' : 'bi-heart' ?>"
                                           aria-hidden="true"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                    </article>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<script>
/**
 * ✅ Requêtes asynchrones avec l'API fetch (sans jQuery)
 * Permet d'ajouter/retirer un favori sans rechargement de page.
 *
 * Bonne pratique :
 * - Utilisation de const/let (pas var)
 * - Gestion des erreurs avec try/catch
 * - Mise à jour de l'interface ET des attributs d'accessibilité (aria-pressed, aria-label)
 */
document.addEventListener('DOMContentLoaded', () => {

    // ✅ Délégation d'événement : un seul listener pour tous les boutons favoris
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.fav-btn');
        if (!btn) return;

        const offerId = btn.dataset.offerId;
        const isFavori = btn.dataset.favori === '1';

        // Désactiver temporairement pour éviter les double-clics
        btn.disabled = true;

        try {
            // ✅ Requête HTTP asynchrone vers le serveur
            const response = await fetch('/offers/addfavoris/', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `offer_id=${encodeURIComponent(offerId)}`
            });

            if (!response.ok) {
                throw new Error(`Erreur serveur : ${response.status}`);
            }

            // Mise à jour de l'interface après succès
            const newFavori = !isFavori;
            btn.dataset.favori = newFavori ? '1' : '0';

            // Toggle des classes CSS
            btn.classList.toggle('btn-danger',         newFavori);
            btn.classList.toggle('btn-outline-danger', !newFavori);

            // ✅ Mise à jour accessibilité
            btn.setAttribute('aria-pressed', String(newFavori));
            btn.setAttribute('aria-label',
                newFavori ? 'Retirer des favoris' : 'Ajouter aux favoris'
            );

            // Toggle de l'icône
            const icon = btn.querySelector('.bi');
            if (icon) {
                icon.classList.toggle('bi-heart-fill', newFavori);
                icon.classList.toggle('bi-heart',      !newFavori);
            }

        } catch (error) {
            console.error('Erreur lors de la mise à jour du favori :', error);
            // ✅ Feedback utilisateur en cas d'erreur
            btn.setAttribute('aria-label', 'Erreur — réessayez');
        } finally {
            btn.disabled = false;
        }
    });

});
</script>