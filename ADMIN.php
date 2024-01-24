<!DOCTYPE html>
<html>

<head>
    <title>Page d'administration</title>
    
</head>

<body>
    <div class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <h2 class="side-header">Page d'administration</h2>
        <div class="nav">
            <ul>
                <li><a href="enregistrabs.php">Enregistrer l'absence des étudiants</a></li>
                <li><a href="listabs.php">Liste des absences des étudiants</a></li>
                <li><a href="excel.php">Enregistrer un fichier Excel d'absences des étudiants</a></li>
            </ul>
        </div>
        <div class="az">
            <ul>
                <li><a href="ajoutetudiant.php">Ajouter des étudiants</a></li>
                <li><a href="ajoutfelier.php">Ajouter une liste d'étudiants</a></li>
                <li><a href="consultermessageetd.php"> les messages des étudiants</a></li>
            </ul>
        </div>
        <ul>
            <li><a href="ajoutrof.php">Ajouter un professeur</a></li>
            <li><a href="ajouteradmin.php">Ajouter un administrateur</a></li>
            <li><a href="element.php">Ajouter une matière/élément</a></li>
            <li><a href="supadmin.php">suprimmer un Admin</a></li>
            <li><a href="supprof.php">suprimmer un prof  </a></li>
            <li><a href="supetudiant.php">suprimmer tous les etudiants d'un filiere</a></li>
            <li><a href="ajoutfiliere.php">Ajouter filiere</a></li>////
        </ul> 
     
        <br>
            <br>
            <br>
            <br>
            <br> 
    </div>
    <a href="javascript:void(0)" class="closebtn" onclick="logout(); closeNav()" style="font-size: 40px; padding: 10px; position: absolute; right: 0;color:red;">&times;</a>
    <div id="main">
        <div class="container">
          <center>  <h1>Page d'administration</h1></center>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="openbtn" onclick="openNav()">&#9776; MENU</div>
            <br>
            <br>
            <br>
           
            <div id="contenu-page"></div>
        </div>
    </div>

    <style>
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #4CAF50;
            overflow-x: hidden;
            padding-top: 60px;
            transition: 0.5s;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 22px;
            color: #fff;
            display: block;
            transition: 0.3s;
        }

        .sidebar .side-header {
            margin-left: 30px;
            margin-bottom: 8px;
            color: #fff;
        }

        .sidebar a:hover {
            background-color: #389036;
        }

        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 2px;
            font-size: 34px;
            margin-left: 50px;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            padding: 10px 15px;
            border: none;
            color: #fff;
            background-color: #4CAF50;
        }

        .openbtn:hover {
            background-color:#389036;
        }

        #main {
            transition: margin-left 0.5s;
            padding: 20px;
        }

        @media screen and (max-height: 278px) {
            .sidebar {
                padding-top: 15px;
            }
            .sidebar a {
                font-size: 18px;
            }
        }
      
    </style>

    <script>
        function openNav() {
            document.querySelector(".sidebar").style.width = "250px";
            document.querySelector("#main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.querySelector(".sidebar").style.width = "0";
            document.querySelector("#main").style.marginLeft = "0";
        }
    </script>
    <script>
// Fonction pour charger le contenu de la page via AJAX
function chargerContenu(page) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("contenu-page").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", page, true);
  xhttp.send();
}

// Écouteurs d'événements pour les clics sur les liens du menu
document.querySelectorAll(".nav a").forEach(function(link) {
  link.addEventListener("click", function(event) {
    event.preventDefault(); // Empêche le comportement par défaut du lien
    var page = this.getAttribute("href");
    chargerContenu(page); // Charge le contenu de la page dans le conteneur
  });
});

document.querySelectorAll(".az a").forEach(function(link) {
  link.addEventListener("click", function(event) {
    event.preventDefault(); // Empêche le comportement par défaut du lien
    var page = this.getAttribute("href");
    chargerContenu(page); // Charge le contenu de la page dans le conteneur
  });
});

document.querySelectorAll("ul li a").forEach(function(link) {
  link.addEventListener("click", function(event) {
    event.preventDefault(); // Empêche le comportement par défaut du lien
    var page = this.getAttribute("href");
    chargerContenu(page); // Charge le contenu de la page dans le conteneur
  });
});
// Fonction pour rediriger vers login.php
function logout() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = "conadmin.php"; // Redirection vers login.php
        }
    };
    xhttp.open("GET", "conadmin.php", true);
    xhttp.send();
}
</script>

</body>

</html>