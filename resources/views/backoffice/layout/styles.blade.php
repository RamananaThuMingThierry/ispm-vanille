<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset(config('public_path.public_path').'admin/css/styles.css') }}" rel="stylesheet" />
<style>
    html, body{
      font-family: "Chakra Petch", sans-serif;
      font-weight: 300;
      font-style: normal;
      display: flex;
      margin: 0;
      flex-direction: column;
    }
    
    #toast-container.toast-middle-center {
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      position: fixed;
    }
    .btn-close{
      color: red !important;
    }
    .sb-sidenav-dark {
        background-color: hsl(0, 0%, 9%) !important; /* Vert Bootstrap */
        color: white !important; /* Texte en blanc */
    }

    .sb-sidenav-dark .nav-link,
    .sb-sidenav-dark .sb-sidenav-menu-heading {
        color: white !important; /* Forcer le texte des liens et titres en blanc */
    }

    .sb-sidenav-dark .nav-link:hover {
        color: #f8f9fa !important; /* Légère variation du blanc au survol */
    }

    @layer reset{
      button{
        all: unset;
      }
    }
    /* Ajoutez ceci dans votre fichier CSS */
    .navbar-nav {
        display: flex;
        flex-direction: row;
        align-items: center;
    }
    
    .nav-item {
        margin-left: 10px; /* Ajoutez un peu d'espace entre les éléments */
    }

    @media (max-width: 576px) { /* Mode sm */
    .footer-brand {
        display: none; /* Masquer le texte "AntaTech-Solutions - {{ date('Y') }}" */
    }
    .footer-text {
        text-align: center;
        width: 100%;
    }
}
  </style>