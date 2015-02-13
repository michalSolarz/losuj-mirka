<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 01.02.15
 * Time: 20:37
 */

namespace Lottery\View\Helper;

use Zend\View\Helper\AbstractHelper;


class PaginationHelper extends AbstractHelper
{
    private $limit;
    private $totalResults;
    private $results;
    private $baseUrl;
    private $paging;
    private $page;
    private $lowerLimit;
    private $upperLimit;

    public function __invoke($pagedResults, $page, $limit, $baseUrl, $lowerLimit = 2, $upperLimit = 2)
    {
        $this->limit = $limit;
        $this->totalResults = $pagedResults->count();
        $this->results = $pagedResults;
        $this->baseUrl = $baseUrl;
        $this->page = $page;
        $this->lowerLimit = $lowerLimit;
        $this->upperLimit = $upperLimit;

        return $this->generatePaging();
    }

    /**
     * Generate paging html
     */
    private function generatePaging()
    {
        # Get total page count
        $pages = ceil($this->totalResults / $this->limit);

        # Don't show pagination if there's only one page
        if ($pages == 1) {
            return;
        }

        if ($this->page > $pages || $this->page < 1) {
            return $this->generateDivider($this->generateUrl($pages, 'Idź do ostatniej strony'));
        }

        # Show back to first page if not first page
        if ($this->page != 1) {
            $this->paging = $this->generateElement('li', $this->generateUrl(1, $this->generateElement('span', '&laquo;', NULL, 0, 'first-page'), 'page-link'));
        } else if ($this->page == 1) {
            $this->paging = $this->generateElement('li', $this->generateUrl(1, $this->generateElement('span', '&laquo;')), 'disabled');
        }

        if ($this->page != 1)
            $this->paging .= $this->generateElement('li', $this->generateUrl($this->page - 1, $this->generateElement('span', '&lsaquo;', NULL, NULL, 'previous-page'), 'page-link'));
        elseif ($this->page == 1) {
            $this->paging .= $this->generateElement('li', $this->generateUrl($this->page - 1, $this->generateElement('span', '&lsaquo;')), 'disabled');
        }

        for ($i = $this->page - $this->lowerLimit; $i < $this->page; $i++) {
            if ($i >= 1)
                $this->paging .= $this->generateElement('li', $this->generateUrl($i, $this->generateElement('span', $i, NULL, $i, 'page'), 'page-link'), 'page');
        }

        $this->paging .= $this->generateElement('li', $this->generateUrl($this->page, $this->generateElement('span', $this->page, NULL, $this->page, 'page'), 'page-link'), 'active');

        for ($i = $this->page + 1; $i <= $this->page + $this->upperLimit; $i++) {
            if ($i <= $pages)
                $this->paging .= $this->generateElement('li', $this->generateUrl($i, $this->generateElement('span', $i, NULL, $i, 'page'), 'page-link'), 'page');
        }

        if ($this->page < $pages)
            $this->paging .= $this->generateElement('li', $this->generateUrl($this->page + 1, $this->generateElement('span', '&rsaquo;', NULL, NULL, 'next-page'), 'page-link'));
        elseif ($this->page == $pages)
            $this->paging .= $this->generateElement('li', $this->generateUrl($this->page + 1, $this->generateElement('span', '&rsaquo;')), 'disabled');
        if ($this->page != $pages) {
            $this->paging .= $this->generateElement('li', $this->generateUrl($pages, $this->generateElement('span', '&raquo;', NULL, $pages + 1, 'last-page'), 'page-link'));
        } else {
            $this->paging .= $this->generateElement('li', $this->generateUrl($pages, $this->generateElement('span', '&raquo;')), 'disabled');
        }

        return $this->generateElement('nav', $this->generateElement('ul', $this->paging, 'pagination'));
    }

    private function generateUrl($page, $content, $class = NULL, $id = NULL, $name = NULL)
    {
        $result = '<a ';
        $result .= 'href="' . $this->baseUrl . $page . '/' . $this->limit . '"';
        if ($class != NULL)
            $result .= 'class="' . $class . '" ';
        if ($id != NULL)
            $result .= 'id="' . $id . '" ';
        if ($name != NULL)
            $result .= 'name="' . $name . '" ';
        $result .= '>';
        $result .= $content;
        $result .= '</a>';
        return $result;
    }

    private function generateDivider($content, $dividerClass = NULL, $dividerId = NULL, $dividerName = NULL)
    {
        $result = '<div ';
        if ($dividerClass != NULL)
            $result .= 'class="' . $dividerClass . '"';
        if ($dividerId != NULL)
            $result .= 'id="' . $dividerId . '"';
        if ($dividerName != NULL)
            $result .= 'name="' . $dividerName . '"';
        $result .= '>';
        $result .= $content;
        $result .= '</div>';

        return $result;
    }

    private function generateElement($element, $content, $class = NULL, $id = NULL, $name = NULL)
    {
        $result = '<' . $element . ' ';
        if ($class != NULL)
            $result .= 'class="' . $class . '"';
        if ($id != NULL)
            $result .= 'id="' . $id . '"';
        if ($name != NULL)
            $result .= 'name="' . $name . '"';
        $result .= '>';
        $result .= $content;
        $result .= '</' . $element . '>';
        return $result;
    }

}