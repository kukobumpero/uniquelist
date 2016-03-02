<?php
/*
 * UniqueList
 *
 * Date: 2/25/16
 * License: See LICENSE file @root_folder.
 */

namespace Bumpero\Utils;

use Bumpero\Utils\UniqueList;

class UniqueListTest extends \PHPUnit_Framework_TestCase
{
    public function testCanParseCSV()
    {
        // Instantiate.
        $csvList = new UniqueList(true, false, 0);

        // Load the sample data.
        $csvList->loadFromCSVFilePath(__DIR__ . '/SampleData.csv');

        // Assert.
        $this->assertEquals('first title - 2', $csvList->getMainList()[4][0]);
    }

    public function testCanParseIDingoCSV()
    {
        // Instantiate.
        $csvList = new UniqueList(true, false, 1);

        // Load the sample data.
        $csvList->loadFromCSVFilePath(__DIR__ . '/CMS Content - Sheet1.csv');

        // Assert.
        $this->assertEquals('A Balanced Diet Leads To Happy And Healthy Aging - 2', $csvList->getMainList()[12][1]);
    }

    public function testCanParseIDingoCSV2()
    {
        // Instantiate.
        $csvList = new UniqueList(true, false, 1);

        // Load the sample data.
        $csvList->loadFromCSVFilePath(__DIR__ . '/CMS Content - Sheet1.csv');

        // Assert.
        $this->assertEquals('A Balanced Diet Leads To Happy And Healthy Aging - 3', $csvList->getMainList()[13][1]);
    }
}
