<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playwrite+BE+WAL:wght@100..400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Gwendolyn:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<style>
    .playwrite{
        font-family: "Playwrite BE WAL", sans-serif !important;
        font-weight: 300 !important;
    }

    .dancing{
        font-family: "Dancing Script", cursive !important;
        font-weight: 700 !important;
    }

    html, body{
      font-family: "Chakra Petch", sans-serif;
      font-weight: 300;
      font-style: normal;
      display: flex;
      margin: 0;
      flex-direction: column;
    }

    .gwendolyn-regular {
        font-family: "Gwendolyn", cursive;
        font-weight: 400;
        font-style: normal;
    }

    .gwendolyn-bold {
        font-family: "Gwendolyn", cursive;
        font-weight: 700;
        font-style: normal;
    }

    /* Par défaut, le header est transparent */
    .bg-header {
        background-color: white;
        box-shadow: none;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Quand on scroll */
    .bg-header.scrolled {
        background-color: white !important;
        width: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
    .nav-link.active {
        color: #dc3545 !important;
        font-weight: bold;
    }
    .lang-dropdown-mobile {
        transition: all 0.3s ease-in-out;
    }

    @keyframes breathe {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 rgba(220, 53, 69, 0.4);
        }
        50% {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.6);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 rgba(220, 53, 69, 0.4);
        }
    }

    #scrollToTopBtn {
        position: fixed;
        bottom: 30px;
        right: 20px;
        display: none;
        z-index: 1000;
        width: 45px;
        height: 45px;
        font-size: 18px;
        justify-content: center;
        align-items: center;
        box-shadow: 0 0 15px rgba(219, 136, 144, 0.4);
        animation: breathe 2s infinite ease-in-out;
        transition: background-color 0.3s;
    }

    #scrollToTopBtn:hover {
        background-color: #c82333;
        transform: scale(1.15);
    }


@media (max-width: 991.98px) {
    #navbarContent .nav-link {
        text-align: center;
        margin: 5px 0;
        background-color: #ffc107;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    #navbarContent .nav-link:hover {
        background-color: transparent !important;
        color: #fff !important;
    }

    .bg-header {
        background-color: #ffc107 !important;
    }

    #about_title{
        text-align: center;
    }
    .bg-header.scrolled {
        background-color: #ffc107 !important;
    }
    /* Centrer le bouton de langue */
    .dropdown {
        width: 100%;
        text-align: center;
        margin-top: 10px;
    }

    .dropdown-menu {
        text-align: center;
    }
}

</style>
