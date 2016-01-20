<?php 

namespace Fiesta\Core\Router;

use Fiesta\Core\HyperText\Res;
use Fiesta\Core\Maintenance\Maintenance;
use Fiesta\Core\Objects\Table;
use Fiesta\Core\Config\Config;
use Fiesta\Core\Router\Exception\NotFoundHttpException;
use Fiesta\Core\Http\Errors;
use Fiesta\Core\Glob\App;
use Fiesta\Core\Access\Url;
use Fiesta\Vendor\Panel\Seeds;
use Fiesta\Vendor\Panel\Migrations;
use Fiesta\Vendor\Panel\Controller;
use Fiesta\Vendor\Panel\Lang;
use Fiesta\Vendor\Panel\Link;
use Fiesta\Vendor\Panel\Model;
use Fiesta\Core\Objects\String as Strings;


/**
* Routes 2
*/
class Routes
{
	private static $requests=array();
	private static $filters=array();
	private static $current=null;

	public static function get($uri,$callback,$subdomains=null)
	{
		$domains = null;
		if(!is_null($subdomains)) $domains = self::extractSubdomains($subdomains);
		if(is_callable($callback)) self::addCallable($uri,$callback,"get",$domains);
		else if(is_array($callback)) self::addFiltred($uri,$callback,"get",$domains);
	}

	public static function post($uri,$callback)
	{
		if(is_callable($callback)) self::addCallable($uri,$callback,"post");
		else if(is_array($callback)) self::addFiltred($uri,$callback,"post");
	}

	protected static function extractSubdomains($subdomains)
	{
		$spliter=",";
		return explode($spliter, $subdomains);
	}

	protected static function convert(&$url)
	{
		if($url=="/") 
		{ 
			$value="project_home"; 
			$url="";
		}
		else  
		{
			$value=$url;
			$url="/".$url; 
		}
		return $value;
	}

	protected static function convertParams($url)
	{
		$url2="";
		$inner=false;
		for ($i=0; $i < strlen($url); $i++) 
		{ 
			if(!$inner) 
			{
				if($url[$i]!="{") $url2.=$url[$i];
				else
				{
					$url2.="{";
					$inner=true;
				}
			}
			else
			{
				if($url[$i]=="}")
				{
					$url2.="}";
					$inner=false;
				}
			}
		}
		return $url2;
	}

	protected static function addCallable($_url_,$_callback_,$_methode_,$_subdomain_=null)
	{
		$_name_=self::convert($_url_);
		$r = array(
			'name' => $_name_ ,
			'url' => $_url_ , 
			'callback' => $_callback_,
			'methode' => $_methode_,
			"filtre" => null,
			"subdomain" => $_subdomain_,
			'controller' => null
			);
		//
		self::$requests[]=$r;

		$r = array(
			'name' => "$_name_"."/" , 
			'url' => $_url_."/" , 
			'callback' => $_callback_,
			'methode' => $_methode_,
			"filtre" => null,
			"subdomain" => $_subdomain_,
			'controller' => null
			);
		//
		self::$requests[]=$r;
	}

	protected static function addFiltred($_uri_,$_callback_,$_methode_,$_subdomain_=null)
	{
		$_name_=self::convert($_url_);
		$r = array(
			'name' => $_name_ , 
			'url' => $_url_ , 
			'callback' => $_callback_[1],
			'methode' => $_methode_,
			"filtre" => $_callback_[0],
			"subdomain" => $_subdomain_,
			'controller' => null
			);

		//
		self::$requests[]=$r;

		$r = array(
			'name' => $_name_."/" , 
			'url' => $_url_."/" , 
			'callback' => $_callback_[1],
			'methode' => $_methode_,
			"filtre" => $_callback_[0],
			"subdomain" => $_subdomain_,
			'controller' => null
			);
		//
		self::$requests[]=$r;
	}

	protected static function newFilterString($route)
	{
		if(!empty($route["filtre"]))
		{
			$call=self::$_filters[self::$_request[$key]];
			$ok=call_user_func($call);
			if(!$ok) { $falseok=self::$_request[$key];  }
		}
	}

	protected static function getSubDomain()
	{
		$domain=$_SERVER['SERVER_NAME'];
	}

