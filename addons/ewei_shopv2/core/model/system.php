<?php
if (!defined("IN_IA")) {
	exit("Access Denied");
}

class System_EweiShopV2Model
{
	private $merch = false;

	public function __construct()
	{
		global $_W;
		if ($_W["plugin"] == "merch" && $_W["merch_user"]) {
			$this->merch = true;
		}
	}

	public function getMenu($full = false)
	{
		global $_W;
		global $_GPC;
		$return_menu = array();
		$return_submenu = array();
		$route = trim($_W["routes"]);
		$routes = explode(".", $_W["routes"]);
		$top = (empty($routes[0]) ? "shop" : $routes[0]);
		if ($this->merch) {
			$allmenus = $this->pluginMenu("merch", "manage_menu");
		} else {
			if (!$_W["isplugin"] && $routes[0] == "system") {
				$allmenus = $this->systemMenu();
			} else {
				$allmenus = $this->shopMenu();
			}
		}
		if ($routes[0] == "system") {
			$top = $routes[1];
		}
		if (!empty($allmenus)) {
			$submenu = $allmenus[$top];
			if (empty($submenu)) {
				$othermenu = $this->otherMenu();
				if (!empty($othermenu[$top])) {
					$submenu = $othermenu[$top];
				}
			}
			if (empty($submenu) && p($top)) {
				$submenu = $this->pluginMenu($top);
				$isplugin = true;
			}
			foreach ($allmenus as $key => $val) {
				if (!empty($val["plugincom"])) {
					if ($val["plugincom"] == 1) {
						if (!p($key)) {
							continue;
						}
					} else {
						if ($val["plugincom"] == 2 && !com($key)) {
							continue;
						}
					}
				}
				if ($this->cv($key)) {
					$menu_item = array(
						"route" => (empty($val["route"]) ? $key : $val["route"]),
						"text"  => $val["title"]
					);
					if ($routes[0] == "system") {
						$menu_item["route"] = "system." . $menu_item["route"];
					}
					if (!empty($val["index"])) {
						$menu_item["index"] = $val["index"];
					}
					if (!empty($val["param"])) {
						$menu_item["param"] = $val["param"];
					}
					if (!empty($val["icon"])) {
						$menu_item["icon"] = $val["icon"];
						if (!empty($val["iconcolor"])) {
							$menu_item["iconcolor"] = $val["iconcolor"];
						}
					}
					if ($top == $menu_item["route"] || $menu_item["route"] == $route || "system." . $top == $menu_item["route"]) {
						if ($this->verifyParam($val) && !empty($_GPC["r"])) {
							$menu_item["active"] = 1;
						}
					} else {
						if ($key == "plugins" && $isplugin && !$this->merch) {
							$menu_item["active"] = 1;
						}
					}
					if ($full) {
						$menu_item["url"] = webUrl($menu_item["route"], (!empty($menu_item["param"]) && is_array($menu_item["param"]) ? $menu_item["param"] : array()));
					}
					$return_menu[] = $menu_item;
				}
			}
			unset($key);
			unset($val);
			if (!empty($submenu)) {
				if (!empty($submenu["plugincom"])) {
					$return_submenu["subtitle"] = m("plugin")->getName($top);
					$return_submenu["plugin"] = $top;
					$return_submenu["route"] = $top;
				} else {
					$return_submenu["subtitle"] = $submenu["subtitle"];
					if ($submenu["main"]) {
						$return_submenu["route"] = $top;
						if (is_string($submenu["main"])) {
							$return_submenu["route"] .= "." . $submenu["main"];
						}
					}
					if (!empty($submenu["index"])) {
						$return_submenu["route"] = $top . "." . $submenu["index"];
					}
				}
				if (!empty($submenu["items"])) {
					foreach ($submenu["items"] as $i => $child) {
						if (!empty($child["isplugin"])) {
							if (!p($child["isplugin"])) {
								continue;
							}
							if (!empty($child["permplugin"]) && !p($child["permplugin"])) {
								continue;
							}
						} else {
							if (!empty($child["iscom"])) {
								if (!com($child["iscom"])) {
									continue;
								}
								if (!empty($child["permcom"]) && !com($child["permcom"])) {
									continue;
								}
							}
						}
						if ($this->merch && $child["hidemerch"]) {
							continue;
						}
						if (!empty($child["top"])) {
							$top = "";
						}
						if (empty($child["items"])) {
							$return_submenu_default = $top . "";
							$route_second = $top;
							if (!empty($child["route"])) {
								if (!empty($top)) {
									$route_second .= ".";
								}
								$route_second .= $child["route"];
							}
							$return_menu_child = array(
								"title" => $child["title"],
								"route" => (empty($child["route"]) ? $return_submenu_default : $route_second)
							);
							if (!empty($child["param"])) {
								$return_menu_child["param"] = $child["param"];
							}
							if (!empty($child["perm"])) {
								$return_menu_child["perm"] = $child["perm"];
							}
							if (!empty($child["permmust"])) {
								$return_menu_child["permmust"] = $child["permmust"];
							}
							if ($routes[0] == "system") {
								$return_menu_child["route"] = "system." . $return_menu_child["route"];
							}
							$addedit = false;
							if (!$child["route_must"] && ($return_menu_child["route"] . ".add" == $route || $return_menu_child["route"] . ".edit" == $route)) {
								$addedit = true;
							}
							$extend = false;
							if (!empty($child["extend"])) {
								if ($child["extend"] . ".add" == $route || $child["extend"] . ".edit" == $route || $child["extend"] == $route) {
									$extend = true;
								}
							} else {
								if (!empty($child["extends"]) && is_array($child["extends"]) && (in_array($route, $child["extends"]) || in_array($route . ".add", $child["extends"]) || in_array($route . ".edit", $child["extends"]))) {
									$extend = true;
								}
							}
							if ($child["route_in"] && strexists($route, $return_menu_child["route"])) {
								$return_menu_child["active"] = 1;
							} else {
								if (($return_menu_child["route"] == $route || $addedit || $extend) && $this->verifyParam($child)) {
									$return_menu_child["active"] = 1;
								}
							}
							if ($full) {
								$return_menu_child["url"] = webUrl($return_menu_child["route"], (!empty($return_menu_child["param"]) && is_array($return_menu_child["param"]) ? $return_menu_child["param"] : array()));
							}
							if (!empty($return_menu_child["permmust"]) && !$this->cv($return_menu_child["permmust"])) {
								continue;
							}
							if (!$this->cv($return_menu_child["route"]) && (empty($return_menu_child["perm"]) || !$this->cv($return_menu_child["perm"]))) {
								continue;
							}
							$return_submenu["items"][] = $return_menu_child;
							unset($return_submenu_default);
							unset($route_second);
						} else {
							$return_menu_child = array(
								"title" => $child["title"],
								"items" => array()
							);
							foreach ($child["items"] as $ii => $three) {
								if (!empty($three["isplugin"])) {
									if (!p($three["isplugin"])) {
										continue;
									}
									if (!empty($three["permplugin"]) && !p($three["permplugin"])) {
										continue;
									}
								} else {
									if (!empty($three["iscom"])) {
										if (!com($three["iscom"])) {
											continue;
										}
										if (!empty($three["permcom"]) && !com($three["permcom"])) {
											continue;
										}
									}
								}
								if ($this->merch && $three["hidemerch"]) {
									continue;
								}
								$return_submenu_default = $top . "";
								$route_second = "main";
								if (!empty($child["route"])) {
									$return_submenu_default = $top . "." . $child["route"];
									$route_second = $child["route"];
								}
								$return_submenu_three = array(
									"title" => $three["title"]
								);
								if (!empty($three["route"])) {
									if (!empty($child["route"])) {
										if (!empty($three["route_ns"])) {
											$return_submenu_three["route"] = $top . "." . $three["route"];
										} else {
											$return_submenu_three["route"] = $top . "." . $child["route"] . "." . $three["route"];
										}
									} else {
										if (!empty($three["top"])) {
											$return_submenu_three["route"] = $three["route"];
										} else {
											$return_submenu_three["route"] = $top . "." . $three["route"];
										}
										$route_second = $three["route"];
									}
								} else {
									$return_submenu_three["route"] = $return_submenu_default;
								}
								if (!empty($three["param"])) {
									$return_submenu_three["param"] = $three["param"];
								}
								if (!empty($three["perm"])) {
									$return_submenu_three["perm"] = $three["perm"];
								}
								if (!empty($three["permmust"])) {
									$return_submenu_three["permmust"] = $three["permmust"];
								}
								if ($routes[0] == "system") {
									$return_submenu_three["route"] = "system." . $return_submenu_three["route"];
								}
								$addedit = false;
								if (!$three["route_must"] && ($return_submenu_three["route"] . ".add" == $route || $return_submenu_three["route"] . ".edit" == $route)) {
									$addedit = true;
								}
								$extend = false;
								if (!empty($three["extend"])) {
									if ($three["extend"] . ".add" == $route || $three["extend"] . ".edit" == $route || $three["extend"] == $route) {
										$extend = true;
									}
								} else {
									if (!empty($three["extends"]) && is_array($three["extends"]) && (in_array($route, $three["extends"]) || in_array($route . ".add", $three["extends"]) || in_array($route . ".edit", $three["extends"]))) {
										$extend = true;
									}
								}
								if ($three["route_in"] && strexists($route, $return_submenu_three["route"])) {
									$return_menu_child["active"] = 1;
									$return_submenu_three["active"] = 1;
								} else {
									if (($return_submenu_three["route"] == $route || $addedit || $extend) && $this->verifyParam($three)) {
										$return_menu_child["active"] = 1;
										$return_submenu_three["active"] = 1;
									}
								}
								if (!empty($child["extend"])) {
									if ($child["extend"] == $route) {
										$return_menu_child["active"] = 1;
									}
								} else {
									if (is_array($child["extends"]) && in_array($route, $child["extends"])) {
										$return_menu_child["active"] = 1;
									}
								}
								if ($full) {
									$return_submenu_three["url"] = webUrl($return_submenu_three["route"], (!empty($return_submenu_three["param"]) && is_array($return_submenu_three["param"]) ? $return_submenu_three["param"] : array()));
								}
								if (!empty($return_submenu_three["permmust"]) && !$this->cv($return_submenu_three["permmust"])) {
									continue;
								}
								if (!$this->cv($return_submenu_three["route"]) && (empty($return_submenu_three["perm"]) || !$this->cv($return_submenu_three["perm"]))) {
									continue;
								}
								$return_menu_child["items"][] = $return_submenu_three;
							}
							if (!empty($child["items"]) && empty($return_menu_child["items"])) {
								continue;
							}
							$return_submenu["items"][] = $return_menu_child;
							unset($ii);
							unset($three);
							unset($route_second);
						}
					}
				}
			}
		}
		return array(
			"menu"     => $return_menu,
			"submenu"  => $return_submenu,
			"shopmenu" => $this->getShopMenu()
		);
	}

