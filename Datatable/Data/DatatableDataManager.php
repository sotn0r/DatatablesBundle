<?php

/**
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable\Data;

use Sg\DatatablesBundle\Datatable\View\DatatableViewInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;

/**
 * Class DatatableDataManager
 *
 * @package Sg\DatatablesBundle\Datatable\Data
 */
class DatatableDataManager
{
    /**
     * The request service.
     *
     * @var Request
     */
    private $request;

    /**
     * The serializer service.
     *
     * @var Serializer
     */
    private $serializer;

    //-------------------------------------------------
    // Ctor.
    //-------------------------------------------------

    /**
     * Ctor.
     *
     * @param Request    $request    The request service
     * @param Serializer $serializer The serializer service
     */
    public function __construct(Request $request, Serializer $serializer)
    {
        $this->request = $request;
        $this->serializer = $serializer;
    }

    //-------------------------------------------------
    // Public
    //-------------------------------------------------

    /**
     * Get Datatable.
     *
     * @param DatatableViewInterface $datatableView
     *
     * @return DatatableData
     */
    public function getDatatable(DatatableViewInterface $datatableView)
    {
        $type = $datatableView->getAjax()->getType();
        $qb = $datatableView->getQb();
        $datatableQueryBuilder = null;
        $parameterBag = null;

        if ("GET" === strtoupper($type)) {
            $parameterBag = $this->request->query;
        }

        if ("POST" === strtoupper($type)) {
            $parameterBag = $this->request->request;
        }

        $params = $parameterBag->all();

        if (null !== $qb) {
            $datatableQueryBuilder = new DatatableCustomQuery($params, $datatableView);
        } else {
            $datatableQueryBuilder = new DatatableQuery($params, $datatableView);
        }

        $datatableData = new DatatableData($this->serializer, $datatableQueryBuilder);

        return $datatableData;
    }
}
