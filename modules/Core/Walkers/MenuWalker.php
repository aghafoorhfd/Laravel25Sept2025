<?php
	namespace Modules\Core\Walkers;
	class MenuWalker
	{
		protected static $currentMenuItem;
		protected        $menu;
		protected $activeItems = [];

		public function __construct($menu)
		{
			$this->menu = $menu;
		}

		public function generate()
		{
			$items = json_decode($this->menu->items, true);
			if (!empty($items)) {
				echo '<ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">';
				$this->generateTree($items);
				echo '</ul>';
			}
		}

        public function generateMobile()
        {
            $items = json_decode($this->menu->items, true);
            if (!empty($items)) {
                echo '<ul>';
                $this->generateTree($items, 0, '', 'mobile');
                echo '</ul>';
            }
        }

		public function generateTree($items = [],$depth = 0,$parentKey = '', $device = 'pc')
		{

			foreach ($items as $k=>$item) {

				$class = $item['class'] ?? '';
				$url = $item['url'] ?? '';
				$item['target'] = $item['target'] ?? '';
				if (!isset($item['item_model']))
					continue;
				if (class_exists($item['item_model'])) {
					$itemClass = $item['item_model'];
					$itemObj = $itemClass::find($item['id']);
					if (empty($itemObj)) {
						continue;
					}
					$url = $itemObj->getDetailUrl();
				}
				if ($this->checkCurrentMenu($item, $url))
				{
					$class .= ' active';
					$this->activeItems[] = $parentKey;
				}

				if (!empty($item['children'])) {
					ob_start();
					$this->generateTree($item['children'],$depth + 1,$parentKey.'_'.$k, $device);
					$html = ob_get_clean();
					if(in_array($parentKey.'_'.$k,$this->activeItems)){
						$class.=' active ';
					}
				}
				$class.=' depth-'.($depth);
				printf('<li class="%s">', e($class));
                if($device == 'pc'){
                    if(empty($item['children'])){
                        printf('<a  target="%s" href="%s" >%s</a>', e($item['target']), e($url), e($item['name']));
                    }else{
                        echo '<a href="javascript:void(0)"><span class="title">'.e($item['name']).'</span></a>';
                    }
                }else{
                    if(empty($item['children'])){
                        printf('<a  target="%s" href="%s" >%s</a>', e($item['target']), e($url), e($item['name']));
                    }else{
                        echo '<span>'.e($item['name']).'</span>';
                    }
                }

				if (!empty($item['children'])) {
					echo '<ul>';
					echo ($html);
					echo "</ul>";
				}
				echo '</li>';
			}
		}

		protected function checkCurrentMenu($item, $url = '')
		{

			if(trim($url,'/') == request()->path()){
				return true;
			}
			if (!static::$currentMenuItem)
				return false;
			if (empty($item['item_model']))
				return false;
			if (is_string(static::$currentMenuItem) and ($url == static::$currentMenuItem or $url == url(static::$currentMenuItem))) {
				return true;
			}
			if (is_object(static::$currentMenuItem) and get_class(static::$currentMenuItem) == $item['item_model'] && static::$currentMenuItem->id == $item['id']) {
				return true;
			}
			return false;
		}

		public static function setCurrentMenuItem($item)
		{
			static::$currentMenuItem = $item;
		}

		public static function getActiveMenu()
		{
			return static::$currentMenuItem;
		}
	}
