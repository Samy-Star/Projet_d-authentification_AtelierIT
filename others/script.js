document.addEventListener('DOMContentLoaded', function() {

    // --- 1. Gestion de la confirmation de déconnexion ---
    
    // Sélectionne tous les liens ou boutons de déconnexion
    const logoutLinks = document.querySelectorAll('a[href*="deconnexion.php"]');

    if (logoutLinks.length > 0) {
        logoutLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                // Demande une confirmation avant de naviguer vers la déconnexion
                const confirmation = confirm("Êtes-vous sûr de vouloir vous déconnecter ?");
                
                // Si l'utilisateur clique sur "Annuler", empêche la navigation
                if (!confirmation) {
                    event.preventDefault();
                }
            });
        });
    }


    // --- 2. Fonctionnalité simple pour le menu de navigation (si vous en ajoutez un) ---
    
    // Supposons que vous ayez un bouton de menu (burger icon) et un conteneur pour les liens
    const navToggle = document.querySelector('.nav-toggle'); // À ajouter dans navbar.php si besoin
    const navLinks = document.querySelector('.nav-links'); // Ce conteneur existe déjà

    if (navToggle && navLinks) {
        navToggle.addEventListener('click', () => {
            // Ajoute ou retire une classe pour afficher/masquer les liens
            navLinks.classList.toggle('active');
        });
    }

    // 3. Animation de base pour les sections de formulaire ---

    const formSections = document.querySelectorAll('.form-section');
    if (formSections.length > 0) {
        // Ajout d'une classe pour déclencher des animations CSS après le chargement
        setTimeout(() => {
            formSections.forEach(section => {
                section.classList.add('loaded');
            });
        }, 100);
    }
});