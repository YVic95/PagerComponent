<?php 
    namespace YVPager;


    /**
     * This class implements per page navigation for text files
     */
    class FilePager extends Pager
    {
        protected $fileName;

        public function __construct(
            View $view,
            $fileName = '.',
            $items_per_page = 20,
            $links_count = 3,
            $get_params = null,
            $counter_param = 'page')
        {
            $this->fileName = $fileName;
            //Initialize parent constructor`s parameters
            parent::__construct(
                $view,
                $items_per_page,
                $links_count,
                $get_params,
                $counter_param);
        }
        //Method counts the total number of strings in file
        public function getItemsCount()
        {
            $countline = 0;
            //Open file
            $fd = fopen($this->fileName, "r");
            if($fd) {
                //Count the amount of entries in file 
                while(!feof($fd)) {
                    fgets($fd, 10000);
                    $countline++;
                }
                //Close file
                fclose($fd);
            }
            return $countline;
        }
        public function getItems()
        {
            //Current page
            $currentPage = $this->getCurrentPage();
            //Total number of items
            $total = $this->getItemsCount();
            //Total number of pages
            $totalPages = $this->getPagesCount();
            //Checking if the requested page is in the min-max range
            if($currentPage <= 0 || $currentPage > $totalPages) {
                return 0;
            }
            //Extracting the items of the current page
            $arr = [];
            $fd = fopen($this->fileName, "r");
            if(!$fd) return 0;
            //The item from which extraction of the file strings starts
            $first = ($currentPage - 1) * $this->getItemsPerPage();
            for($i = 0; $i < $total; $i++) {
                $str = fgets($fd, 10000);
                if($i < $first) continue;
                if($i > $first + $this->getItemsPerPage() - 1) break;
                $arr[] = $str;
            }

            fclose($fd);

            return $arr;
        }
    }