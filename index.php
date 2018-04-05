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
);

foreach($o->services as $k => $aVal){
	if (isset($classes[strtolower($aVal['name'])])){		
		$o->services[$k]['class']=$classes[strtolower($aVal['name'])];		
	}	
}

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('twig');
$twig = new Twig_Environment($loader, array(
    //'cache' => 'cache',
	'cache' => false
));

$template = $twig->load('index.html');
echo $template->render(array('artist' => $o->artist, 'release' => $o->release, 'img' => $o->img, 'services' => $o->services));

?>