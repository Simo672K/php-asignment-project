<?php 
require_once("settings.php");
class TEngine{
  static $blocks = array();
	static $cache_path = 'cache/';
	static $cache_enabled = FALSE;
  static $templates_path= __DIR__;

	static function view($path, $data = array()) {
		self::clearCache();
		$cached_file = self::cache($path);
    extract($data, EXTR_SKIP);
    require $cached_file;
	}

	static function cache($path) {
		if (!file_exists(self::$cache_path)) {
      mkdir(self::$cache_path, 0744);
		}
    $path_components= explode("\\",$path);
    $file= array_pop($path_components);
    self::$templates_path= implode("\\", $path_components);

    $cached_file = self::$cache_path . str_replace(array('/', '.html'), array('_', ''), $file . '.php');
    if (!self::$cache_enabled || !file_exists($cached_file) || filemtime($cached_file) < filemtime($file)) {
      $code = self::includeFiles($path);
      $code = self::compileCode($code);
      file_put_contents($cached_file, '<?php class_exists("Parser") or exit; ?>' . PHP_EOL . $code);
    }
		return $cached_file;
	}

	static function clearCache() {
		foreach(glob(self::$cache_path . '*') as $file) {
			unlink($file);
		}
	}

	// Complile the code
	static function compileCode($code) {
		$code = self::compileBlock($code);
		$code = self::compileYield($code);
		$code = self::compileEscapedEchos($code);
		$code = self::compileEchos($code);
		$code = self::complileStatics($code);
		$code = self::compilePHP($code);
		return $code;
	}

	// Compile includes and extends
	static function includeFiles($file) {
		$code = file_get_contents($file);
		preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			$code = str_replace($value[0], self::includeFiles(self::$templates_path."\\".$value[2]), $code);
		}
		$code = preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $code);
		return $code;
	}

	// Head of file, contains all data to be parsed in
	static function compilePHP($code) {
		return preg_replace('~\{%\s*(.+?)\s*\%}~is', '<?php $1 ?>', $code);
	}

	// for static files url compilation
	static function complileStatics($code){
		return preg_replace('/{% static \'(.*?)\' %}/i', '<?php echo STATIC_URL . "/$1"; ?>', $code);
	}

	// static and dynamic links compilation
	static function complileUrls($code){
		
	}
	
	// for dynamic data filling
	static function compileEchos($code) {
		return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $$1 ?>', $code);
	}

	// for parsing html entities "tags" as raw text without evaluating 
	static function compileEscapedEchos($code) {
		return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
	}

	// for block convertion
	static function compileBlock($code) {
		preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
			if (strpos($value[2], '@parent') === false) {
				self::$blocks[$value[1]] = $value[2];
			} else {
				self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
			}
			$code = str_replace($value[0], '', $code);
		}
		return $code;
	}

	// replace {% yield someting %} with code contained in something code block
	static function compileYield($code) {
		foreach(self::$blocks as $block => $value) {
			$code = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $code);
		}
		$code = preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $code);
		return $code;
	}

}
