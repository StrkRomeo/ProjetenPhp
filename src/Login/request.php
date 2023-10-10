<?php
function request_login(){
    session_start();

    $error_message = ""; // Initialisez la variable $error_message en dehors du bloc if

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $bdd = new PDO('pgsql:host=localhost;port=5432;dbname=VenteBoisson', 'postgres', '1234');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $email = $_POST["mail"];
            $password = $_POST["mdp_user"];
            $query = "SELECT * FROM utilisateur WHERE mail = ?";

            $login = $bdd->prepare($query);
            $login->execute([$email]);
            $user = $login->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["mdp_user"])) {
                $_SESSION["user_id"] = $user["id_user"];
                header("Location: /");
                exit();
               
            } else {
                $error_message = "<span>Erreur, Identifiants incorrects. Veuillez réessayer.</span>";
                echo $error_message;

            }
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
}
?>
