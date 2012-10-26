<?php

/*
 * This file is part of the Harvest Cloud package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HarvestCloud\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use HarvestCloud\CoreBundle\Util\DayOfWeek;
use HarvestCloud\CoreBundle\Entity\WindowMaker;

/**
 * HubWindowMakerType
 *
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2012-10-25
 */
class HubWindowMakerType extends AbstractType
{
    /**
     * buildForm
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2012-10-25
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('day_of_week_numbers', 'choice', array(
                'choices'   => DayOfWeek::getChoices(),
                'multiple'  => true,
                'expanded'  => true,
                'label'     => 'Days of Week',
            ))
            ->add('start_time', 'choice', array(
                'choices'   => WindowMaker::getStartTimeChoices(),
            ))
            ->add('end_time', 'choice', array(
                'choices'   => WindowMaker::getEndTimeChoices(),
            ))
        ;
    }

    /**
     * getName
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2012-10-25
     */
    public function getName()
    {
        return 'harvestcloud_corebundle_hubwindowmakertype';
    }
}
