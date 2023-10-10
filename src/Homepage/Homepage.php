<?php

function Homepage_view() {
    session_start();

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8' />
        <script src='https://unpkg.com/@phosphor-icons/web'></script>
        <title>SavourezLaSoif</title>
        <style>
            /* Your CSS styles here */
        </style>
    </head>
    <body>
    <header>
        <h1>SavourezLaSoif</h1>
        <nav>
            <ul>
                <li><a href='/TousLesProduits'>Tous les Produits</a></li>
                <li><a href='/Panier'><i class='ph ph-shopping-cart-simple'></i></a></li>
    ";

    if (isset($_SESSION["user_id"])) {
        // User is logged in, show logout button and user's name
        try {
            $bdd = new PDO('pgsql:host=localhost;port=5432;dbname=VenteBoisson', 'postgres', '1234');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $user_id = $_SESSION["user_id"];
            $query = "SELECT user_name FROM utilisateur WHERE id_user = ?";

            $user_info = $bdd->prepare($query);
            $user_info->execute([$user_id]);
            $user_data = $user_info->fetch(PDO::FETCH_ASSOC);

            $username = $user_data["user_name"];

            echo "
            <li>Bienvenue, $username</li>
                <li><a href='/Logout'>Déconnexion</a></li>
            ";
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    } else {
        echo "
            <li><a href='/Connection'><i class='ph ph-sign-in'></i></a></li>
        ";
    }

    echo "
                <li><a href='/EnSavoirPlus'><i class='ph ph-info'></i></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2> Nos dernières Boissons : </h2>
        <?php request_homepage();?>
    ";

    echo "
    </main>
    <footer>
        <p>&copy; 2023 Agostino Roméo. Tous droits réservés.</p>
    </footer>
    </body>
    </html>
    <style>
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;   
        overflow-x:hidden; 

    }
    
    
    header {
        display:flex;
        align-items:center;
        justify-content:space-between;
        background-color:#242424;
        color: white;
        padding: 10px;
        text-align: center;
    }
    
    header h1 {
        margin: 0;
    }
    
    
    nav ul {
        list-style-type: none;
        padding: 0;
        display: flex; 
    }

    nav ul li {
        margin-right:40px;
    }
    
    nav ul li a {
        color:white;
        text-decoration: none;
    }
    

    nav ul li a:hover {
        color: #767676;
    }
    
    
    main {
        display: flex;
        flex-direction:column;
        justify-content: center;
        align-items: center; 
        width:100%;
        height: 30vh;

    }

    form{
        width:15%;
    }

    h2{
        font-size:40px;
        margin-top:100px;
        text-decoration:underline;
    }

    img{
        width:200px;
    }


    .boisson-homepage {
        width:100%;
        margin: 10px;
        padding: 10px;
        text-align: center;
        display: flex;
        
    }
    .boisson-all{
        width:15%;
        
        margin-left:250px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .boisson-homepage img {
        max-width: 100%;
        height: auto;
    }
    
    .boisson-texte{
        display:block;
    }
    
    .boisson-texte {
        margin-top: 10px;
    }
    
    .boisson-texte h3 {
        font-size: 20px;
        color: #333;
    }
    
    .boisson-texte p {
        font-size: 16px;
        color: #777;
        margin: 5px 0;
    }
    
    footer{
        position:absolute;
        bottom:0 ;
        background-color:#242424;
        width:100%;
        color:white;
    }
    footer p {
        display:flex;
        justify-content:center;
    }

    </style>
    ";
}
?>