	protected static function getDomain()
	{
		$domain=$_SERVER['SERVER_NAME'];
		return $domain;
	}

	protected static function selectMethode($request,$params)
	{
		var_dump($request["subdomain"]);
		//
		if($request["methode"]=="post" && Res::isPost())
		{
			$ok=self::exec($params,$request);
			break;
		}
		else if($request["methode"]=="post" && !Res::isPost())
		{
			$ok=0;
		}
		else if($request["methode"]=="get")
		{
			$ok=self::exec($params,$request);
			break;
		}
		else if($request["methode"]=="resource")
		{
			$ok=self::exec($params,$request);
			break;
		}
		else if($request["methode"]=="object")
		{
			$ok=self::exec($params,$request);
			//var_dump($request);
			break;
		}
		return $ok;
	}

	public static function run()
	{
		$currentUrl=self::CheckUrl();
		//
		if( ! Maintenance::check())
		{
			self::ReplaceParams();
			self::Replace();
			//
			$ok=false;
			//
			foreach (self::$requests as $value) {
				$requestsUrl=$value["url"];
				//var_dump($value);
				//
				if(preg_match("#^$requestsUrl$#" , $currentUrl , $params))
				{
					if(!is_null($value["subdomain"]))
					{
						if(Table::contains($value["subdomain"],self::getDomain()))
							{
								if($value["methode"]=="post" && Res::isPost())
								{
									$ok=self::exec($params,$value);
									break;
								}
								else if($value["methode"]=="post" && !Res::isPost())
								{
									$ok=0;
								}
								else if($value["methode"]=="get")
								{
									$ok=self::exec($params,$value);
									break;
								}
								else if($value["methode"]=="resource")
								{
									$ok=self::exec($params,$value);
									break;
								}
								else if($value["methode"]=="object")
								{
									$ok=self::exec($params,$value);
									//var_dump($value);
									break;
								}
							}
						else $ok=0;
					}
					else
					{
						if($value["methode"]=="post" && Res::isPost())
						{
							$ok=self::exec($params,$value);
							break;
						}
						else if($value["methode"]=="post" && !Res::isPost())
						{
							$ok=0;
						}
						else if($value["methode"]=="get")
						{
							$ok=self::exec($params,$value);
							break;
						}
						else if($value["methode"]=="resource")
						{
							$ok=self::exec($params,$value);
							break;
						}
						else if($value["methode"]=="object")
						{
							$ok=self::exec($params,$value);
							break;
						}
					}

				}
			}
			if($ok==0) 
			{
				if(Config::get('app.unrouted')) throw new NotFoundHttpException();
				else Errors::r_404();
			}
		}
		else Maintenance::show();
	}

	protected static function exec($params,&$one)
	{
		array_shift($params);
		//
		self::callBefore();
		//
		$ok=true;
		$falseok=null;
		$oks=array();
		//
		$filtre=$one["filtre"];
		if(is_string($filtre))
		{
			if(!empty($filtre))
			{
				self::callFilter($filtre,$ok,$falseok);
			}
		}
		// self::$_request[$key] => $filtre
		else if(is_array($filtre))
		{
			if(!empty($filtre))
			{
				self::callFilters($filtre,$ok,$falseok);
			}
		}

		// run the route callback
		if($ok) { self::runRoute($one,$params); }

		//if the filter is false
		else { $ok=self::falseFilter($falseok); }
		//
		self::callAfter();
		$ok=1;
		return $ok;
	}

	protected static function callBefore()
	{
		call_user_func(App::$Callbacks['before']);
	}

	protected static function callAfter()
	{
		call_user_func(App::$Callbacks['after']);
	}

	protected static function SplitSlash($link)
	{
		$one="";
		$links=$_SERVER['DOCUMENT_ROOT'];
		$array=explode('/', $link);
		foreach ($array as $value)
		{
			$links.="/".$value;
			if (!is_dir($links)) $one.=$value."/";
		}
		return $one;
	}

	protected static function MaintenanceUrl()
	{
		//$url=self::SplitSlash($_SERVER["REQUEST_URI"]);
		$url=isset($_GET['url'])?$_GET['url']:"/";
		return $url;
		//return '/'.$url;
	}

