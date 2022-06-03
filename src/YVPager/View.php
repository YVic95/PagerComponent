<?php 
    namespace YVPager;


    abstract class View
    {
        protected $pager;

        public function link($title, $currentPage = 1)
        {
            return "<a href='{$this->pager->getCurrentPagePath()}?".
                   "{$this->pager->getCounterParam()}={$currentPage}". 
                   "{$this->pager->getParameters()}'>{$title}</a>";
        }

        abstract public function render(Pager $pager);
    }