<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Register :
if ($_SERVER["REQUEST_METHOD"] == "POST") {		// Récupère les données envoyées par le formulaire
    $name = $_POST['username'];
    $pwd = $_POST['password'];
	$confirm_pwd = $_POST['confirm_pwd'];

	if (!empty($name) && !empty($pwd)) {
		if ($pwd == $confirm_pwd) {
			$file = 'userdata.json';
			$user_data = array (
				'username' => array(),
				'password' => array()
			);		
			

			if (file_exists($file) && filesize($file) > 0) {		// Si le fichier existe ET contient déjà des données
				$json_content = file_get_contents($file);

				if (!empty($json_content)) {
					$existing_data = json_decode($json_content, true);
					
					
                    // Vérifier que le décodage a réussi et que la structure est valide
                    if ($existing_data !== null && isset($existing_data['username']) && isset($existing_data['password'])) {
						$user_data = $existing_data;
					}
                }
			}
			
			$user_data['username'][] = $name;
			$user_data['password'][] = $pwd;

			$json_data = json_encode($user_data, JSON_PRETTY_PRINT);	// Convertir le tableau en JSON
	
			if (file_put_contents($file, $json_data)) {		// Si les données ont bien été écrites dans le fichier
				header("Location: index.html");				// Redirige vers la page principale
				exit();
			} else {
				echo "Erreur lors de l'enregistrement des données.";
			}
		} else {
			echo "Les mots de passe ne correspondent pas. Réessaie !";
		}
    } else {
        echo "Il manque des informations. Vérifie que tu aies bien rempli toutes les cases.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">	<!-- css -->
	<title>Program App</title>
</head>

<body>
	<h1>Hello world !</h1>
	<h2> Pour te connecter, c'est ici :</h2>
	<form method="POST">	<!-- GET c'est dans l'URL, POST c'est mieux -->
		<div id="Register" class="liste">
			<form>
				<input placeholder="Nouveau compte" type="text" id="register" name="username" required><br>
				<input placeholder="Mot de passe" type="password" id="register" name="password" required><br>
				<input placeholder="Confirmer le mot de passe" type="password" id="confirm_pwd" name="confirm_pwd" required><br>
				<button class="submit" type="submit">S'inscrire</button>
			</form>
		</div>
		
		<div id="Login" class="liste">
			<form>
				<input placeholder="Nom de compte" type="text" id="login-username" name="username" required><br>
				<input placeholder="Mot de passe" type="password" id="login-password" name="password" required><br>
				<button class="submit" type="submit">Se connecter</button>
			</form>
		</div>
		
		<!-- <div>
			<a href="index.html">Lien test</a>	 A faire en bouton en css
		</div> -->
		</form>
</body>
</html>
<?php
// Vider et terminer la mise en tampon de sortie
ob_end_flush();
?>