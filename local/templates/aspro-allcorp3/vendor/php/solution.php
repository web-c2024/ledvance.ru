<?
namespace {
	if (!defined('VENDOR_PARTNER_NAME')) {
		/** @const Aspro partner name */
		define('VENDOR_PARTNER_NAME', 'aspro');
	}
			
	if (!defined('VENDOR_SOLUTION_NAME')) {
		/** @const Aspro solution name */
		define('VENDOR_SOLUTION_NAME', 'allcorp3');
	}
			
	if (!defined('VENDOR_MODULE_ID')) {
		/** @const Aspro module id */
		define('VENDOR_MODULE_ID', 'aspro.allcorp3');
	}
			
	if (!defined('VENDOR_MODULE_CODE')) {
		/** @const Aspro module code */
		define('VENDOR_MODULE_CODE', '');
	}
			
	foreach ([
		'CAllcorp3' => 'TSolution',
		'CAllcorp3Events' => 'TSolution\Events',
		'CAllcorp3Cache' => 'TSolution\Cache',
		'CAllcorp3Regionality' => 'TSolution\Regionality',
		'CAllcorp3Condition' => 'TSolution\Condition',
		'CInstargramAllcorp3' => 'TSolution\Instagram',
		'CAllcorp3Tools' => 'TSolution\Tools',
		'CVKAllcorp3' => 'TSolution\VK',
		'Aspro\Allcorp3\Functions\CAsproAllcorp3' => 'TSolution\Functions',
		'Aspro\Functions\CAsproAllcorp3Custom' => 'TSolution\FunctionsCustom',
		'Aspro\Allcorp3\Functions\CAsproAllcorp3ReCaptcha' => 'TSolution\ReCaptcha',
		'Aspro\Allcorp3\Functions\CAsproAllcorp3Switcher' => 'TSolution\Switcher',
		'Aspro\Allcorp3\Functions\Extensions' => 'TSolution\Extensions',
		'Aspro\Allcorp3\Functions\CSKU' => 'TSolution\SKU',
		'Aspro\Allcorp3\Functions\CSKUTemplate' => 'TSolution\CSKUTemplate',
		'Aspro\Allcorp3\Functions\ExtComponentParameter' => 'TSolution\ExtComponentParameter',
		'Aspro\Allcorp3\Property\CustomFilter' => 'TSolution\Property\CustomFilter',
		'Aspro\Allcorp3\Property\TariffItem' => 'TSolution\Property\TariffItem',
		'Aspro\Allcorp3\Notice' => 'TSolution\Notice',
		'Aspro\Allcorp3\Eyed' => 'TSolution\Eyed',
		'Aspro\Allcorp3\Banner\Transparency' => 'TSolution\Banner\Transparency',
		'Aspro\Allcorp3\Video\Iframe' => 'TSolution\Video\Iframe',
		'Aspro\Allcorp3\MarketingPopup' => 'TSolution\MarketingPopup',
		'Aspro\Allcorp3\Product\Common' => 'TSolution\Product\Common',
		'Aspro\Allcorp3\Product\DetailGallery' => 'TSolution\Product\DetailGallery',
		'Aspro\Allcorp3\Product\Image' => 'TSolution\Product\Image',
		'Aspro\Allcorp3\Product\Template' => 'TSolution\Product\Template',
		'Aspro\Allcorp3\Form\Field\Factory' => 'TSolution\Form\Field\Factory',
		'Aspro\Allcorp3\Utils' => 'TSolution\Utils',
	] as $original => $alias) {
		if (!class_exists($alias)) {
			class_alias($original, $alias);
		}    
	}

	// these alias declarations for IDE only
	if (false) {
		class TSolution extends CAllcorp3 {}
	}
}

// these alias declarations for IDE only
namespace TSolution {
	if (false) {
		class Events extends \CAllcorp3Events {}

		class Cache extends \CAllcorp3Cache {}

		class Regionality extends \CAllcorp3Regionality {}

		class Condition extends \CAllcorp3Condition {}

		class Instagram extends \CInstargramAllcorp3 {}

		class Tools extends \CAllcorp3Tools {}

		class Functions extends \Aspro\Allcorp3\Functions\CAsproAllcorp3 {}

		class FunctionsCustom extends \Aspro\Functions\CAsproAllcorp3Custom {}

		class Extensions extends \Aspro\Allcorp3\Functions\Extensions {}

		class SKU extends \Aspro\Allcorp3\Functions\CSKU {}

		class Notice extends \Aspro\Allcorp3\Notice {}

		class Eyed extends \Aspro\Allcorp3\Eyed {}

		class ExtComponentParameter extends \Aspro\Allcorp3\Functions\ExtComponentParameter {}

		class ReCaptcha extends \Aspro\Allcorp3\Functions\CAsproAllcorp3ReCaptcha {}

		class Switcher extends \Aspro\Allcorp3\Functions\CAsproAllcorp3Switcher {}

		class CSKUTemplate extends \Aspro\Allcorp3\Functions\CSKUTemplate {}

		class VK extends \CVKAllcorp3 {}

		class MarketingPopup extends \Aspro\Allcorp3\MarketingPopup {}

		class Utils extends \Aspro\Allcorp3\Utils {}
	}
}

namespace TSolution\Banner {
	if (false) {
		class Transparency extends \Aspro\Allcorp3\Banner\Transparency {}
	}
}

namespace TSolution\Form\Field {
	if (false) {
		class Factory extends \Aspro\Allcorp3\Form\Field\Factory {}
	}
}

namespace TSolution\Product {
	if (false) {
		class Common extends \Aspro\Allcorp3\Product\Common {}

		class Image extends \Aspro\Allcorp3\Product\Image {}
		
		class DetailGallery extends \Aspro\Allcorp3\Product\DetailGallery {}

		class Template extends \Aspro\Allcorp3\Product\Template {}
	}
}

namespace TSolution\Video {
	if (false) {
		class Iframe extends \Aspro\Allcorp3\Video\Iframe {}
	}
}

namespace TSolution\Property {
	if (false) {
		class CustomFilter extends \Aspro\Allcorp3\Property\CustomFilter {}

		class TariffItem extends \Aspro\Allcorp3\Property\TariffItem {}
	}
}