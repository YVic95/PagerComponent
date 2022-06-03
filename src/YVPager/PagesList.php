<?php
    namespace YVPager;


    class PagesList extends View
    {
        public function render( Pager $pager )
        {
            //Pager object
            $this->pager = $pager;

            //Resulting string
            $returnPage = "";

            //Current page number
            $currentPage = $this->pager->getCurrentPage();

            //Total number of pages
            $totalPages = $this->pager->getPagesCount();

            //Link to the first page
            $returnPage .= $this->link('&lt;&lt;', 1) . " ... ";

            //Display a "Back" link if it's not the first page
            if($currentPage != 1) {
                $returnPage .= $this->link('&lt;', $currentPage - 1) . " ... ";
            }

            //Display previous elements
            if($currentPage > $this->pager->getVisibleLinkCount() + 1) {
                $init = $currentPage - $this->pager->getVisibleLinkCount();
                for($i = $init; $i < $currentPage; $i++) {
                    $returnPage .= $this->link($i, $i) . "";
                } 
            } else {
                for($i = 1; $i < $currentPage; $i++) {
                    $returnPage .= $this->link($i, $i) . "";
                }
            }
            //Display current element
            $returnPage .= "$i ";
            //Display next elements
            if($currentPage + $this->pager->getVisibleLinkCount() < $totalPages) {
                $cond = $currentPage + $this->pager->getVisibleLinkCount();
                for($i = $currentPage + 1; $i < $cond; $i++) {
                    $returnPage .= $this->link($i, $i) . "";
                }
            } else {
                for($i = $currentPage + 1; $i <= $totalPages; $i++) {
                    $returnPage .= $this->link($i, $i) . "";
                }
            }
            //Display link "Next" if its not the last page
            if($currentPage != $totalPages) {
                $returnPage .= " ... " . $this->link('&gt;', $currentPage + 1);
            }
            //Link to the last page
            $returnPage .= " ... " . $this->link('&gt;&gt;', $totalPages);
            return $returnPage;
        }

    }

    