	public function getSubMenus($full = false, $plugin = false)
	{
		global $_W;
		$return_submenu = array();
		if (!$this->merch) {
			$systemMenu = $this->systemMenu();
			$allmenus = array_merge($this->shopMenu(), $systemMenu);
			if ($plugin) {
				$allmenus = array_merge($allmenus, $this->allPluginMenu());
			}
		} else {
			$allmenus = $this->pluginMenu("merch", "manage_menu");
		}
		if ($this->merch) {
			$iscredit = $_W["merch_user"]["iscredit"];
		}
		if (!empty($allmenus)) {
			foreach ($allmenus as $key => $item) {
				if (!$this->merch && is_array($systemMenu) && array_key_exists($key, $systemMenu)) {
					$key = "system." . $key;
				}
				if (empty($item["items"])) {
					$return_submenu_item = array(
						"title"       => $item["title"],
						"top"         => $key,
						"toptitle"    => $item["title"],
						"topsubtitle" => $item["subtitle"],
						"route"       => (empty($item["route"]) ? $key : $item["route"])
					);
					if (!empty($item["param"])) {
						$return_submenu_item = $item["param"];
					}
					if ($full) {
						$return_submenu_item["url"] = webUrl($return_submenu_item["route"], (!empty($return_submenu_item["param"]) && is_array($return_submenu_item["param"]) ? $return_submenu_item["param"] : array()));
					}
					$return_submenu[] = $return_submenu_item;
				} else {
					foreach ($item["items"] as $i => $child) {
						if (empty($child["items"])) {
							$return_submenu_default = $key;
							$return_submenu_route = $key . "." . $child["route"];
							$return_submenu_child = array(
								"title"       => $child["title"],
								"top"         => $key,
								"toptitle"    => $item["title"],
								"topsubtitle" => $item["subtitle"],
								"route"       => (empty($child["route"]) ? $return_submenu_default : $return_submenu_route)
							);
							if (!empty($child["desc"])) {
								$return_submenu_child["desc"] = $child["desc"];
							}
							if (!empty($child["keywords"])) {
								$return_submenu_child["keywords"] = $child["keywords"];
							}
							if (!empty($child["param"])) {
								$return_submenu_child["param"] = $child["param"];
							}
							if ($full) {
								$return_submenu_child["url"] = webUrl($return_submenu_child["route"], (!empty($return_submenu_child["param"]) && is_array($return_submenu_child["param"]) ? $return_submenu_child["param"] : array()));
							}
							$return_submenu[] = $return_submenu_child;
						} else {
							foreach ($child["items"] as $ii => $three) {
								$return_submenu_default = $key;
								if (!empty($child["route"])) {
									$return_submenu_default = $key . "." . $child["route"];
								}
								$return_submenu_three = array(
									"title"       => $three["title"],
									"top"         => $key,
									"topsubtitle" => $item["subtitle"]
								);
								if (!empty($three["desc"])) {
									$return_submenu_three["desc"] = $three["desc"];
								}
								if (!empty($three["keywords"])) {
									$return_submenu_three["keywords"] = $three["keywords"];
								}
								if (!empty($three["route"])) {
									if (!empty($child["route"])) {
										$return_submenu_three["route"] = $key . "." . $child["route"] . "." . $three["route"];
									} else {
										$return_submenu_three["route"] = $key . "." . $three["route"];
									}
								} else {
									$return_submenu_three["route"] = $return_submenu_default;
								}
								if (!empty($three["param"])) {
									$return_submenu_three["param"] = $three["param"];
								}
								if ($full) {
									$return_submenu_three["url"] = webUrl($return_submenu_three["route"], (!empty($return_submenu_three["param"]) && is_array($return_submenu_three["param"]) ? $return_submenu_three["param"] : array()));
								}
								$return_submenu[] = $return_submenu_three;
							}
							unset($return_submenu_default);
							unset($return_submenu_three);
						}
					}
					unset($return_submenu_default);
					unset($return_submenu_route);
					unset($return_submenu_child);
				}
			}
		}
		return $return_submenu;
	}

	public function getShopMenu()
	{
		$return_menu = array();
		if (!$this->merch) {
			$menus = $this->shopMenu();
		} else {
			$menus = $this->pluginMenu("merch", "manage_menu");
		}
		foreach ($menus as $key => $val) {
			$menu_item = array(
				"title" => $val["subtitle"],
				"items" => array()
			);
			if ($key == "diypage") {
				$menu_item["title"] = m("plugin")->getName("diypage");
			} else {
				if ($key == "app") {
					$menu_item["title"] = m("plugin")->getName("app");
				}
			}
			if (empty($val["items"])) {
				continue;
			}
			foreach ($val["items"] as $child) {
				if (!empty($child["isplugin"])) {
					if (!p($child["isplugin"])) {
						continue;
					}
					if (!empty($child["permplugin"]) && !com($child["permplugin"])) {
						continue;
					}
				} else {
					if (!empty($child["iscom"])) {
						if (!com($child["iscom"])) {
							continue;
						}
						if (!empty($child["permcom"]) && !com($child["permcom"])) {
							continue;
						}
					}
				}
				$child_route_default = $key;
				if (!empty($child["route"])) {
					$child_route_default = $key . "." . $child["route"];
					if (!empty($child["top"])) {
						$child_route_default = $child["route"];
					}
				}
				if (empty($child["items"])) {
					$menu_item_child = array(
						"title" => $child["title"],
						"route" => $child_route_default
					);
					if (!empty($child["param"])) {
					}
					$menu_item_child["url"] = webUrl($menu_item_child["route"], (!empty($menu_item_child["param"]) && is_array($menu_item_child["param"]) ? $menu_item_child["param"] : array()));
					$menu_item["items"][] = $menu_item_child;
				} else {
					foreach ($child["items"] as $three) {
						if (!empty($three["isplugin"])) {
							if (!p($three["isplugin"])) {
								continue;
							}
							if (!empty($three["permplugin"]) && !com($three["permplugin"])) {
								continue;
							}
						} else {
							if (!empty($three["iscom"])) {
								if (!com($three["iscom"])) {
									continue;
								}
								if (!empty($three["permcom"]) && !com($three["permcom"])) {
									continue;
								}
							}
						}
						$menu_item_three = array(
							"title" => $three["title"],
							"route" => (empty($three["route"]) ? $child_route_default : $child_route_default . "." . $three["route"])
						);
						if (!empty($three["param"])) {
						}
						$menu_item_three["url"] = webUrl($menu_item_three["route"], (!empty($menu_item_three["param"]) && is_array($menu_item_three["param"]) ? $menu_item_three["param"] : array()));
						$menu_item["items"][] = $menu_item_three;
					}
				}
			}
			$return_menu[] = $menu_item;
		}
		return $return_menu;
	}

