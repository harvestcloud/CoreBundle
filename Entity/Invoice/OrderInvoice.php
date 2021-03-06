<?php

/*
 * This file is part of the Harvest Cloud package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HarvestCloud\CoreBundle\Entity\Invoice;

use Doctrine\ORM\Mapping as ORM;
use HarvestCloud\CoreBundle\Entity\Invoice\BaseOrderInvoice;
use HarvestCloud\CoreBundle\Entity\InvoiceJournal;

/**
 * OrderInvoice Entity
 *
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2012-05-07
 *
 * @ORM\Entity
 */
class OrderInvoice extends BaseOrderInvoice
{
    /**
     * @ORM\OneToOne(targetEntity="HarvestCloud\CoreBundle\Entity\Order", mappedBy="orderInvoice")
     */
    protected $order;

    /**
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-02-23
     *
     * @param  \HarvestCloud\CoreBundle\Entity\Order $order
     */
    public function __construct(\HarvestCloud\CoreBundle\Entity\Order $order)
    {
        $this->setOrder($order);
        $this->setVendor($order->getSeller());
        $this->setCustomer($order->getBuyer());
        $this->setAmount($order->getTotal());
    }

    /**
     * post()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-03-11
     */
    public function post()
    {
        // Create Vendor Journal
        $vendorJournal = new InvoiceJournal($this);
        $vendorJournal->debit($this->getVendor()->getAccountsReceivableAccount(), $this->getAmount());
        $vendorJournal->credit($this->getVendor()->getSalesAccount(), $this->getAmount());

        // Add Vendor Journal to Invoice
        $this->addJournal($vendorJournal);

        // Create Customer Journal
        $customerJournal = new InvoiceJournal($this);
        $customerJournal->debit($this->getCustomer()->getAccountsPayableAccount(), $this->getAmount());
        $customerJournal->credit($this->getCustomer()->getPurchasesAccount(), $this->getAmount());

        // Add Customer Journal to Invoice
        $this->addJournal($customerJournal);

        parent::post();
    }
}
