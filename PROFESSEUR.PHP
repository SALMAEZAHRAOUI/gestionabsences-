
<!DOCTYPE html>
<html>

<head>
    <title>Page de prof</title>
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
            margin: 18px;
        }

        .sidebar .side-header {
            margin-left: 30px;
            margin-bottom: 8px;
            color: #fff;
        }

        .sidebar a:hover {
            background-color:#389036;
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
            background-color: #389036;
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

        /* Style CSS pour la mise en forme de la page */

        .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 10px;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="enregistrabs.php">Enregistrer l'absence des étudiants</a>
        <a href="listabs.php">Liste des absences des étudiants</a>
        <a href="consultermessageetd.php">Messages des étudiants</a>
        
   
        <a href="excel.php">Enregistrer un fichier Excel d'absences des étudiants</a>
    </div>

    <div id="main">
        <div class="zz">
            <div class="container">
                <h1>Page de prof</h1>
  
               
                <span class="openbtn" onclick="openNav()">&#9776; Menu</span>
                <br>
                <br>
                <br>
                <div id="contenu-page"></div>
            </div>
        </div>
    </div>

    <script>
        function openNav() {
            document.querySelector(".sidebar").style.width = "250px";
            document.querySelector("#main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.querySelector(".sidebar").style.width = "0";
            document.querySelector("#main").style.marginLeft = "0";
        }

        
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
document.querySelectorAll(".sidebar a").forEach(function(link) {
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
</script>
</body>

</html>