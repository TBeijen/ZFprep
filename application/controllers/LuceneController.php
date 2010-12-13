<?php
class LuceneController extends Zend_Controller_Action
{
    /**
     *
     * @var Zend_Search_Lucene_Interface
     */
    protected $_index;

    /**
     * Setup lucene index
     */
    public function init()
    {
        $indexLoc = Zend_Registry::get('config')->paths->lucene->index;
        try {
            $this->_index = Zend_Search_Lucene::open($indexLoc);
        } catch (Zend_Search_Lucene_Exception $e) {
            // if openening fails, assume because of missing index,
            // try to create instead
            $this->_index = Zend_Search_Lucene::create($indexLoc);
        }
    }

    /**
     * Perform basic search
     */
    public function indexAction()
    {
        $searchForm = new Zend_Form();
        $searchForm->addElement('text', 'search');
        $searchForm->addElement('submit', 'submit');

        $results = array();
        
        if ($this->getRequest()->isPost()) {
            if ($searchForm->isValid($this->getRequest()->getPost())) {
                $search = $searchForm->getValue('search');

                $results = $this->_index->find($search);
            }
        }
        $this->view->assign('form', $searchForm);
        $this->view->assign('results', $results);
    }
    
    /**
     * Will rebuild index
     */
    public function buildAction()
    {
        // fetch articles
        $articleTable = new Article();
        $articleRowset = $articleTable->fetchAll();

        $articlesDeleted = array();

        foreach ($articleRowset as $articleRow) {
            // row allows access to field data as properties
            // for row access use $articleRow->toArray();

            // finding/deleting doesn't seem to work on numeric values (ids)
            $term = new Zend_Search_Lucene_Index_Term($articleRow->url, 'url');
            $query = new Zend_Search_Lucene_Search_Query_Term($term);
            $hits = $this->_index->find($query);
            foreach ($hits as $doc) {
                $this->_index->delete($doc->id);
                $articlesDeleted[] = $doc->id;
            }

            // create doc
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Keyword('article_id', 'id' . $articleRow->article_id));
            $doc->addField(Zend_Search_Lucene_Field::Text('title', $articleRow->title));
            $doc->addField(Zend_Search_Lucene_Field::UnStored('body', $articleRow->body));
            $doc->addField(Zend_Search_Lucene_Field::Keyword('url', $articleRow->url));
            $doc->addField(Zend_Search_Lucene_Field::UnIndexed('date_created', $articleRow->date_created));

            $this->_index->addDocument($doc);
        }
        
        // assign view params
        $this->view->assign('numDocs', $this->_index->numDocs());
        $this->view->assign('docsDeleted', $articlesDeleted);
    }

}