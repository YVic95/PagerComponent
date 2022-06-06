<?php
    namespace YVPager;

    /**
     * This class implements per page navigation for DB tables
     */
    class PdoPager extends Pager
    {
        protected $pdo;
        protected $tableName;
        protected $where;
        protected $params;
        protected $order;

        public function __construct(
            View $view,
            $pdo,
            $tableName,
            $where = "",
            $params = [],
            $order = "",
            $items_per_page = 10,
            $links_count = 3,
            $get_params = null,
            $counter_param = 'page')
        {
            $this->pdo = $pdo;
            $this->tableName = $tableName;
            $this->where = $where;
            $this->params = $params;
            $this->order = $order;
            //Initialize parent constructor`s parameters
            parent::__construct(
                $view,
                $items_per_page,
                $links_count,
                $get_params,
                $counter_param);
        }
        public function getItemsCount()
        {
            //Prepearing a query to get the total number 
            //of records in the table
            //Use the COUNT function to get the number of rows 
            //for a particular group in the table. 
            //Here is the basic syntax: SELECT COUNT(column_name) 
            //FROM table_name;
            $query = "SELECT COUNT(*) AS total FROM {$this->tableName}{$this->where}";
            $to = $this->pdo->prepare($query);
            $to->execute($this->params);
            return $to->fetch()['total'];
        }
        public function getItems() {
            //Current page
            $currentPage = $this->getCurrentPage();
            //Total number of pages
            $totalPages = $this->getPagesCount();
            //Checking if the requested page is in the min-max range
            if($currentPage <= 0 || $currentPage > $totalPages) {
                return 0;
            }
            //Extracting the items of the current page
            $arr = [];
            //The item from which extraction of the file strings starts
            $first = ($currentPage - 1) * $this->getItemsPerPage();
            //Extracting elements for current page
            $query = "SELECT * FROM {$this->tableName} {$this->where}
                      {$this->order} LIMIT $first, {$this->getItemsPerPage()}";
            $table = $this->pdo->prepare($query);
            $table->execute($this->params);
            
            return $results = $table->fetchAll();
            

        }
    }