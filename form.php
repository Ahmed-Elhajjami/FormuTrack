<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">
    <title>Formulaire Clients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("form.jpg");
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 640px;
            height: auto;
            max-height: 800px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .form-container:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-field {
            margin-bottom: 10px;
            position: relative;
            transition: transform 0.3s ease;
        }

        .form-field label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .form-field input,
        .form-field textarea {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-field input:focus,
        .form-field textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .form-field .error {
            color: red;
            font-size: 0.9em;
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
            transition: opacity 0.3s ease;
        }

        .form-field.error .error {
            display: block;
            opacity: 1;
        }

        button {
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.98);
        }
        .logout-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 10px 20px;
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .logout-button:hover {
        background-color: #c82333;
    }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Formulaire Clients</h1>
        <form id="professionalForm" action="traitment.php" method="post">
    <div class="form-group">
        <div class="form-field">
            <label for="partenaire">Partenaire :</label>
            <input type="text" id="partenaire" name="partenaire" required>
            <span class="error" id="partenaireError">Le partenaire est requis.</span>
        </div>
        <div class="form-field">
            <label for="nomPresident">Nom président :</label>
            <input type="text" id="nomPresident" name="nomPresident" required>
            <span class="error" id="nomPresidentError">Le nom président est requis.</span>
        </div>
    </div>
    <div class="form-group">
        <div class="form-field">
            <label for="activite">Activité :</label>
            <input type="text" id="activite" name="activite" required>
            <span class="error" id="activiteError">L'activité est requise.</span>
        </div>
        <div class="form-field">
            <label for="projet">Projet :</label>
            <input type="text" id="projet" name="projet" required>
            <span class="error" id="projetError">Le projet est requis.</span>
        </div>
    </div>
    <div class="form-group">
        <div class="form-field">
            <label for="budgetDebloque">Budget débloqué :</label>
            <input type="number" id="budgetDebloque" name="budgetDebloque" step="0.01" required>
            <span class="error" id="budgetDebloqueError">Le budget débloqué est requis.</span>
        </div>
        <div class="form-field">
            <label for="avancement">Avancement :</label>
            <input type="text" id="avancement" name="avancement" required>
            <span class="error" id="avancementError">L'avancement est requis.</span>
        </div>
    </div>
    <div class="form-group">
        <div class="form-field">
            <label for="chefDeProjet">Chef de projet :</label>
            <input type="text" id="chefDeProjet" name="chefDeProjet" required>
            <span class="error" id="chefDeProjetError">Le chef de projet est requis.</span>
        </div>
    </div>
    <button type="submit">Envoyer</button>
</form>

</form>

    <script>
        document.getElementById('professionalForm').addEventListener('submit', function(event) {
            let isValid = true;

            // Validation des champs
            const fields = ['partenaire', 'nomPresident', 'activite', 'projet', 'budget', 'avancement', 'chefProjet'];
            fields.forEach(field => {
                const input = document.getElementById(field);
                const errorSpan = document.getElementById(field + 'Error');
                const formField = input.parentElement;

                if (!input.checkValidity()) {
                    errorSpan.style.display = 'block';
                    formField.classList.add('error');
                    isValid = false;
                } else {
                    errorSpan.style.display = 'none';
                    formField.classList.remove('error');
                }
            });

            // Empêcher l'envoi du formulaire si des erreurs sont présentes
            if (!isValid) {
                event.preventDefault();
            }
        });

        // Validation en temps réel
        document.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', function() {
                const errorSpan = document.getElementById(this.id + 'Error');
                const formField = this.parentElement;

                if (this.checkValidity()) {
                    errorSpan.style.display = 'none';
                    formField.classList.remove('error');
                } else {
                    errorSpan.style.display = 'block';
                    formField.classList.add('error');
                }
            });
        });

        
    </script>
      <form action="logout.php" method="post">
        <button type="submit" class="logout-button">Se déconnecter</button>
      </form>
    
</body>
</html>
