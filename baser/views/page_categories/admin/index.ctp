<?php
/* SVN FILE: $Id$ */
/**
 * [管理画面] ページカテゴリ一覧
 *
 * PHP versions 4 and 5
 *
 * BaserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2009, Catchup, Inc.
 *								9-5 nagao 3-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2009, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			baser.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
?>
<!-- pagination -->
<?php //$baser->element('paginations'.DS.'default'); ?>
<table cellpadding="0" cellspacing="0" class="admin-col-table-01" id="TablePageCategoryCategories">
<tr>
	<th>操作</th>
    <th>NO</th>
	<th>ページカテゴリ名</th>
	<th>ページカテゴリタイトル</th>
	<th>登録日</th>
	<th>更新日</th>
</tr>
<?php if(!empty($dbDatas)): ?>
<?php $count=0; ?>
<?php foreach($dbDatas as $dbData): ?>
	<?php if ($count%2 === 0): ?>
		<?php $class=' class="altrow"'; ?>
	<?php else: ?>
		<?php $class=''; ?>
	<?php endif; ?>
	<tr<?php echo $class; ?>>
		<td class="operation-button">
			<?php echo $html->link('編集',array('action'=>'edit', $dbData['PageCategory']['id']),array('class'=>'btn-orange-s button-s'),null,false) ?>
			<?php echo $html->link('削除', array('action'=>'delete', $dbData['PageCategory']['id']), array('class'=>'btn-gray-s button-s'), sprintf('%s を本当に削除してもいいですか？\n\nこのカテゴリに関連するページは、どのカテゴリにも関連しない状態として残ります。', $dbData['PageCategory']['name']),false); ?>
		</td>
        <td><?php echo $dbData['PageCategory']['no']; ?></td>
		<td><?php echo $html->link($dbData['PageCategory']['name'],array('action'=>'edit', $dbData['PageCategory']['id'])); ?></td>
        <td><?php echo $dbData['PageCategory']['title']; ?></td>
		<td><?php echo $timeEx->format('y-m-d',$dbData['PageCategory']['created']); ?></td>
		<td><?php echo $timeEx->format('y-m-d',$dbData['PageCategory']['modified']); ?></td>
	</tr>
	<?php $count++; ?>
<?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="8"><p class="no-data">データが見つかりませんでした。</p></td></tr>
<?php endif; ?>
</table>


<?php //$baser->element('paginations'.DS.'default'); ?>

<div class="align-center"><?php echo $html->link('新規登録',array('action'=>'add'),array('class'=>'btn-red button')) ?></div>