	protected function shopMenu()
	{
		global $_W;
		if ($_W['user']['jobid'] == 0) {
			$shopmenu = array(
				"shop"   => array(
					"title"    => "店铺",
					"subtitle" => "店铺首页",
					"icon"     => "store",
					"items"    => array(
						array(
							"title" => "首页",
							"route" => "",
							"items" => array(
								array(
									"title" => "幻灯片 ",
									"route" => "adv",
									"desc"  => "店铺首页幻灯片管理"
								),
								array(
									"title" => "导航图标",
									"route" => "nav",
									"desc"  => "店铺首页导航图标管理"
								),
								array(
									"title" => "广告",
									"route" => "banner",
									"desc"  => "店铺首页广告管理"
								),
								array(
									"title" => "魔方推荐",
									"route" => "cube",
									"desc"  => "店铺首页魔方推荐管理"
								),
								array(
									"title" => "商品推荐",
									"route" => "recommand",
									"desc"  => "店铺首页商品推荐管理"
								),
								array(
									"title" => "排版设置",
									"route" => "sort",
									"desc"  => "店铺首页排版设置"
								)
							)
						),
						array(
							"title" => "商城",
							"items" => array(
								array(
									"title" => "公告管理",
									"route" => "notice",
									"desc"  => "店铺公告管理"
								),
								array(
									"title" => "评价管理",
									"route" => "comment",
									"desc"  => "店铺商品评价管理"
								),
								array(
									"title" => "退货地址",
									"route" => "refundaddress",
									"desc"  => "店铺退货地址管理"
								)
							)
						),

						array(
							"title" => "配送方式",
							"items" => array(
								array(
									"title" => "普通快递",
									"route" => "dispatch",
									"desc"  => "店铺普通快递管理"
								),
								array(
									"title" => "同城配送",
									"route" => "cityexpress",
									"desc"  => "店铺同城配送管理"
								)
							)
						),
						array(
							"title"    => m("plugin")->getName("diypage"),
							"isplugin" => "diypage",
							"route"    => "diypage",
							"top"      => true
						)
					)
				),
              	"store" => array(
                    "title" => "门店",
                    "subtitle" => "门店",
                    "icon" => "mendianguanli",
                    "items" => array(
                        array(
                            "title" => "门店管理",
                            "items" => array(
                                array(
                                    "title" => "门店管理",
                                    "route" => "",
                                    "extends" => array(
                                        "store.diypage.settings",
                                        "store.diypage.page",
                                        "store.goods",
                                        "store.goods.goodsoption"
                                    )
                                )
                            )
                        ),
                    )
                ),
				"goods"  => array(
					"title"    => "商品",
					"subtitle" => "商品管理",
					"icon"     => "goods",
					"items"    => array(
						array(
							"title"  => "出售中",
							"desc"   => "出售中商品管理",
							"extend" => "goods.sale",
							"perm"   => "goods.main"
						),
						array(
							"title" => "已售罄",
							"route" => "out",
							"desc"  => "已售罄/无库存商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "仓库中",
							"route" => "stock",
							"desc"  => "仓库中商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "回收站",
							"route" => "cycle",
							"desc"  => "回收站/已删除商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "导入记录",
							"route" => "record",
							"desc"  => "导入记录以及修改卖出记录",
							"perm"  => "goods.main"
						),
						array(
							"title" => "商品分类",
							"route" => "category"
						),
						array(
							"title" => "商品组",
							"route" => "group"
						),
						array(
							"title"  => "标签管理",
							"route"  => "label",
							"extend" => "goods.label.style"
						),
						array(
							"title" => "购物税管理",
							"route" => "tallage",
						),
//						array(
//							"title" => "运费管理",
//							"route" => "freight",
//						)
					)
				),
				"admins" => array(
					"title"    => "管理",
					"subtitle" => "管理员管理",
					"icon"     => "store",
					"items"    => array(
						array(
							"title"  => "管理员",
							"extend" => "admins.list",
							"perm"   => "amdins.main",
							"desc"   => "管理员管理"
						),
						array(
							"title" => "权限",
							"route" => "job",
							"desc"  => "权限管理"
						),
						array(
							"title" => "客服提成",
							"route" => "service",
							"desc"  => "客服提成设置"
						),
						array(
							"title" => "客服分红",
							"route" => "dividend",
							"desc"  => "客服分红"
						)
					)
				),
				"member" => array(
					"title"    => "会员",
					"subtitle" => "会员管理",
					"icon"     => "member",
					"items"    => array(
						array(
							"title"    => "会员列表",
							"route"    => "list",
							"route_in" => true
						),
						array(
							"title" => "会员等级",
							"route" => "level"
						),
						array(
							"title" => "代理规则",
							"route" => "levelRule"
						),
						array(
							"title" => "代理描述",
							"route" => "levelDetails"
						),
						array(
							"title" => "股东列表",
							"route" => "shareholder"
						),
						array(
							"title" => "股东申请列表",
							"route" => "shareholderApply"
						),
						array(
							"title" => "股东规则",
							"route" => "shareholderRule"
						),
						array(
							"title" => "股东描述",
							"route" => "shareholderDetails"
						),
						array(
							"title" => "会员提现",
							"route" => "withdraw"
						)
					)
				),
				"order"  => array(
					"title"    => "订单",
					"subtitle" => "订单管理",
					"icon"     => "order",
					"items"    => array(
						array(
							"title" => "待发货",
							"route" => "list.status1",
							"desc"  => "待发货订单管理"
						),
						array(
							"title" => "待收货",
							"route" => "list.status2",
							"desc"  => "待收货订单管理"
						),
						array(
							"title" => "待付款",
							"route" => "list.status0",
							"desc"  => "待付款订单管理"
						),
						array(
							"title" => "已完成",
							"route" => "list.status3",
							"desc"  => "已完成订单管理"
						),
						array(
							"title" => "已关闭",
							"route" => "list.status_1",
							"desc"  => "已关闭订单管理"
						),
						array(
							"title"    => "全部订单",
							"route"    => "list",
							"desc"     => "全部订单列表",
							"permmust" => "order.list.main"
						),
						array(
							"title" => "股东分红",
							"route" => "participation",
							"desc"  => "选择一个月交易进行分红",
						),
						array(
							"title" => "工具",
							"items" => array(
								array(
									"title" => "自定义导出",
									"route" => "export",
									"desc"  => "订单自定义导出"
								),
								array(
									"title" => "批量发货",
									"route" => "batchsend",
									"desc"  => "订单批量发货"
								)
							)
						)
					)
				),
				"finance"    => array(
					"title"    => "财务",
					"subtitle" => "财务管理",
					"icon"     => "31",
					"items"    => array(
						array(
							"title" => "财务",
							"route" => "log",
							"items" => array(
								array(
									"title" => "充值记录",
									"route" => "recharge"
								),
								array(
									"title" => "提现申请",
									"route" => "withdraw"
								)
							)
						),
						array(
							"title" => "明细",
							"route" => "credit",
							"items" => array(
								array(
									"title" => "积分明细",
									"route" => "credit1"
								),
								array(
									"title" => "余额明细",
									"route" => "credit2"
								)
							)
						),
						array(
							"title" => "对账单",
							"items" => array(
								array(
									"title" => "下载对账单",
									"route" => "downloadbill"
								)
							)
						)
					)
				),
				"statistics" => array(
					"title"    => "数据",
					"subtitle" => "数据统计",
					"icon"     => "statistics",
					"items"    => array(
						array(
							"title" => "销售统计",
							"items" => array(
								array(
									"title" => "销售统计",
									"route" => "sale"
								),
								array(
									"title" => "销售指标",
									"route" => "sale_analysis"
								),
								array(
									"title" => "订单统计",
									"route" => "order"
								)
							)
						),
						array(
							"title" => "商品统计",
							"items" => array(
								array(
									"title" => "销售明细",
									"route" => "goods"
								),
								array(
									"title" => "销售排行",
									"route" => "goods_rank"
								),
								array(
									"title" => "销售转化率",
									"route" => "goods_trans"
								)
							)
						),
						array(
							"title" => "会员统计",
							"items" => array(
								array(
									"title" => "消费排行",
									"route" => "member_cost"
								),
								array(
									"title" => "增长趋势",
									"route" => "member_increase"
								)
							)
						)
					)
				),
				"sysset"     => array(
					"title"    => "设置",
					"subtitle" => "商城设置",
					"icon"     => "sysset",
					"items"    => array(
						array(
							"title" => "商城",
							"items" => array(
								array(
									"title" => "基础设置",
									"route" => "shop"
								),
								array(
									"title" => "关注及分享",
									"route" => "follow"
								),
								array(
									"title" => "商城状态",
									"route" => "close"
								),
								array(
									"title" => "模板设置",
									"route" => "templat"
								),
								array(
									"title"   => "全网通设置",
									"route"   => "wap",
									"iscom"   => "wap",
									"permcom" => "sms"
								)
							)
						),
						array(
							"title" => "交易",
							"items" => array(
								array(
									"title" => "交易设置",
									"route" => "trade"
								),
								array(
									"title" => "支付设置",
									"route" => "payset"
								),
								array(
									"title" => "支付管理",
									"route" => "payment"
								)
							)
						),
						array(
							"title" => "短信配置",
							"route" => "sms",
							"iscom" => "sms",
							"items" => array(
								array(
									"title" => "短信消息库",
									"route" => "temp"
								),
								array(
									"title" => "短信接口设置",
									"route" => "set"
								)
							)
						),
                        array(
                            "title" => "小票打印机",
                            "route" => "printer",
                            "iscom" => "printer",
                            "items" => array(
                                array(
                                    "title" => "打印机管理",
                                    "route" => "printer_list",
                                    "extends" => array("sysset.printer.printer_add")
                                ),
                                array("title" => "打印机模板库"),
                                array("title" => "打印设置",
                                    "route" => "set"))),
						array(
							"title" => "其他",
							"items" => array(
								array(
									"title" => "会员设置",
									"route" => "member"
								),
								array(
									"title" => "分类层级",
									"route" => "category"
								),
								array(
									"title" => "联系方式",
									"route" => "contact"
								),
								array(
									"title" => "地址库设置",
									"route" => "area"
								),
								array(
									"title" => "物流信息接口",
									"route" => "express"
								)
							)
						),

						array(
							"title" => "入口",
							"route" => "cover",
							"items" => array(
								array(
									"title" => "商城入口",
									"route" => "shop"
								),
								array(
									"title" => "会员中心入口",
									"route" => "member"
								),
//                            array(
//                                "title" => "订单入口",
//                                "route" => "order"
//                            ) ,
//                            array(
//                                "title" => "收藏入口",
//                                "route" => "favorite"
//                            ) ,
//                            array(
//                                "title" => "购物车入口",
//                                "route" => "cart"
//                            ) ,
//                            array(
//                                "title" => "优惠券入口",
//                                "route" => "coupon"
//                            )
							)
						)
					)
				),
				"myinfo"     => array(
					"title"    => "我的",
					"subtitle" => "商城设置",
					"icon"     => "sysset",
				),
			);
		}
		if ($_W['user']['jobid'] == 3) {
			$shopmenu = array(
				"shop"   => array(
					"title"    => "店铺",
					"subtitle" => "店铺首页",
					"icon"     => "store",
					"items"    => array(
						array(
							"title" => "首页",
							"route" => "",
							"items" => array(
								array(
									"title" => "幻灯片 ",
									"route" => "adv",
									"desc"  => "店铺首页幻灯片管理"
								),
								array(
									"title" => "导航图标",
									"route" => "nav",
									"desc"  => "店铺首页导航图标管理"
								),
								array(
									"title" => "广告",
									"route" => "banner",
									"desc"  => "店铺首页广告管理"
								),
								array(
									"title" => "魔方推荐",
									"route" => "cube",
									"desc"  => "店铺首页魔方推荐管理"
								),
								array(
									"title" => "商品推荐",
									"route" => "recommand",
									"desc"  => "店铺首页商品推荐管理"
								),
								array(
									"title" => "排版设置",
									"route" => "sort",
									"desc"  => "店铺首页排版设置"
								)
							)
						),
						array(
							"title" => "商城",
							"items" => array(
								array(
									"title" => "公告管理",
									"route" => "notice",
									"desc"  => "店铺公告管理"
								),
								array(
									"title" => "评价管理",
									"route" => "comment",
									"desc"  => "店铺商品评价管理"
								),
								array(
									"title" => "退货地址",
									"route" => "refundaddress",
									"desc"  => "店铺退货地址管理"
								)
							)
						),

						array(
							"title" => "配送方式",
							"items" => array(
								array(
									"title" => "普通快递",
									"route" => "dispatch",
									"desc"  => "店铺普通快递管理"
								),
								array(
									"title" => "同城配送",
									"route" => "cityexpress",
									"desc"  => "店铺同城配送管理"
								)
							)
						),
						array(
							"title"    => m("plugin")->getName("diypage"),
							"isplugin" => "diypage",
							"route"    => "diypage",
							"top"      => true
						)
					)
				),
				"goods"  => array(
					"title"    => "商品",
					"subtitle" => "商品管理",
					"icon"     => "goods",
					"items"    => array(
						array(
							"title"  => "出售中",
							"desc"   => "出售中商品管理",
							"extend" => "goods.sale",
							"perm"   => "goods.main"
						),
						array(
							"title" => "已售罄",
							"route" => "out",
							"desc"  => "已售罄/无库存商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "仓库中",
							"route" => "stock",
							"desc"  => "仓库中商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "回收站",
							"route" => "cycle",
							"desc"  => "回收站/已删除商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "导入记录",
							"route" => "record",
							"desc"  => "导入记录以及修改卖出记录",
							"perm"  => "goods.main"
						),
						array(
							"title" => "商品分类",
							"route" => "category"
						),
						array(
							"title" => "商品组",
							"route" => "group"
						),
						array(
							"title"  => "标签管理",
							"route"  => "label",
							"extend" => "goods.label.style"
						),
						array(
							"title" => "购物税管理",
							"route" => "tallage",
						)
					)
				),
				"member" => array(
					"title"    => "会员",
					"subtitle" => "会员管理",
					"icon"     => "member",
					"items"    => array(
						array(
							"title"    => "会员列表",
							"route"    => "list",
							"route_in" => true
						),
						array(
							"title" => "会员等级",
							"route" => "level"
						),
						array(
							"title" => "代理规则",
							"route" => "levelRule"
						),
						array(
							"title" => "代理描述",
							"route" => "levelDetails"
						),
						array(
							"title" => "股东列表",
							"route" => "shareholder"
						),
						array(
							"title" => "股东规则",
							"route" => "shareholderRule"
						),
						array(
							"title" => "股东描述",
							"route" => "shareholderDetails"
						),
						array(
							"title" => "会员提现",
							"route" => "withdraw"
						)
					)
				),
				"order"  => array(
					"title"    => "订单",
					"subtitle" => "订单管理",
					"icon"     => "order",
					"items"    => array(
						array(
							"title" => "待发货",
							"route" => "list.status1",
							"desc"  => "待发货订单管理"
						),
						array(
							"title" => "待收货",
							"route" => "list.status2",
							"desc"  => "待收货订单管理"
						),
						array(
							"title" => "待付款",
							"route" => "list.status0",
							"desc"  => "待付款订单管理"
						),
						array(
							"title" => "已完成",
							"route" => "list.status3",
							"desc"  => "已完成订单管理"
						),
						array(
							"title" => "已关闭",
							"route" => "list.status_1",
							"desc"  => "已关闭订单管理"
						),
						array(
							"title"    => "全部订单",
							"route"    => "list",
							"desc"     => "全部订单列表",
							"permmust" => "order.list.main"
						),
						array(
							"title" => "股东分红",
							"route" => "participation",
							"desc"  => "选择一个月交易进行分红",
						),
						array(
							"title" => "工具",
							"items" => array(
								array(
									"title" => "自定义导出",
									"route" => "export",
									"desc"  => "订单自定义导出"
								),
								array(
									"title" => "批量发货",
									"route" => "batchsend",
									"desc"  => "订单批量发货"
								)
							)
						)
					)
				),
			);
		}
		if ($_W['user']['jobid'] == 4) {
			$shopmenu = array(
				"shop"   => array(
					"title"    => "店铺",
					"subtitle" => "店铺首页",
					"icon"     => "store",
					"items"    => array(
						array(
							"title" => "首页",
							"route" => "",
							"items" => array(
								array(
									"title" => "幻灯片 ",
									"route" => "adv",
									"desc"  => "店铺首页幻灯片管理"
								),
								array(
									"title" => "导航图标",
									"route" => "nav",
									"desc"  => "店铺首页导航图标管理"
								),
								array(
									"title" => "广告",
									"route" => "banner",
									"desc"  => "店铺首页广告管理"
								),
								array(
									"title" => "魔方推荐",
									"route" => "cube",
									"desc"  => "店铺首页魔方推荐管理"
								),
								array(
									"title" => "商品推荐",
									"route" => "recommand",
									"desc"  => "店铺首页商品推荐管理"
								),
								array(
									"title" => "排版设置",
									"route" => "sort",
									"desc"  => "店铺首页排版设置"
								)
							)
						),
						array(
							"title" => "商城",
							"items" => array(
								array(
									"title" => "公告管理",
									"route" => "notice",
									"desc"  => "店铺公告管理"
								),
								array(
									"title" => "评价管理",
									"route" => "comment",
									"desc"  => "店铺商品评价管理"
								),
								array(
									"title" => "退货地址",
									"route" => "refundaddress",
									"desc"  => "店铺退货地址管理"
								)
							)
						),

						array(
							"title" => "配送方式",
							"items" => array(
								array(
									"title" => "普通快递",
									"route" => "dispatch",
									"desc"  => "店铺普通快递管理"
								),
								array(
									"title" => "同城配送",
									"route" => "cityexpress",
									"desc"  => "店铺同城配送管理"
								)
							)
						),
						array(
							"title"    => m("plugin")->getName("diypage"),
							"isplugin" => "diypage",
							"route"    => "diypage",
							"top"      => true
						)
					)
				),
				"goods"  => array(
					"title"    => "商品",
					"subtitle" => "商品管理",
					"icon"     => "goods",
					"items"    => array(
						array(
							"title"  => "出售中",
							"desc"   => "出售中商品管理",
							"extend" => "goods.sale",
							"perm"   => "goods.main"
						),
						array(
							"title" => "已售罄",
							"route" => "out",
							"desc"  => "已售罄/无库存商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "仓库中",
							"route" => "stock",
							"desc"  => "仓库中商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "回收站",
							"route" => "cycle",
							"desc"  => "回收站/已删除商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "导入记录",
							"route" => "record",
							"desc"  => "导入记录以及修改卖出记录",
							"perm"  => "goods.main"
						),
						array(
							"title" => "商品分类",
							"route" => "category"
						),
						array(
							"title" => "商品组",
							"route" => "group"
						),
						array(
							"title"  => "标签管理",
							"route"  => "label",
							"extend" => "goods.label.style"
						),
						array(
							"title" => "购物税管理",
							"route" => "tallage",
						)
					)
				),
				"member" => array(
					"title"    => "会员",
					"subtitle" => "会员管理",
					"icon"     => "member",
					"items"    => array(
						array(
							"title"    => "会员列表",
							"route"    => "list",
							"route_in" => true
						),
						array(
							"title" => "会员等级",
							"route" => "level"
						),
						array(
							"title" => "代理规则",
							"route" => "levelRule"
						),
						array(
							"title" => "代理描述",
							"route" => "levelDetails"
						),
						array(
							"title" => "股东列表",
							"route" => "shareholder"
						),
						array(
							"title" => "股东规则",
							"route" => "shareholderRule"
						),
						array(
							"title" => "股东描述",
							"route" => "shareholderDetails"
						),
						array(
							"title" => "会员提现",
							"route" => "withdraw"
						)
					)
				),
				"admins" => array(
					"title"    => "管理",
					"subtitle" => "管理员管理",
					"icon"     => "store",
					"items"    => array(
						array(
							"title"  => "管理员",
							"extend" => "admins.list",
							"perm"   => "amdins.main",
							"desc"   => "管理员管理"
						),
						array(
							"title" => "权限",
							"route" => "job",
							"desc"  => "权限管理"
						),
						array(
							"title" => "客服提成",
							"route" => "service",
							"desc"  => "客服提成设置"
						)
					)
				),
				"order"  => array(
					"title"    => "订单",
					"subtitle" => "订单管理",
					"icon"     => "order",
					"items"    => array(
						array(
							"title" => "待发货",
							"route" => "list.status1",
							"desc"  => "待发货订单管理"
						),
						array(
							"title" => "待收货",
							"route" => "list.status2",
							"desc"  => "待收货订单管理"
						),
						array(
							"title" => "待付款",
							"route" => "list.status0",
							"desc"  => "待付款订单管理"
						),
						array(
							"title" => "已完成",
							"route" => "list.status3",
							"desc"  => "已完成订单管理"
						),
						array(
							"title" => "已关闭",
							"route" => "list.status_1",
							"desc"  => "已关闭订单管理"
						),
						array(
							"title"    => "全部订单",
							"route"    => "list",
							"desc"     => "全部订单列表",
							"permmust" => "order.list.main"
						),
						array(
							"title" => "股东分红",
							"route" => "participation",
							"desc"  => "选择一个月交易进行分红",
						),
						array(
							"title" => "工具",
							"items" => array(
								array(
									"title" => "自定义导出",
									"route" => "export",
									"desc"  => "订单自定义导出"
								),
								array(
									"title" => "批量发货",
									"route" => "batchsend",
									"desc"  => "订单批量发货"
								)
							)
						)
					)
				),
			);
		}
		if ($_W['user']['jobid'] == 5) {
			$shopmenu = array(
				"shop"   => array(
					"title"    => "店铺",
					"subtitle" => "店铺首页",
					"icon"     => "store",
					"items"    => array(
						array(
							"title" => "首页",
							"route" => "",
							"items" => array(
								array(
									"title" => "幻灯片 ",
									"route" => "adv",
									"desc"  => "店铺首页幻灯片管理"
								),
								array(
									"title" => "导航图标",
									"route" => "nav",
									"desc"  => "店铺首页导航图标管理"
								),
								array(
									"title" => "广告",
									"route" => "banner",
									"desc"  => "店铺首页广告管理"
								),
								array(
									"title" => "魔方推荐",
									"route" => "cube",
									"desc"  => "店铺首页魔方推荐管理"
								),
								array(
									"title" => "商品推荐",
									"route" => "recommand",
									"desc"  => "店铺首页商品推荐管理"
								),
								array(
									"title" => "排版设置",
									"route" => "sort",
									"desc"  => "店铺首页排版设置"
								)
							)
						),
						array(
							"title" => "商城",
							"items" => array(
								array(
									"title" => "公告管理",
									"route" => "notice",
									"desc"  => "店铺公告管理"
								),
								array(
									"title" => "评价管理",
									"route" => "comment",
									"desc"  => "店铺商品评价管理"
								),
								array(
									"title" => "退货地址",
									"route" => "refundaddress",
									"desc"  => "店铺退货地址管理"
								)
							)
						),

						array(
							"title" => "配送方式",
							"items" => array(
								array(
									"title" => "普通快递",
									"route" => "dispatch",
									"desc"  => "店铺普通快递管理"
								),
								array(
									"title" => "同城配送",
									"route" => "cityexpress",
									"desc"  => "店铺同城配送管理"
								)
							)
						),
						array(
							"title"    => m("plugin")->getName("diypage"),
							"isplugin" => "diypage",
							"route"    => "diypage",
							"top"      => true
						)
					)
				),
				"goods"  => array(
					"title"    => "商品",
					"subtitle" => "商品管理",
					"icon"     => "goods",
					"items"    => array(
						array(
							"title"  => "出售中",
							"desc"   => "出售中商品管理",
							"extend" => "goods.sale",
							"perm"   => "goods.main"
						),
						array(
							"title" => "已售罄",
							"route" => "out",
							"desc"  => "已售罄/无库存商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "仓库中",
							"route" => "stock",
							"desc"  => "仓库中商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "回收站",
							"route" => "cycle",
							"desc"  => "回收站/已删除商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "导入记录",
							"route" => "record",
							"desc"  => "导入记录以及修改卖出记录",
							"perm"  => "goods.main"
						),
						array(
							"title" => "商品分类",
							"route" => "category"
						),
						array(
							"title" => "商品组",
							"route" => "group"
						),
						array(
							"title"  => "标签管理",
							"route"  => "label",
							"extend" => "goods.label.style"
						),
						array(
							"title" => "购物税管理",
							"route" => "tallage",
						)
					)
				),
				"member" => array(
					"title"    => "会员",
					"subtitle" => "会员管理",
					"icon"     => "member",
					"items"    => array(
						array(
							"title"    => "会员列表",
							"route"    => "list",
							"route_in" => true
						),
						array(
							"title" => "会员等级",
							"route" => "level"
						),
						array(
							"title" => "代理规则",
							"route" => "levelRule"
						),
						array(
							"title" => "代理描述",
							"route" => "levelDetails"
						),
						array(
							"title" => "股东列表",
							"route" => "shareholder"
						),
						array(
							"title" => "股东规则",
							"route" => "shareholderRule"
						),
						array(
							"title" => "股东描述",
							"route" => "shareholderDetails"
						),
						array(
							"title" => "会员提现",
							"route" => "withdraw"
						)
					)
				),
				"order"  => array(
					"title"    => "订单",
					"subtitle" => "订单管理",
					"icon"     => "order",
					"items"    => array(
						array(
							"title" => "待发货",
							"route" => "list.status1",
							"desc"  => "待发货订单管理"
						),
						array(
							"title" => "待收货",
							"route" => "list.status2",
							"desc"  => "待收货订单管理"
						),
						array(
							"title" => "待付款",
							"route" => "list.status0",
							"desc"  => "待付款订单管理"
						),
						array(
							"title" => "已完成",
							"route" => "list.status3",
							"desc"  => "已完成订单管理"
						),
						array(
							"title" => "已关闭",
							"route" => "list.status_1",
							"desc"  => "已关闭订单管理"
						),
						array(
							"title"    => "全部订单",
							"route"    => "list",
							"desc"     => "全部订单列表",
							"permmust" => "order.list.main"
						),
						array(
							"title" => "股东分红",
							"route" => "participation",
							"desc"  => "选择一个月交易进行分红",
						),
						array(
							"title" => "工具",
							"items" => array(
								array(
									"title" => "自定义导出",
									"route" => "export",
									"desc"  => "订单自定义导出"
								),
								array(
									"title" => "批量发货",
									"route" => "batchsend",
									"desc"  => "订单批量发货"
								)
							)
						)
					)
				),
			);
		}
		if ($_W['user']['jobid'] == 6) {
			$shopmenu = array(
				"goods"  => array(
					"title"    => "商品",
					"subtitle" => "商品管理",
					"icon"     => "goods",
					"items"    => array(
						array(
							"title"  => "出售中",
							"desc"   => "出售中商品管理",
							"extend" => "goods.sale",
							"perm"   => "goods.main"
						),
						array(
							"title" => "已售罄",
							"route" => "out",
							"desc"  => "已售罄/无库存商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "仓库中",
							"route" => "stock",
							"desc"  => "仓库中商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "回收站",
							"route" => "cycle",
							"desc"  => "回收站/已删除商品管理",
							"perm"  => "goods.main"
						),
						array(
							"title" => "导入记录",
							"route" => "record",
							"desc"  => "导入记录以及修改卖出记录",
							"perm"  => "goods.main"
						),
						array(
							"title" => "商品分类",
							"route" => "category"
						),
						array(
							"title" => "商品组",
							"route" => "group"
						),
						array(
							"title"  => "标签管理",
							"route"  => "label",
							"extend" => "goods.label.style"
						),
						array(
							"title" => "购物税管理",
							"route" => "tallage",
						)
					)
				),
				"order"  => array(
					"title"    => "订单",
					"subtitle" => "订单管理",
					"icon"     => "order",
					"items"    => array(
						array(
							"title" => "待发货",
							"route" => "list.status1",
							"desc"  => "待发货订单管理"
						),
						array(
							"title" => "待收货",
							"route" => "list.status2",
							"desc"  => "待收货订单管理"
						),
						array(
							"title" => "待付款",
							"route" => "list.status0",
							"desc"  => "待付款订单管理"
						),
						array(
							"title" => "已完成",
							"route" => "list.status3",
							"desc"  => "已完成订单管理"
						),
						array(
							"title" => "已关闭",
							"route" => "list.status_1",
							"desc"  => "已关闭订单管理"
						),
						array(
							"title"    => "全部订单",
							"route"    => "list",
							"desc"     => "全部订单列表",
							"permmust" => "order.list.main"
						),
						array(
							"title" => "股东分红",
							"route" => "participation",
							"desc"  => "选择一个月交易进行分红",
						),
						array(
							"title" => "工具",
							"items" => array(
								array(
									"title" => "自定义导出",
									"route" => "export",
									"desc"  => "订单自定义导出"
								),
								array(
									"title" => "批量发货",
									"route" => "batchsend",
									"desc"  => "订单批量发货"
								)
							)
						)
					)
				),
			);
		}
		if (!p("app")) {
			unset($shopmenu["app"]);
		}
		if (!function_exists("redis") || is_error(redis())) {
			if (isset($shopmenu["sale"]["items"][0]["items"])) {
				foreach ($shopmenu["sale"]["items"][0]["items"] as $key => & $item) {
					if ($item["route"] == "deduct") {
						unset($shopmenu["sale"]["items"][0]["items"][$key]);
					}
				}
				unset($item);
			}
			if (isset($shopmenu["sysset"]["items"][2]["items"])) {
				foreach ($shopmenu["sysset"]["items"][2]["items"] as $key => & $item) {
					if ($item["route"] == "notice_redis") {
						unset($shopmenu["sysset"]["items"][2]["items"][$key]);
					}
				}
				unset($item);
			}
		}
		return $shopmenu;
	}

