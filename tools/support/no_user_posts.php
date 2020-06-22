<?php

$s_product = 'category';

if (!str_replace('.' . $phpEx, '', $user->page['page_name']))
{
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include($phpbb_root_path . 'common.' . $phpEx);

	// Start session management
	$user->session_begin();
	$user->setup();
	$s_product = $url_params = false;
	$limit = request_var('n', 8);
	$start = request_var('start', 0);
	$filter = request_var('f', 'id');
	$url = false;
}

include($phpbb_root_path . 'includes/functions_category.' . $phpEx);

$id = request_var('id', 0);
$current_page = 0;

if (!$id && $config['enable_modrewrite'])
{
	$url_params = explode('/', $page_url);
	if($url_params[count($url_params) - 1] == '')
	{
		unset($url_params[count($url_params)-1]);
	}

	if (isset($url_params[2]))
	{
		$params = explode('?', $url_params[2]);
		$current_page = preg_replace("/[^0-9]/", '', $params[0]);
		$url = $params[0];
	}
	if (isset($url_params[1]))
	{
		$params = explode('?', $url_params[1]);
		$url = $params[0];
	}

	$sql = 'SELECT DISTINCT c.category_id, cl.category_id
		FROM ' . CATEGORY_TABLE . ' c, ' . CATEGORY_LANG_TABLE . ' cl
		WHERE cl.category_id = c.category_id AND cl.link_rewrite = \'' . $url . '\'';
	$start = ($current_page - 1) * $limit;
	if ($start < 0 || $showall)
	{
		$start = 0;
	}
	$paths = './';
	for($i = 0; $i < (sizeof($url_params) - 1); $i++)
	{
		$paths .= '../';
	}
}
else
{
	$sql = 'SELECT category_id
		FROM ' . CATEGORY_TABLE . '
		WHERE category_id = ' . $id;
}

$result = $db->sql_query($sql);
$cat_id = $db->sql_fetchfield('category_id');
$db->sql_freeresult($result);

if (!$cat_id)
{
	//if($config['enable_modrewrite'])
	{
		redirect($phpbb_root_path);
	}
	trigger_error($user->lang['CAT_NO_EXISTS']);
}

$limits = array('8' => 8, '16' => 16, '32' => 32);
$filters = array(
	'id'			=> $user->lang['SELECT'],
	'price_asc'		=> $user->lang['BY_PRICE_ASC'],
	'price_desc'	=> $user->lang['BY_PRICE_DESC'],
	'name_asc'		=> $user->lang['BY_NAME_ASC'],
	'name_desc'		=> $user->lang['BY_NAME_DESC'],
);
$s_select_filter = '';
foreach ($filters as $key => $value)
{
	$s_selected = ($key == $filter) ? ' selected="selected"' : '';
	$s_select_filter .='<option value="' . $key . '" ' . $s_selected . '>' . $value . '</option>';
}

$s_select_limit = '';
foreach ($limits as $key => $value)
{
	$s_selected = ($key == $limit) ? ' selected="selected"' : '';
	$s_select_limit .='<option value="' . $value . '" ' . $s_selected . '>' . $value . '</option>';
}

$limit_sql = ($start == 0) ? $limit : $start .','. $limit;
$sql = 'SELECT COUNT(product_id) AS total
	FROM ' . PRODUCT_TABLE . '
	WHERE category_id = ' . $cat_id;
$result = $db->sql_query($sql);
$total = $db->sql_fetchfield('total');
$db->sql_freeresult($result);

switch ($filter)
{
	case 'price_asc':
		$order_by = 'ORDER BY p.price ASC';
	break;
	case 'price_desc':
		$order_by = 'ORDER BY p.price DESC';
	break;
	case 'name_asc':
		$order_by = 'ORDER BY pl.name ASC';
	break;
	case 'name_desc':
		$order_by = 'ORDER BY pl.name DESC';
	break;
	case 'id':
	default:
		$order_by = 'ORDER BY p.display_order ASC';
}

$sql = 'SELECT p.product_id, p.price, p.old_price, p.unique_name, p.filetype, pl.name, p.sale, p.is_new, pl.link_rewrite, pl.description, pl.description_short, pl.available_now
	FROM ' . PRODUCT_TABLE . ' p, ' . PRODUCT_LANG_TABLE . ' pl
	WHERE p.category_id = ' . $cat_id . '
	AND p.product_id = pl.id_product
	AND pl.lang = \'' . $user->data['user_lang'] . '\'
	' . $order_by . '
	LIMIT ' . $limit_sql;

$result = $db->sql_query($sql);

