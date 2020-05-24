<?php
/**
 * A module for the Instagram Basic Display API.
 * Copyright (C) 2020  Sparacino Enzo Franco
 *
 * This file is part of Sparacino/Instagram.
 *
 * Sparacino/Instagram is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Sparacino\Instagram\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Sparacino\Instagram\Helper\Data as InstagramHelper;

class Instagram extends Template implements BlockInterface
{

    protected $_template = "widget/instagram.phtml";
    protected $instagramHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        InstagramHelper $instagramHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->instagramHelper = $instagramHelper;
    }

    /**
     * @return array
     */
    public function displayMedia()
    {
        return $this->instagramHelper->getMedia();
    }


}