	protected function systemMenu()
	{
		return array(
			"plugin"    => array(
				"title"    => "应用",
				"subtitle" => "应用管理",
				"icon"     => "plugins",
				"items"    => array(
					array(
						"title" => "应用信息"
					),
					array(
						"title" => "组件信息",
						"route" => "coms"
					),
					array(
						"title" => "公众号权限",
						"route" => "perm"
					),
					array(
						"title"    => "站点小程序",
						"route"    => "wxapp",
						"route"    => "wxapp",
						"isplugin" => "app"
					),
					array(
						'title'    => '商家管理程序',
						'route'    => 'release1',
						'route'    => 'release1',
						'isplugin' => 'app'
					),
					array(
						"title"    => "应用授权管理",
						"isplugin" => "grant",
						"items"    => array(
							array(
								"title" => "幻灯片管理",
								"route" => "pluginadv"
							),
							array(
								"title" => "授权应用管理",
								"route" => "pluginmanage"
							),
							array(
								"title" => "授权套餐管理",
								"route" => "pluginpackage"
							),
							array(
								"title" => "销售记录",
								"route" => "pluginsale"
							),
							array(
								"title" => "系统授权管理",
								"route" => "plugingrant"
							),
							array(
								"title" => "授权管理设置",
								"route" => "pluginsetting"
							)
						)
					)
				)
			),
			"copyright" => array(
				"title"    => "版权",
				"subtitle" => "版权设置",
				"icon"     => "banquan",
				"items"    => array(
					array(
						"title" => "手机端"
					),
					array(
						"title" => "管理端",
						"route" => "manage"
					),
					array(
						"title" => "公告管理",
						"items" => array(
							array(
								"title" => "公告管理",
								"route" => "notice"
							)
						)
					)
				)
			),
			"data"      => array(
				"title"    => "数据",
				"subtitle" => "数据管理",
				"icon"     => "statistics",
				"items"    => array(
					array(
						"title" => "数据清理"
					),
					array(
						"title" => "数据转移",
						"route" => "transfer"
					),
					array(
						"title" => "计划任务",
						"items" => array(
							array(
								"title" => "计划任务",
								"route" => "task"
							)
						)
					),
					array(
						"title" => "工具",
						"items" => array(
							array(
								"title" => "七牛存储",
								"route" => "qiniu"
							)
						)
					)
				)
			),
			"site"      => array(
				"title"    => "网站",
				"subtitle" => "网站设置",
				"icon"     => "wangzhan",
				"items"    => array(
					array(
						"title" => "网站",
						"items" => array(
							array(
								"title" => "基本设置"
							),
							array(
								"title" => "幻灯片",
								"route" => "banner"
							),
							array(
								"title" => "案例分类",
								"route" => "casecategory"
							),
							array(
								"title" => "案例",
								"route" => "case"
							),
							array(
								"title" => "友情链接",
								"route" => "link"
							)
						)
					),
					array(
						"title" => "文章",
						"items" => array(
							array(
								"title" => "文章分类",
								"route" => "category"
							),
							array(
								"title" => "文章管理",
								"route" => "article"
							)
						)
					),
					array(
						"title" => "内容",
						"items" => array(
							array(
								"title" => "内容分类",
								"route" => "companycategory"
							),
							array(
								"title" => "内容管理",
								"route" => "companyarticle"
							)
						)
					),
					array(
						"title" => "留言板",
						"items" => array(
							array(
								"title" => "留言内容",
								"route" => "guestbook"
							)
						)
					),
					array(
						"title" => "设置",
						"items" => array(
							array(
								"title" => "基础设置",
								"route" => "setting"
							)
						)
					)
				)
			),
			"auth"      => array(
				"title"    => "授权",
				"subtitle" => "授权管理",
				"icon"     => "iconfont-shouquan",
				"items"    => array(
					array(
						"title" => "授权管理"
					),
					array(
						"title" => "系统更新",
						"route" => "upgrade"
					),

				)
			)
		);
	}

