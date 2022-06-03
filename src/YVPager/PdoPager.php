<?php
    namespace YVPager;

    /**
     * This class implements per page navigation for DB tables
     */
    class PdoPager extends PdoPager
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
            $query = "SELECT COUNT (*) AS total FROM {$this->tableName}
                      {$this->where}";
            $to = $this->pdo->prepare($query);
            $to->execute($this->params);
            return $to->fetch()['total'];
        }
    }