$root_path = (!$id && $config['enable_modrewrite']) ? $paths : $phpbb_root_path;
while($row = $db->sql_fetchrow($result))
{
	$product_id = $row['product_id'];
	$link_rewrite = $row['link_rewrite'];
	$u_view = ($config['enable_modrewrite'] && $link_rewrite) ? $link_rewrite : append_sid("{$root_path}products.$phpEx", "id=$product_id");
	$template->assign_block_vars('row', array(
		'ID'			=> $product_id,
		'NAME'			=> $row['name'],
		'PRICE'			=> $row['price'],
		'OLD_PRICE'		=> ($row['old_price'] != 0.00) ? $row['old_price'] . '&nbsp;' . $user->lang['EUR'] : '',
		'S_SALE'		=> ($row['old_price'] != 0.00) ? true: false, //$data_row['sale'],
		'S_NEW'			=> $row['is_new'],
		'IMG'			=> '' . $row['unique_name'] . '_'  .$row['product_id'] . '_default.'  .$row['filetype'] . '',
		'DESCRIPTION'	=> $row['description'],
		'URL'			=> ($config['enable_modrewrite'] && $link_rewrite) ? $root_path . 'products/' . $link_rewrite : $u_view,
		'U_QVIEW'		=> ($config['enable_modrewrite'] && $link_rewrite) ? $root_path . 'products/' . $link_rewrite . '?mode=quick' : append_sid("{$root_path}products.$phpEx", "id=$product_id"),
	));
}
$db->sql_freeresult($result);

$sql = 'SELECT cl.*, c.category_id, c.parent_id, c.left_id, c.right_id, c.imagetype
	FROM ' . CATEGORY_LANG_TABLE . ' cl, ' . CATEGORY_TABLE . ' c
	WHERE cl.category_id = ' . $cat_id . '
	AND c.category_id = cl.category_id
	AND lang = \'' . $user->data['user_lang'] . '\'';
$result = $db->sql_query_limit($sql, 1);
$cat_row = $db->sql_fetchrow($result);
$parent_id = $cat_row['parent_id'];
$id = $cat_row['category_id'];
$navigation = '';
$cats_nav = get_category_branch($parent_id, 'parents', 'descending');
foreach ($cats_nav as $row)
{
	$navigation .= ' <span class="navigation-pipe" >&gt;</span> <a class="catnav" href="' . append_sid("{$phpbb_root_path}category.$phpEx", "id=" . $row['category_id'] . "") . '">' . $row['category_name'] . '</a>';
}

if (($cat_row['right_id'] - $cat_row['left_id']) > 1) // has subcats
{
	$sql = 'SELECT c.category_id, c.imagetype, cl.category_name, cl.link_rewrite
		FROM ' . CATEGORY_TABLE . ' c, ' . CATEGORY_LANG_TABLE . ' cl
		WHERE c.parent_id = ' . $id . '
		AND c.category_id = cl.category_id
		AND cl.lang = \'' . $user->data['user_lang']. '\'';
	$result = $db->sql_query($sql);
	while($row = $db->sql_fetchrow($result))
	{
		$template->assign_block_vars('subcats', array(
			'SUBCAT_NAME'		=> $row['category_name'],
			'SUBCAT_IMG'		=> 'th_cat_' . $row['category_id'] . '.' . '' . $row['imagetype'] . '',
			'U_SUBCAT'			=> ($config['enable_modrewrite'] && $row['link_rewrite']) ? $root_path . 'category/' . $row['link_rewrite'] : append_sid("{$phpbb_root_path}category.$phpEx", "id=" . $row['category_id'] . ""),
		));
	}
}

if ($cat_row['link_rewrite'] && $config['enable_modrewrite'])
{
	$pagination_url = $url_params;
	$page_num  = floor($start / $limit) + 1;;
	$url .= '/page_'. $page_num;
}
else
{
	$pagination_url = append_sid("{$phpbb_root_path}category.$phpEx", "id=$id&amp;f=$filter&amp;n=$limit");
}

$template->assign_vars(array(
	'TOTAL'					=> $total,
	'CATEGORY_ID'			=> $id,
	'CATEGORY_NAME'			=> $cat_row['category_name'],
	'CATEGORY_DESCR'		=> $cat_row['description'],
	'CATEGORY_DESCR_SHORT'	=> truncate($cat_row['description']),
	'CAT_IMG'				=> 'cat_' . $cat_id . '.' . '' . $cat_row['imagetype'] . '',
	'S_SELECT_LIMIT'		=> $s_select_limit,
	'S_SELECT_FILTER'		=> $s_select_filter,
	'PAGINATION'			=> generate_pagination($pagination_url, $total, $limit, $start, $id),
	'PAGE_NUMBER'			=> on_page($total, $limit, $start),
	'NAVIGATION' 			=> $navigation,
	'S_ACTION'				=> ($cat_row['link_rewrite'] && $config['enable_modrewrite']) ? $root_path . 'category/' . $url : append_sid("{$phpbb_root_path}category.$phpEx", "id=$id"),
	'FILTER'				=> $filter,
	'LIMIT'					=> $limit,

	'BODY'		=> 'id="category" class="index hide-left-column hide-right-column lang_' . $user->data['user_lang'] . ' one-column"',
));

page_header($cat_row['category_name'], $s_product, $url_params);

$template->set_filenames(array(
	'body' => 'category_body.html')
);

page_footer();

?>