	protected function otherMenu()
	{
		return array(
			"perm" => array(
				"title"    => "权限",
				"subtitle" => "权限系统",
				"icon"     => "store",
				"items"    => array(
					array(
						"title" => "角色管理",
						"route" => "role"
					),
					array(
						"title" => "操作员管理",
						"route" => "user"
					),
					array(
						"title" => "操作日志",
						"route" => "log"
					)
				)
			)
		);
	}

	protected function pluginMenu($plugin = array(), $key = "menu")
	{
		global $_W;
		if (empty($plugin)) {
			return array();
		}
		$config = m("plugin")->getConfig($plugin);
		if (p("merch")) {
			$params = array(
				":uniacid" => $_W["uniacid"],
				":merchid" => $_W["merchid"]
			);
			$_condition = "and uniacid=:uniacid and id=:merchid";
			$_sql = "select iscredit from" . tablename("ewei_shop_merch_user") . "where 1 " . $_condition;
			$iscredit = pdo_fetch($_sql, $params);
			$iscredit = $iscredit["iscredit"];
			if ($iscredit == 1) {
				unset($config["manage_menu"]["apply"]["items"][1]);
			}
		}
		return (empty($config[$key]) ? array() : $config[$key]);
	}

	protected function allPluginMenu()
	{
		return array();
	}

