<?php
    namespace YVPager;


    /**
     * DirPager class implements page-by-page 
     * navigation of a folder
     */
    class DirPager extends Pager 
    {
        protected $dirname;

        public function __construct(
            View $view,
            $dir_name = '.',
            $items_per_page = 10,
            $links_count = 3,
            $get_params = null,
            $counter_param = 'page')
        {
            $this->dirname = ltrim($dir_name, "/");
            //properties` initialization via parent class construct
            parent::__construct(
                $view,
                $items_per_page,
                $links_count,
                $get_params,
                $counter_param);
        }

        public function getItemsCount()
        {
            $countline = 0;
            //open directory
            if(($dir = opendir($this->dirname)) !== false) {
                while(($file = readdir($dir)) !== false) {
                    // if current element is file calculate it
                    if(is_file($this->dirname."/".$file)) {
                        $countline++;
                    }
                }
                closedir($dir);
            }
            return $countline;
        }

        public function getItems()
        {
            //Current page
            $currentPage = $this->getCurrentPage();
            //Total number of pages
            $totalPages = $this->getPagesCount();
            //Checking if current page`s number is in the range 
            //between min and max
            if($currentPage <= 0 || $currentPage > $totalPages) {
                return 0;
            }
            //Retrieving the positions of the current page
            $arr = [];
            //Number from which to select the lines of the file
            $firstElement = ($currentPage - 1) * $this->getItemsPerPage();
            //Open directory
            if(($dir = opendir($this->dirname)) === false) {
                return 0;
            }
            $i = -1;
            while(($file = readdir($dir)) !== false) {
                //If current element is file
                if(is_file($this->dirname."/".$file)) {
                    $i++;
                    if($i < $firstElement) continue;
                    if($i > $firstElement + $this->getItemsPerPage() - 1) break;
                    $arr[] = $this->dirname."/".$file;
                }
            }
            closedir($dir);

            return $arr;
        }
    }
