<?php
/**
 *
 * @package Support Toolkit - Restore Deleted Users French language
 * French translation by phpBB-fr http://www.phpbb-fr.com & Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2017 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'DAMAGED_POSTS'			=> 'Messages endommagés',
	'DAMAGED_POSTS_EXPLAIN'	=> 'Les ID des messages suivants contiennent des informations sur l’utilisateur trop endommagées pour être restaurées. Merci de visiter les <a href="https://www.phpbb.com/community/viewforum.php?f=46">forums de support sur phpBB.com</a> ou les <a href="http://forums.phpbb-fr.com/support-phpbb3/">forums de support de phpBB-fr.com</a> afin de recevoir une aide pour résoudre ce problème.',

	'NO_DELETED_USERS'	=> 'Il n’y a aucun utilisateur supprimé pouvant être restauré',
	'NO_USER_SELECTED'	=> 'Aucun utilisateur n’a été sélectionné !',

	'RESTORE_DELETED_USERS'						=> 'Restaurer les utilisateurs supprimés',
	'RESTORE_DELETED_USERS_CONFLICT'			=> 'Restaurer les utilisateurs supprimés :: En conflit',
	'RESTORE_DELETED_USERS_CONFLICT_EXPLAIN'	=> 'Cet outil permet de restaurer des utilisateurs qui ont été supprimés à partir du forum mais qui conservent des messages en « invité ».<br />Ces utilisateurs se verront assigner un mot de passe aléatoire qu’il sera nécessaire de réinitialiser manuellement après que l’outil ait été exécuté. Cet outil <b>ne</b> fournit <b>pas</b> une liste de ces mots de passe générés.<br /><br />Durant sa dernière exécution, cet outil a trouvé certains noms d’utilisateurs qui existent déjà sur ce forum. Merci de fournir un nouveau nom concernant ces utilisateurs.',
	'RESTORE_DELETED_USERS_EXPLAIN'				=> 'Cet outil permet de restaurer des utilisateurs qui ont été supprimés à partir du forum mais qui conservent des messages en « invité ».<br />Ces utilisateurs se verront assigner un mot de passe aléatoire qu’il sera nécessaire de réinitialiser manuellement après que l’outil ait été exécuté. Cet outil <b>ne</b> fournit <b>pas</b> une liste de ces mots de passe générés.',

	'SELECT_USERS'	=> 'Sélectionner les utilisateurs à restaurer',

	'USER_RESTORED_SUCCESSFULLY'	=> 'L’utilisateur sélectionné a été restauré.',
	'USERS_RESTORED_SUCCESSFULLY'	=> 'Les utilisateurs sélectionnés ont été restaurés.',
));
