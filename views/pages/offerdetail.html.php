

<div>
    <div>
        <h1>
            <i class="fa-solid fa-box-open"></i> <?= htmlspecialchars($detail['titre']) ?>
        </h1>
        <p>Découvrez tous les détails de cette offre</p>
    </div>

    <div>
        <div>
            <div>
                <?php if (!empty($detail["photo"])): ?>
                    <img src="<?= htmlspecialchars($detail["photo"]) ?>" alt="Image de l'offre">
                <?php else: ?>
                    <div>Aucune image disponible</div>
                <?php endif; ?>
            </div>

            <div>
                <h3>Description</h3>
                <p><?= nl2br(htmlspecialchars($detail["description"])) ?></p>

                <div>
                    <div>
                        <strong>Type d’offre :</strong> <?= htmlspecialchars($detail["type"]) ?>
                    </div>
                    <div>
                        <strong>Sens :</strong> <?= htmlspecialchars($detail["sens"]) ?>
                    </div>
                    <div>
                        <strong>Catégorie :</strong> <?= htmlspecialchars($detail["categorie"]) ?>
                    </div>
                    <div>
                        <strong>État :</strong> <?= htmlspecialchars($detail["etat"]) ?>
                    </div>
                    <div>
                        <strong>Prix :</strong> <?= number_format($detail["prix"], 2) ?> €
                    </div>
                    <div>
                        <strong>Caution :</strong> <?= number_format($detail["caution"], 2) ?> €
                    </div>
                    <div>
                        <strong>Localisation :</strong> <?= htmlspecialchars($detail["localisation"]) ?>
                    </div>
                    <div>
                        <strong>Disponibilité jusqu’au :</strong> <?= htmlspecialchars($detail["disponibilite"]) ?>
                    </div>
                    <div>
                        <strong>Date de création :</strong> <?= date("d/m/Y", strtotime($detail["date_creation"])) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
