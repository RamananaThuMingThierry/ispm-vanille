<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset(config('public_path.public_path').'admin/js/scripts.js') }}"></script>
<script>
    $(document).ready(function() {
        document.addEventListener("DOMContentLoaded", function () {
            var toastEl = document.querySelector('.toast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 4000 });
                toast.show();
            }
        });

        $('.lang-change').on('click', function (event) {
            event.preventDefault(); // Empêche l'action par défaut du lien

            var lang = $(this).data('lang'); // Récupère la langue sélectionnée

            // Envoie la requête AJAX pour changer la langue
            $.ajax({
                url: "{{ route('lang', ['lang' => ':lang']) }}".replace(':lang', lang),
                method: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Indique que la requête est faite via AJAX
                },
                success: function (data) {
                    // Si la langue a été changée avec succès, mettre à jour l'interface
                    if (data.locale) {
                        $('#current-lang').text(data.locale === 'fr' ? 'Français' : (data.locale === 'de' ? 'Deutsch' : 'English'));
                        location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erreur lors du changement de langue:', xhr.responseText);
                    alert("Erreur lors du changement de langue : " + xhr.status + " " + error);
                }
            });
        });

        const scrollToTopBtn = document.getElementById("scrollToTopBtn");

        // Afficher le bouton après avoir scrollé de 200px
        window.addEventListener("scroll", () => {
            if (window.scrollY > 200) {
                scrollToTopBtn.style.display = "flex";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        });

        // Scroll vers le haut en douceur
        scrollToTopBtn.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });

        window.addEventListener("scroll", function () {
            const navbar = document.querySelector(".bg-header");
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });

        function updateFooterPosition() {
            const footer = document.getElementById('mainFooter');
            const body = document.body;
            const html = document.documentElement;
            const windowHeight = window.innerHeight;
            const bodyHeight = Math.max(body.scrollHeight, body.offsetHeight,
                                        html.clientHeight, html.scrollHeight, html.offsetHeight);

            if (bodyHeight <= windowHeight) {
                footer.classList.add('fixed-footer');
            } else {
                footer.classList.remove('fixed-footer');
            }
        }

        window.addEventListener('load', updateFooterPosition);
        window.addEventListener('resize', updateFooterPosition);
        window.addEventListener('scroll', updateFooterPosition);
    });

    document.addEventListener("DOMContentLoaded", function () {
        const langDropdown = document.querySelector('.lang-dropdown-mobile');
        const navbarCollapse = document.getElementById('navbarContent');

        function updateLangDropdownVisibility(isVisible) {
            const isMobile = window.innerWidth < 992;
            if (isMobile) {
                langDropdown.style.display = isVisible ? 'block' : 'none';
            } else {
                langDropdown.style.display = 'block'; // Toujours visible en desktop
            }
        }

        // ▶ Afficher quand le menu est complètement ouvert
        navbarCollapse.addEventListener('shown.bs.collapse', () => {
            updateLangDropdownVisibility(true);
        });

        // ▶ Cacher quand le menu est complètement fermé
        navbarCollapse.addEventListener('hidden.bs.collapse', () => {
            updateLangDropdownVisibility(false);
        });

        // ▶ Initialisation au chargement
        updateLangDropdownVisibility(navbarCollapse.classList.contains('show'));

        // ▶ Adapter si on resize
        window.addEventListener('resize', () => {
            const isMobile = window.innerWidth < 992;
            const isShown = navbarCollapse.classList.contains('show');
            updateLangDropdownVisibility(isMobile ? isShown : true);
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Quand un bouton "reserved" est cliqué
        document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#reservationModal"]').forEach(button => {
            button.addEventListener('click', function () {
                const tourId = this.getAttribute('data-tour-id');
                document.getElementById('tour_id').value = tourId;
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const toggler = document.querySelector('.navbar-toggler');
        const icon = document.getElementById('navbarToggleIcon');

        toggler.addEventListener('click', function () {
            setTimeout(() => {
                const isExpanded = toggler.getAttribute('aria-expanded') === 'true';
                if (isExpanded) {
                    icon.innerHTML = '<i class="fas fa-times"></i>'; // Menu ouvert → croix
                } else {
                    icon.innerHTML = '<i class="fas fa-bars"></i>';  // Menu fermé → hamburger
                }
            }, 300); // délai pour attendre la classe .show
        });
    });
</script>
<script>
    const translations = {
        read_more: "{{ __('default.read_more') }}",
        minimize_text: "{{ __('default.minimize_text') }}"
    };
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggles = document.querySelectorAll('.toggle-readmore');

        toggles.forEach(toggle => {
            const tourId = toggle.getAttribute('data-tour-id');
            const target = document.getElementById('moreText' + tourId);

            if (!target) return;

            target.addEventListener('shown.bs.collapse', function () {
                toggle.textContent = translations.minimize_text;
            });

            target.addEventListener('hidden.bs.collapse', function () {
                toggle.textContent = translations.read_more;
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggles = document.querySelectorAll('.toggle-readmore-testimonial');

        toggles.forEach(toggle => {
            const collapseId = toggle.getAttribute('href')?.replace('#', '');
            const target = document.getElementById(collapseId);

            if (target) {
                target.addEventListener('shown.bs.collapse', function () {
                    toggle.textContent = translations.minimize_text;
                });

                target.addEventListener('hidden.bs.collapse', function () {
                    toggle.textContent = translations.read_more;
                });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tourDetailModal = document.getElementById('tourDetailModal');
        var modalDialog = document.getElementById('tourDetailModalDialog');

        tourDetailModal.addEventListener('show.bs.modal', function () {
            if (window.innerWidth >= 768) {
                modalDialog.classList.add('modal-dialog-centered');
            } else {
                modalDialog.classList.remove('modal-dialog-centered');
            }
        });

        // Optionnel: Si tu veux aussi gérer le resize pendant que le modal est ouvert
        window.addEventListener('resize', function() {
            if (tourDetailModal.classList.contains('show')) {
                if (window.innerWidth >= 768) {
                    modalDialog.classList.add('modal-dialog-centered');
                } else {
                    modalDialog.classList.remove('modal-dialog-centered');
                }
            }
        });
    });
</script>




