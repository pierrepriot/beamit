<?php
$yaml =  'conf.yml';

/* ------------------------------------------------ */
	
$o = (object)yaml_parse_file ($yaml);


//var_dump($o);


$classes = array(
				'bandcamp' => 'fas fa-bold',
				'apple' => 'fab fa-apple',
				'spotify' => 'fab fa-spotify',
				'deezer' => 'fas fa-signal',
				'youtube' => 'fab fa-youtube',
				'facebook' => 'fab fa-facebook',
				'twitter' => 'fab fa-twitter-square',
				'instagram' => 'fab fa-instagram',
);

foreach($o->services as $k => $aVal){
	if (isset($classes[strtolower($aVal['name'])])){		
		$o->services[$k]['class']=$classes[strtolower($aVal['name'])];		
	}	
}

foreach($o->socials as $k => $aVal){
	if (isset($classes[strtolower($aVal['name'])])){		
		$o->socials[$k]['class']=$classes[strtolower($aVal['name'])];		
	}	
}

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('twig');
$twig = new Twig_Environment($loader, array(
    //'cache' => 'cache',
	'cache' => false
));

$template = $twig->load('index.html');
echo $template->render(array('ogurl' => $_SERVER['REQUEST_URI'], 'artist' => $o->artist, 'release' => $o->release, 'img' => $o->img, 'services' => $o->services, 'socials' => $o->socials));

?>