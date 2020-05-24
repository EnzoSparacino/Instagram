# Magento2 Module Sparacino Instagram

    ``sparacino/module-instagram``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
A module for the Instagram Basic Display API for Magento2.

## Installation

### Type 1: Zip file

 - Unzip the zip file in `app/code/Sparacino`
 - Enable the module by running `php bin/magento module:enable Sparacino_Instagram`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`
 - Rebuild static content `php bin/magento setup:static-content:deploy`

### Type 2: Composer

 - Install the module composer by running `composer require sparacino/module-instagram`
 - enable the module by running `php bin/magento module:enable Sparacino_Instagram`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - ENABLE (YES/NO)
 - APP_ACCESS_TOKEN

## Specifications

 - Block
	- Instagram > instagram.phtml
 - Widget
	- Instagram > widget/instagram.phtml

## Usage

You can insert a block inside a CMS page like this:

{{block class="Sparacino\Instagram\Block\Instagram" block_id="instagram.block" template="Sparacino_Instagram::instagram.phtml"}}

or you can use the widget
