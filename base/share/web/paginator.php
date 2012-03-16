<?php
/**
 * Description of paginator
 *
 * @author Nemo.xiaolan
 * @created 2011-2-23 10:25:50
 */

class Paginator {

    /*
     * num objects of perpage
     */
    public $num_perpage = 10;

    /*
     * objects array
     */
    public $object_list = array();

    /*
     * Current page $_GET['page'];
     */
    public $current_page = 1;

    

    /*
     * num records total
     */
    public $num_objects;

    /*
     * page nums
     */
    public $num_pages;

    /*
     * pages array
     */
    public $page_range = array();

    /*
     * has the previous page or not
     */
    public $has_previous = false;

    /*
     * has the next page or not
     */
    public $has_next = true;

    /*
     * the previous page index
     */
    public $previous_page;

    /*
     * the next page index
     */
    public $next_page;

    /*
     * how many pages button to show
     */
    public $num_page_show;

    /*
     * The 1-based index of the first item on this page
     */
    public $start_index;

    /*
     * The 1-based index of the last item on this page
     */
    public $end_index;

    /*
     * Paginator::__construct();
     * @param $objects array
     * @param $current_page integer
     * @param $num_perpage integer 
     * @param $total integer | total nums
     * @param $num_page_show integer
     * @return void
     */
    public function __construct($objects, $current_page, $num_perpage,
                                        $total = null, $num_page_show = 10) {
        if(!$objects) {
            return;
        }
        $this->num_objects = $total ? $total : count($objects);
        $this->current_page = intval($current_page);
        $this->num_perpage = intval($num_perpage);
        $this->num_pages = ceil($this->num_objects/$this->num_perpage);
        $this->num_page_show = intval($num_page_show);
        $this->current_page = $this->current_page > $this->num_pages ?
                                $this->num_pages : $this->current_page;
        $this->current_page = $this->current_page < 1 ? 1 : $this->current_page;
        /*
         * 
         */
        $min_i = ($this->current_page-1) * $this->num_perpage;
        $max_i = $min_i + $this->num_perpage;
        $max_i = $max_i > $this->num_objects ? $this->num_objects : $max_i;
        if($max_i >= $this->num_objects) {
            $max_i = $this->num_objects;
            $this->has_next = false;
        } else {
            $this->has_next = true;
        }
        if($current_page > 1) {
            $this->has_previous = true;
        }

        if($this->has_next) {
            $this->next_page = $this->current_page+1;
        }
        if($this->has_previous) {
            $this->previous_page = $this->current_page-1;
        }

        /*
         * the objects list
         */
        for($i = $min_i; $i < $max_i; $i++) {
            $this->object_list[] = $objects[$i];
        }

        /*
         * set the page range
         */
        if($this->num_pages > $this->num_page_show) {
            $half = intval($this->num_page_show/2);
            $this->start_index = $this->current_page - $half;
            if($this->num_pages - $this->start_index < $this->num_page_show) {
                $this->start_index = $this->num_pages - $this->num_page_show + 1;
            }
            if($this->start_index < 1) {
                $this->start_index = 1;
            }
            $this->end_index = $this->start_index + $this->num_page_show - 1;
            
            if($this->end_index > $this->num_pages) {
                $this->end_index = $this->num_pages;
            }

            for($i = $this->start_index; $i <= $this->end_index; $i++) {
                $this->page_range[] = $i;
            }

        } else {
            for($i = 1; $i <= $this->num_pages; $i++) {
                $this->page_range[] = $i;
            }
        }
        
    }

    /*
     * return the array for template display
     */
    public function output() {
        return array(
            'num_objects'  => $this->num_objects,
            'current_page' => $this->current_page,
            'num_perpage'  => $this->num_perpage,
            'num_pages'    => $this->num_pages,
            'last_page'    => $this->last_page,
            'num_page_show'=> $this->num_page_show,
            'page_range'   => $this->page_range,
            'has_next'     => $this->has_next,
            'has_previous' => $this->has_previous,
            'last_page'    => $this->num_pages,
            'next'         => $this->next_page,
            'previous'     => $this->previous_page,
            'items'        => $this->object_list,
        );
    }


}


?>
