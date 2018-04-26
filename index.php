<?php

class BeamIt
{
    // main configuration storage object
	private $conf; 
	
	// default/sample configuration file
	private $yaml = './conf/conf.yml'; 
	
	// mapping array for services and font awesome css classes
	private $classes = array(
						'bandcamp' => 'fas fa-bold',
						'apple' => 'fab fa-apple',
						'spotify' => 'fab fa-spotify',
						'deezer' => 'fas fa-signal',
						'youtube' => 'fab fa-youtube',
						'facebook' => 'fab fa-facebook',
						'twitter' => 'fab fa-twitter-square',
						'instagram' => 'fab fa-instagram',
						'mixcloud' => 'fab fa-mixcloud',
						'openwhyd' => 'far fa-dot-circle',
						'amazon' => 'fab fa-amazon',
						'vinyl' =>  'fas fa-dot-circle',
						'cd' =>  'far fa-dot-circle',		
						'google play' => 'fab fa-google-play',
		);
	
	private $slug;
	
	// class constructor
	public function __construct() {
		
		$this->setSlug();
		
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
	
	private function setSlug(){
		
		$this->slug = preg_replace('/^([^\?]+).*/msi', '$1', basename($_SERVER['REQUEST_URI']));
	}
	
	// matches the request URl with existing yaml conf file 
	// and loads configuration 
	private function loadConf(){		
		
		if(is_file('./conf/'.str_replace('.json', '', $this->slug).'.yml')){			
			$this->yaml = './conf/'.str_replace('.json', '', $this->slug).'.yml';
		}		
		
		$this->conf = (object)yaml_parse_file ($this->yaml);
	}
	
	// sets base url depending on http/https protocol
	private function setBaseUrl(){
		if ( $_SERVER['HTTPS'] != null){
			$this->conf->baseurl = 'https://'.$_SERVER['HTTP_HOST'].'/';
		}
		else{
			$this->conf->baseurl = 'http://'.$_SERVER['HTTP_HOST'].'/';
		}		
	}
	
	// returns twig template depending on slug
	public function getTemplate(){
		
		if (preg_match('/.+\.json$/si', $this->slug)){
			return 'manifest.json';
		}
		else{
			return 'index.html';
		}		
	}
	
	// returns twig friendly var array
	public function getConf(){
		
		$aTwigVars = array(
			'tartebypass' => 'false',
			'ogurl' => $this->conf->baseurl.$this->slug, 
			'slug' => str_replace('.json', '', $this->slug), 
			'artist' => $this->conf->artist, 
			'release' => $this->conf->release, 
			'img' => $this->conf->img, 
			'services' => $this->conf->services, 
			'socials' => $this->conf->socials, 
			'twitternic' => $this->conf->twitternic, 
			'baseurl' => $this->conf->baseurl
		);		
		
		if(function_exists('geoip_continent_code_by_name')){
			$continent = geoip_continent_code_by_name($_SERVER['REMOTE_ADDR']);		
			if ($continent != 'EU') {
				$aTwigVars['tartebypass']='true';
			}			
		}
		
		return $aTwigVars;
	}
}
	
$o = new BeamIt();

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('twig');
$twig = new Twig_Environment($loader, array(
    //'cache' => 'cache',
	'cache' => false
));
$template = $twig->load($o->getTemplate());
echo $template->render($o->getConf());
