<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Articles</title>
    <style>
        .espace{
            margin-left: 5%;
            margin-right: 5%;

        }
        .photo{
            margin-left: 35%;
        }

        .couleur{
            color: white;
            background-image: linear-gradient(to right, black,grey);
            font-family: "Roboto Light";
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expend-lg navbar-dark shadow">
    <div class="container my-2">Liste des Articles</div>
    <div class="nav-item active" > Charpentier Tristan</div>
</nav>

<div class="couleur">
<div class="espace" >

<?php

$id = array();
$content = array();
$img =array();
$site= array();
$file = 'https://www.maisonapart.com/article.json';
$tabLabelBdd=array();
$compteur = 0;
$boolean= false;

$data = file_get_contents($file);

$obj =json_decode($data);

for ($i = 0  ; $i<99;$i++){

    //récupération des données du json

    $label[$i] = $obj->response->docs[$i]->label;
    $content[$i] = $obj->response->docs[$i]->content;
    $img[$i] = $obj->response->docs[$i]->sm_image_url[0];
    $site[$i] = $obj->response->docs[$i]->path;
 }

      try{

    //insertion à la base de donnée MYSQL

        $bdd= new PDO('mysql:host=127.0.0.1;dbname=articles','root','');

        $requeteLireLabel='select * from lesInformations';
        $result = $bdd->query($requeteLireLabel);
        while (($tab=$result->fetch(PDO::FETCH_ASSOC))!=false){
            $tabLabelBdd[$compteur]=$tab['label'];
            $compteur++;
        }


            for ($j = 0; $j < count($label); $j++) {
                $boolean=false;
                for ($k = 0; $k < count($tabLabelBdd); $k++) {
                    if ($label[$j] ==$tabLabelBdd[$k]) {
                        $boolean=true;
                    }
                }
                if ($boolean==false){
                    $requeteInserer = "insert into lesInformations(label,content,image,site)values (?,?,?,?)";
                    $prepa=$bdd->prepare($requeteInserer);
                    $prepa->execute(array($label[$j],$content[$j],$img[$j],$site[$j]));
                }
            }
    $bdd=null;

  }catch (PDOException $e){
       echo 'Echec de connection à la BDD : '.$e->getMessage();
    }

for ($i = 0  ; $i<count($label);$i++){

    //Affichage
    print ("<h3><br><b><u>$label[$i]</u></b><br></h3>
    <p><br>$content[$i]<br></p><a href='$site[$i]'  ><img title='Cliquez sur l&#39image pour aller sur le site internet' class='photo' src=$img[$i] width='500' height='500'></a>
    <br><br><hr>");

}



?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>

