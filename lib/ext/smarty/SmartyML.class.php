<?php 
// Originally found at http://www.smarty.net/forums/viewtopic.php?t=84&start=195
// Slightly modified by [SC]Smash3r specially for ezRPG project <scsmash3r@gmail.com>

require(dirname(__FILE__) . '/Smarty.class.php');
/** 
* smarty_prefilter_i18n() 
* This function takes the language file, and rips it into the template 
* $GLOBALS['_NG_LANGUAGE_'] is not unset anymore 
* 
* @param $tpl_source 
* @return 
**/ 
function smarty_prefilter_i18n($tpl_source, &$smarty) { 
   if (!is_object($GLOBALS['_NG_LANGUAGE_'])) { 
   die("Error loading Multilanguage Support"); 
} 
// load translations (if needed) 
$GLOBALS['_NG_LANGUAGE_']->loadCurrentTranslationTable(); 
// Now replace the matched language strings with the entry in the file 
return preg_replace_callback('/##(.+?)##/', '_compile_lang', $tpl_source); 
} 

// Additional shorthand function for plugins translation (copy of upper one)
function _e($tpl_source) { 
   if (!is_object($GLOBALS['_NG_LANGUAGE_'])) { 
   die("Error loading Multilanguage Support"); 
} 
// load translations (if needed) 
$GLOBALS['_NG_LANGUAGE_']->loadCurrentTranslationTable(); 
// Now replace the matched language strings with the entry in the file 
return preg_replace_callback('/##(.+?)##/', '_compile_lang', $tpl_source); 
} 

/** 
 * _compile_lang 
 * Called by smarty_prefilter_i18n function it processes every language 
 * identifier, and inserts the language string in its place. 
 * 
*/ 

function _compile_lang($key) { 
   return $GLOBALS['_NG_LANGUAGE_']->getTranslation($key[1]); 
} 

class SmartyML extends Smarty { 
   var $language; 
   function __construct($locale="") { 
      parent::__construct();  
      // Multilanguage Support 
      // use $smarty->language->setLocale() to change the language of your template 
      //     $smarty->loadTranslationTable() to load custom translation tables 
      $this->language = new ngLanguage($locale); // create a new language object 
      $GLOBALS['_NG_LANGUAGE_'] =$this->language; 
       
      $this->registerFilter('pre','smarty_prefilter_i18n'); 
   } 
   function fetch($_smarty_tpl_file, $_smarty_cache_id = null, $_smarty_compile_id = null, $_smarty_parent = null, $_smarty_display = false) { 
      // We need to set the cache id and the compile id so a new script will be 
      // compiled for each language. This makes things really fast ;-) 
      $_smarty_compile_id = $this->language->getCurrentLanguage().'-'.$_smarty_compile_id; 
      $_smarty_cache_id = $_smarty_compile_id; 
      // Now call parent method 
      return parent::fetch( $_smarty_tpl_file, $_smarty_cache_id, $_smarty_compile_id, $_smarty_parent, true); 
   } 

   /** 
     * test to see if valid cache exists for this template 
     * 
     * @param string $tpl_file name of template file 
     * @param string $cache_id 
     * @param string $compile_id 
     * @return string|false results of {@link _read_cache_file()} 
   */ 
    
   function is_cached($tpl_file, $cache_id = null, $compile_id = null) { 
      if (!$this->caching) 
         return false; 
        if (!isset($compile_id)) { 
           $compile_id = $this->language->getCurrentLanguage().'-'.$this->compile_id; 
         $cache_id = $compile_id; 
         return parent::is_cached($tpl_file, $cache_id, $compile_id); 
      } 
   } 
} 

class ngLanguage { 
   var $_translationTable;        // currently loaded translation table 
   var $_supportedLanguages;      // array of all supported languages 
   var $_defaultLocale;           // the default lang locale
   var $_currentLocale;           // currently set locale 
   var $_currentLanguage;         // currently loaded language 
   var $_languageTable;           // array of language to file associations 
   var $_loadedTranslationTables; // array of all loaded translation tables 

   function ngLanguage($locale="") { 
      $this->_languageTable = Array( 
      "de" => "deu", 
      "en" => "eng", 
      "en-us" => "eng", 
      "en-gb" => "eng", 
      "nl" => "nld", 
      "zh" => "chn", 
      "dk" => "dnk", 
      "es" => "esp", 
      "fr" => "fra", 
      "it" => "ita", 
      "no" => "nor", 
      "pl" => "pol", 
      "pt" => "prt", 
      "ru" => "rus", 
      "sv" => "swe", 
      "tr" => "tur" 
      ); // to be continued ... 
      $this->_translationTable = Array(); 
      $this->_loadedTranslationTables = Array(); 
      foreach ($this->_languageTable as $lang) 
      $this->_translationTable[$lang] = Array(); 
      $this->_defaultLocale = 'en'; 
      if (empty($locale)) 
         $locale = $this->getHTTPAcceptLanguage(); 
      $this->setCurrentLocale($locale); 
	  $this->setDefaultLocale($this->_defaultLocale);
   } 

   function getAvailableLocales() { 
      return array_keys($this->_languageTable); 
   } 

