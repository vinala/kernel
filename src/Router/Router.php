<?php 
namespace Vinala\Kernel\Router;
use Vinala\Kernel\HyperText\Res;
use Vinala\Kernel\Maintenance\Maintenance;
use Vinala\Kernel\Collections\Collection;
use Vinala\Kernel\Config\Config;
use Vinala\Kernel\Http\Errors;
use Vinala\Kernel\Http\Request;
use Vinala\Kernel\Foundation\Application;
use Vinala\Kernel\Access\Url;
use Vinala\Panel\Seeds;
use Vinala\Panel\Migrations;
use Vinala\Panel\Controller;
use Vinala\Panel\Lang;
use Vinala\Panel\Link;
use Vinala\Panel\Model;
use Vinala\Kernel\String\Strings;
use Vinala\Kernel\MVC\Views;
use Vinala\Kernel\MVC\View;
use Vinala\Kernel\Http\Middleware\Middleware;
use App\Http\Filter;
use Vinala\Kernel\Router\Exception\NotFoundHttpException;
use Vinala\Kernel\Http\Middleware\Exceptions\MiddlewareWallException;
/**
* Routes 2
*/
class Routes
{
	public static $requests=array();
	private static $filters=array();
	private static $current=null;
	public static function get($uri,$callback,$subdomains=null)
	{
		$domains = null;
		if(!is_null($subdomains)) $domains = self::extractSubdomains($subdomains);
		if(is_callable($callback)) self::addCallable($uri,$callback,"get",$domains);
		else if(is_array($callback)) self::addFiltred($uri,$callback,"get",$domains);
	}
	/**
	* The HTTP get router
	*
	* @param string $uri
	* @param callable $Callbacks
	* @return null
	*/
	public static function get_($uri , $callback , $filter = null , $subdomains = null)
	{
		$domains = null;
		if(!is_null($subdomains)) {
			$domains = static::extractSubdomains($subdomains);
		}
		if(is_null($filter)){
			static::addCallable($uri,$callback,"get",$filter,$domains);
		} else {
			static::addFiltred_($uri,$callback,"get",$filter,$domains);	
		}
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
	/**
	* to add route with filter
	*
	* @param string $url
	* @param callable $callback
	* @param string $methode
	* @param string|array $filter
	* @param string $subdomain
	* @return null
	*/
	private static function addFiltred_($url , $callback , $methode , $filter , $subdomain = null)
	{
		$name = self::convert($url);
		$request = [
				'name' => $name , 
				'url' => $url , 
				'callback' => $callback,
				'methode' => $methode,
				"filtre" => $filter,
				"subdomain" => $subdomain,
				'controller' => null
			];
		self::$requests[] = $request;
		$request['name'] .= '/';
		$request['url'] .= '/';
		self::$requests[] = $request;
		return ;
	}
	protected static function addFiltred($_url_,$_callback_,$_methode_,$_subdomain_=null)
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
			// break;  Problem with PHP7
		}
		else if($request["methode"]=="post" && !Res::isPost())
		{
			$ok=0;
		}
		else if($request["methode"]=="get")
		{
			$ok=self::exec($params,$request);
			// break;  Problem with PHP7
		}
		else if($request["methode"]=="resource")
		{
			$ok=self::exec($params,$request);
			// break;  Problem with PHP7
		}
		else if($request["methode"]=="object")
		{
			$ok=self::exec($params,$request);
			//var_dump($request);
			// break;  Problem with PHP7
		}
		return $ok;
	}
	public static function run()
	{
		$currentUrl=self::CheckUrl();
		//
		$currentRoot=self::setRoot($currentUrl);
		//
		self::ReplaceParams();
		self::Replace();
		//
		$ok=false;
		//
		foreach (self::$requests as $value) {
			$requestsUrl=$value["url"];
			//
			if(preg_match("#^$requestsUrl$#" , $currentUrl , $params))
			{
				if(!is_null($value["subdomain"]))
				{
					if(Collection::contains($value["subdomain"],self::getDomain()))
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
							else if(is_array($value["methode"]))
							{
								if( $value['methode']['type'] == 'resource' )
								{
									$ok=self::exec($params,$value);
									break;
								}
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
					
					else if(is_array($value["methode"]))
					{
						if( $value['methode']['type'] == 'resource' )
						{
							$ok=self::exec($params,$value);
							break;
						}
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
			exception(NotFoundHttpException::class);
		}
	}
	protected static function exec($params,&$one)
	{
		array_shift($params);
		//
		self::runAppMiddleware();
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
		else 
		{ 
			$ok=self::falseFilter($falseok); 
		}
		//
		$ok=1;
		return $ok;
	}
	protected static function callBefore()
	{
		// call_user_func(Application::$Callbacks['before']);
		/**
		* Working on...
		**/
	}
	protected static function callAfter()
	{
		// call_user_func(Application::$Callbacks['after']);
		/**
		* Working on...
		**/
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
		$url=isset($_GET['_framework_url_'])?$_GET['_framework_url_']:"/";
		return $url;
		//return '/'.$url;
	}
	/**
	* Check and get $_GET['_framework_url_'] and remove it
	*
	* @return string
	*/
	protected static function CheckUrl()
	{
		$url=isset($_GET['_framework_url_'])?'/'.$_GET['_framework_url_']:"/";
		//
		unset($_GET['_framework_url_']);
		//
		return $url;
	}
	/**
	* Set Application::$root for root variable
	*
	* @param string $url
	* @return string
	*/
	protected static function setRoot($url)
	{
		$parts = explode('/', $url);
		$count = count($parts)-2;
		//
		$path = "";
		for ($i=0; $i <$count; $i++) 
		{ 
			$path .= '../';
		}
		Application::$path .= $path;
		return Application::$path;
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
	}
	public static function filter($_name_,$_callback_,$_falsecall_=null)
	{
		self::addFilter($_name_,$_callback_,$_falsecall_);
	}
	protected static function getFilterCallback($_name_)
	{
		return self::$filters[$_name_];
	}
	protected static function callFilter($filtre,&$result,&$falseok)
	{
		$middleware = Middleware::get($filtre);
		if($middleware[0] == 'route')
		{
			$result = static::callRouteMiddleware($middleware[1]);
		}
		elseif($middleware[0] == 'groups')
		{
			$result = static::callGroupMiddleware($middleware[1]);
		}
		if(!$result) { $falseok=$filtre;  return ;}
		exception_if( ! $result , MiddlewareWallException::class , get_class($middleware));
	}
	/**
	* Check middleware group
	*
	* @param array $middlewares
	* @return bool
	*/
	protected static function callGroupMiddleware(array $middlewares)
	{
		$result = 'DO_NOTHING';
		//
		foreach ($middlewares as $key => $value) 
		{
			if( $result != 'DO_NOTHING' ) break;
			//
			$middleware = instance($value);
			$result = $middleware->handle(new Request);
		}
		return $result;
	}
	/**
	* Check middleware route
	*
	* @param mixed $middlewares
	* @return bool
	*/
	protected static function callRouteMiddleware($middleware)
	{
		$middleware = instance($middleware);
		return $middleware->handle(new Request);
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
		
		if(is_array($request['methode']))
		{
			if($request['methode']['type'] == 'resource' && $request['methode']['target'] == 'update')
			{
				$id = $params[0];
				$params[0] = new Request;
				$params[] = $id;
			}
			else if($request['methode']['type'] == 'resource' && $request['methode']['target'] == 'insert')
			{
				$params[] = new Request;
			}
		}
		self::treatment(call_user_func_array($request["callback"], $params));
	}
	/**
	* treatment the result of the route
	*
	* @param closure $result
	* @return string
	*/
	protected static function treatment($result)
	{
		if(is_string($result))
		{
			echo $result;
		}
		elseif ($result instanceof Views) 
		{
			View::show($result);
		}
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
		//to chose what resources to use
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
		if(Collection::contains($routes,"index"))
		{
			self::addController($uri."",                  $controller,"index");
			self::addController($uri."/",                 $controller,"index");
			self::addController($uri."/".$index."",       $controller,"index");
			self::addController($uri."/".$index."/",      $controller,"index");
		}
		//
		if(Collection::contains($routes,"show"))
		{
			self::addController($uri."/$show/{}",         $controller,"show");
			self::addController($uri."/$show/{}/",        $controller,"show");
		}
		//
		if(Collection::contains($routes,"add"))
		{
			self::addController($uri."/$add",             $controller,"add");
			self::addController($uri."/$add/",            $controller,"add");
		}
		//
		if(Collection::contains($routes,"insert"))
		{
			self::addController($uri."/$insert",          $controller,"insert");
			self::addController($uri."/$insert/",         $controller,"insert");
		}
		//
		if(Collection::contains($routes,"edit"))
		{
			
			// self::addController($uri."/{}/$edit",         $controller,"edit");
			// self::addController($uri."/{}/$edit/",        $controller,"edit");
			
			// edited in build 2.5.1.268 last script
			self::addController($uri."/$edit/{}",         $controller,"edit");
			self::addController($uri."/$edit/{}/",        $controller,"edit");
		}
		//
		if(Collection::contains($routes,"update"))
		{
			self::addController($uri."/$update",          $controller,"update");
			self::addController($uri."/$update/",         $controller,"update");
			self::addController($uri."/$update/{}",       $controller,"update",true);
			self::addController($uri."/$update/{}/",      $controller,"update",true);
		}
		//
		if(Collection::contains($routes,"delete"))
		{
			self::addController($uri."/$delete/{}",       $controller,"delete");
			self::addController($uri."/$delete/{}/",      $controller,"delete");
		}
	}
	protected static function addController($url,$controller,$methode,$params=false)
	{
		if($methode=="show" || $methode=="edit" || $methode=="delete")
		{
			$callback=function($id) use ($controller,$methode){ return $controller::$methode($id); };
		}
		else if($methode=='update')
		{
			$callback=function($request , $id) use ($controller,$methode){ return $controller::$methode($request , $id); };
		}
		else if($methode=='insert')
		{
			$callback=function($request) use ($controller,$methode){ return $controller::$methode($request); };
		}
		else
		{
			$callback=function() use ($controller,$methode){ return $controller::$methode(); };
		}
			
		$_name_=self::convert($url);
		$r = array(
			'name' => $_name_ ,
			'url' => $url , 
			'callback' => $callback,
			'methode' => [ 'type' => 'resource' , 'target' => $methode ], //"resource",
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
			'methode' => [ 'type' => 'resource' , 'target' => $methode ],
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
				if(Collection::contains($except,$value)) unset($all[$i]);
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
	/**
	* Check app middlewares before run the application
	*
	* @return null
	*/
	protected static function runAppMiddleware()
	{
		$appMiddleware = Filter::$middleware;
		foreach ($appMiddleware as $middleware ) {
			$middleware = instance($middleware);
			$middleware->handle(new Request);
		}
		return true;
	}
}