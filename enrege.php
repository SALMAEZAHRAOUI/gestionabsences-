<!DOCTYPE html>
<html>
<head>
    <style>body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  margin: 0;
  padding: 0;
}

h1 {
  text-align: center;
  color: #333;
}

form {
  max-width: 400px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 4px;
}

label {
  display: block;
  margin-bottom: 10px;
  color: #333;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 90%;
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}</style>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form method="POST" action="enregistrement.php">
        <label for="first_name">Prénom:</label>
        <input type="text" name="prenom" required><br>

        <label for="last_name">Nom:</label>
        <input type="text" name="nom" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Mot de passe:</label>
        <input type="password" name="motDePasse" required><br>

        <label for="contact_no">Numéro de contact:</label>
        <input type="text" name="contactNo" required><br>

        <label for="cne">CNE</label>
        <input type="text" name="cne" required><br>

        <input type="submit" name="submit" value="S'inscrire"><br>
        <br>
        <div class="links"> Déjà un compte? <a href="conex.php">Connectez-vous maintenant</a> </div>
                 
    </form>
</body>
</html>