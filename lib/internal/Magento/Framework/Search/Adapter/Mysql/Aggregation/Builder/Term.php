<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Search\Adapter\Mysql\Aggregation\Builder;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Select;
use Magento\Framework\Search\Adapter\Mysql\Aggregation\DataProviderInterface;
use Magento\Framework\Search\Request\BucketInterface as RequestBucketInterface;

class Term implements BucketInterface
{
    /**
     * @var Metrics
     */
    private $metricsBuilder;

    /**
     * @param Metrics $metricsBuilder
     */
    public function __construct(Metrics $metricsBuilder)
    {
        $this->metricsBuilder = $metricsBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function build(
        DataProviderInterface $dataProvider,
        array $dimensions,
        RequestBucketInterface $bucket,
        Table $entityIdsTable
    ) {
        $metrics = $this->metricsBuilder->build($bucket);

        $select = $dataProvider->getDataSet($bucket, $dimensions, $entityIdsTable);
        $select->columns($metrics);
        $select->group(RequestBucketInterface::FIELD_VALUE);

        return $dataProvider->execute($select);
    }
}