	protected static function CheckUrl()
	{
		//$url=self::SplitSlash($_SERVER["REQUEST_URI"]);
		$url=isset($_GET['url'])?'/'.$_GET['url']:"/";
		return $url;
		//return '/'.$url;
	}

	protected static function CheckMaintenance($url)
	{
		if(!Config::get("maintenance.activate") || in_array($url, Config::get("maintenance.outRoutes")))
			return true;
		else return false;
	}

	protected static function Replace()
	{
		for ($i=0; $i < count(self::$requests); $i++) 
			if (strpos(self::$requests[$i]['url'],'{}') !== false) 
					self::$requests[$i]['url']=str_replace('{}', '(.*)?', self::$requests[$i]['url']); 
	}

	protected static function ReplaceParams()
	{
		for ($i=0; $i < count(self::$requests); $i++) 
			self::$requests[$i]['url']=self::convertParams(self::$requests[$i]['url']);
			//if (strpos(self::$requests[$i]['url'],'{}') !== false) 
			//		self::$requests[$i]['url']=str_replace('{}', '(.*)?', self::$requests[$i]['url']); 
	}

	protected static function addFilter($_name_,$_callback_,$_falsecall_=null)
	{
		$r = array(
			'name' => $_name_,
			'callback' => $_callback_,
			'falsecall' => $_falsecall_
			 );
		self::$filters[$_name_]=$r;
		//if(!is_null($falsecall)) self::$_falsecall[$filter]=$falsecall;
	}

	public static function filter($_name_,$_callback_,$_falsecall_=null)
	{
		self::addFilter($_name_,$_callback_,$_falsecall_);
	}

	protected static function getFilterCallback($_name_)
	{
		return self::$filters[$_name_];
	}

	protected static function callFilter($filtre,&$ok,&$falseok)
	{
		$call=self::$filters[$filtre];
		$ok=call_user_func($call['callback']);
		if(!$ok) { $falseok=$filtre;  }
	}

	protected static function callFilters($filtre,&$ok,&$falseok)
	{
		foreach ($filtre as $key => $value) {
			$call=self::$filters[$value];
			$ok=call_user_func($call['callback']);
			if(!$ok) { $falseok=$value; break; }
		}
	}

	protected static function runRoute($request,$params)
	{
		self::$current=$request["name"];
		return call_user_func_array($request["callback"], $params);
	}

	protected static function falseFilter($key)
	{
		$call=self::$filters[$key]['falsecall'];
		if(isset($call) && !empty($call))
		{
			return call_user_func($call);
		}
	}

	protected static function showMaintenance()
	{
		if(Config::get("maintenance.maintenanceEvent")=="string") echo Config::get("maintenance.maintenanceResponse");
		else if(Config::get("maintenance.maintenanceEvent")=="link") Url::redirect(Config::get("maintenance.maintenanceResponse"));
	}

	public static function resource($uri,$controller,$data=null)
	{
		$only=(isset($data['only']) && !empty($data['only']))?$data['only']:null;
		$except=(isset($data['except']) && !empty($data['except']))?$data['except']:null;
		$names=(isset($data['names']) && !empty($data['names']))?$data['names']:null;
		//
		$routes=self::diffResource($only,$except);
		//
		$index=isset($names['index'])?(!empty($names['index'])?$names['index']:"index"):"index";
		$show=isset($names['show'])?(!empty($names['show'])?$names['show']:"show"):"show";
		$add=isset($names['add'])?(!empty($names['add'])?$names['add']:"add"):"add";
		$insert=isset($names['insert'])?(!empty($names['insert'])?$names['insert']:"insert"):"insert";
		$edit=isset($names['edit'])?(!empty($names['edit'])?$names['edit']:"edit"):"edit";
		$update=isset($names['update'])?(!empty($names['update'])?$names['update']:"update"):"update";
		$delete=isset($names['delete'])?(!empty($names['delete'])?$names['delete']:"delete"):"delete";
		//
		if(Table::contains($routes,"index"))
		{
			self::addController($uri."",                  $controller,"index");
			self::addController($uri."/",                 $controller,"index");
			self::addController($uri."/".$index."",       $controller,"index");
			self::addController($uri."/".$index."/",      $controller,"index");
		}
		//
		if(Table::contains($routes,"show"))
		{
			self::addController($uri."/$show/{}",         $controller,"show");
			self::addController($uri."/$show/{}/",        $controller,"show");
		}
		//
		if(Table::contains($routes,"add"))
		{
			self::addController($uri."/$add",             $controller,"add");
			self::addController($uri."/$add/",            $controller,"add");
		}
		//
		if(Table::contains($routes,"insert"))
		{
			self::addController($uri."/$insert",          $controller,"insert");
			self::addController($uri."/$insert/",         $controller,"insert");
		}
		//
		if(Table::contains($routes,"edit"))
		{
			
			// self::addController($uri."/{}/$edit",         $controller,"edit");
			// self::addController($uri."/{}/$edit/",        $controller,"edit");
			
			// edited in build 2.5.1.268 last script
			self::addController($uri."/$edit/{}",         $controller,"edit");
			self::addController($uri."/$edit/{}/",        $controller,"edit");
		}
		//
		if(Table::contains($routes,"update"))
		{
			self::addController($uri."/$update",          $controller,"update");
			self::addController($uri."/$update/",         $controller,"update");
			self::addController($uri."/$update/{}",       $controller,"update",true);
			self::addController($uri."/$update/{}/",      $controller,"update",true);
		}
		//
		if(Table::contains($routes,"delete"))
		{
			self::addController($uri."/$delete/{}",       $controller,"delete");
			self::addController($uri."/$delete/{}/",      $controller,"delete");
		}
	}

