<?php
    namespace YVPager;


    class ItemsRange extends View
    {
        public function range($first, $second)
        {
            return "[{$first}-{$second}]";
        }
        public function render(Pager $pager)
        {
            //Pager object
            $this->pager = $pager;

            //Resulting string
            $returnPage = "";

            //Current page number
            $currentPage = $this->pager->getCurrentPage();

            //Total number of pages
            $totalPages = $this->pager->getPagesCount();

            //Checking if there are links on the left side
            if($currentPage - $this->pager->getVisibleLinkCount() > 1) {
                $range = $this->range(1, $this->pager->getItemsPerPage());
                $returnPage .= $this->link($range, 1) . " ... ";
                //If there are 
                $init = $currentPage - $this->pager->getVisibleLinkCount();
                for($i = $init; $i < $currentPage; $i++) {
                    $range = $this->range(
                        (($i-1) * $this->pager->getItemsPerPage() + 1),
                        $i * $this->pager->getItemsPerPage());
                    $returnPage .= " " . $this->link($range, $i) . " ";
                }
            } else {
                //If there are no link on the left
                for($i = 1; $i < $currentPage; $i++) {
                    $range = $this->range(
                        (($i-1) * $this->pager->getItemsPerPage() + 1),
                        $i * $this->pager->getItemsPerPage());
                    $returnPage .= " " . $this->link($range, $i) . " ";
                }
            }
            //Checking if there are links on the right side
            if($currentPage + $this->pager->getVisibleLinkCount() > $totalPages) 
            {
                echo "hi";
                //If there are 
                 $condition = $currentPage + $this->pager->getVisibleLinkCount();
                // or $i <= $condition ???
                for($i = $currentPage; $i < $totalPages; $i++) {
                    if($currentPage == $i) {
                        $returnPage .= " " . $this->range(
                            (($i-1) * $this->pager->getItemsPerPage() + 1),
                            $i * $this->pager->getItemsPerPage()) . " ";
                    } else {
                        $range = $this->range(
                            (($totalPages-1) * $this->pager->getItemsPerPage() + 1),
                            $i * $this->pager->getItemsPerPage());
                            
                        $returnPage .= " " . $this->link($range, $i) . " ";
                    }
                }
                $range = $this->range(
                    (($totalPages - 1) * $this->pager->getItemsPerPage() + 1),
                    $this->pager->getItemsCount());
                $returnPage .= " " .$this->link($range, $totalPages) . " ";
            } else {
                echo "hi2!";
                //If there are no link on the right side
                for($i = $currentPage; $i <= $totalPages; $i++) {
                    if($totalPages == $i) {
                        if($currentPage = $i) {
                            $returnPage .= " " . $this->range(
                                (($i - 1) * $this->pager->getItemsPerPage() + 1),
                                $this->pager->getItemsCount()) . " ";
                        } else {
                            $range = $this->range(
                                (($i - 1) * $this->pager->getItemsPerPage() + 1),
                                $this->pager->getItemsCount()); 
                            $returnPage .= " " . $this->link($range, $i) . " ";
                        }
                    } else {
                        if($currentPage == $i) {
                            $returnPage .= " " . $this->range(
                                (($i - 1) * $this->pager->getItemsPerPage() + 1),
                                $i * $this->pager->getItemsPerPage()) . " ";    
                        } else {
                            $range = $this->range(
                                (($i - 1) * $this->pager->getItemsPerPage() + 1),
                                $i * $this->pager->getItemsPerPage());
                            $returnPage .= " " . $this->link($range, $i) . " ";
                        }
                    }
                }
            }
            return $returnPage;
        }
    }