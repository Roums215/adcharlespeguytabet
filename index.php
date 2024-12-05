<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8" />
	<title>Inscription</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #121212;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
			color: #ffffff;
		}

		.creerUser {
			background-color: #1e1e1e;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			width: 350px;
		}

		.listeComptes {
			background-color: #1e1e1e;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
		}

		.form-group {
			margin-bottom: 15px;
		}

		label {
			display: block;
			margin-bottom: 5px;
			color: #888;
		}

		input,
		select {
			width: 95%;
			padding: 10px;
			border: 1px solid #333;
			border-radius: 5px;
			background-color: #2c2c2c;
			color: #fff;
		}

		input:focus,
		select:focus {
			outline: none;
			border-color: #4a90e2;
		}

		button {
			width: 101%;
			padding: 12px;
			background-color: #4a90e2;
			color: white;
			border: none;
			border-radius: 5px;
			margin-top: 10px;
			cursor: pointer;
		}

		button:hover {
			background-color: #357abd;
		}

		h2 {
			text-align: center;
			margin-bottom: 20px;
		}

		th,
		td {
			border: 1px solid #333;
			padding: 10px
		}
	</style>
</head>

<body>
	<div class="container creerUser">
		<h2>Créer un compte</h2>
		<form action="script.php" method="POST" id="creerUser">
			<div class="form-group">
				<label for="nom">Nom</label>
				<input type="text" id="nom" name="nom" required />
			</div>
			<div class="form-group">
				<label for="prenom">Prénom</label>
				<input type="text" id="prenom" name="prenom" required />
			</div>
			<div class="form-group">
				<label for="typeUser">Type d'utilisateur</label>
				<select id="typeUser" name="typeUser">
					<option value="etudiant">Etudiant</option>
					<option value="professeur">Professeur</option>
					<option value="administration">Administration</option>
				</select>
			</div>
			<button type="submit" name="validerInscrire" id="validerInscrire">S'inscrire</button>
			<p id="result"></p>
			<a href="afficherUtilisateur.php">Voir les utilisateurs</a>

		</form>
	</div>

	<div class=" container mt-5 listeComptes" id="listeComptes" hidden>
		<h2>Liste des comptes</h2>
		<table style="width: 100%; border-collapse: collapse">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Email</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Dupont</td>
					<td>Jean</td>
					<td>
						jean.dupont@example.com
					</td>
					<td>
						<button>Supprimer</button>
					</td>
				</tr>
				<tr>
					<td>Martin</td>
					<td>Marie</td>
					<td>
						marie.martin@example.com
					</td>
					<td>
						<button>Supprimer</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<script>
		document.getElementById('creerUser').addEventListener('submit', async (event) => {
			event.preventDefault(); // Empêche la soumission classique du formulaire

			// Récupérer les valeurs du formulaire
			let nom = document.getElementById('nom').value.trim().toLowerCase();
			let prenom = document.getElementById('prenom').value.trim().toLowerCase();
			const typeUser = document.getElementById('typeUser').value;

			// Validation des champs
			if (!prenom || !nom || !typeUser) {
				alert("Tous les champs doivent être remplis !");
				return;
			}

			// Vérifier la longueur du prénom et du nom
			if (prenom.length > 20) {
				prenom = prenom.charAt(0); // Utiliser l'initiale du prénom
			}
			if (nom.length > 20) {
				nom = nom.charAt(0); // Utiliser l'initiale du nom
			}

			// Générer l'identifiant
			const identifiant = `${prenom}.${nom}`;
			console.log(`Identifiant généré : ${identifiant}`); // Pour débogage

			// Générer les données à envoyer
			const formData = new URLSearchParams();
			formData.append("nom", nom);
			formData.append("prenom", prenom);
			formData.append("typeUser", typeUser);
			formData.append("validerInscrire", true);

			// Envoyer les données au serveur via fetch
			try {
				const response = await fetch('script.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: formData.toString(),
				});

				const result = await response.text();
				document.getElementById('result').textContent = result;
			} catch (error) {
				console.error('Erreur lors de la requête :', error);
			}
		});
	</script>
</body>

</html>