   function getAvailableLanguages() { 
      return array_unique(array_values($this->_languageTable)); 
   } 

   function getCurrentLanguage() { 
      return $this->_currentLanguage; 
   } 

   function setCurrentLanguage($language) { 
      $this->_currentLanguage = $language; 
   } 
   
   function setDefaultLanguage($language) { 
      $this->_defaultLanguage = $language; 
   } 

   function getCurrentLocale() { 
      return $this->_currentLocale; 
   } 

   function setCurrentLocale($locale) { 
      $language = $this->_languageTable[$locale]; 
      if (empty($language)) { 
         die ("LANGUAGE Error: Unsupported locale '$locale'"); 
      } 
      $this->_currentLocale = $locale; 
      return $this->setCurrentLanguage($language); 
   } 
   
   function setDefaultLocale($locale) { 
      $language = $this->_languageTable[$locale]; 
      if (empty($language)) { 
         die ("LANGUAGE Error: Unsupported locale '$locale'"); 
      } 
      $this->_defaultLocale = $locale; 
      return $this->setDefaultLanguage($language); 
   } 

   function getDefaultLocale() { 
      return $this->_defaultLocale; 
   } 

   function getHTTPAcceptLanguage() { 
      $langs = explode(';', $_SERVER["HTTP_ACCEPT_LANGUAGE"]); 
      $locales = $this->getAvailableLocales(); 
      foreach ($langs as $value_and_quality) { 
         // Loop through all the languages, to see if any match our supported ones 
         $values = explode(',', $value_and_quality); 
         foreach ($values as $value) { 
            if (in_array($value, $locales)){ 
               // If found, return the language 
               return $value; 
            } 
         } 
      } 
      // If we can't find a supported language, we use the default 
      return $this->getDefaultLocale(); 
   } 

   // Warning: parameter positions are changed! 
   function _loadTranslationTable($locale, $path='') { 
      if (empty($locale)) 
         $locale = $this->getDefaultLocale(); 
      $language = $this->_languageTable[$locale]; 
      if (empty($language)) { 
         die ("LANGUAGE Error: Unsupported locale '$locale'"); 
      } 
      if (!is_array($this->_translationTable[$language])) { 
         die ("LANGUAGE Error: Language '$language' not available"); 
      } 
      if(empty($path)) 
         $path =(dirname(__FILE__)) . '/../../lang/'.$this->_languageTable[$locale].'/global.lng'; 
      if (isset($this->_loadedTranslationTables[$language])) { 
         if (in_array($path, $this->_loadedTranslationTables[$language])) { 
            // Translation table was already loaded 
            return true; 
         } 
      } 
      if (file_exists($path)) { 
         $entries = file($path); 
         $this->_translationTable[$language][$path] = Array(); 
         $this->_loadedTranslationTables[$language][] = $path; 
         foreach ($entries as $row) { 
            if (substr(ltrim($row),0,2) == '//') // ignore comments 
            continue; 
            $keyValuePair = explode('=',$row); 
            // multiline values: the first line with an equal sign '=' will start a new key=value pair 
            if(sizeof($keyValuePair) == 1) { 
               $this->_translationTable[$language][$path][$key] .= ' ' . chop($keyValuePair[0]); 
               continue; 
            } 
            $key = trim($keyValuePair[0]); 
            $value = $keyValuePair[1]; 
            if (!empty($key)) { 
               $this->_translationTable[$language][$path][$key] = chop($value); 
            }
         } 
         return true; 
      } 
      return false; 
   } 

   // Warning: parameter positions are changed! 
   function _unloadTranslationTable($locale, $path) { 
      $language = $this->_languageTable[$locale]; 
      if (empty($language)) { 
         die ("LANGUAGE Error: Unsupported locale '$locale'"); 
      } 
      unset($this->_translationTable[$language][$path]); 
      foreach($this->_loadedTranslationTables[$language] as $key => $value) { 
         if ($value == $path) { 
            unset($this->_loadedTranslationTables[$language][$key]); 
            break; 
         } 
      } 
      return true; 
   } 

   function loadCurrentTranslationTable() { 
      $this->_loadTranslationTable($this->getCurrentLocale()); // Loading current language stuff
	  $this->_loadTranslationTable($this->getDefaultLocale()); // Loading default language for degrade, so not to show ugly ##VARIABLE_HERE## strings
   } 

   function getTranslation($key) { 
		
      $trans = $this->_translationTable[$this->_currentLanguage]; 
	  $default = $this->_translationTable[$this->_defaultLanguage];
	  
	  $not_translated = Array();

      if (is_array($trans)) { 
         foreach ($this->_loadedTranslationTables[$this->_currentLanguage] as $table) {
            if (isset($trans[$table][$key])) {
               return $trans[$table][$key];
				// If no string to translate is found - store it in another array to gracefully degrade to default language
            } else { 
				$not_translated[] = $key;
			}
         } 
      } 
	  
	if (is_array($not_translated)) {
         foreach ($this->_loadedTranslationTables[$this->_defaultLanguage] as $table) {
            if (isset($default[$table][$key]) && in_array($key, $not_translated)) {
               return $default[$table][$key];
            }
         }
	}
      return $key; 
   } 

} 
?>