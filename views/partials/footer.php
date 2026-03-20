<?php
/**
 * Partiel : Pied de page (Footer)
 * Optimisé RNCP : Accessibilité, zéro style inline
 */
?>

<footer class="footer mt-auto py-5 glass-effect border-top" role="contentinfo">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                <div class="footer-logo mb-2">
                    <img src="/images/logo.png"
                         alt="TroqueTout"
                         class="footer-logo-img">
                </div>
                <p class="small text-muted mb-0">
                    &copy; <?= date('Y') ?> TroqueTout. Tous droits réservés.
                </p>
                <p class="small text-muted mb-0">Plateforme d'échange et de partage communautaire.</p>
            </div>

            <div class="col-md-4 text-center mb-4 mb-md-0">
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="text-muted fs-5" aria-label="Suivez-nous sur Facebook">
                        <i class="bi bi-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="text-muted fs-5" aria-label="Suivez-nous sur Instagram">
                        <i class="bi bi-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="text-muted fs-5" aria-label="Suivez-nous sur Twitter / X">
                        <i class="bi bi-twitter-x" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <nav aria-label="Navigation de pied de page">
                    <ul class="list-unstyled mb-0 d-flex flex-column flex-md-row justify-content-md-end gap-md-3">
                        <li>
                            <a href="/contact" class="text-decoration-none text-muted small">Contact</a>
                        </li>
                        <li>
                            <a href="https://entreprendre.service-public.gouv.fr/vosdroits/F31228"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-decoration-none text-muted small"
                               aria-label="Mentions légales (s'ouvre dans un nouvel onglet)">
                                Mentions légales
                                <i class="bi bi-box-arrow-up-right small" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</footer>