	protected function verifyParam($item = array())
	{
		global $_GPC;
		if (empty($item["param"])) {
			return true;
		}
		$return = true;
		foreach ($item["param"] as $k => $v) {
			if ($_GPC[$k] != $v) {
				$return = false;
				break;
			}
		}
		return $return;
	}

	protected function initRightMenu($routes)
	{
		global $_W;
		$return_arr = array(
			"system"     => 0,
			"menu_title" => "",
			"menu_items" => array(),
			"logout"     => ""
		);
		if ($this->merch) {
			$return_arr["menu_title"] = $_W["merch_username"] . "//" . $_W["uniaccount"]["username"];
			$return_arr["menu_items"][] = array(
				"text" => "修改密码",
				"href" => merchUrl("updatepassword")
			);
			$return_arr["logout"] = merchUrl("quit");
		} else {
			$return_arr["menu_title"] = $_W["uniaccount"]["name"];
			if ($_W["role"] == "founder" && $routes[0] != "system") {
				$return_arr["system"] = 1;
			}
			if ($routes[0] == "system") {
				$return_arr["menu_items"][] = array(
					"text" => "返回商城",
					"href" => webUrl(),
					"icow" => "icow-qiehuan"
				);
			} else {
				$return_arr["menu_items"][] = array(
					"text" => "切换公众号",
					"href" => webUrl("sysset/account"),
					"icow" => "icow-qiehuan"
				);
				if ($_W["role"] == "manager" || $_W["role"] == "founder") {
					$return_arr["menu_items"][] = array(
						"text"  => "编辑公众号",
						"href"  => "./index.php?c=account&a=post&uniacid=" . $_W["uniacid"] . "&acid=" . $_W["acid"],
						"blank" => "true",
						"icow"  => "icow-bianji5"
					);
					$return_arr["menu_items"][] = array(
						"text" => "支付方式",
						"href" => webUrl("sysset/payset"),
						"icow" => "icow-zhifu"
					);
				}
				$permset = intval(m("cache")->getString("permset", "global"));
				if (com("perm") && cv("perm")) {
					$return_arr["menu_items"][] = "line";
					$return_arr["menu_items"][] = array(
						"text" => "权限管理",
						"href" => webUrl("perm"),
						"icow" => "icow-quanxian"
					);
				}
				if (p("grant")) {
					$return_arr["menu_items"][] = "line";
					$return_arr["menu_items"][] = array(
						"text" => "应用授权",
						"href" => webUrl("system/plugin/plugingrant"),
						"icow" => "icow-shouquan"
					);
				}
				if ($_W["isfounder"] && $_W["role"] != "vice_founder") {
				}
				$return_arr["menu_items"][] = array(
					"text"  => "修改密码",
					"href"  => "./index.php?c=user&a=profile&",
					"blank" => true,
					"icow"  => "icow-quanxian1"
				);
			}
			$return_arr["logout"] = "./index.php?c=user&a=logout&";
		}
		return $return_arr;
	}

