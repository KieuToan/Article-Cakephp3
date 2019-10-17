<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

class ArticlesController extends AppController
{
	public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['tags']);

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }
    public function index()
    {
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }
    public function view($slug = null)
	{
	    $article = $this->Articles->findBySlug($slug)->contain('Tags')->firstOrFail();
	    // Get a list of tags.
	    $tags = $this->Articles->Tags->find('list');

	    $this->set(compact('article', 'tags'));
	}
	public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            // Changed: Set the user_id from the session.
        	$article->user_id = $this->Auth->user('id');

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $tags = $this->Articles->Tags->find('list');

        $this->set('tags', $tags);
        $this->set('article', $article);
    }
    public function edit($slug)
	{
	    $article = $this->Articles->findBySlug($slug)->contain('Tags')->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	        $this->Articles->patchEntity($article, $this->request->getData(), [
	            // Added: Disable modification of user_id.
	            'accessibleFields' => ['user_id' => false]
	        ]);
	        if ($this->Articles->save($article)) {
	            $this->Flash->success(__('Your article has been updated.'));
	            return $this->redirect(['action' => 'index']);
	        }
	        $this->Flash->error(__('Unable to update your article.'));
	    }
	    $tags = $this->Articles->Tags->find('list');

	    $this->set('tags', $tags);
	    $this->set('article', $article);
	}
	public function delete($slug)
	{
	    $this->request->allowMethod(['post', 'delete']);

	    $article = $this->Articles->findBySlug($slug)->firstOrFail();
	    if ($this->Articles->delete($article)) {
	        $this->Flash->success(__('The {0} article has been deleted.', $article->title));
	        return $this->redirect(['action' => 'index']);
	    }
	}
	public function tags()
	{
	    // The 'pass' key is provided by CakePHP and contains all
	    // the passed URL path segments in the request.
	    $tags = $this->request->getParam('pass');

	    // Use the ArticlesTable to find tagged articles.
	    $articles = $this->Articles->find('tagged', [
	        'tags' => $tags
	    ]);
	    $this->set([
	        'articles' => $articles,
	        'tags' => $tags
	    ]);
	}
}