<?php
$yaml =  'conf.yml';

/* ------------------------------------------------ */
	
$o = (object)yaml_parse_file ($yaml);
$o->services=(object)($o->services);

var_dump($o);


?><!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="theme-color" content="#3273dc">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
    <title><?php echo $o->artist.' - '.$o->release; ?></title>
    <style>
		a  {
color: #363636;
}
		
	</style>
</head>
<body>
<section class="hero is-info is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title"><?php echo $o->artist.' - '.$o->release; ?></h1>
        </div>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column">
                <div class="panel">
                    
                    <div class="panel-block">
                        <div class="content">
                            <p>
                               <img src="<?php echo $o->img; ?>"  alt="<?php echo $o->artist.' - '.$o->release; ?>">                               
                            </p>
                           
                        </div>
                    </div>

                </div>
            </div>
            <div class="column">
               
               <div class="panel">
                    <p class="panel-heading">
                        <span class="icon"><i class="fas fa-bold"></i></span>
                        Bandcamp
                    </p>                    
                </div>
                
               <div class="panel">
                    <p class="panel-heading">
                        <span class="icon"><i class="fab fa-apple"></i></span>
                        iTunes - Apple Music
                    </p>                   
                </div>
                
                 <div class="panel">
                        <p class="panel-heading">
                        <span class="icon"><i class="fab fa-spotify"></i></span>
                        Spotify
                    </p>
                </div>
                
                <div class="panel">
                    <p class="panel-heading">
                        <span class="icon"><i class="fas fa-signal"></i></span>
							<a href="<?php echo $o->services->Deezer; ?>" class="is-info">Deezer</a>
                    </p>
                </div>
       