	public function init()
	{
		global $_W;
		global $_GPC;
		$routes = explode(".", $GLOBALS["_W"]["routes"]);
		$arr = array(
			"merch"       => ($this->merch ? 1 : 0),
			"order1"      => 0,
			"order2"	  =>0,
			"order0"	  =>0,
			"order4"      => 0,
			"notice"      => array(),
			"commission1" => 0,
			"commission2" => 0,
			"comment"     => 0,
			"foldnav"     => intval($_COOKIE["foldnav"]),
			"foldpanel"   => intval($_COOKIE["foldpanel"]),
			"routes"      => $routes,
			"funbar"      => array(
				"open" => intval($_W["shopset"]["shop"]["funbar"])
			),
			"right_menu"  => $this->initRightMenu($routes)
		);
		if ($this->cv("order.list.status1")) {
			$arr["order1"] = $this->getOrderTotal(1);
		}
		if ($this->cv("order.list.status2")) {
			$arr["order2"] = $this->getOrderTotal(2);
		}
		if ($this->cv("order.list.status0")) {
			$arr["order0"] = $this->getOrderTotal(0);
		}
		if ($this->cv("order.list.status4")) {
			$arr["order4"] = $this->getOrderTotal(4);
		}
		if (!$this->merch) {
			$arr["notice"] = pdo_fetchall("SELECT * FROM " . tablename("ewei_shop_system_copyright_notice") . " ORDER BY displayorder DESC,createtime DESC LIMIT 5");
			if (p("commission")) {
				if ($this->cv("commission.apply.view1")) {
					$arr["commission1"] = pdo_fetchcolumn("select count(1) from" . tablename("ewei_shop_commission_apply") . " a " . " left join " . tablename("ewei_shop_member") . " m on m.uid = a.mid" . " left join " . tablename("ewei_shop_commission_level") . " l on l.id = m.agentlevel" . " where a.uniacid=:uniacid and a.status=:status", array(
						":uniacid" => $_W["uniacid"],
						":status"  => 1
					));
				}
				if ($this->cv("commission.apply.view2")) {
					$arr["commission2"] = pdo_fetchcolumn("select count(1) from" . tablename("ewei_shop_commission_apply") . " a " . " left join " . tablename("ewei_shop_member") . " m on m.uid = a.mid" . " left join " . tablename("ewei_shop_commission_level") . " l on l.id = m.agentlevel" . " where a.uniacid=:uniacid and a.status=:status", array(
						":uniacid" => $_W["uniacid"],
						":status"  => 2
					));
				}
			}
			if ($this->cv("shop.comment")) {
				$arr["comment"] = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename("ewei_shop_order_comment") . "c LEFT JOIN " . tablename("ewei_shop_goods") . " g ON g.id=c.goodsid WHERE (c.checked=1 OR c.replychecked=1) AND c.deleted=0 AND c.uniacid=:uniacid AND g.merchid=:merchid", array(
					":uniacid" => $_W["uniacid"],
					":merchid" => 0
				));
			}
		} else {
			$arr["notice"] = "none";
			if ($this->cv("shop.comment")) {
				$arr["comment"] = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename("ewei_shop_order_comment") . "c LEFT JOIN " . tablename("ewei_shop_goods") . " g ON g.id=c.goodsid WHERE (c.checked=1 OR c.replychecked=1) AND c.deleted=0 AND c.uniacid=:uniacid AND g.merchid=:merchid", array(
					":uniacid" => $_W["uniacid"],
					":merchid" => $_W["merchid"]
				));
			}
		}
		if (!empty($arr["funbar"]["open"])) {
			$funbardata = pdo_fetch("select * from " . tablename("ewei_shop_funbar") . " where uid=:uid and uniacid=:uniacid limit 1", array(
				":uid"     => $_W["uid"],
				":uniacid" => $_W["uniacid"]
			));
			if (!empty($funbardata["datas"]) && !is_array($funbardata["datas"])) {
				if (strexists($funbardata["datas"], "{\"")) {
					$funbardata["datas"] = json_decode($funbardata["datas"], true);
				} else {
					$funbardata["datas"] = unserialize($funbardata["datas"]);
				}
			}
			$arr["funbar"]["data"] = $funbardata["datas"];
		}
		$arr["url"] = str_replace($_W["siteroot"] . "web/", "./", $_W["siteurl"]);
		if (!$this->merch) {
			$history_url = htmlspecialchars_decode($_GPC["history_url"]);
		} else {
			$history_url = htmlspecialchars_decode($_GPC["merch_history_url"]);
		}
		if (!empty($history_url)) {
			$arr["history"] = json_decode($history_url, true);
		}
		return $arr;
	}

	protected function getOrderTotal($status = 0)
	{
		global $_W;
		$total = 0;
		if ($status == 1) {
			$condition = "uniacid = :uniacid and isparent=0 and ismr=0 and ( status=1 or ( status=0 and paytype=3) ) and deleted=0";
			$params = array(
				":uniacid" => $_W["uniacid"]
			);
			if ($this->merch) {
				$condition .= " and merchid=:merchid";
				$params[":merchid"] = intval($_W["merchid"]);
			}
			$total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename("ewei_shop_order") . " WHERE " . $condition, $params);
		}elseif($status == 2){
			$condition = "uniacid = :uniacid and isparent=0 and ismr=0 and  status=2 and deleted=0";
			$params = array(
				":uniacid" => $_W["uniacid"]
			);
			if ($this->merch) {
				$condition .= " and merchid=:merchid";
				$params[":merchid"] = intval($_W["merchid"]);
			}
			$total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename("ewei_shop_order") . " WHERE " . $condition, $params);
		}elseif($status == 0){
			$condition = "uniacid = :uniacid and isparent=0 and ismr=0 and  status=0 and deleted=0";
			$params = array(
				":uniacid" => $_W["uniacid"]
			);
			if ($this->merch) {
				$condition .= " and merchid=:merchid";
				$params[":merchid"] = intval($_W["merchid"]);
			}
			$total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename("ewei_shop_order") . " WHERE " . $condition, $params);
		}else {
			if ($status == 4) {
				$condition = "uniacid = :uniacid and isparent=0 and ismr=0 and refundstate>0 and refundid<>0 and deleted=0";
				$params = array(
					":uniacid" => $_W["uniacid"]
				);
				if ($this->merch) {
					$condition .= " and merchid=:merchid";
					$params[":merchid"] = intval($_W["merchid"]);
				}
				$total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename("ewei_shop_order") . " WHERE " . $condition, $params);
			}
		}
		return $total;
	}

	public function cv($str)
	{
		if ($str == "plugins") {
			$str = $this->isOpenPlugin();
		}
		if ($this->merch) {
			return mcv($str);
		}
		return cv($str);
	}

	public function isOpenPlugin()
	{
		if (!com("perm")) {
			return array();
		}
		$name = com_run("perm::allPerms");
		unset($name["shop"]);
		unset($name["goods"]);
		unset($name["member"]);
		unset($name["order"]);
		unset($name["finance"]);
		unset($name["statistics"]);
		unset($name["sysset"]);
		unset($name["sale"]);
		$name_keys = array_keys($name);
		return implode("|", $name_keys);
	}

	public function history_url()
	{
		global $_W;
		global $_GPC;
		if (!$this->merch) {
			$history_url = $_GPC["history_url"];
		} else {
			$history_url = $_GPC["merch_history_url"];
		}
		if (empty($history_url)) {
			$history_url = array();
		} else {
			$history_url = htmlspecialchars_decode($history_url);
			$history_url = json_decode($history_url, true);
		}
		if (!empty($history_url)) {
			$this_url = str_replace($_W["siteroot"] . "web/", "./", $_W["siteurl"]);
			foreach ($history_url as $index => $history_url_item) {
				$item_url = str_replace($_W["siteroot"] . "web/", "./", $history_url_item["url"]);
				if ($item_url == $this_url) {
					unset($history_url[$index]);
				}
			}
		}
		$submenu = $this->getSubMenus(true);
		$thispage = array();
		if (!empty($submenu)) {
			foreach ($submenu as $submenu_item) {
				if ($_GPC["r"] == $submenu_item["route"] && $this->verifyParam($submenu_item)) {
					$submenu_item["url"] = str_replace($_W["siteroot"] . "web/", "./", $submenu_item["url"]);
					$thispage = $submenu_item;
					if (!empty($submenu_item["toptitle"])) {
						$thispage["title"] = $submenu_item["toptitle"] . "-" . $submenu_item["title"];
					}
					break;
				}
			}
		}
		if ($thispage) {
			$thispage_item = array(
				array(
					"title" => $thispage["title"],
					"url"   => $thispage["url"]
				)
			);
			$history_url = array_merge($thispage_item, $history_url);
			if (10 < count($history_url)) {
				$history_url = array_slice($history_url, 0, 10);
			}
			isetcookie((!$this->merch ? "history_url" : "merch_history_url"), json_encode($history_url), 7 * 86400);
		}
	}

	public function set_version($type = 0)
	{
		$GLOBALS["_W"]["shopversion"] = 1;
	}
}

?>
