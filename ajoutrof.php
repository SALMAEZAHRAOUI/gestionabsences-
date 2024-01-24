<style>
  form {
    text-align: center;
    max-width: 400px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
  }

  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 15px;
  }

  input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #45a049;
  }
  h2{
    text-align: center;
  }
</style>

<div class="container">
  <h2>ajouter un prof</h2>
  <form action="ajouter_prof.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" required><br><br>
    <label for="email">Email :</label>
    <input type="email" name="email" required><br><br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Ajouter">
  </form>
</div>