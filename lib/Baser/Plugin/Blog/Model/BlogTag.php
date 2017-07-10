<?php
/**
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright (c) baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright (c) baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Blog.Model
 * @since			baserCMS v 0.1.0
 * @license			http://basercms.net/license/index.html
 */

App::uses('BlogAppModel', 'Blog.Model');

/**
 * ブログタグモデル
 *
 * @package Blog.Model
 */
class BlogTag extends BlogAppModel {

/**
 * クラス名
 *
 * @var string
 */
	public $name = 'BlogTag';

/**
 * ビヘイビア
 * 
 * @var array
 */
	public $actsAs = ['BcCache'];

/**
 * HABTM
 *
 * @var array
 */
	public $hasAndBelongsToMany = [
		'BlogPost' => [
			'className' => 'Blog.BlogPost',
			'joinTable' => 'blog_posts_blog_tags',
			'foreignKey' => 'blog_tag_id',
			'associationForeignKey' => 'blog_post_id',
			'conditions' => '',
			'order' => '',
			'limit' => '',
			'unique' => true,
			'finderQuery' => '',
			'deleteQuery' => ''
	]];
	
/**
 * ファインダーメソッド
 *
 * @var array
 */
	public $findMethods = ['customParams' =>  true];
	
/**
 * validate
 *
 * @var array
 */
	public $validate = [
		'name' => [
			'notBlank' => [
				'rule' => ['notBlank'],
				'message' => 'ブログタグを入力してください。'
			],
			'duplicate' => [
				'rule' => ['duplicate', 'name'],
				'message' => '既に登録のあるタグです。'
			]
	]];

/**
 * カスタムパラメーター検索
 * ※ カスタムファインダーメソッド
 * 
 * @param string $state
 * @param array $query
 * @param array $results
 * @return array
 */
	public function _findCustomParams($state, $query, $results = []) {
		if ($state == 'before') {
			$query = array_merge([
				'conditions' => [],		// 検索条件のベース
				'direction' => 'ASC',	// 並び方向
				'sort' => 'name',		// 並び順対象のフィールド
				'contentId' => null,	// 《条件》ブログコンテンツID
				'contentUrl' => null, 	// 《条件》コンテンツURL
				'siteId' => null,		// 《条件》サイトID
				'recursive' => 0,
			], $query);
			$assocContent = false;
			$conditions = $query['conditions'];
			if(!is_null($query['siteId'])) {
				$assocContent = true;
				$conditions['Content.site_id'] = $query['siteId'];
			}
			if($query['contentId']) {
				$assocContent = true;
				$conditions['Content.entity_id'] = $query['contentId'];
			}
			if($query['contentUrl']) {
				$assocContent = true;
				$conditions['Content.url'] = $query['contentUrl'];
			}
			$query['conditions'] = $conditions;
			if($assocContent) {
				$query['joins'] = [
					[
						'type' => 'INNER',
						'table' => 'blog_posts_blog_tags',
						'alias' => 'BlogPostsBlogTag',
						'conditions' => "BlogPostsBlogTag.blog_tag_id=BlogTag.id"
					],
					[
						'type' => 'INNER',
						'table' => 'blog_posts',
						'alias' => 'BlogPost',
						'conditions' => "BlogPostsBlogTag.blog_post_id=BlogPost.id"
					],
					[
						'type' => 'INNER',
						'table' => 'blog_contents',
						'alias' => 'BlogContent',
						'conditions' => "BlogPost.blog_content_id=BlogContent.id"
					],
					[
						'type' => 'INNER',
						'table' => 'contents',
						'alias' => 'Content',
						'conditions' => "Content.entity_id=BlogContent.id AND Content.type='BlogContent'",
				]];
				if($query['fields']) {
					if(is_array($query['fields'])) {
						$query['fields'][0] = 'DISTINCT ' . $query['fields'][0];
					} else {
						$query['fields'] = 'DISTINCT ' . $query['fields'];
					}
				} else {
					$query['fields'] = 'DISTINCT *';
				}
			}
			$order = "BlogTag.{$query['sort']} {$query['direction']}";
			if($query['order']) {
				$query['order'] = array_merge([$order], $query['order']);
			} else {
				$query['order'] = $order;
			}
			unset($query['sort'], $query['direction'], $query['contentId'], $query['contentUrl'], $query['siteId']);
			return $query;
		}
		return $results;
	}

}