	protected static function addController($url,$controller,$methode,$params=false)
	{
		if($methode=="show" || $methode=="edit" || $methode=="delete")
			$callback=function($id) use ($controller,$methode){ $controller::$methode($id); };
		else if($methode=="update")
		{
			if($params) $callback=function($id) use ($controller,$methode){ $controller::$methode($id); };
			else $callback=function() use ($controller,$methode){ $controller::$methode(); };
		}
		else
			$callback=function() use ($controller,$methode){ $controller::$methode(); };
			

		$_name_=self::convert($url);
		$r = array(
			'name' => $_name_ ,
			'url' => $url , 
			'callback' => $callback,
			'methode' => "resource",
			"filtre" => null,
			"subdomain" => null,
			'controller' => $controller
			);
		//
		self::$requests[]=$r;

		$r = array(
			'name' => "$_name_"."/" , 
			'url' => $url."/" , 
			'callback' => $callback,
			'methode' => "resource",
			"filtre" => null,
			"subdomain" => null,
			'controller' => $controller
			);
		self::$requests[]=$r;
		//
	}

	protected static function diffResource($only,$except)
	{
		$all = array('index','show','add','insert','edit','update','delete');
		//
		if(isset($except))
		{
			$i=0;
			foreach ($all as  $value) 
			{
				if(Table::contains($except,$value)) unset($all[$i]);
				$i++;
			}
		}
		// 
		if(isset($only))
		{
			foreach ($all as $key =>$value) 
			{
				$ext=false;
				foreach ($only as  $value2) {
					if($value==$value2) { $ext=true; break;}
				}
				if(!$ext) unset($all[$key]);
			}
		}
		return $all;
	}

	public static function current()
	{
		return self::$current;
	}	

	/**
	 * to call a method in a controller with string
	 * the string must contains the controller name 
	 * and methode name separted with @ like this
	 * controller_name@methode_name
	 */
	public static function call($url,$callback,$parameter)
	{
		$controller =  self::getCallback($callback , $parameter);
		//
		self::addCallable($url,$controller,"get",null);
	}

	/**
	 * return callback oth methode in controller and
	 * passing one single parameter
	 */
	protected static function getAnonymousFunction($controller,$methode,$parameter)
	{
		return function() use ($controller,$methode,$parameter)
		{
			return $controller::$methode($parameter); 
		};
	}

	/**
	 * get the callback of commande string
	 */
	protected static function getCallback($command , $params)
	{
		$callbacks = self::spliteStringCallback($command);
		//
		$controller = $callbacks["controller"];
		$methode = $callbacks["methode"];
		//
		return self::getAnonymousFunction($controller,$methode,$params);
	}

	/**
	 * splite commande string with '@'
	 */
	protected static function spliteStringCallback($string)
	{
		$data = Strings::splite($string,"@");
		return array('controller' => $data[0], 'methode' => $data[1]);
	}




	
}



