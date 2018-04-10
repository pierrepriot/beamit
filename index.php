<?php

class BeamIt
{
    private $o;
	private $yaml = 'conf.yml';
	private $classes = array(
						'bandcamp' => 'fas fa-bold',
						'apple' => 'fab fa-apple',
						'spotify' => 'fab fa-spotify',
						'deezer' => 'fas fa-signal',
						'youtube' => 'fab fa-youtube',
						'facebook' => 'fab fa-facebook',
						'twitter' => 'fab fa-twitter-square',
						'instagram' => 'fab fa-instagram',
		);

	public function __construct() {
		$this->loadConf();
		
		foreach($this->conf->services as $k => $aVal){
			if (isset($this->classes[strtolower($aVal['name'])])){		
				$this->conf->services[$k]['class']=$this->classes[strtolower($aVal['name'])];		
			}	
		}

		foreach($this->conf->socials as $k => $aVal){
			if (isset($this->classes[strtolower($aVal['name'])])){		
				$this->conf->socials[$k]['class']=$this->classes[strtolower($aVal['name'])];		
			}	
		}

		$this->setBaseUrl();
	 }
	
	private function loadConf(){
		
		$slug = preg_replace('/^([^\?]+).*/msi', '$1', basename($_SERVER['REQUEST_URI']));
		
		if(is_file($slug.'.yml')){			
			$this->yaml = $slug.'.yml';
		}		
		
		$this->conf = (object)yaml_parse_file ($this->yaml);
	}
	
	private function setBaseUrl(){
		if ( $_SERVER['HTTPS'] != null){
			$this->conf->baseurl = 'https://'.$_SERVER['HTTP_HOST'].'/';
		}
		else{
			$this->conf->baseurl = 'http://'.$_SERVER['HTTP_HOST'].'/';
		}		
	}
	
	
	public function getConf(){
		
		return array(
			'ogurl' => $_SERVER['REQUEST_URI'], 
			'artist' => $this->conf->artist, 
			'release' => $this->conf->release, 
			'img' => $this->conf->img, 
			'services' => $this->conf->services, 
			'socials' => $this->conf->socials, 
			'twitternic' => $this->conf->twitternic, 
			'baseurl' => $this->conf->baseurl);		
	}
}
	
$o = new BeamIt();

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('twig');
$twig = new Twig_Environment($loader, array(
    //'cache' => 'cache',
	'cache' => false
));
$template = $twig->load('index.html');
echo $template->render($o->getConf());
